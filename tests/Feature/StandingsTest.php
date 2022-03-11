<?php

namespace Tests\Feature;

use Tests\TestCase;

class StandingsTest extends TestCase
{
    /**
     * Test fetching standings
     */
    public function testFetchStandings()
    {
        $this->from(route('index'))->ajaxPostJson(route('standings.fetch'), [])->assertOk();
    }

    /**
     * Test fetching predictions
     */
    public function testFetchPredictions()
    {
        $this->from(route('index'))->ajaxPostJson(route('standings.fetch_predictions'), [])->assertOk();
    }
}
