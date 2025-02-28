<?php

use App\Rules\NumberArrayWithLeadingZeros;
use Illuminate\Support\Facades\Validator;

it('passes when value is null, empty array or empty string', function ($value) {
    $validator = getIsbnValidator($value);
    expectPassesForIsbn($validator);
})->with([
    null,
    [[]],
    '',
]);

it('passes when value is an array of valid 10-digit strings', function ($value) {
    $validator = getIsbnValidator($value);
    expectPassesForIsbn($validator);
})->with([
    [['0123456789', '9876543210']],
    [['0000000000']],
]);

it('passes when value is an array of valid 13-digit strings', function ($value) {
    $validator = getIsbnValidator($value);
    expectPassesForIsbn($validator);
})->with([
    [['0123456789012', '9876543210987']],
    [['0000000000000']],
]);

it('fails with "must be an array or empty" when value is not an array, string, or null', function ($value) {
    $validator = getIsbnValidator($value);
    expectFailsForIsbn($validator, 'The isbn must be an array or empty.');
})->with([
    1234567890,
    true,
    new stdClass,
]);

it('fails with "must be strings" when array contains non-string items', function ($value) {
    $validator = getIsbnValidator($value);
    expectFailsForIsbn($validator, 'All items in isbn must be strings.');
})->with([
    [[1234567890]],
    [['0123456789', 9876543210]],
    [[['0123456789']]],
]);

it('fails with when array contains strings of invalid length', function ($value) {
    $validator = getIsbnValidator($value);
    expectFailsForIsbn($validator, 'Items in isbn must have correct format.');
})->with([
    [['123']],
    [['012345678']],
    [['01234567890123']],
]);

it('fails with when array contains non-digit strings', function ($value) {
    $validator = getIsbnValidator($value);
    expectFailsForIsbn($validator, 'Items in isbn must have correct format.');
})->with([
    [['01234abcde']],
    [['0123456789abc']],
    [['0123456789!@#']],
]);

it('fails with when array mixes valid and invalid items', function ($value) {
    $validator = getIsbnValidator($value);
    expectFailsForIsbn($validator, 'Items in isbn must have correct format.');
})->with([
    [['0123456789', '123']],
    [['9876543210987', 'abc']],
]);

// Helpers

function getIsbnValidator($value): \Illuminate\Validation\Validator
{
    return Validator::make([
        'isbn' => $value,
    ], [
        'isbn' => new NumberArrayWithLeadingZeros,
    ]);
}

function expectPassesForIsbn($validator): void
{
    expect($validator->fails())->toBeFalse();
}

function expectFailsForIsbn($validator, $message): void
{
    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->first('isbn'))
        ->toBe($message);
}
