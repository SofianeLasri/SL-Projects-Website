<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ProjectMediasArraySchemeRule implements ValidationRule
{
    private array $validProperties = [
        'display_order',
        'name',
        'type',
        'file_upload_id',
        'link',
    ];
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_array($value)) {
            $fail('The :attribute must be an array.');
            return;
        }

        foreach ($value as $media) {
            if (! is_array($media)) {
                $fail('Each media must be an array.');
                return;
            }

            foreach ($media as $property => $propertyValue) {
                if (! in_array($property, $this->validProperties)) {
                    $fail("The property '{$property}' is not allowed.");
                    return;
                }
            }
        }
    }
}
