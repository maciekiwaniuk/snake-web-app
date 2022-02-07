<?php

namespace App\Services;

use App\Models\User;
use App\Models\VisitorUnique;
use App\Models\AppLog;
use Illuminate\Support\Facades\Redis;

class StatisticsService
{
    /**
     * Constructor
     */
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

    /**
     * Return count of all registered users
     */
    public function getAmountOfUsers()
    {
        return count($this->users);
    }

    /**
     * Return date of last registered user
     */
    public function getDateOfLastRegisteredUser()
    {
        return $this->users->first()->created_at;
    }

    /**
     * Return date last login time of users
     */
    public function getLastLoginTimeOfUsers()
    {
        return User::query()
            ->orderBy('last_login_time', 'DESC')
            ->first()
            ->last_login_time;
    }

    /**
     * Return amount of unique ips
     */
    public function getAmountOfUniqueIps()
    {
        return count($this->visitors_unique);
    }

    /**
     * Return amount of application logs
     */
    public function getAmountOfApplicationLogs()
    {
        return count($this->server_logs);
    }

    /**
     * Return amount of server logs
     */
    public function getAmountOfServerLogs()
    {
        $logFile = file(storage_path().'/logs/laravel.log');
        $logString = "";

        foreach ($logFile as $line) {
            $logString .= $line;
        }

        // check if app is running in production or local
        if (env('APP_ENV') == 'production') {
            $errorName = 'production.ERROR:';
        } else if (env('APP_ENV') == 'local') {
            $errorName = 'local.ERROR:';
        } else {
            $errorName = 'ERROR';
        }

        $logArray = explode($errorName, $logString);

        return count($logArray) - 1;
    }

    /**
     * Return amount of total visits on any subpage
     */
    public function getAmountOfTotalVisits()
    {
        if (env('REDIS_CONFIGURED')) {
            return Redis::get('total_visits_amount_'.env('APP_ENV'));
        }
        return 'Brak danych (Wymagany Redis)';
    }

    /**
     * Return amount of welcome page visits
     */
    public function getAmountOfWelcomePageVisits()
    {
        if (env('REDIS_CONFIGURED')) {
            return Redis::get('welcome_page_visits_amount_'.env('APP_ENV'));
        }
        return 'Brak danych (Wymagany Redis)';
    }

    /**
     * Return amount of downloaded games
     */
    public function getAmountOfDownloadedGames()
    {
        if (env('REDIS_CONFIGURED')) {
            return Redis::get('total_game_downloads_amount_'.env('APP_ENV'));
        }
        return 'Brak danych (Wymagany Redis)';
    }

}
