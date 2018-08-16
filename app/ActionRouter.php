<?php

namespace App;

use App\Actions\Decrease;
use App\Actions\IBalancesAction;
use App\Actions\Increase;
use App\Actions\SendTo;
use Mockery\Exception;

final class ActionRouter
{
    public const ROUTER_SEND_TO  = 'send';
    public const ROUTER_INCREASE = 'in';
    public const ROUTER_DECREASE = 'out';

    /**
     * Returns action instance for given action value
     *
     * @param $action
     *
     * @return IBalancesAction
     */
    public static function getRoute(string $action): IBalancesAction
    {
        switch ($action) {
            case (self::ROUTER_SEND_TO):
                return new SendTo();
            case (self::ROUTER_INCREASE):
                return new Increase();
            case (self::ROUTER_DECREASE):
                return new Decrease();
            default:
                throw new Exception('router '. $action . ' not found');
        }
    }
}
