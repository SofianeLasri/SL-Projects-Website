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
    public int $fileCount;
    public array $value;

    private const AVAILABLE_TYPES = ['file', 'image', 'video', 'audio', 'document', 'archive'];
    private const AVAILABLE_APPARENCES = ['input', 'square'];

    public function __construct(
        string $name,
        string $type = 'image',
        string $apparence = 'input',
        string $label = '',
        int   $fileCount = 1,
        mixed $value = [],
        string $id = ''
    ) {
        $this->setName($name);
        $this->setType($type);
        $this->setApparence($apparence);
        $this->setId($id);
        $this->label = $label;
        $this->fileCount = $fileCount;

        if (!empty($value)) {
            $this->setValue($value);
        } else {
            $this->value = [];
        }

        if ($this->apparence === 'input') {
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

    private function setValue(mixed $value): void
    {
        if (is_int($value)) {
            $this->value = [$value];
        } elseif (is_array($value)) {
            $this->value = $value;
        } else {
            throw new \InvalidArgumentException('The value must be an integer or an array of integers.');
        }
    }

    public function getSelectedFiles(): string
    {
        return implode(',', $this->value);
    }
}
