<?php

namespace Toneflix\LaravelPayPocket\Traits;

trait ManagesWallet
{
    use HandlesDeposit, HandlesPayment, HasWallet;
}
