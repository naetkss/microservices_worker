<?php

namespace App\Actions;

use App\Events\ActionEvents\BalanceChanged;
use App\User;

class SendTo implements IBalancesAction
{
    /**
     * @inheritdoc
     */
    public function handle(User $user, float $amount, ?User $to)
    {
        if ($to === null) {
            throw new \InvalidArgumentException('User to is null');
        }

        $user->sendTo($to, $amount);

        event(new BalanceChanged($this));
    }
}
