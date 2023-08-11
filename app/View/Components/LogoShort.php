<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Str;

/**
 * Class LogoShort
 */
class LogoShort extends Component
{
    /**
     * Le code couleur hexadécimal de la couleur de fond du logo.
     */
    public string $color;

    /**
     * La hauteur du logo.
     */
    public string $height;

    /**
     * LogoShort constructor.
     */
    public function __construct(string $color = '#fff', string $height = '100%')
    {
        if (Str::contains($color, '#')) {
            $this->color = $color;
        } else {
            $this->color = '#'.$color;
        }

        $this->height = $height;
    }

    public function render(): View
    {
        return view('components.logo-short');
    }
}
