<?php

namespace App\Events\ActionEvents;

use App\Actions\IBalancesAction;
use App\Events\Event;

class BalanceChanged extends Event
{
    /**
     * @var IBalancesAction
     */
    public $action;

    /**
     * SentAmount constructor.
     * @param IBalancesAction $action
     */
    public function __construct(IBalancesAction $action)
    {
        $this->action = $action;
    }
}
