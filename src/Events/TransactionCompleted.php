<?php

namespace Toneflix\LaravelPayPocket\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Toneflix\LaravelPayPocket\Models\Wallet;
use Toneflix\LaravelPayPocket\Models\WalletsLog;

class TransactionCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public string $type,
        public int|float $value,
        public Wallet $wallet,
        public WalletsLog $log,
    ) {}
}
