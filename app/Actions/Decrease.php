<?php

namespace App\Actions;

use App\Events\ActionEvents\BalanceChanged;
use App\User;

class Decrease implements IBalancesAction
{
    /**
     * @inheritdoc
     */
    public function handle(User $user, float $amount, ?User $to)
    {
        $user->balance->decrease($amount);

        event(new BalanceChanged($this));
    }
}
