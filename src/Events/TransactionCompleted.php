<?php

namespace ToneflixCode\LaravelPayPocket\Events;

use ToneflixCode\LaravelPayPocket\Models\Wallet;
use ToneflixCode\LaravelPayPocket\Models\WalletsLog;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderShipped
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public Wallet $wallet,
        public WalletsLog $log,
    ) {}
}
