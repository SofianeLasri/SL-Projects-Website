<?php

namespace App\Models;

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
    protected $connection = 'main';

    protected $fillable = [
        'name',
        'filename',
        'path',
        'type',
        'size',
    ];

    public function getVariantsIfPicture(): HasMany
    {
        return $this->hasMany(PictureType::class, 'original_file_upload_id');
    }

    public function getThumbnailVariant(): HasOne
    {
        return $this->hasOne(PictureType::class)->where('type', 'thumbnail');
    }

    public function getSmallVariant(): HasOne
    {
        return $this->hasOne(PictureType::class)->where('type', 'small');
    }

    public function getMediumVariant(): HasOne
    {
        return $this->hasOne(PictureType::class)->where('type', 'medium');
    }

    public function getLargeVariant(): HasOne
    {
        return $this->hasOne(PictureType::class)->where('type', 'large');
    }

    public function getOriginalVariant(): HasOne
    {
        return $this->hasOne(PictureType::class)->where('type', 'original');
    }

    public function getFileUrl(): string
    {
        return Storage::url($this->path);
    }

    public function getPendingImageConversions(): HasMany
    {
        return $this->hasMany(PendingImageConversion::class);
    }

    public function addToConversionQueue(string $conversionType): void
    {
        if (Str::before($this->type, '/') !== 'image') {
            return;
        }

        Log::info('Adding '.$this->filename.' to conversion queue: '.$conversionType);
        PendingImageConversion::create([
            'file_upload_id' => $this->id,
            'type' => $conversionType,
        ]);
    }

    public function convertImage(string $conversionType)
    {
        $image = Image::make($this->getFileUrl());
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
        $store = Storage::disk('ftp')->put($uploadFolder.$newFilename, $image->__toString());

        if (! $store) {
            throw new \Exception('Error while storing image');
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

    /**
     * Check if a file already exists in the given folder.
     *
     * @param  string  $folder The folder to check in.
     * @param  string  $filename The filename to check.
     * @param  int  $iteration The iteration of the filename.
     * @return string The new filename.
     */
    public static function checkFileName(string $folder, string $filename, int $iteration = 0): string
    {
        $cacheKey = 'folder-content.'.md5($folder);

        $existingFiles = Cache::has($cacheKey) ? Cache::get($cacheKey) : self::refreshCache($folder);

        $newFilename = $iteration === 0 ? $filename : Str::beforeLast($filename, '.').'-'.$iteration.'.'.Str::afterLast($filename, '.');

        if (in_array(pathinfo($newFilename, PATHINFO_FILENAME), $existingFiles)) {
            return self::checkFileName($folder, $filename, $iteration + 1);
        }

        return $newFilename;
    }

    /**
     * Refresh the cache for the specified folder.
     *
     * @param  string  $folder The folder for which to refresh the cache.
     */
    public static function refreshCache(string $folder): array
    {
        $cacheKey = 'folder-content.'.md5($folder);

        Cache::forget($cacheKey);

        return Cache::remember($cacheKey, 120, function () use ($folder) {
            return collect(Storage::disk('ftp')->files($folder))->map(function ($path) {
                return pathinfo($path, PATHINFO_FILENAME);
            })->toArray();
        });
    }
}
