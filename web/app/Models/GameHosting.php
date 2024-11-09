<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameHosting extends Model
{
    use HasFactory;

    protected $table = 'game_hostings';

    protected $fillable = [
        'name',
        'link'
    ];

}
