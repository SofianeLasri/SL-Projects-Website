<?php

namespace App\View\Components;

use Illuminate\Validation\ValidationException;
use Illuminate\View\Component;

abstract class BaseComponentWithValidation extends Component
{

    public function validateNameId(string $name): void
    {
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9:_.-]*$/', $name)) {
            $this->throwValidationException(
                'name',
                "Name or ID '$name' is incorrect. The name attribute must begin with a letter and can only contain letters (a-z, A-Z), digits (0-9), colons (:), periods (.), underscores (_), and hyphens (-)."
            );
        }
    }

    public function validateInArray(string $attribute, mixed $value, array $validValues): void
    {
        if (!in_array($value, $validValues)) {
            $this->throwValidationException(
                $attribute,
                "The attribute $attribute '$value' is incorrect. Possible types are " . implode(', ', $validValues) . '.'
            );
        }
    }

    public function throwValidationException(string $attribute, string $message)
    {
        throw ValidationException::withMessages([$attribute => $message]);
    }
}
