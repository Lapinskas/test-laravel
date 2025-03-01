<?php
uses(Tests\TestCase::class);

use App\Services\LaravelLogger;
use Illuminate\Support\Facades\Log;

it('logs info message with context', function () {
    $logSpy = Log::spy();

    $message = 'Test message';
    $context = ['key' => 'value'];

    (new LaravelLogger())->info($message, $context);
    (new LaravelLogger())->error($message, $context);

    expect(fn() => $logSpy->shouldHaveReceived('info', [$message, $context]))->not->toThrow(Exception::class)
        ->and(fn() => $logSpy->shouldHaveReceived('error', [$message, $context]))->not->toThrow(Exception::class);

    Mockery::close();
});
