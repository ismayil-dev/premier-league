<?php

namespace App\Observers;

use App\Models\Standing;

class StandingObserver
{
    /**
     * Make changes before update
     * @param Standing $standing
     */
    public function updating(Standing $standing)
    {
        if ($standing->isDirty('goal_for') || $standing->isDirty('goal_against')) {
            $standing->goal_difference = $standing->goal_for - $standing->goal_against;
        }
    }
}
