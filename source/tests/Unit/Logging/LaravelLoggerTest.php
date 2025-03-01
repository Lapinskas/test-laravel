<?php
uses(Tests\TestCase::class);

use App\Services\LaravelLogger;
use Illuminate\Support\Facades\Log;

it('logs info message with context', function () {
    $logSpy = Log::spy();

    $message = 'Test message';
    $context = ['key' => 'value'];

    (new LaravelLogger())->info($message, $context);

    $logSpy->shouldHaveReceived('info', [$message, $context]);

    Mockery::close();
});
