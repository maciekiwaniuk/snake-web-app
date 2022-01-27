<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppLog;

class AppLogsController extends Controller
{
    /**
     * Show index page with application logs
     */
    public function index()
    {
        return view('admin.app-logs');
    }

    /**
     * Return all application logs
     */
    public function getAppLogs()
    {
        $logs = AppLog::query()
            ->with('user')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $logs
        ]);
    }
}
