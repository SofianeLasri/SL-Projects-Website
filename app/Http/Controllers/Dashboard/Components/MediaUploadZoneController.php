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
    public function findIcon(Request $request): string
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $type = $request->input('type');

        if (array_key_exists($type, config('global-ui.fa-file-types-icons'))) {
            return config('global-ui.fa-file-types-icons')[$type];
        }

        $shortMimeType = Str::before($type, '/');
        if (array_key_exists($shortMimeType, config('global-ui.fa-file-types-icons'))) {
            return config('global-ui.fa-file-types-icons')[$shortMimeType];
        }

        return config('global-ui.fa-file-types-icons.default');
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        $uploadFolder = '/'.Carbon::now()->format('Y/m/d').'/';
        $filename = FileUpload::checkFileName($uploadFolder, $file->getClientOriginalName());

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
                $originalFileUpload->addToConversionQueue($typeName);
            }
        }

        return response()->json([
            'success' => true,
            'url' => Storage::disk('ftp')->url($uploadFolder.$filename),
        ]);
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

        FileUpload::refreshCache($uploadFolder);

        return $fileUpload;
    }
}
