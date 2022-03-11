<?php

namespace App\Http\Repositories;

use App\Models\Standing;

class StandingRepository extends AbstractRepository
{
    /**
     * @param Standing $model
     */
    public function __construct(Standing $model)
    {
        parent::__construct($model);
    }

    /**
     * Team win match
     * @param Standing $standing
     * @param int $goal_for
     * @param int $goal_against
     */
    public function winMatch(Standing $standing, int $goal_for, int $goal_against)
    {
        $this->update($standing->id, [
            'played'       => $standing->played + 1,
            'won'          => $standing->won + 1,
            'goal_for'     => $standing->goal_for + $goal_for,
            'goal_against' => $standing->goal_against + $goal_against,
            'score'        => $standing->score + Standing::WIN_SCORE
        ]);
    }

    /**
     * Team lost match
     * @param Standing $standing
     * @param int $goal_for
     * @param int $goal_against
     */
    public function lostMatch(Standing $standing, int $goal_for, int $goal_against)
    {
        $this->update($standing->id, [
            'played'       => $standing->played + 1,
            'lost'         => $standing->lost + 1,
            'goal_for'     => $standing->goal_for + $goal_for,
            'goal_against' => $standing->goal_against + $goal_against
        ]);
    }

    public function drawnMatch(Standing $standing, int $goal_for, int $goal_against)
    {
        $standing->update([
            'played'       => $standing->played + 1,
            'drawn'        => $standing->drawn + 1,
            'goal_for'     => $standing->goal_for + $goal_for,
            'goal_against' => $standing->goal_against + $goal_against,
            'score'        => $standing->score + Standing::DRAWN_SCORE
        ]);
    }

    /**
     * Return standings order by score
     * @return mixed
     */
    public function getByScore()
    {
        return $this->model::byScore()->get();
    }

    /**
     * @param int $teamId
     * @return Standing|null
     */
    public function getByTeam(int $teamId): ?Standing
    {
        return $this->model::whereTeam($teamId)->first();
    }
}
