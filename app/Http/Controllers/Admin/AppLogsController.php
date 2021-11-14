<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppLog;
use Illuminate\Http\Request;

class AppLogsController extends Controller
{
    /**
     * Showing index page with logs
     */
    public function index()
    {
        return view('admin.app-logs');
    }

    /**
     * Returning all app logs
     */
public function getAllAppLogs()
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
