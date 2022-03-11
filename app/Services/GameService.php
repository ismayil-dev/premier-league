<?php

namespace App\Services;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\StandingRepository;
use App\Services\Prediction\Prediction;

class GameService
{
    /**
     * @var StandingRepository
     */
    private StandingRepository $standingRepository;

    /**
     * @var LeagueMatchRepository
     */
    private LeagueMatchRepository $leagueMatchRepository;

    /**
     * @var Prediction
     */
    private Prediction $prediction;

    /**
     * GameService constructor
     * @param LeagueMatchRepository $leagueMatchRepository
     * @param StandingRepository $standingRepository
     * @param Prediction $prediction
     */
    public function __construct(
        LeagueMatchRepository $leagueMatchRepository,
        StandingRepository    $standingRepository,
        Prediction            $prediction,
    )
    {
        $this->leagueMatchRepository = $leagueMatchRepository;
        $this->standingRepository = $standingRepository;
        $this->prediction = $prediction;
    }

    /**
     * Return required data to show matches
     * @return array
     */
    public function getMatches(): array
    {
        return [
            'standings'   => $this->standingRepository->getByScore(),
            'matches'     => $this->leagueMatchRepository->getByWeeks(),
            'predictions' => $this->prediction::calculate(),
            'lastWeek'    => $this->leagueMatchRepository->getLastWeek(),
        ];
    }
}
