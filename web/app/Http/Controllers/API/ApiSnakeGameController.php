<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ApiSnakeGameService;

class ApiSnakeGameController extends Controller
{
    public function __construct(ApiSnakeGameService $service)
    {
        $this->apiService = $service;
    }

    public function login(Request $request)
    {
        $result = $this->apiService->handleLogin($request);

        return response()->json([
            'result' => $result
        ]);
    }

    public function loadData(Request $request)
    {
        $result = $this->apiService->handleLoadData($request);
        $ip = $request->getClientIp();

        return response()->json([
            'result' => $result,
            'ip' => $ip
        ]);
    }

    public function saveData(Request $request)
    {
        $this->apiService->handleSaveData($request);
    }

    public function createOpenGameLog(Request $request)
    {
        $this->apiService->handleOpenGameLog($request);
    }

    public function createExitGameLog(Request $request)
    {
        $this->apiService->handleExitGameLog($request);
    }

    public function createLogoutGameLog(Request $request)
    {
        $this->apiService->handleLogoutGameLog($request);
    }
}
