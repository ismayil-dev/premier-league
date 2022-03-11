<?php

namespace App\Http\Repositories;

use App\Models\Team;

class TeamRepository extends AbstractRepository
{
    /**
     * @param Team $model
     */
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    /**
     * Return given column as array
     * @param string $column
     * @return array
     */
    public function getPluckArray(string $column = 'id'): array
    {
        return $this->model::pluck($column)->toArray();
    }

    /**
     * Return teams for seeding
     * @return array
     */
    public function getForSeeding(): array
    {
        return $this->all()->map(fn($team) => ['team_id' => $team->id, 'created_at' => now()])->toArray();
    }
}
