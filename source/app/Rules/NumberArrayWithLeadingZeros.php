<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Custom rule to validate an array of strings representing
 * 10 or 13 - digits ISBNs
 */
class NumberArrayWithLeadingZeros implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        // check for empty value
        if (is_null($value) ||
            (is_array($value) && count($value) === 0) ||
            $value === ''
        ) {
            return;
        }

        // check for an array
        if (! is_array($value)) {
            $fail("The {$attribute} must be an array or empty.");

            return;
        }

        // check each item of the array
        foreach ($value as $item) {
            // item should be a string
            if (! is_string($item)) {
                $fail("All items in {$attribute} must be strings.");

                return;
            }

            // string should be 10 or 13 digits-only
            $length = strlen($item);
            if (($length !== 10 && $length !== 13) || ! ctype_digit($item)) {
                $fail("Items in {$attribute} must have correct format.");

                return;
            }
        }
    }
}
