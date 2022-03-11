<?php

namespace App\Services\Prediction;

use App\Http\Repositories\LeagueMatchRepository;
use App\Http\Repositories\StandingRepository;
use App\Models\Standing;
use Illuminate\Support\Collection;

class PredictionService
{
    /**
     * @var StandingRepository
     */
    private StandingRepository $standingRepository;

    /**
     * @var LeagueMatchRepository
     */
    private LeagueMatchRepository $leagueMatchRepository;

    /**
     * PredictionService constructor
     * @param LeagueMatchRepository $leagueMatchRepository
     * @param StandingRepository $standingRepository
     */
    public function __construct(
        LeagueMatchRepository $leagueMatchRepository,
        StandingRepository    $standingRepository
    )
    {
        $this->leagueMatchRepository = $leagueMatchRepository;
        $this->standingRepository = $standingRepository;
    }

    /**
     * Calculate prediction
     * Calculate approx prediction by score, won, goal_against
     * @return Collection
     */
    public function calculate(): Collection
    {
        if (!$this->leagueMatchRepository->countOnlyPlayed()) {
            return self::defaultPredictions();
        }

        $standings = $this->standingRepository->getByScore();

        $sumWonGames = $standings->sum('won');
        $sumGoalFor = $standings->sum('goal_for');

        $sumScore = $standings->sum('score');
        $avgPredictions = collect();

        $standings->each(function (Standing $standing) use ($avgPredictions, $sumScore, $sumGoalFor, $sumWonGames) {
            $data['team'] = $standing->team;
            if (round2($sumScore) != 0) {
                $data['avg_score'] = $this->averagePercentage($sumScore, $standing->score);
            }
            if (round2($sumWonGames) != 0) {
                $data['avg_won'] = $this->averagePercentage($sumWonGames, $standing->won);
            }
            if (round2($sumGoalFor) != 0) {
                $data['avg_goal_for'] = $this->averagePercentage($sumGoalFor, $standing->goal_for);
            }

            $avgPredictions->push(collect($data));
        });

        return $this->calculatePercentage($avgPredictions);
    }

    /**
     * Calculate percentage for each team due to given (calculated) average data
     * @param Collection $predictions
     * @return Collection
     */
    protected function calculatePercentage(Collection $predictions): Collection
    {
        return $predictions->map(function (Collection $avgPredict) {
            $sumArray = $avgPredict->except('team')->toArray();
            $sum = array_sum($sumArray);
            $percentage = number_format($sum / count($sumArray), 2);

            return collect([
                'team'       => $avgPredict->get('team'),
                'percentage' => (float)$percentage,
            ]);
        })->sortByDesc('percentage');
    }

    /**
     * Return default percentage
     * @return Collection
     */
    public function defaultPredictions(): Collection
    {
        $standings = Standing::byScore()->get();
        $avgPredictions = collect();

        $standings->each(function (Standing $standing) use ($avgPredictions) {
            $avgPredictions->push(collect([
                'team'       => $standing->team,
                'percentage' => 100
            ]));
        });

        return $avgPredictions;
    }

    /**
     * Calculate average
     * @param $sum
     * @param $value
     * @return float
     */
    private function averagePercentage($sum, $value): float
    {
        $average = ($value / $sum) * 100;
        return (float)number_format($average, 2);
    }
}
