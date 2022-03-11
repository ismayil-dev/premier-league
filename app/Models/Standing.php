<?php

namespace App\Models;

use App\Observers\StandingObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder|Standing whereTeam(int $teamId)
 * @method static Builder|Standing byScore()
 * @property int $team_id
 * @property int $played
 * @property int $won
 * @property int $drawn
 * @property int $lost
 * @property int $goal_for
 * @property int $goal_against
 * @property int $goal_difference
 * @property int $score
 */
class Standing extends Model
{
    use HasFactory;

//    use DateCasting;

    /**
     * Fillable fields
     * @var string[]
     */
    protected $fillable = [
        'team_id',
        'played',
        'won',
        'drawn',
        'lost',
        'goal_for',
        'goal_against',
        'goal_difference',
        'score',
    ];

    /**
     * Set default relations
     * @var string[]
     */
    protected $with = ['team'];

    /**
     * Score by match result
     */
    public const WIN_SCORE = 3;
    public const DRAWN_SCORE = 1;

    public static function boot()
    {
        parent::boot();
        self::observe(StandingObserver::class);
    }

    /**
     * Return related team (Team relation)
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Return given team id
     * @param Builder $query
     * @param int $teamId
     * @return Builder
     */
    public function scopeWhereTeam(Builder $query, int $teamId): Builder
    {
        return $query->where('team_id', $teamId);
    }

    /**
     * Order by score
     * @param Builder $query
     * @return Builder
     */
    public function scopeByScore(Builder $query): Builder
    {
        return $query->orderByDesc('score')
            ->orderByDesc('goal_difference')
            ->orderByDesc('won')
            ->orderByDesc('drawn')
            ->orderBy('lost');
    }

    /**
     * Return next week
     * @return int
     */
    public static function nextWeek(): int
    {
        return self::latest('played')->limit(1)->first()->played + 1;
    }
}
