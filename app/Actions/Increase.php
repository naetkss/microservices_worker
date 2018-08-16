<?php

namespace App\Actions;

use App\Events\ActionEvents\BalanceChanged;
use App\User;

class Increase implements IBalancesAction
{
    /**
     * @inheritdoc
     */
    public function handle(User $user, float $amount, ?User $to)
    {
        $user->balance->increase($amount);

        event(new BalanceChanged($this));
    }
}
