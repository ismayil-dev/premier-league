<?php

namespace App\Services\Simulator;

use App\Models\LeagueMatch;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void simulate(LeagueMatch $match)
 * @method static void simulateBulk(array|Collection $matches)
 * @method static void simulateByWeek(int $week)
 * @method static void reset()
 * @method static void resetAll()
 */
class MatchSimulator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'MatchSimulator';
    }
}
