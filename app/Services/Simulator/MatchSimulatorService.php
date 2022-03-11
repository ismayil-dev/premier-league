<?php

namespace App\Services\Simulator;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\StandingRepository;
use App\Http\Repositories\TeamRepository;
use App\Models\LeagueMatch;
use App\Services\MatchService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

class MatchSimulatorService
{
    /**
     * Match service
     * @var MatchService
     */
    protected MatchService $matchService;

    /**
     * @var LeagueMatchRepository
     */
    protected LeagueMatchRepository $leagueMatchRepository;

    /**
     * @var StandingRepository
     */
    protected StandingRepository $standingRepository;

    protected TeamRepository $teamRepository;

    public function __construct(
        MatchService          $matchService,
        StandingRepository    $standingRepository,
        LeagueMatchRepository $leagueMatchRepository,
        TeamRepository        $teamRepository,
    )
    {
        $this->matchService = $matchService;
        $this->standingRepository = $standingRepository;
        $this->leagueMatchRepository = $leagueMatchRepository;
        $this->teamRepository = $teamRepository;
    }

    /**
     * Simulate match
     * @param LeagueMatch $match
     * @throws Exception
     */
    public function simulate(LeagueMatch $match)
    {
        $homeStanding = $this->standingRepository->getByTeam($match->home_team_id);
        $awayStanding = $this->standingRepository->getByTeam($match->away_team_id);

        $homeGoal = random_int(LeagueMatch::MINIMUM_GOAL, LeagueMatch::MAX_GOAL);
        $awayGoal = random_int(LeagueMatch::MINIMUM_GOAL, LeagueMatch::MAX_GOAL);

        if ($match->is_played) {
            return;
        }

        $match->update([
            'home_team_goal' => $homeGoal,
            'away_team_goal' => $awayGoal,
            'is_played'      => LeagueMatch::STATUS_PLAYED
        ]);

        if ($homeGoal > $awayGoal) {
            $this->standingRepository->winMatch($homeStanding, $homeGoal, $awayGoal);
            $this->standingRepository->lostMatch($awayStanding, $awayGoal, $homeGoal);
        } elseif ($homeGoal < $awayGoal) {
            $this->standingRepository->winMatch($awayStanding, $awayGoal, $homeGoal);
            $this->standingRepository->lostMatch($homeStanding, $homeGoal, $awayGoal);
        } else {
            $this->standingRepository->drawnMatch($homeStanding, $homeGoal, $awayGoal);
            $this->standingRepository->drawnMatch($awayStanding, $homeGoal, $awayGoal);
        }
    }

    /**
     * Simulate matches by week
     * @param int $week
     * @throws Exception
     */
    public function simulateByWeek(int $week)
    {
        $matches = $this->leagueMatchRepository->getByWeek($week);
        foreach ($matches as $match) {
            $this->simulate($match);
        }
    }

    /**
     * Simulate many matches
     * @param array|Collection $matches
     * @throws Exception
     */
    public function simulateBulk(array|Collection $matches)
    {
        foreach ($matches as $match) {
            $this->simulate($match);
        }
    }

    /**
     * Reset only matches and standings
     */
    public function reset()
    {
        $this->leagueMatchRepository->updateAll([
            'home_team_goal' => null,
            'away_team_goal' => null,
            'is_played'      => LeagueMatch::STATUS_NOT_PLAYED
        ]);

        $this->standingRepository->truncate();
        $this->standingRepository->insert($this->teamRepository->getForSeeding());
    }

    /**
     * Reset only matches and standings including fixtures
     * @throws Throwable
     */
    public function resetAll()
    {
        $this->leagueMatchRepository->truncate();
        $this->standingRepository->truncate();
        $this->matchService->generateFixture();
        $this->standingRepository->insert($this->teamRepository->getForSeeding());
    }
}
