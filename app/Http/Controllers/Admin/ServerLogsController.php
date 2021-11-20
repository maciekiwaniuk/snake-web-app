<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ServerLogsController extends Controller
{
    /**
     * Showing index page with server logs
     */
    public function index()
    {
        return view('admin.server-logs');
    }

    /**
     * Returning all server logs from laravel.log file
     */
    public function getAllServerLogs()
    {
        $logFile = file(storage_path().'/logs/laravel.log');
        $logCollection = [];
        $logString = "";

        foreach ($logFile as $line_number => $line) {
            $logString .= $line;
        }

        // file with logs is empty
        if (strlen($logString <= 1)) {
            return response()->json([
                'data' => ''
            ]);
        }

        $logArray = explode('local.ERROR:', $logString);

        for ($i = 0; $i < count($logArray); $i += 2) {
            $logCollection[] = array(
                'date' => $logArray[$i],
                'content' => substr($logArray[$i+1], 0, 500)
            );
        }

        return response()->json([
            'data' => $logCollection
        ]);
    }
}
