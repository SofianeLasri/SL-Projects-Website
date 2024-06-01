<?php

namespace App\View\Components;

use Illuminate\Validation\ValidationException;
use Illuminate\View\Component;

abstract class BaseComponentWithValidation extends Component
{
    /**
     * Validate the name or ID attribute to ensure it is a valid HTML attribute.
     * @param string $nameOrId The name or ID attribute to validate.
     * @return void
     */
    public function validateNameId(string $nameOrId): void
    {
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9:_.-]*$/', $nameOrId)) {
            $this->throwValidationException(
                'name',
                "Name or ID '$nameOrId' is incorrect. The name attribute must begin with a letter and can only contain letters (a-z, A-Z), digits (0-9), colons (:), periods (.), underscores (_), and hyphens (-)."
            );
        }
    }

    /**
     * Validate that the value is in the array of valid values.
     * @param string $attribute The attribute name.
     * @param mixed $value The value to validate.
     * @param array $validValues The array of valid values.
     * @return void
     */
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
