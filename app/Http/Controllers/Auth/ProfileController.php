<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\ProfilesService;

class ProfileController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(ProfilesService $service)
    {
        $this->profilesService = $service;
    }

    /**
     * Change user's profile status visibility
     */
    public function changeProfileVisibilityStatus(Request $request)
    {
        $user = Auth::user();

        $this->profilesService->handleChangeProfileVisibilityStatus($request, $user);
    }
}
