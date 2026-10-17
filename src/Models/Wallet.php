<?php

namespace Toneflix\LaravelPayPocket\Models;

use App\Enums\WalletEnums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Toneflix\LaravelPayPocket\Traits\BalanceOperation;
use Toneflix\LaravelPayPocket\Traits\Loggable;

/**
 * Toneflix\LaravelPayPocket\Models\Wallet
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
