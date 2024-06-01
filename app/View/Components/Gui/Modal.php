<?php

namespace App\View\Components\Gui;

use App\View\Components\BaseComponentWithValidation;
use Illuminate\Contracts\View\View;

class Modal extends BaseComponentWithValidation
{
    public string $id;
    public string $title;
    public string $size;
    public bool $scrollable;
    public bool $staticBackdrop;
    public bool $centered;

    private const VALID_SIZES = ['sm', 'md', 'lg', 'xl'];

    public function __construct(
        string $id,
        string $title,
        string $size = 'md',
        bool $scrollable = false,
        bool $staticBackdrop = false,
        bool $centered = false
    ) {
        $this->validateNameId($id);
        $this->validateInArray('size', $size, self::VALID_SIZES);

        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->scrollable = $scrollable;
        $this->staticBackdrop = $staticBackdrop;
        $this->centered = $centered;
    }

    public function render(): View
    {
        return view('components.gui.modal');
    }
}
