<?php

namespace ToneflixCode\LaravelPayPocket\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use ToneflixCode\LaravelPayPocket\Models\Wallet;
use ToneflixCode\LaravelPayPocket\Models\WalletsLog;

class TransactionCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $type,
        public Wallet $wallet,
        public WalletsLog $log,
    ) {}
}
