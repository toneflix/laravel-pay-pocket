<?php

namespace ToneflixCode\LaravelPayPocket\Interfaces;

use ToneflixCode\LaravelPayPocket\Exceptions\InsufficientBalanceException;

interface WalletOperations
{
    /**
     * Get User's Wallet Balance
     */
    public function getWalletBalanceAttribute(): int|float;

    /**
     * Get the balance of a specific wallet type.
     */
    public function getWalletBalanceByType(string $walletType): int|float;

    /**
     *  Check if User's wallet balance is more than given value
     */
    public function hasSufficientBalance(int|float $value): bool;

    /**
     * Pay the order value from the user's wallets.
     *
     *
     * @return \Illuminate\Support\Collection<\ToneflixCode\LaravelPayPocket\Models\WalletsLog>
     *
     * @throws InsufficientBalanceException
     */
    public function pay(
        int|float $orderValue,
        array $allowedWallets = [],
        ?string $notes = null
    ): \Illuminate\Support\Collection;

    /**
     * Deposit an amount to the user's wallet of a specific type.
     */
    public function deposit(string $type, int|float $amount, ?string $notes = null): bool;

    /**
     * Get user's wallet balance.
     */
    public function getWalletBalance(): int|float;
}
