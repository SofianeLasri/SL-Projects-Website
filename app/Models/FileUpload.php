<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class FileUpload extends Model
{
    use HasFactory;

    protected $connection = 'main';

    protected $fillable = [
        'name',
        'filename',
        'path',
        'type',
        'size',
    ];

    /**
     * Get the query builder for the files in the given folder.
     *
     * @param  string|null  $type  The type of the files to get.
     * @param  bool  $originalFilesOnly  Whether to get only original files or all files.
     * @param  string  $path  The path to get the files from.
     * @return Builder The query builder.
     */
    public static function getUploadQB(?string $type, bool $originalFilesOnly, string $path): Builder
    {
        $query = self::query();
        $query->select('file_uploads.*');

        if ($type) {
            if ($type === 'other') {
                $query->where('file_uploads.type', 'not like', 'image/%');
                $query->where('file_uploads.type', 'not like', 'video/%');
                $query->where('file_uploads.type', 'not like', 'audio/%');
            } else {
                $query->where('file_uploads.type', 'like', $type.'/%');
            }
        }

        if ((is_null($type) || $type === 'image') && $originalFilesOnly) {
            $query->where(function ($query) {
                $query->whereHas('pictureType', function ($query) {
                    $query->where('type', PictureType::TYPE_ORIGINAL);
                })->orWhereDoesntHave('pictureType');
            });

            // Jointure avec la table picture_types pour récupérer le chemin du fichier de prévisualisation
            $query->leftJoin('picture_types as thumbnail_variant', function ($join) {
                $join->on('file_uploads.id', '=', 'thumbnail_variant.original_file_upload_id')
                    ->where('thumbnail_variant.type', '=', PictureType::TYPE_THUMBNAIL);
            });
            $query->leftJoin('file_uploads as thumbnail_variant_file_upload', 'thumbnail_variant_file_upload.id', '=', 'thumbnail_variant.file_upload_id');

            $query->addSelect('thumbnail_variant_file_upload.path as thumbnail_path');
        }

        $query->where('file_uploads.path', 'like', $path.'%');

        return $query;
    }

    public function pictureType(): HasOne
    {
        return $this->hasOne(PictureType::class);
    }

    public function pictureTypes(): HasMany
    {
        return $this->hasMany(PictureType::class, 'original_file_upload_id');
    }

    public function getThumbnailVariant(string $format = 'webp'): ?FileUpload
    {
        $thumbNailVariant = $this->pictureTypes()
            ->join('file_uploads as thumbnail_variant_file_upload', 'thumbnail_variant_file_upload.id', '=', 'picture_types.file_upload_id')
            ->where('type', PictureType::TYPE_THUMBNAIL)
            ->where('thumbnail_variant_file_upload.type', 'image/'.$format)
            ->first();
        if ($thumbNailVariant) {
            return FileUpload::find($thumbNailVariant->file_upload_id);
        }

        return null;
    }

    public function getSmallVariant(string $format = 'webp'): ?FileUpload
    {
        $smallVariant = $this->pictureTypes()
            ->small()
            ->join('file_uploads as small_variant_file_upload', 'small_variant_file_upload.id', '=', 'picture_types.file_upload_id')
            ->where('small_variant_file_upload.type', 'image/'.$format)
            ->first();
        if ($smallVariant) {
            return FileUpload::find($smallVariant->file_upload_id);
        }

        return null;
    }

    public function getMediumVariant(string $format = 'webp'): ?FileUpload
    {
        $mediumVariant = $this->pictureTypes()
            ->medium()
            ->join('file_uploads as medium_variant_file_upload', 'medium_variant_file_upload.id', '=', 'picture_types.file_upload_id')
            ->where('medium_variant_file_upload.type', 'image/'.$format)
            ->first();
        if ($mediumVariant) {
            return FileUpload::find($mediumVariant->file_upload_id);
        }

        return null;
    }

    public function getLargeVariant(string $format = 'webp'): ?FileUpload
    {
        $largeVariant = $this->pictureTypes()
            ->where('type', PictureType::TYPE_LARGE)
            ->join('file_uploads as large_variant_file_upload', 'large_variant_file_upload.id', '=', 'picture_types.file_upload_id')
            ->where('large_variant_file_upload.type', 'image/'.$format)
            ->first();
        if ($largeVariant) {
            return FileUpload::find($largeVariant->file_upload_id);
        }

        return null;
    }

    public function getOriginalVariant(): FileUpload
    {
        $originalVariant = $this->pictureTypes()->where('type', PictureType::TYPE_ORIGINAL)->first();
        if ($originalVariant) {
            return FileUpload::find($originalVariant->file_upload_id);
        }

        return $this;
    }

    public function getFileUrl(): string
    {
        return Storage::url($this->path);
    }

    public function getFile(): string
    {
        return Storage::get($this->path);
    }

    public function getPendingImageConversions(): HasMany
    {
        return $this->hasMany(PendingImageConversion::class);
    }

    public function isImage(): bool
    {
        return Str::before($this->type, '/') === 'image';
    }

    public function isOriginalImage(): bool
    {
        if (! $this->isImage()) {
            return false;
        }

        if ($this->pictureType()->exists()) {
            return $this->pictureType->type === 'original';
        }

        return false;
    }

    public function addToConversionQueue(string $conversionType): void
    {
        if (Str::before($this->type, '/') !== 'image') {
            return;
        }

        Log::debug('Adding '.$this->filename.' to conversion queue: '.$conversionType);
        PendingImageConversion::create([
            'file_upload_id' => $this->id,
            'type' => $conversionType,
        ]);
    }

    /**
     * Convert the image to the given conversion type.
     *
     * @param  string  $conversionType  The conversion type to convert the image to.
     */
    public function convertImage(string $conversionType): void
    {
        Log::debug('Converting image '.$this->filename.' to '.$conversionType);
        try {
            $image = Image::make($this->getFile());
        } catch (\Exception $e) {
            $this->removeFromConversionQueueAndPlaceToUnprocessable($conversionType, 'Error while converting image', $e);

            return;
        }

        $config = config('app.fileupload.images.'.$conversionType);
        $width = $config['width'];
        $height = $config['height'];
        $format = $config['format'];
        $quality = $config['quality'];
        $uploadFolder = Str::beforeLast($this->path, '/').'/';
        $filename = $this->filename;

        if ($width && $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        if ($format && $quality) {
            $image->encode($format, $quality);
        }

        $newFilename = $this->checkFileName($uploadFolder, Str::beforeLast($filename, '.').'_'.$conversionType.'.'.$format);

        try {
            Storage::put($uploadFolder.$newFilename, $image->__toString());
        } catch (\Exception $e) {
            $this->removeFromConversionQueueAndPlaceToUnprocessable($conversionType, 'Error while storing image', $e);

            return;
        }

        $fileUpload = new FileUpload();
        $fileUpload->name = $newFilename;
        $fileUpload->filename = $newFilename;
        $fileUpload->size = $image->filesize();
        $fileUpload->type = $image->mime();
        $fileUpload->path = $uploadFolder.$newFilename;
        $fileUpload->save();

        FileUpload::refreshCache($uploadFolder);

        $pictureType = new PictureType();
        $pictureType->file_upload_id = $fileUpload->id;
        $pictureType->original_file_upload_id = $this->id;
        $pictureType->type = $conversionType;
        $pictureType->save();

        $this->getPendingImageConversions()->where('type', $conversionType)->delete();
    }

    private function removeFromConversionQueueAndPlaceToUnprocessable(string $conversionType, string $logMessage, \Exception $e): void
    {
        Log::warning($logMessage, [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
        Log::info('Removing '.$this->filename.' ID '.$this->id.' from conversion queue: '.$conversionType);

        $unprocessableFileUpload = UnprocessableFileUpload::where('file_upload_id', $this->id);

        if (! $unprocessableFileUpload->exists()) {
            UnprocessableFileUpload::create([
                'file_upload_id' => $this->id,
                'reason' => $e->getMessage(),
                'task' => UnprocessableFileUpload::TASK_CONVERSION,
            ]);
        } else {
            $unprocessableFileUpload = $unprocessableFileUpload->first();
            $unprocessableFileUpload->reason = $e->getMessage();
            $unprocessableFileUpload->save();
        }

        $this->getPendingImageConversions()->where('type', $conversionType)->delete();
    }

    /**
     * Check if a file already exists in the given folder.
     *
     * @param  string  $folder  The folder to check in.
     * @param  string  $filename  The filename to check.
     * @param  int  $iteration  The iteration of the filename.
     * @return string The new filename.
     */
    public static function checkFileName(string $folder, string $filename, int $iteration = 0): string
    {
        $cacheKey = self::gerenateFolderCacheKey($folder);

        $existingFiles = Cache::has($cacheKey) ? Cache::get($cacheKey) : self::refreshCache($folder);

        $newFilename = $iteration === 0 ? $filename : Str::beforeLast($filename, '.').'-'.$iteration.'.'.Str::afterLast($filename, '.');

        if (in_array(pathinfo($newFilename, PATHINFO_BASENAME), $existingFiles)) {
            Log::debug('File '.$newFilename.' already exists in folder '.$folder);

            return self::checkFileName($folder, $filename, $iteration + 1);
        }

        return $newFilename;
    }

    /**
     * Refresh the cache for the specified folder.
     *
     * @param  string  $folder  The folder for which to refresh the cache.
     */
    public static function refreshCache(string $folder): array
    {
        Log::debug('Refreshing cache for folder: '.$folder);
        $cacheKey = self::gerenateFolderCacheKey($folder);

        Cache::forget($cacheKey);

        return Cache::remember($cacheKey, 120, function () use ($folder) {
            return collect(Storage::files($folder))->map(function ($path) {
                return pathinfo($path, PATHINFO_BASENAME);
            })->toArray();
        });
    }

    /**
     * Generate the cache key for the specified folder.
     *
     * @param  string  $folder  The folder for which to generate the cache key.
     */
    public static function gerenateFolderCacheKey(string $folder): string
    {
        if (Str::endsWith($folder, '/')) {
            $folder = Str::beforeLast($folder, '/');
        }

        return config('app.fileupload.folder_cache_key').md5($folder);
    }

    /**
     * Get the files in the given folder, based on database records.
     *
     * @param  string  $path  The path to get the files from.
     * @param  string|null  $type  The type of the files to get.
     * @param  bool  $originalFilesOnly  Whether to get only original files or all files.
     * @param  int  $offset  The offset of the files to get.
     * @param  int  $limit  The limit of the files to get.
     * @param  string  $order  The order of the files to get.
     * @return array The files.
     */
    public static function getFiles(string $path = '/', ?string $type = null, bool $originalFilesOnly = true, int $offset = 0, int $limit = 20, string $order = 'desc'): array
    {
        $query = self::getUploadQB($type, $originalFilesOnly, $path);
        $query->orderBy('file_uploads.created_at', $order);
        $query->offset($offset);
        $query->limit($limit);

        $files = $query->get();

        return $files->toArray();
    }

    /**
     * Get the picture type associated with the file upload.
     *
     * @param  string  $path  The path to get the files from.
     * @param  string|null  $type  The type of the files to get.
     * @param  bool  $originalFilesOnly  Whether to get only original files or all files.
     * @return int The number of files.
     */
    public static function getFilesCount(string $path = '/', ?string $type = null, bool $originalFilesOnly = false): int
    {
        $query = self::getUploadQB($type, $originalFilesOnly, $path);

        return $query->count();
    }
}
