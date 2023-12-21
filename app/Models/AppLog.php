<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AppLog extends Model
{
    use HasFactory;

    protected $table = 'app_logs';

    protected $fillable = [
        'type',
        'content',
        'user_id',
        'ip',
    ];

    /**
     * Relation for users table
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
