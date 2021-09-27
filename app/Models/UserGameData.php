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
        'user_id'
    ];

    protected $primaryKey = 'user_id';

    /**
     * Relation for users table
     */
    public function user()
    {
        return $this->belongsTo(UserGameData::class, 'user_id', 'id');
    }
}
