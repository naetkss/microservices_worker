<?php

namespace App\Providers;

use App\Events\ActionEvents\BalanceChanged;
use App\Listeners\BalanceChangedListener;
use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BalanceChanged::class => [
            BalanceChangedListener::class,
        ],
    ];
}
