<?php

namespace App\Services\Scheduler;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\ServiceProvider;

/**
 * @method static DoubleRoundRobin teams(array|Collection $teams)
 * @method array scheduleFixtures()
 */
class SchedulerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Scheduler', DoubleRoundRobin::class);
    }
}
