<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class UserGameData extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users_game_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',

        'points',
        'coins',
        'total_coins_earned',
        'play_time_seconds',

        'selected_level',
        'selected_head_skin',
        'selected_body_skin',
        'selected_fruit_skin',
        'selected_board_skin',

        'head_skins',
        'body_skins',
        'fruit_skins',
        'board_skins',

        'unlocked_medium',
        'unlocked_hard',
        'unlocked_speed',

        'coins_upgrade_lvl',
        'points_upgrade_lvl',
        'fruits_upgrade_lvl',

        'selected_fruits_upgrade_lvl',

        'easy_record',
        'medium_record',
        'hard_record',
        'speed_record',

        'ate_fruits_amount',
        'ate_fruits_on_easy',
        'ate_fruits_on_medium',
        'ate_fruits_on_hard',
        'ate_fruits_on_speed',

        'games_amount',
        'hit_wall',
        'hit_snake',
        'clicks',

        'fps',
        'music',
        'effects',
        'volume',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * Relation for users table
     */
    public function user()
    {
        return $this->belongsTo(UserGameData::class, 'user_id', 'id');
    }
}
