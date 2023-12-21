<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\VisitorsUniqueService;
use App\Models\VisitorUnique;
use App\Helpers\Helper;
use App\Helpers\ApplicationLog;

class VisitorsUniqueController extends Controller
{
    public function __construct(VisitorsUniqueService $service)
    {
        $this->ipService = $service;
    }

    public function index()
    {
        return view('admin.visitors-unique');
    }

    public function getAllVisitors()
    {
        $data = VisitorUnique::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getBannedVisitors()
    {
        $data = VisitorUnique::query()
            ->where('ip_banned', '=', 1)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getNotBannedVisitors()
    {
        $data = VisitorUnique::query()
            ->where('ip_banned', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function banIp($ip_id)
    {
        $ip = Helper::getVisitorUniqueById($ip_id);

        // ban if selected ip is different than
        // current user's ip (admin's ip)
        if (Auth::user()->last_login_ip != $ip->ip) {
            $this->ipService->handleBanIp($ip);

            ApplicationLog::createAppLog(
                'ip_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip->ip.'.'
            );

            return back()
                ->with('success', 'IP: '.$ip->ip.' zostało pomyślnie zbanowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Coś poszło nie tak podczas próby zbanowania IP: '.$ip->ip.'.'
            ]);
    }

    public function unbanIp($ip_id)
    {
        $ip = Helper::getVisitorUniqueById($ip_id);

        $this->ipService->handleUnbanIp($ip);

        ApplicationLog::createAppLog(
            'ip_unban',
            'Administrator '.Auth::user()->name.' odbanował IP: '.$ip->ip.'.'
        );

        return back()
            ->with('success', 'IP: '.$ip->ip.' zostało pomyślnie odbanowane.');
    }
}
