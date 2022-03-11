<?php

namespace App\Http\Controllers;

use App\Services\GameService;
use App\Services\MatchService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Throwable;

class AppController extends Controller
{
    /**
     * Return home page
     * @param MatchService $matchService
     * @param GameService $gameService
     * @return Application|Factory|View
     * @throws Throwable
     */
    public function index(MatchService $matchService, GameService $gameService): View|Factory|Application
    {
        if (!$matchService->fixtureIsGenerated()) {
            $matchService->generateFixture();
        }

        return view('home', $gameService->getMatches());
    }
}
