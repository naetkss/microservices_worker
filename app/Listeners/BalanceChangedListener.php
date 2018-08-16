<?php

namespace App\Listeners;

use App\Events\ActionEvents\BalanceChanged;

class BalanceChangedListener
{
    /**
     * Handle the event.
     *
     * @param BalanceChanged $event
     *
     * @return void
     */
    public function handle(BalanceChanged $event)
    {
        echo get_class($event->action) . PHP_EOL;

        // TODO some staff
    }
}
