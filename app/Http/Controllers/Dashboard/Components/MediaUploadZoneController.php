<?php

namespace App\Http\Controllers\Dashboard\Components;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\PictureType;
use App\View\Components\Dashboard\MediaUploadZoneFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class MediaUploadZoneController extends Controller
{
    public function renderComponent(Request $request): View
    {
        $request->validate([
            'name' => 'required|string',
            'size' => 'required|integer',
            'type' => 'required|string',
        ]);

        return (new MediaUploadZoneFile(
            $request->input('name'),
            $request->input('size'),
            $request->input('type')
        ))->render();
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $uploadFolder = '/'.Carbon::now()->format('Y/m/d').'/';
        $filename = $this->checkFileName($uploadFolder, $file->getClientOriginalName());

        Storage::disk('ftp')->putFileAs($uploadFolder, $file, $filename);
        $fileType = $file->getMimeType();
        $originalFileUpload = $this->saveFileUpload($file, $uploadFolder, $filename, $fileType);

        if (Str::before($fileType, '/') === 'image') {
            // We will create PictureType instance for original file
            $originalPictureType = new PictureType([
                'file_upload_id' => $originalFileUpload->id,
                'type' => 'original',
            ]);
            $originalPictureType->save();

            foreach (config('app.fileupload.images') as $typeName => $value) {
                if ($typeName === 'original') {
                    continue;
                }
                $this->processImage($file, $uploadFolder, $filename, $typeName, $value['width'], $value['height'], $value['format'], $value['quality'], $originalFileUpload);
            }
        }

        return response()->json([
            'success' => true,
            'url' => Storage::disk('ftp')->url($uploadFolder.$filename),
        ]);
    }

    /**
     * Process an image file.
     *
     * @param  UploadedFile  $file The file to process.
     * @param  string  $uploadFolder The folder to upload the file to.
     * @param  string  $filename The name of the file.
     * @param  string  $typeName The type of the file (thumbnail, small, medium, large, original).
     * @param  int  $width The width (in px) of the image.
     * @param  int  $height The height (in px) of the image.
     * @param  string  $format The format of the image (jpg, png, webp).
     * @param  int  $quality The quality of the image (0-100).
     * @param  FileUpload  $originalFileUpload The original file FileUpload model instance.
     * @return void The processed file FileUpload model instance.
     *
     * @throws \Exception If the file cannot be stored.
     */
    private function processImage(UploadedFile $file, string $uploadFolder, string $filename, string $typeName, int $width, int $height, string $format, int $quality, FileUpload $originalFileUpload): void
    {
        $image = Image::make($file->getRealPath());

        if ($width && $height) {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        if ($format && $quality) {
            $image->encode($format, $quality);
        }

        $newFilename = $this->checkFileName($uploadFolder, Str::beforeLast($filename, '.').'_'.$typeName.'.'.$format);
        $store = Storage::disk('ftp')->put($uploadFolder.$newFilename, $image->__toString());

        if (! $store) {
            throw new \Exception('Error while storing image');
        }

        $fileUpload = $this->saveFileUpload($file, $uploadFolder, $newFilename, $file->getMimeType());

        $pictureType = new PictureType();
        $pictureType->file_upload_id = $fileUpload->id;
        $pictureType->original_file_upload_id = $originalFileUpload->id;
        $pictureType->type = $typeName;
        $pictureType->save();
    }

    /**
     * Save a file upload and return the model instance.
     *
     * @param  UploadedFile  $file The file to save.
     * @param  string  $uploadFolder The folder to upload the file to.
     * @param  string  $filename The name of the file.
     * @param  string  $fileType The type of the file.
     * @return FileUpload The saved file FileUpload model instance.
     */
    private function saveFileUpload(UploadedFile $file, string $uploadFolder, string $filename, string $fileType): FileUpload
    {
        $fileUpload = new FileUpload();
        $fileUpload->name = $filename;
        $fileUpload->filename = $filename;
        $fileUpload->size = $file->getSize();
        $fileUpload->type = $fileType;
        $fileUpload->path = $uploadFolder.$filename;
        $fileUpload->save();

        $this->refreshCache($uploadFolder);

        return $fileUpload;
    }

    /**
     * Refresh the cache for the specified folder.
     *
     * @param  string  $folder The folder for which to refresh the cache.
     */
    private function refreshCache(string $folder): array
    {
        $cacheKey = 'media-upload-zone.'.md5($folder);

        Cache::forget($cacheKey);

        return Cache::remember($cacheKey, 120, function () use ($folder) {
            return collect(Storage::disk('ftp')->files($folder))->map(function ($path) {
                return pathinfo($path, PATHINFO_FILENAME);
            })->toArray();
        });
    }

    /**
     * Check if a file already exists in the given folder.
     *
     * @param  string  $folder The folder to check in.
     * @param  string  $filename The filename to check.
     * @param  int  $iteration The iteration of the filename.
     * @return string The new filename.
     */
    private function checkFileName(string $folder, string $filename, int $iteration = 0): string
    {
        $cacheKey = 'media-upload-zone.'.md5($folder);

        $existingFiles = Cache::has($cacheKey) ? Cache::get($cacheKey) : $this->refreshCache($folder);

        $newFilename = $iteration === 0 ? $filename : Str::beforeLast($filename, '.').'-'.$iteration.'.'.Str::afterLast($filename, '.');

        if (in_array(pathinfo($newFilename, PATHINFO_FILENAME), $existingFiles)) {
            return $this->checkFileName($folder, $filename, $iteration + 1);
        }

        return $newFilename;
    }
}
