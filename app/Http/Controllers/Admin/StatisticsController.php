<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VisitorUnique;
use App\Models\AppLog;
use Illuminate\Support\Facades\Redis;

class StatisticsController extends Controller
{
    /**
     * Set all necessery variables needed in functions
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
     * Show index page with general statistics
     */
    public function index()
    {
        return view('admin.statistics', [
            'users_amount' => $this->getAmountOfUsers(),
            'last_register' => $this->getDateOfLastRegisteredUser(),
            'last_login_time' => $this->getLastLoginTimeOfUsers(),
            'ips_amount' => $this->getAmountOfUniqueIps(),
            'application_logs_amount' => $this->getAmountOfApplicationLogs(),
            'server_logs_amount' => $this->getAmountOfServerLogs(),
            'total_visits_amount' => $this->getAmountOfTotalVisits()
        ]);
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
            return Redis::get('total_visits_amount');
        }
        return 'Brak danych (Redis)';
    }

}
