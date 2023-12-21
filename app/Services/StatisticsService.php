<?php

namespace App\Services;

use App\Models\User;
use App\Models\VisitorUnique;
use App\Models\AppLog;
use Illuminate\Support\Facades\Redis;

class StatisticsService
{
    public function __construct()
    {
        $this->users = User::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        $this->visitors_unique = VisitorUnique::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        $this->server_logs = AppLog::query()
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function getAmountOfUsers()
    {
        return count($this->users);
    }

    public function getDateOfLastRegisteredUser()
    {
        return $this->users->first()->created_at;
    }

    public function getLastLoginTimeOfUsers()
    {
        return User::query()
            ->orderBy('last_login_time', 'DESC')
            ->first()
            ->last_login_time;
    }

    public function getAmountOfUniqueIps()
    {
        return count($this->visitors_unique);
    }

    public function getAmountOfApplicationLogs()
    {
        return count($this->server_logs);
    }

    public function getAmountOfServerLogs()
    {
        try {
            $logFile = file(storage_path().'/logs/laravel.log');
        } catch (\Exception $e) {
            $logFile = [];
        }

        $logString = '';

        foreach ($logFile as $line) {
            $logString .= $line;
        }

        // check if app is running in production or local
        if (config('app.env') == 'production') {
            $errorName = 'production.ERROR:';
        } else if (config('app.env') == 'local') {
            $errorName = 'local.ERROR:';
        } else {
            $errorName = 'ERROR';
        }

        $logArray = explode($errorName, $logString);

        return count($logArray) - 1;
    }

    public function getAmountOfTotalVisits()
    {
        if (config('features.redis.enabled')) {
            return Redis::get('total_visits_amount_' . config('app.env')) ?? 0;
        }
        return 'Brak danych (Wymagany Redis)';
    }

    public function getAmountOfWelcomePageVisits()
    {
        if (config('features.redis.enabled')) {
            return Redis::get('welcome_page_visits_amount_' . config('app.env')) ?? 0;
        }
        return 'Brak danych (Wymagany Redis)';
    }

    public function getAmountOfDownloadedGames()
    {
        if (config('features.redis.enabled')) {
            return Redis::get('total_game_downloads_amount_' . config('app.env')) ?? 0;
        }
        return 'Brak danych (Wymagany Redis)';
    }

}
