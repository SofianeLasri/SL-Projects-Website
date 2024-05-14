<?php

namespace App\View\Components\Dashboard\MediaLibrary;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MediaUploadZone extends Component
{
    public function render(): View
    {
        return view('components.dashboard.media-library.media-upload-zone');
    }
}
