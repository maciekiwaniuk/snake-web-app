<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServerLogsService;

class ServerLogsController extends Controller
{
    public function __construct(ServerLogsService $service)
    {
        $this->serverLogsService = $service;
    }

    public function index()
    {
        return view('admin.server-logs');
    }

    public function getServerLogs()
    {
        $logsCollection = $this->serverLogsService->handleLogsCollection();

        return response()->json([
            'data' => $logsCollection
        ]);
    }

    public function clearServerLogs()
    {
        file_put_contents(storage_path('logs/laravel.log'), '');

        return back();
    }
}
