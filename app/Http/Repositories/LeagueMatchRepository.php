<?php

namespace App\Http\Repositories;

use App\Models\LeagueMatch;

class LeagueMatchRepository extends AbstractRepository
{
    /**
     * LeagueMatchRepository constructor.
     * @param LeagueMatch $model
     */
    public function __construct(LeagueMatch $model)
    {
        parent::__construct($model);
    }

    /**
     * Return matches grouped by week
     * @return mixed
     */
    public function getByWeeks(): mixed
    {
       return $this->model::orderBy('week')->get()->groupBy('week');
    }

    /**
     * Return by given week
     * @param int $week
     * @return mixed
     */
    public function getByWeek(int $week)
    {
        return $this->model::byWeek($week)->get();
    }

    /**
     * Return last week
     */
    public function getLastWeek()
    {
        return $this->model::query()->latest('week')->limit(1)->first()->week;
    }

    /**
     * Count and return played games
     * @return int
     */
    public function countOnlyPlayed(): int
    {
        return $this->model::onlyPlayed()->count();
    }

    /**
     * Return only not played games
     * @return mixed
     */
    public function getNotPlayed()
    {
        return $this->model::onlyNotPlayed()->get();
    }
}
