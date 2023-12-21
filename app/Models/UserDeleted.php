<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeleted extends Model
{
    use HasFactory;

    protected $table = 'users_deleted';

    protected $fillable = [
        'name',
        'email',
        'password',
        'previous_id',
        'last_login_ip',
        'last_login_time',
        'created_at'
    ];

    public $timestamps = false;
}
