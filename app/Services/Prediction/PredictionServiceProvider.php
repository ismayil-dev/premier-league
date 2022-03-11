<?php

namespace App\Services\Prediction;

use Illuminate\Support\ServiceProvider;

class PredictionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Prediction', PredictionService::class);
    }
}
