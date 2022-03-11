<?php

namespace Tests\Feature;

use App\Models\LeagueMatch;
use App\Models\Standing;
use Tests\TestCase;

class MatchSimulatorTest extends TestCase
{
    /**
     * Test index page
     */
    public function testHomePage()
    {
        $this->get(route('index'))->assertOk()->assertSeeText('Premier League');
    }
    /**
     * Test simulate next week
     */
    public function testPlayNextWeek()
    {
        $this->from(route('index'))
            ->ajaxPostJson(route('matches.simulate_week', ['week' => Standing::nextWeek()]), [])
            ->assertOk();
        $this->assertNotEmpty(LeagueMatch::onlyPlayed()->get());
    }

    /**
     * Test Play all week
     */
    public function testPlayAllWeek()
    {
        $this->from(route('index'))->ajaxPostJson(route('matches.simulate_all'), [])->assertOk();
        $this->assertEmpty(LeagueMatch::onlyNotPlayed()->get());
    }

    /**
     * Test Reset all matches, fixtures and standings
     */
    public function testResetAll()
    {
        $this->from(route('index'))->ajaxPostJson(route('matches.reset', ['all' => 1]), [])->assertOk();
        $this->assertEmpty(LeagueMatch::onlyPlayed()->get());
    }

    /**
     * Test Reset only matches and standings
     */
    public function testResetOnlyStandingAndMatches()
    {
        $this->from(route('index'))->ajaxPostJson(route('matches.reset'), [])->assertOk();
        $this->assertEmpty(LeagueMatch::onlyPlayed()->get());
    }

    /**
     * Test Fetch matches
     */
    public function testFetchMatches()
    {
        $this->from(route('index'))->ajaxPostJson(route('matches.fetch_all'), [])->assertOk();
    }
}
