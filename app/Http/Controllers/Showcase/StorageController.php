<?php

namespace App\Http\Controllers\Showcase;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index($path)
    {
        $folder = dirname($path);
        $cacheKey = FileUpload::gerenateFolderCacheKey($folder);

        $existingFiles = Cache::has($cacheKey) ? Cache::get($cacheKey) : FileUpload::refreshCache($folder);

        if (! in_array(pathinfo($path, PATHINFO_BASENAME), $existingFiles)) {
            abort(404);
        }

        return Storage::response($path);
    }
}
