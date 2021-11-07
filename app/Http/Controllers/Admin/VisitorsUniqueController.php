<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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
        $data = DB::select('SELECT *, visitors_unique.id as ip_id FROM visitors_unique
                            ORDER BY created_at DESC');

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Returning banned visitors unique data
     */
    public function getBannedVisitors()
    {
        $data = DB::select('SELECT *, visitors_unique.id as ip_id FROM visitors_unique
                            WHERE ip_banned = 1
                            ORDER BY created_at DESC');
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Returning not banned visitors unique data
     */
    public function getNotBannedVisitors()
    {
        $data = DB::select('SELECT *, visitors_unique.id as ip_id FROM visitors_unique
                            WHERE ip_banned = 0
                            ORDER BY created_at DESC');
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

        return back();
    }
}
