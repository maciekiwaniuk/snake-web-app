<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorUnique extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'visitors_unique';

    /**
     * Relation for users table
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'ip', 'last_login_ip');
    }
}
