<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameRequest extends Model
{
    protected $table = 'game_requests';

    protected $fillable = [
        'secret_hash'
    ];
}
