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

        $fileType = $file->getMimeType();

        if (Str::before($fileType, '/') === 'image') {
            $originalFileUpload = $this->processImage($file, $uploadFolder, $filename, 'original');

            foreach (config('app.fileupload.images') as $typeName => $value) {
                if ($typeName === 'original') {
                    continue;
                }
                $this->processImage($file, $uploadFolder, $filename, $typeName, $value['width'], $value['height'], $value['format'], $value['quality'], $originalFileUpload);
            }

            $pictureVariants = $originalFileUpload->getVariantsIfPicture()->get();

            $urls = [];
            $urls['original'] = Storage::disk('ftp')->url($originalFileUpload->path);
            foreach ($pictureVariants as $pictureVariant) {
                $urls[$pictureVariant->type] = Storage::disk('ftp')->url($pictureVariant->associatedFile->path);
            }

            return response()->json([
                'success' => true,
                'urls' => $urls,
            ]);
        }

        $this->processNonImageFile($file, $uploadFolder, $filename, $fileType);

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
     * @param  int|null  $width The width (in px) of the image.
     * @param  int|null  $height The height (in px) of the image.
     * @param  string|null  $format The format of the image (jpg, png, webp).
     * @param  int|null  $quality The quality of the image (0-100).
     * @param  FileUpload|null  $originalFileUpload The original file FileUpload model instance.
     * @return FileUpload The processed file FileUpload model instance.
     *
     * @throws \Exception If the file cannot be stored.
     */
    private function processImage(UploadedFile $file, string $uploadFolder, string $filename, string $typeName, int $width = null, int $height = null, string $format = null, int $quality = null, FileUpload $originalFileUpload = null): FileUpload
    {
        // Instance de intervention/image
        $image = Image::make($file->getRealPath());
        if(is_null($format)) $format = config('app.fileupload.images.original.format');

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

        $fileUpload = new FileUpload();
        $fileUpload->name = $newFilename;
        $fileUpload->filename = $newFilename;
        $fileUpload->size = $image->filesize();
        $fileUpload->type = $file->getMimeType();
        $fileUpload->path = $uploadFolder.$newFilename;
        $fileUpload->save();

        if ($originalFileUpload) {
            $pictureType = new PictureType();
            $pictureType->file_upload_id = $fileUpload->id;
            $pictureType->original_file_upload_id = $originalFileUpload->id;
            $pictureType->type = $typeName;
            $pictureType->save();
        } else {
            $pictureType = new PictureType();
            $pictureType->file_upload_id = $fileUpload->id;
            $pictureType->type = $typeName;
            $pictureType->save();
        }

        return $fileUpload;
    }

    private function processNonImageFile($file, $uploadFolder, $filename, $fileType)
    {
        $fileUpload = new FileUpload();
        $fileUpload->name = $filename;
        $fileUpload->filename = $filename;
        $fileUpload->size = $file->getSize();
        $fileUpload->type = $fileType;
        $fileUpload->path = $uploadFolder.$filename;
        $fileUpload->save();
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
        $newFilename = $iteration === 0 ? $filename : Str::beforeLast($filename, '.').'-'.$iteration.'.'.Str::afterLast($filename, '.');

        if (Storage::disk('ftp')->exists($folder.'/'.$newFilename)) {
            return $this->checkFileName($folder, $filename, $iteration + 1);
        }

        return $newFilename;
    }
}
