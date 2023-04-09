<?php

namespace App\View\Components\Showcase;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PhotoViewer extends Component
{
    public string $title = "Visionneuse de photos";
    public array $photos;

    public function __construct(string $title = null, array $photos = [])
    {
        if ($title) {
            $this->title = $title;
        }
        $this->photos = $photos;
    }
    public function render(): View
    {
        return view('components.showcase.photo-viewer');
    }
}
