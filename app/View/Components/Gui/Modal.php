<?php

namespace App\View\Components\Gui;

use App\View\Components\BaseComponentWithValidation;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modal extends BaseComponentWithValidation
{
    public string $id;
    public string $title;

    public function __construct(string $id, string $title)
    {
        $this->validateNameId($id);
        $this->id = $id;
        $this->title = $title;
    }
    public function render(): View
    {
        return view('components.gui.modal');
    }
}
