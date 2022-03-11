<?php

namespace App\Services\Prediction;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection calculate()
 */
class Prediction extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Prediction';
    }
}
