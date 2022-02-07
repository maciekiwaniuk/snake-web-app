<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(StatisticsService $service)
    {
        $this->statisticsService = $service;
    }

    /**
     * Show index page with general statistics
     */
    public function index()
    {
        return view('admin.statistics', [
            'users_amount' => $this->statisticsService->getAmountOfUsers(),
            'last_register' => $this->statisticsService->getDateOfLastRegisteredUser(),
            'last_login_time' => $this->statisticsService->getLastLoginTimeOfUsers(),
            'ips_amount' => $this->statisticsService->getAmountOfUniqueIps(),
            'application_logs_amount' => $this->statisticsService->getAmountOfApplicationLogs(),
            'server_logs_amount' => $this->statisticsService->getAmountOfServerLogs(),
            'total_visits_amount' => $this->statisticsService->getAmountOfTotalVisits(),
            'welcome_page_visits_amount' => $this->statisticsService->getAmountOfWelcomePageVisits(),
            'total_game_downloads_amount' => $this->statisticsService->getAmountOfDownloadedGames()
        ]);
    }

}
