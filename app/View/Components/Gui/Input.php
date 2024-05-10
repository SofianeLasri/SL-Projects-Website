<?php

namespace App\View\Components\Gui;

use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\View\Component;

class Input extends Component
{
    public string $id;

    public string $name;

    public string $type;

    public string $dataFormType;

    public string $placeholder;

    public string $label;

    public ?string $value;

    public bool $required;

    public string $apparence;

    public string $class;

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
        string $dataFormType = '',
        string $placeholder = '',
        string $label = '',
        ?string $value = '',
        bool $required = false,
        string $apparence = '',
        string $class = '',
        string $validation = 'none',
        string $feedback = ''
    ) {
        $this->validateAttributes($name, $type, $dataFormType, $apparence, $validation);

        $id = ! empty($id) ? $id : 'input_'.$name;
        $required = $required ? 'required' : '';
        $label = ! empty($label) ? $label : $name;
        $value = ! empty($value) ? $value : old($name);

        if ($validation === 'invalid') {
            $class .= ' is-invalid';
        } elseif ($validation === 'valid') {
            $class .= ' is-valid';
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
        $this->class = $class;
        $this->validation = $validation;
        $this->feedback = $feedback;
    }

    public function render(): View
    {
        return view('components.gui.input.'.$this->apparence);
    }

    public function validateName(string $name): void
    {
        if (! preg_match('/^[a-zA-Z][a-zA-Z0-9:_.-]*$/', $name)) {
            $this->throwValidationException(
                'name',
                "Input name '$name' is incorrect. The name attribute must begin with a letter and can only contain letters (a-z, A-Z), digits (0-9), colons (:), periods (.), underscores (_), and hyphens (-)."
            );
        }
    }

    /**
     * Validate if the value is in the array of valid values.
     *
     * @param  string  $attribute  The attribute name
     * @param  mixed  $value  The value to validate
     * @param  array  $validValues  The array of valid values
     */
    public function validateInArray(string $attribute, mixed $value, array $validValues): void
    {
        if (! in_array($value, $validValues)) {
            $this->throwValidationException(
                $attribute,
                "Input $attribute '$value' is incorrect. Possible types are ".implode(', ', $validValues).'.'
            );
        }
    }

    /**
     * Validate the input attributes. Throw an exception if an attribute is incorrect.
     */
    public function validateAttributes(string $name, string $type, string $dataFormType, string $apparence, string $validation): void
    {
        $this->validateName($name);
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

    public function throwValidationException(string $attribute, string $message)
    {
        throw ValidationException::withMessages([$attribute => $message]);
    }
}
