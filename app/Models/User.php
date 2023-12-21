<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\AppLog;
use App\Models\VisitorUnique;
use App\Models\UserGameData;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\EmailVerificationNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Constants that specify number for account permission
     */
    const USER_PERMISSION = 0;
    const ADMIN_PERMISSION = 2;

    /**
     * Constants that specify number for account ban status
     */
    const NOT_BANNED = 0;
    const BANNED = 1;

    protected $fillable = [
        'name',
        'email',
        'api_token',
        'password',
        'avatar_path',
        'permission',
        'last_login_ip',
        'last_login_time',
        'last_user_agent',
        'user_banned',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'users';

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    public function isAdmin()
    {
        if ($this->permission == self::ADMIN_PERMISSION) {
            return true;
        }
        return false;
    }

    public function isUser()
    {
        if ($this->permission == self::USER_PERMISSION) {
            return true;
        }
        return false;
    }

    public function isBanned()
    {
        if ($this->user_banned == self::BANNED) {
            return true;
        }
        return false;
    }

    public function userGameData()
    {
        return $this->hasOne(UserGameData::class, 'user_id', 'id');
    }

    /**
     * Relation for app_logs table
     */
    public function appLogs()
    {
        return $this->hasMany(AppLog::class, 'user_id', 'id');
    }

    /**
     * Relation for unique_visitors table
     */
    public function visitorUnique()
    {
        return $this->hasOne(VisitorUnique::class, 'ip', 'last_login_ip');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function ($user) {
            $app_logs = AppLog::where('user_id', '=', $user->id)->get();

            foreach ($app_logs as $app_log) {
                $app_log->delete();
            }
        });
    }

}
