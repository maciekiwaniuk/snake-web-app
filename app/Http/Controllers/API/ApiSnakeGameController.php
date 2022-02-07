<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiSnakeGameService;

class ApiSnakeGameController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(ApiSnakeGameService $service)
    {
        $this->apiService = $service;
    }

    /**
     * Try to log into account from login panel in dekstop app
     */
    public function login(Request $request)
    {
        $result = $this->apiService->handleLogin($request);

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Return user game data if token is valid
     */
    public function loadData(Request $request)
    {
        $result = $this->apiService->handleLoadData($request);
        $ip = $request->getClientIp();

        return response()->json([
            'result' => $result,
            'ip' => $ip
        ]);
    }

    /**
     * Save user game data by user's api token
     */
    public function saveData(Request $request)
    {
        $this->apiService->handleSaveData($request);
    }

    /**
     * Save log when user opened game
     */
    public function createOpenGameLog(Request $request)
    {
        $this->apiService->handleOpenGameLog($request);
    }

    /**
     * Save log when user quit game
     */
    public function createExitGameLog(Request $request)
    {
        $this->apiService->handleExitGameLog($request);

    }

    /**
     * Save log when user logout from game
     */
    public function createLogoutGameLog(Request $request)
    {
        $this->apiService->handleLogoutGameLog($request);
    }
}
