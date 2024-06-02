<?php

namespace App\View\Components\Gui;

use App\View\Components\BaseComponentWithValidation;
use Illuminate\Contracts\View\View;

class Input extends BaseComponentWithValidation
{
    public string $id;

    public string $name;

    public string $type;

    public string $dataFormType;

    public string $placeholder;

    public string $label;

    public ?string $value;

    public string $required;

    public string $apparence;

    public string $validationClass;

    public string $validation;

    public string $feedback;

    private array $types = [
        'text',
        'password',
        'email',
        'number',
        'tel',
        'url',
        'search',
        'date',
        'time',
        'datetime-local',
        'month',
        'week',
        'color',
        'range',
        'file',
        'hidden',
    ];

    private array $dataFormTypes = [
        'action',
        'address',
        'age',
        'company',
        'consent',
        'date',
        'email',
        'id_document',
        'name',
        'other',
        'otp',
        'password',
        'payment',
        'phone',
        'query',
        'title',
        'username',
        'website',
    ];

    const APPARENCE_COMBINED = 'combined';

    const APPARENCE_SEPARATED = 'separated'; // Classic

    private array $apparences = [
        self::APPARENCE_COMBINED,
        self::APPARENCE_SEPARATED,
    ];

    private array $combinedCompatibleTypes = [
        'text',
        'password',
        'email',
        'number',
        'tel',
        'url',
        'search',
        'date',
        'time',
        'datetime-local',
        'month',
        'week',
    ];

    private array $validationTypes = [
        'none',
        'invalid',
        'valid',
    ];

    public function __construct(
        string $name,
        string $id = '',
        string $type = 'text',
        string $dataFormType = 'other',
        string $placeholder = '',
        string $label = '',
        ?string $value = '',
        bool $required = false,
        string $apparence = '',
        string $validation = 'none',
        string $feedback = ''
    ) {
        $this->validateAttributes($name, $type, $dataFormType, $apparence, $validation);

        $id = ! empty($id) ? $id : 'input_'.$name;
        $required = $required ? 'required' : '';
        $label = ! empty($label) ? $label : $name;
        $value = ! empty($value) ? $value : old($name);

        if ($validation === 'invalid') {
            $validationClass = ' is-invalid';
        } elseif ($validation === 'valid') {
            $validationClass = ' is-valid';
        } else {
            $validationClass = '';
        }

        if (empty($apparence)) {
            if (in_array($type, $this->combinedCompatibleTypes)) {
                $apparence = self::APPARENCE_COMBINED;
            } else {
                $apparence = self::APPARENCE_SEPARATED;
            }
        }

        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->dataFormType = $dataFormType;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->value = $value;
        $this->required = $required;
        $this->apparence = $apparence;
        $this->validationClass = $validationClass;
        $this->validation = $validation;
        $this->feedback = $feedback;
    }

    public function render(): View
    {
        return view('components.gui.input.'.$this->apparence);
    }

    /**
     * Validate the input attributes. Throw an exception if an attribute is incorrect.
     */
    public function validateAttributes(string $name, string $type, string $dataFormType, string $apparence, string $validation): void
    {
        $this->validateNameId($name);
        $this->validateInArray('type', $type, $this->types);
        if (! empty($dataFormType)) {
            $this->validateInArray('data_form_type', $dataFormType, $this->dataFormTypes);
        }
        if (! empty($apparence)) {
            $this->validateInArray('apparence', $apparence, $this->apparences);
        }
        $this->validateInArray('validation', $validation, $this->validationTypes);

        if ($apparence === self::APPARENCE_COMBINED && ! in_array($type, $this->combinedCompatibleTypes)) {
            $this->throwValidationException(
                'apparence',
                "Input apparence '$apparence' is incompatible with type '$type'. Possible types are ".implode(', ', $this->combinedCompatibleTypes).'.'
            );
        }
    }
}
