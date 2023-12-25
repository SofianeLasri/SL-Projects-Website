<?php

namespace App\Http\Controllers\Showcase;

use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function index($path)
    {
        $folder = dirname($path);
        $cacheKey = config('app.fileupload.folder_cache_key').md5($folder);

        $existingFiles = Cache::has($cacheKey) ? Cache::get($cacheKey) : FileUpload::refreshCache($folder);

        if (! in_array(pathinfo($path, PATHINFO_BASENAME), $existingFiles)) {
            abort(404);
        }

        return Storage::disk('ftp')->response($path);
    }
}
