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
     * @var string
     */
    public string $color;

    /**
     * LogoShort constructor.
     * @param string $color
     */
    public function __construct(string $color = '#fff')
    {
        if (Str::contains($color, "#")) {
            $this->color = $color;
        } else {
            $this->color = "#" . $color;
        }
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('components.logo-short');
    }
}
