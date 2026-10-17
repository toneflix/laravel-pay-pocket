<?php

namespace Toneflix\LaravelPayPocket\Services;

use Illuminate\Support\Collection;
use Toneflix\LaravelPayPocket\Exceptions\InsufficientBalanceException;
use Toneflix\LaravelPayPocket\Interfaces\WalletOperations;
use Toneflix\LaravelPayPocket\Models\WalletsLog;

class PocketServices
{
    /**
     * Deposit an amount to the user's wallet of a specific type.
     */
    public function deposit(WalletOperations $user, string $type, int|float $amount, ?string $notes = null): bool
    {
        return $user->deposit($type, $amount, $notes);
    }

    /**
     * Pay the order value from the user's wallets.
     *
     *
     * @return Collection<WalletsLog>
     *
     * @throws InsufficientBalanceException
     */
    public function pay(
        WalletOperations $user,
        int|float $orderValue,
        array $allowedWallets = [],
        ?string $notes = null
    ): Collection {
        return $user->pay($orderValue, $allowedWallets, $notes);
    }

    /**
     * Get the balance of the user.
     */
    public function checkBalance(WalletOperations $user): int|float
    {
        return $user->getWalletBalance();
    }

    /**
     * Get the balance of a specific wallet type.
     */
    public function walletBalanceByType(WalletOperations $user, string $type): int|float
    {
        return $user->getWalletBalanceByType($type);
    }
}
