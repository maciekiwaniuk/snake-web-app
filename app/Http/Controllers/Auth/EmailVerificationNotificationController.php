<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        $this->createAppLog(
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
        // return back()->with('status', 'verification-link-sent');
    }
}
