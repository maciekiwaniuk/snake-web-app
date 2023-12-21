<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Models\AppLog;

class ApplicationLog
{
    public static function createAppLog($type, $content)
    {
        AppLog::create([
            'type' => $type,
            'content' => $content,
            'user_id' => Auth::user()->id,
            'ip' => RequestFacade::ip()
        ]);
    }

    public static function createGameAppLog($type, $content, $user_id, $ip)
    {
        AppLog::create([
            'type' => $type,
            'content' => $content,
            'user_id' => $user_id,
            'ip' => $ip
        ]);
    }

}
