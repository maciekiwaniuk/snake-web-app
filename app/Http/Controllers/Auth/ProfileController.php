<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Change user's profile status visibility
     */
    public function changeProfileStatusVisibility(Request $request)
    {
        $user = Auth::user();

        if ($request->status == 'public' && $user->profile_visibility_status != 'public') {
            $user->profile_visibility_status = 'public';
            $user->save();
        } else if ($request->status == 'private' && $user->profile_visibility_status != 'private') {
            $user->profile_visibility_status = 'private';
            $user->save();
        }

    }
}
