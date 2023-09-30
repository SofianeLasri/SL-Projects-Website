<?php

namespace App\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MediaUploadZoneFile extends Component
{
    private string $id;

    private string $name;

    private int $size;

    private string $type;

    private string $formattedSize;

    private string $icon;

    public function __construct(string $name, int $size, string $type)
    {
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;

        $this->formattedSize = $this->formatSize($size);
        $this->icon = $this->findIcon($type);

        $this->id = 'muzf-'.md5($name.$size.$type);
    }

    private function formatSize(int $size): string
    {
        $units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        $unitIndex = 0;
        while ($size > 1024) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2).' '.$units[$unitIndex];
    }

    private function findIcon(string $type): string
    {
        if (array_key_exists($type, config('global-ui.fa-file-types-icons'))) {
            return config('global-ui.fa-file-types-icons')[$type];
        }

        $shortMimeType = Str::before($type, '/');
        if (array_key_exists($shortMimeType, config('global-ui.fa-file-types-icons'))) {
            return config('global-ui.fa-file-types-icons')[$shortMimeType];
        }

        return config('global-ui.fa-file-types-icons.default');
    }

    public function render(): View
    {
        return view('components.dashboard.media-upload-zone-file', [
            'id' => $this->id,
            'name' => $this->name,
            'size' => $this->size,
            'type' => $this->type,
            'formattedSize' => $this->formattedSize,
            'icon' => $this->icon,
        ]);
    }
}
