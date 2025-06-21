<?php

namespace ToneflixCode\LaravelPayPocket\Models;

use App\Enums\WalletEnums;
use ToneflixCode\LaravelPayPocket\Traits\BalanceOperation;
use ToneflixCode\LaravelPayPocket\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * ToneflixCode\LaravelPayPocket\Models\Wallet
 *
 * @property mixed $balance
 * @property WalletEnums $type
 */
class Wallet extends Model
{
    use BalanceOperation;
    use HasFactory;
    use Loggable;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => WalletEnums::class,
    ];

    public function owner(): MorphTo
    {
        return $this->morphTo();
    }
}
