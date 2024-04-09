<?php

namespace App\Http\Controllers\Dashboard\Components;

use App\Http\Controllers\Controller;
use App\Jobs\ConvertImageJob;
use App\Models\FileUpload;
use App\Models\PictureType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUploadZoneController extends Controller
{
    public function findIcon(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|string',
        ]);

        $type = $request->input('type');

        if (array_key_exists($type, config('global-ui.fa-file-types-icons'))) {
            return response()->json([
                'icon' => config('global-ui.fa-file-types-icons')[$type],
            ]);
        }

        $shortMimeType = Str::before($type, '/');
        if (array_key_exists($shortMimeType, config('global-ui.fa-file-types-icons'))) {
            return response()->json([
                'icon' => config('global-ui.fa-file-types-icons')[$shortMimeType],
            ]);
        }

        return response()->json([
            'icon' => config('global-ui.fa-file-types-icons.default'),
        ]);
    }

    public function uploadFile(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:'.config('app.fileupload.max_size', 10).'000',
        ]);

        $file = $request->file('file');

        $uploadFolder = '/'.Carbon::now()->format('Y/m/d').'/';
        $slugifiedFilename = Str::slug(Str::beforeLast($file->getClientOriginalName(), '.')).'.'.$file->getClientOriginalExtension();
        $filename = FileUpload::checkFileName($uploadFolder, $slugifiedFilename);

        Log::debug('Upload file to FTP', [
            'uploadFolder' => $uploadFolder,
            'filename' => $filename,
        ]);

        Storage::putFileAs($uploadFolder, $file, $filename);
        $fileType = $file->getMimeType();
        $originalFileUpload = $this->saveFileUpload($file, $uploadFolder, $filename, $fileType);

        if (Str::before($fileType, '/') === 'image' && ! in_array('image', config('app.fileupload.excluded_image_types', $fileType))) {
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
            // ConvertImageJob::dispatch();
        }

        return response()->json([
            'success' => true,
            'url' => Storage::url($uploadFolder.$filename),
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
