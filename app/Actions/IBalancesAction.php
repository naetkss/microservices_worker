<?php

namespace App\Actions;

use App\User;

interface IBalancesAction
{
    /**
     * Performs action
     *
     * @param User $user
     * @param User|null $to
     * @param float $amount
     *
     * @return mixed
     */
    public function handle(User $user, float $amount, ?User $to);
}
