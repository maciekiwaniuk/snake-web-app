<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * Constant that specify which message subjects are valid
     */
    const VALID_SUBJECTS = [
        'contact',
        'error-website',
        'error-game',
        'idea-website',
        'idea-game',
        'other'
    ];

    protected $table = 'messages';

    protected $fillable = [
        'subject',
        'sender',
        'email',
        'content',
        'sent_as_user',
        'user_name',
        'deleted'
    ];

}
