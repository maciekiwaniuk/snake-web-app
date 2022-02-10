<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileService
{
    /**
     * Handle user's profile visibility status
     */
    public function handleChangeProfileVisibilityStatus(Request $request, User $user)
    {
        if ($request->status == 'public' && $user->profile_visibility_status != 'public') {
            $user->profile_visibility_status = 'public';
            $user->save();
        } else if ($request->status == 'private' && $user->profile_visibility_status != 'private') {
            $user->profile_visibility_status = 'private';
            $user->save();
        }
    }
}
