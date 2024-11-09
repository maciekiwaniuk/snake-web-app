<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Helpers\ApplicationLog;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        ApplicationLog::createAppLog(
            'email_verification',
            'Użytkownik '.Auth::user()->name.' wysłał linka potwierdzającego e-mail na skrzynkę pocztową.'
        );

        $result = [
            'success' => true,
            'message' => 'Link potwierdzający e-mail został wysłany na skrzynkę pocztową wskazanego e-mail\'a podczas rejestracji.'
        ];

        return response()->json([
            'result' => $result
        ]);
    }
}
