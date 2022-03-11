<?php

namespace App\Services;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\TeamRepository;
use App\Services\Exceptions\NoTeamAvailableGenerateFixtureException;
use App\Services\Scheduler\Scheduler;
use Throwable;

class MatchService
{
    /**
     * @var LeagueMatchRepository
     */
    private LeagueMatchRepository $leagueMatchRepository;

    /**
     * @var TeamRepository
     */
    private TeamRepository $teamRepository;

    /**
     * @var Scheduler
     */
    private Scheduler $scheduler;

    /**
     * MatchService constructor
     * @param LeagueMatchRepository $leagueMatchRepository
     * @param TeamRepository $teamRepository
     * @param Scheduler $scheduler
     */
    public function __construct(LeagueMatchRepository $leagueMatchRepository, TeamRepository $teamRepository, Scheduler $scheduler)
    {
        $this->leagueMatchRepository = $leagueMatchRepository;
        $this->teamRepository = $teamRepository;
        $this->scheduler = $scheduler;
    }

    /**
     * @throws Throwable
     */
    public function generateFixture()
    {
        $teams = $this->teamRepository->getPluckArray();
        throw_if(empty($teams), new NoTeamAvailableGenerateFixtureException('No team available to generate fixture'));
        $fixtures = $this->scheduler::teams($teams)->build();

        foreach ($fixtures as $week => $fixture) {
            foreach ($fixture as $team) {
                $this->leagueMatchRepository->create([
                    'home_team_id' => $team['home'],
                    'away_team_id' => $team['away'],
                    'week' => $week,
                    'played_at' =>  now()->addWeeks($week),
                ]);
            }
        }
    }

    /**
     * Check fixture is generated or not
     * @return bool
     */
    public function fixtureIsGenerated(): bool
    {
        return $this->leagueMatchRepository->count();
    }

}
