<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\VisitorUnique;

class VisitorsUniqueController extends Controller
{
    /**
     * Showing visitors unique ip index page
     */
    public function index()
    {
        return view('admin.visitors-unique');
    }

    /**
     * Returning all visitors unique data
     */
    public function getAllVisitors()
    {
        $data = VisitorUnique::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Returning banned visitors unique data
     */
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

    /**
     * Returning not banned visitors unique data
     */
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

    /**
     * Banning ip where param is ip's id
     */
    public function banIp($id)
    {
        $ip = VisitorUnique::query()
            ->where('id', '=', $id)
            ->first();

        // ban if selected ip is different than
        // current user's ip (admin's ip)
        if (Auth::user()->last_login_ip != $ip->ip) {
            $this->createAppLog(
                'ip_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip->ip.'.'
            );

            $ip->ip_banned = 1;
            $ip->save();
        }

        return back();
    }

    /**
     * Unbanning ip where param is ip's id
     */
    public function unbanIp($id)
    {
        $ip = VisitorUnique::query()
            ->where('id', '=', $id)
            ->first();

        $ip->ip_banned = 0;
        $ip->save();

        $this->createAppLog(
            'ip_unban',
            'Administrator '.Auth::user()->name.' odbanował IP: '.$ip->ip.'.'
        );

        return back();
    }
}
