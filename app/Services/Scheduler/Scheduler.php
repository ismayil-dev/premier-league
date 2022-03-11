<?php

namespace App\Services\Scheduler;

use Illuminate\Support\Facades\Facade;

/**
 * @method static DoubleRoundRobin teams(array $teams)
 * @method array build()
 */
class Scheduler extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Scheduler';
    }
}
