<?php

namespace Toneflix\LaravelPayPocket\Facades;

use Illuminate\Support\Facades\Facade;
use Toneflix\LaravelPayPocket\Interfaces\WalletOperations;
use Toneflix\LaravelPayPocket\Services\PocketServices;

/**
 * @see PocketServices
 *
 * @method static \Illuminate\Support\Collection pay(WalletOperations $user, int|float $orderValue, array $allowedWallets = [], ?string $notes = null)
 * @method static bool deposit(WalletOperations $user, string $type, int|float $amount, ?string $notes = null)
 * @method static int|float checkBalance(WalletOperations $user)
 * @method static int|float walletBalanceByType(WalletOperations $user, string $type)
 */
class LaravelPayPocket extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PocketServices::class;
    }
}
