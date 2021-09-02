<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\VisitorUnique;


class UsersController extends Controller
{
    /**
     * Showing visitors unique ip index page
     */
    public function index()
    {
        $visitors_unique = $this->getVisitorsUniqueIps();

        return view('admin.visitors-unique', [
            'visitors_unique' => $visitors_unique
        ]);
    }

    /**
     * Returning all visitors unique data
     */
    public function getVisitorsUniqueData()
    {
        $data = VisitorUnique::all();
        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * all visitors
     * banned visitors
     * notbanned visitoors
     */
}
