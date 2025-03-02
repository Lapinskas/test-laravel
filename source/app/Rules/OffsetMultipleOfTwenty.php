<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

/**
 * Custom rule to validate zero or positive integer multiple of 20
 */
class OffsetMultipleOfTwenty implements ValidationRule
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
        if (is_null($value)) {
            return;
        }

        if (! is_numeric($value) ||
            ! is_int($value + 0) ||
            $value < 0 ||
            $value % 20 !== 0
        ) {
            $fail("The {$attribute} must be a non-negative multiple of 20");
        }
    }
}
