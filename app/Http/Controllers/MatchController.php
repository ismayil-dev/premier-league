<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\StandingRepository;
use App\Services\Simulator\MatchSimulator;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class MatchController extends Controller
{
    /**
     * @var LeagueMatchRepository $leagueMatchRepository
     */
    protected LeagueMatchRepository $leagueMatchRepository;

    /**
     * @var StandingRepository $standingRepository
     */
    protected StandingRepository $standingRepository;

    /**
     * @var MatchSimulator
     */
    protected MatchSimulator $matchSimulator;

    /**
     * MatchController constructor
     * @param LeagueMatchRepository $leagueMatchRepository
     * @param StandingRepository $standingRepository
     * @param MatchSimulator $matchSimulator
     */
    public function __construct(
        LeagueMatchRepository $leagueMatchRepository,
        StandingRepository    $standingRepository,
        MatchSimulator        $matchSimulator,
    )
    {
        $this->leagueMatchRepository = $leagueMatchRepository;
        $this->standingRepository = $standingRepository;
        $this->matchSimulator = $matchSimulator;
    }

    /**
     * Return matches rendered view
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function fetchMatches(Request $request): string
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        $matches = $this->leagueMatchRepository->getByWeeks();

        return view('all_weeks', compact('matches'))->render();
    }

    /**
     * Simulate matches by week, render and return view
     * @param Request $request
     * @param int $week
     * @return string
     * @throws Throwable
     */
    public function simulateWeek(Request $request, int $week): string
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        $this->matchSimulator::simulateByWeek($week);
        $weekMatches = $this->leagueMatchRepository->getByWeek($week);
        $standings = $this->standingRepository->getByScore();

        return view('week_match', compact('weekMatches', 'week', 'standings'))->render();
    }

    /**
     * Simulate all matches
     * @param Request $request
     * @return string
     * @throws Throwable
     */
    public function simulateAll(Request $request): string
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        $matches = $this->leagueMatchRepository->getNotPlayed();
        $this->matchSimulator::simulateBulk($matches);

        $matches = $this->leagueMatchRepository->getByWeeks();

        return view('all_weeks', compact('matches'))->render();
    }

    /**
     * Reset all simulations
     * @param Request $request
     * @return bool
     * @throws Throwable
     */
    public function reset(Request $request): bool
    {
        throw_if(!$request->ajax(), new BadRequestHttpException('Request should be AJAX'));

        if ($request->has('all') && $request->query('all')) {
            $this->matchSimulator::resetAll();
        } else {
            $this->matchSimulator::reset();
        }

        return true;
    }
}
