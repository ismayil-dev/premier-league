<?php

namespace Database\Seeders;

use App\Http\Repositories\TeamRepository;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{

    /**
     * @var TeamRepository
     */
    protected TeamRepository $teamRepository;

    /**
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Liverpool', 'logo' => 'liverpool.png', 'created_at' => now()],
            ['name' => 'Chelsea', 'logo' => 'chelsea.png', 'created_at' => now()],
            ['name' => 'Manchester United', 'logo' => 'manchester-united.png', 'created_at' => now()],
            ['name' => 'Arsenal', 'logo' => 'arsenal.png', 'created_at' => now()],
            //            [ 'name' => 'Everton', 'logo' => 'everton.png', 'created_at' => now()],
            //            [ 'name' => 'Manchester City', 'logo' => 'manchester-city.png', 'created_at' => now()],
            //            [ 'name' => 'Aston Villa', 'logo' => 'aston-villa.png', 'created_at' => now()],
            //            [ 'name' => 'Watford', 'logo' => 'watford.png', 'created_at' => now()],
            //            [ 'name' => 'Tottenham ', 'logo' => 'tottenham .png', 'created_at' => now()],
            //            [ 'name' => 'Brentford', 'logo' => 'brentford.png', 'created_at' => now()],
        ];

        $this->teamRepository->insert($data);
    }
}
