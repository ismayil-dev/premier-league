<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static Builder|LeagueMatch onlyPlayed()
 * @method static Builder|LeagueMatch onlyNotPlayed()
 * @method static Builder|LeagueMatch byWeek(int $week)
 * @property-read Team $homeTeam
 * @property-read Team $awayTeam
 * @property int $home_team_id
 * @property int $home_team_goal
 * @property int $away_team_goal
 * @property int $away_team_id
 * @property bool $is_played
 */
class LeagueMatch extends Model
{
    use HasFactory;

    /**
     * Table name
     * @var string
     */
    protected $table = 'matches';

    /**
     * Fillable fields
     * @var string[]
     */
    protected $fillable = [
        'home_team_id',
        'away_team_id',
        'week',
        'home_team_goal',
        'away_team_goal',
        'is_played',
        'played_at'
    ];

    protected $with = ['homeTeam', 'awayTeam'];

    public const STATUS_PLAYED = 1;
    public const STATUS_NOT_PLAYED = 0;

    public const MINIMUM_GOAL = 0;
    public const MAX_GOAL = 10;

    /**
     * Return only played matches
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyPlayed(Builder $query): Builder
    {
        return $query->where('is_played', self::STATUS_PLAYED);
    }

    /**
     * Return only not played matches
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnlyNotPlayed(Builder $query): Builder
    {
        return $query->where('is_played', self::STATUS_NOT_PLAYED);
    }

    /**
     * Return by week
     * @param Builder $query
     * @param int $week
     * @return Builder
     */
    public function scopeByWeek(Builder $query, int $week): Builder
    {
        return $query->where('week', $week);
    }

    /**
     * Return home team
     * @return BelongsTo
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id', 'id');
    }

    /**
     * Return away team
     * @return BelongsTo
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id', 'id');
    }
}
