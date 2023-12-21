<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(ProfileService $service)
    {
        $this->profileService = $service;
    }

    public function changeProfileVisibilityStatus(Request $request)
    {
        $user = Auth::user();

        $this->profileService->handleChangeProfileVisibilityStatus($request, $user);
    }
}
