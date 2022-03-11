<?php

namespace App\Services\Simulator;

use Illuminate\Support\ServiceProvider;

class MatchSimulatorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('MatchSimulator', MatchSimulatorService::class);
    }
}
