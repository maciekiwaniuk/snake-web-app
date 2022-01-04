<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\VisitorUnique;

class StatisticsController extends Controller
{
    /**
     * Show index page with general statistics
     */
    public function index()
    {
        $users = User::query()
            ->orderBy('created_at', 'DESC')
            ->get();

        $last_login_time = User::query()
            ->orderBy('last_login_time', 'DESC')
            ->first()
            ->last_login_time;

        $visitors_unique = VisitorUnique::query()
            ->orderBy('created_at', 'DESC')
            ->get();


        return view('admin.statistics', [
            'users_amount' => count($users),
            'last_register' => $users->first()->created_at,
            'last_login_time' => $last_login_time,
            'ips_amount' => count($visitors_unique)
        ]);
    }

}
