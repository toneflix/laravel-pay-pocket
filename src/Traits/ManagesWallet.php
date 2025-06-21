<?php

namespace ToneflixCode\LaravelPayPocket\Traits;

trait ManagesWallet
{
    use HandlesDeposit, HandlesPayment, HasWallet;
}
