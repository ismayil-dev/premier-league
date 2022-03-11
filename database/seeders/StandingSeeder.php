<?php

namespace Database\Seeders;

use App\Http\Repositories\StandingRepository;
use App\Http\Repositories\TeamRepository;
use Illuminate\Database\Seeder;

class StandingSeeder extends Seeder
{
    /**
     * @var TeamRepository
     */
    protected TeamRepository $teamRepository;

    /**
     * @var StandingRepository
     */
    protected StandingRepository $standingRepository;

    /**
     * @param TeamRepository $teamRepository
     * @param StandingRepository $standingRepository
     */
    public function __construct(TeamRepository $teamRepository, StandingRepository $standingRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->standingRepository = $standingRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = $this->teamRepository->getForSeeding();
        $this->standingRepository->insert($teams);
    }
}
