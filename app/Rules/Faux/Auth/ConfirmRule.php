<?php

namespace App\Rules\Faux\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class ConfirmRule implements ValidationRule
{
    protected $password;

    public function __construct($password = '')
    {
        $this->password = $password;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($attribute === 'confirm' && $value !== $this->password) {
            $fail('Password mismatch');
        }
    }
}
