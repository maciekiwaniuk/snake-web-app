<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorUnique extends Model
{
    use HasFactory;

    /**
     * Constants that specify number for ip ban status
     */
    const NOT_BANNED = 0;
    const BANNED = 1;

    protected $table = 'visitors_unique';

    protected $fillable = [
        'ip',
        'user_agent',
        'ip_banned',
    ];

    /**
     * Relation for users table
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ip', 'last_login_ip');
    }
}
