<?php

namespace ToneflixCode\LaravelPayPocket\Traits;

use Illuminate\Support\Facades\DB;
use ToneflixCode\LaravelPayPocket\Exceptions\InsufficientBalanceException;
use ToneflixCode\LaravelPayPocket\Models\WalletsLog;

trait HandlesPayment
{
    /**
     * Pay the order value from the user's wallets.
     *
     * @param  string[]  $allowedWallets
     * @return \Illuminate\Support\Collection<TKey,WalletsLog>
     *
     * @throws InsufficientBalanceException
     */
    public function pay(int|float $orderValue, array $allowedWallets = [], ?string $notes = null): \Illuminate\Database\Eloquent\Collection
    {
        if (! $this->hasSufficientBalance($orderValue)) {
            throw new InsufficientBalanceException('Insufficient balance to cover the order.');
        }

        $log = DB::transaction(function () use ($orderValue, $notes, $allowedWallets) {
            $remainingOrderValue = $orderValue;

            /**
             * @var \Illuminate\Support\Collection<TKey, \ToneflixCode\LaravelPayPocket\Models\Wallet>
             */
            $walletsInOrder = $this->wallets()->whereIn('type', $this->walletsInOrder())->get();

            $logs = (new WalletsLog)->newCollection();

            /**
             * @param string|\App\Enums\WalletEnums
             * @return bool $useWallet
             * */
            $useWallet = function (string|\App\Enums\WalletEnums $wallet) use ($allowedWallets) {
                return count($allowedWallets) < 1 ||
                    in_array($wallet, $allowedWallets) ||
                    in_array($wallet->value, $allowedWallets);
            };

            /**
             * @var BalanceOperation $wallet
             */
            foreach ($walletsInOrder as $wallet) {
                if (! $wallet || ! $wallet->hasBalance() || ! $useWallet($wallet->type)) {
                    continue;
                }

                $amountToDeduct = min($wallet->balance, $remainingOrderValue);
                $logs->push($wallet->decrementAndCreateLog($amountToDeduct, $notes));

                $remainingOrderValue -= $amountToDeduct;

                if ($remainingOrderValue <= 0) {
                    break;
                }
            }

            if ($remainingOrderValue > 0) {
                throw new InsufficientBalanceException('Insufficient total wallet balance to cover the order.');
            }

            return $logs;
        });

        return $log;
    }
}
