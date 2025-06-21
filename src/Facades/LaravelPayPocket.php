<?php

namespace ToneflixCode\LaravelPayPocket\Facades;

use Illuminate\Support\Facades\Facade;
use ToneflixCode\LaravelPayPocket\Interfaces\WalletOperations;

/**
 * @see \ToneflixCode\LaravelPayPocket\Services\PocketServices
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
        return \ToneflixCode\LaravelPayPocket\Services\PocketServices::class;
    }
}
