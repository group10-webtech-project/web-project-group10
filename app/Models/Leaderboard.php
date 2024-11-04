<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Leaderboard
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_games
 * @property int $total_wins
 * @property float $avg_attempts
 * @property int $current_streak
 * @property int $best_streak
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Leaderboard extends Model
{
    //
    protected $table = 'leaderboards';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'total_games',
        'total_wins',
        'avg_attempts',
        'current_streak',
        'best_streak'
    ];
}
