<?php

namespace Tests\Unit;

use App\Http\Repositories\LeagueMatchRepository;
use App\Models\LeagueMatch;
use Tests\UnitTestCase;
use Throwable;

class MatchServiceTest extends UnitTestCase
{
    /**
     * Test fixture is generated
     * @throws Throwable
     */
    public function testGenerateFixture()
    {
        $this->seed();
        $leagueMatchRepo = new LeagueMatchRepository(new LeagueMatch());
        $leagueMatchRepo->truncate();

        $this->matchService->generateFixture();

        $this->assertNotEmpty($leagueMatchRepo->all());
    }

    /**
     * Test fixture is not generated
     */
    public function testFixtureIsNotGenerated()
    {
        $leagueMatchRepo = new LeagueMatchRepository(new LeagueMatch());
        $leagueMatchRepo->truncate();

        $this->assertFalse($this->matchService->fixtureIsGenerated());
    }

    /**
     * Test fixture is generated
     * @throws Throwable
     */
    public function testFixtureIsGenerated()
    {
        $this->seed();
        $leagueMatchRepo = new LeagueMatchRepository(new LeagueMatch());
        $leagueMatchRepo->truncate();

        $this->matchService->generateFixture();

        $this->assertTrue($this->matchService->fixtureIsGenerated());
    }
}
