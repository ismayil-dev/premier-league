<?php

namespace Tests\Unit;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\StandingRepository;
use App\Models\LeagueMatch;
use App\Models\Standing;
use App\Services\GameService;
use App\Services\Prediction\Prediction;
use Tests\UnitTestCase;
use Throwable;

class GameServiceTest extends UnitTestCase
{
    /**
     * @throws Throwable
     */
    public function testGetMatches()
    {
        $this->seed();
        $this->matchService->generateFixture();
        $gameService = new GameService(new LeagueMatchRepository(new LeagueMatch()), new StandingRepository(new Standing()), new Prediction());
        $matches = $gameService->getMatches();
        
        $this->assertArrayHasKey('standings', $matches);
        $this->assertArrayHasKey('matches', $matches);
        $this->assertArrayHasKey('predictions', $matches);
        $this->assertArrayHasKey('lastWeek', $matches);

        $this->assertNotEmpty($matches['standings']);
        $this->assertNotEmpty($matches['matches']);
        $this->assertNotEmpty($matches['predictions']);
        $this->assertNotEmpty($matches['lastWeek']);
    }
}
