<?php

use Illuminate\Support\Facades\Event;
use ToneflixCode\LaravelPayPocket\Tests\Models\User;
use ToneflixCode\LaravelPayPocket\Events\TransactionCompleted;

it('will not use debugging functions')
    ->expect(['dd', 'dump', 'ray'])
    ->each->not->toBeUsed();

test('dispatches events', function () {
    Event::fake();

    $user = User::factory()->create();

    // Perform wallet update...
    $type = 'main_escrow';
    $user->deposit($type, 234.56);

    // Assert that an event was dispatched...
    Event::assertDispatched(function (TransactionCompleted $event) {
        return $event->type === 'inc';
    });
});
