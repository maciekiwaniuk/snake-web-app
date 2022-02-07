<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ServerLogsService;

class ServerLogsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(ServerLogsService $service)
    {
        $this->serverLogsService = $service;
    }

    /**
     * Show index page with server logs
     */
    public function index()
    {
        return view('admin.server-logs');
    }

    /**
     * Return all server logs from laravel.log file
     */
    public function getServerLogs()
    {
        $logsCollection = $this->serverLogsService->handleLogsCollection();

        return response()->json([
            'data' => $logsCollection
        ]);
    }

    /**
     * Clear file with server logs
     */
    public function clearServerLogs()
    {
        file_put_contents(storage_path('logs/laravel.log'), '');

        return back();
    }
}
