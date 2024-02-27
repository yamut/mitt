<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class EnumRule implements ValidationRule
{
    /**
     * @param class-string $enumName
     */
    public function __construct(
        private string $enumName,
    ) {
        //
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!class_exists($this->enumName) || !$this->enumName::tryFrom($value)) {
            $fail(sprintf(':attribute must be a valid %s value', $this->enumName));
        }
    }
}
