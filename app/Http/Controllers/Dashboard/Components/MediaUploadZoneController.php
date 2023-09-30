<?php

namespace App\Http\Controllers\Dashboard\Components;

use App\Http\Controllers\Controller;
use App\View\Components\Dashboard\MediaUploadZoneFile;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
}
