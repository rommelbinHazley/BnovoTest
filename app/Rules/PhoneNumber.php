<?php

namespace App\Rules;

use App\Facades\PhoneNumberFacade;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class PhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            /** @throw Number */
            PhoneNumberFacade::parse($value);
        } catch (Exception) {
            //В дальнейшем перевести на файлы локализации.
            $fail('Incorrect phone number.');
        }
    }
}
