<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GameSessions
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property int $animal_id
 * @property int $attempts
 * @property bool $won
 * @property Carbon $started_at
 * @property Carbon $completed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class GameSessions extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'game_sessions';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'animal_id',
        'attempts',
        'won',
        'started_at',
        'completed_at'
    ];

    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'animal_id' => 'integer',
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }
}
