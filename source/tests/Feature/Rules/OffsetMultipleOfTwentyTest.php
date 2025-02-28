<?php

use App\Rules\OffsetMultipleOfTwenty;
use Illuminate\Support\Facades\Validator;

it('passes when value is null', function () {
    $validator = getOffsetValidator(null);
    expectPassesForOffset($validator);
});

it('passes when value is a positive multiple of 20', function ($value) {
    $validator = getOffsetValidator($value);
    expectPassesForOffset($validator);
})->with([0, 20, 40, 60]);

it('fails when value is a negative multiple of 20', function ($value) {
    $validator = getOffsetValidator($value);
    expectFailsForOffset($validator);
})->with([-20, -40, -60]);

it('fails when value is not a multiple of 20', function ($value) {
    $validator = getOffsetValidator($value);
    expectFailsForOffset($validator);
})->with([1, 19, 21, 39, -1, -19]);

it('fails when value is not numeric', function ($value) {
    $validator = getOffsetValidator($value);
    expectFailsForOffset($validator);
})->with(['abc', '20abc', new stdClass]);

it('passes when value is a numeric string representing a multiple of 20', function ($value) {
    $validator = getOffsetValidator($value);
    expectPassesForOffset($validator);
})->with(['0', '20', '40']);

it('fails when value is a numeric string not representing a multiple of 20', function ($value) {
    $validator = getOffsetValidator($value);
    expectFailsForOffset($validator);
})->with(['1', '19', '21', '-19', '-20']);

it('fails in case of float values', function ($value) {
    $validator = getOffsetValidator($value);
    expectFailsForOffset($validator);
})->with([20.0, 20.1, 19.9, -20.0]);

it('handles edge case of very large numbers', function ($value) {
    $validator = getOffsetValidator($value);
    if ($value % 20 === 0) {
        expectPassesForOffset($validator);
    } else {
        expectFailsForOffset($validator);
    }

})->with([PHP_INT_MAX, PHP_INT_MAX - 1, -PHP_INT_MAX]);

// Helpers

function getOffsetValidator($value)
{
    return Validator::make([
        'offset' => $value,
    ], [
        'offset' => new OffsetMultipleOfTwenty,
    ]);
}

function expectPassesForOffset($validator): void
{
    expect($validator->fails())->toBeFalse();
}

function expectFailsForOffset($validator): void
{
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('offset'))
        ->toBe('The offset must be a non-negative multiple of 20');
}
