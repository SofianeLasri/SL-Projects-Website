<?php

namespace App\View\Components\Dashboard\MediaLibrary;

use App\View\Components\BaseComponentWithValidation;
use Illuminate\Contracts\View\View;

class InputPicker extends BaseComponentWithValidation
{
    public string $id;

    public string $name;

    public string $type;

    public string $apparence;

    public string $label;

    public string $fakeInputName;
    public string $fakeInputId;

    private const AVAILABLE_TYPES = ['file', 'image', 'video', 'audio', 'document', 'archive'];

    private const AVAILABLE_APPARENCES = ['input', 'square'];

    public function __construct(string $id, string $name, string $type = 'image', string $apparence = 'input', string $label = '')
    {
        $this->setName($name);
        $this->setType($type);
        $this->setApparence($apparence);
        $this->setId($id);
        $this->label = $label;

        if($this->apparence === 'input') {
            $this->fakeInputName = $this->name.'_fake';
            $this->fakeInputId = $this->id.'_fake';
        }
    }

    public function render(): View
    {
        return view('components.dashboard.media-library.input-picker');
    }

    private function setId(string $id): void
    {
        $this->id = ! empty($id) ? $id : 'fileupload_picker_'.$this->name;
    }

    private function setName(string $name): void
    {
        $this->validateNameId($name);
        $this->name = $name;
    }

    private function setType(string $type): void
    {
        $this->validateInArray('type', $type, self::AVAILABLE_TYPES);
        $this->type = $type;
    }

    private function setApparence(string $apparence): void
    {
        $this->validateInArray('apparence', $apparence, self::AVAILABLE_APPARENCES);
        $this->apparence = $apparence;
    }
}
