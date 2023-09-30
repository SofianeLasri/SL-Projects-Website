<?php

namespace App\Http\Controllers\Dashboard\Components;

use App\Http\Controllers\Controller;
use App\View\Components\Dashboard\MediaUploadZoneFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $uploadFolder = '/'.Carbon::now()->format('Y/m/d').'/';
        $file = $request->file('file');
        $filename = $this->checkFileName($uploadFolder, $file->getClientOriginalName());
        $file->storeAs($uploadFolder, $filename, 'ftp');

        return response()->json([
            'success' => true,
            'url' => Storage::disk('ftp')->url($uploadFolder.$filename),
        ]);
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
