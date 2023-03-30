<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class PhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $phoneNumberProto = $phoneUtil->parse($value);
        } catch (NumberParseException $e) {
            $fail('The ' . $attribute . ' is invalid.');
        }
        if (!$phoneUtil->isValidNumber($phoneNumberProto)) {
            $fail('The ' . $attribute . ' is invalid.');
        }
    }
}
