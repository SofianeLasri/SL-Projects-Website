<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaLibraryController extends Controller
{
    public function page()
    {
        return view('websites.dashboard.media-library');
    }

    public function getUploadedFiles(Request $request): JsonResponse
    {
        $request->validate([
            'offset' => 'sometimes|integer',
            'type' => 'sometimes|string|in:all,image,video,audio,other',
            'order' => 'sometimes|string|in:asc,desc',
        ]);

        $offset = $request->input('offset', 0);
        $type = $request->input('type', null);
        if ($type === 'all') {
            $type = null;
        }
        $order = $request->input('order', 'desc');

        $fileUploads = FileUpload::getFiles('/', $type, true, $offset, 50, $order);

        return response()->json([
            'files' => $fileUploads,
            'total' => FileUpload::getFilesCount('/', $type, true),
        ]);
    }
}
