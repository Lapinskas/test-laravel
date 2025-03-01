<?php

use App\Helpers\Config;

beforeEach(function () {
    config()->set([]);
});

it('returns integer value when config key exists and is numeric', function () {
    config(['test.key' => '123']);
    expect(Config::int('test.key'))->toBe(123);
});

it('returns default integer when config key does not exist', function () {
    expect(Config::int('non.existent.key'))->toBe(0);
});

it('returns default integer when config value is not numeric', function () {
    config(['test.key' => 'not-a-number']);
    expect(Config::int('test.key'))->toBe(0);
});

it('returns string value when config key exists and is string', function () {
    config(['test.key' => 'hello']);
    expect(Config::int('test.key', 42))->toBe(42)
        ->and(Config::string('test.key'))->toBe('hello');
});

it('returns default string when config key does not exist', function () {
    expect(Config::string('non.existent.key'))->toBe('');
});

it('returns default string when config value is not string', function () {
    config(['test.key' => 123]);
    expect(Config::string('test.key'))->toBe('');
});

it('handles null values correctly', function () {
    config(['test.key' => null]);
    expect(Config::int('test.key'))->toBe(0)
        ->and(Config::string('test.key'))->toBe('');
});
