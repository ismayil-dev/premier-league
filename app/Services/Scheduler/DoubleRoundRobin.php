<?php

namespace App\Services\Scheduler;

use App\Services\Scheduler\Exceptions\TeamNotSetOrMinimumNumberException;
use Exception;
use Throwable;

/**
 * for more information please visit https://en.wikipedia.org/wiki/Round-robin_tournament
 */
class DoubleRoundRobin
{
    /**
     * Teams
     * @var array $teams
     */
    protected array $teams = [];

    /**
     * Set teams
     * @param array $teams
     * @return static
     * @throws Exception
     */
    public function teams(array $teams): static
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * Build and refine fixtures
     * @return array
     * @throws Throwable
     * @throws Exception
     */
    public function build(): array
    {
        $teams = $this->teams;

        throw_if(empty($teams) || count($teams) < 2, new TeamNotSetOrMinimumNumberException("Teams can't be empty or minimum number of teams should 2"));

        //Check number of teams and add fake team due to condition
        if (count($teams) % 2 === 1) {
            $teams[] = null;
        }

        shuffle($teams); //shuffle teams

        $fixtures = $this->buildFixtures($teams); //build fixtures

        return $this->refineFixtures($fixtures);
    }

    /**
     * Build the fixtures array.
     * @param $teams
     * @return array
     */
    protected function buildFixtures($teams): array
    {
        $fixtures = [];
        $teamCount = count($teams);
        $halfTeamCount = $teamCount / 2;
        $weeks = (($teamCount) % 2 === 0 ? $teamCount - 1 : $teamCount) * 2;

        for ($week = 1; $week <= $weeks; $week += 1) {
            foreach ($teams as $key => $team) {
                if ($key >= $halfTeamCount) {
                    break;
                }
                $team1 = $team;
                $team2 = $teams[$key + $halfTeamCount];

                $match = $week % 2 === 0 ? ['home' => $team1, 'away' => $team2] : ['home' => $team2, 'away' => $team1];
                $fixtures[$week][] = $match;
            }
            $teams = $this->rotate($teams);
        }

        return $fixtures;
    }

    /**
     * Check if there is empty (null) match remove it
     * @param array $fixtures
     * @return array
     */
    protected function refineFixtures(array $fixtures): array
    {
        return array_map(function ($round) {
            $values = array_map(function ($match) {
                return array_filter($match, function () use ($match) {
                    return !in_array(null, $match) ?? $match;
                });
            }, $round);
            $matches = array_filter($values);

            return array_values($matches);
        }, $fixtures);
    }

    /**
     * Rotate array items according to the round-robin algorithm.
     * @param array $teams
     * @return array
     */
    protected function rotate(array $teams): array
    {
        $teamCount = count($teams);
        if ($teamCount < 3) {
            return $teams;
        }
        $lastIndex = $teamCount - 1;
        $factor = (int)($teamCount % 2 === 0 ? $teamCount / 2 : ($teamCount / 2) + 1);
        $topRightIndex = $factor - 1;
        $topRightItem = $teams[$topRightIndex];
        $bottomLeftIndex = $factor;
        $bottomLeftItem = $teams[$bottomLeftIndex];
        for ($i = $topRightIndex; $i > 0; $i -= 1) {
            $teams[$i] = $teams[$i - 1];
        }
        for ($i = $bottomLeftIndex; $i < $lastIndex; $i += 1) {
            $teams[$i] = $teams[$i + 1];
        }
        $teams[1] = $bottomLeftItem;
        $teams[$lastIndex] = $topRightItem;

        return $teams;
    }
}
