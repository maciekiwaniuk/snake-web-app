<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\ChangeAvatarRequest;
use App\Http\Requests\Auth\DeleteAccountRequest;
use App\Http\Requests\Auth\LogoutFromOtherDevicesRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Models\AppLog;

class OptionsController extends Controller
{
    /**
     * Show options index page
     */
    public function index()
    {
        return view('pages.options');
    }

    /**
     * Show options index page with
     * selected one tab
     */
    public function show($selected)
    {
        return view('pages.options', [
            'selected' => $selected
        ]);
    }

    /**
     * Change user's avatar
     */
    public function avatarChange(ChangeAvatarRequest $request)
    {
        $this->changeUserAvatar($request->file('image'));

        $this->createAppLog(
            'avatar_change',
            'Użytkownik '.Auth::user()->name.' zmienił swój awatar.'
        );

        $result = [
            'success' => true,
            'message' => 'Awatar został pomyślnie zmieniony.'
        ];

        return response()->json([
            'result' => $result,
            'avatarPath' => Auth::user()->avatar_path
        ]);
    }

    /**
     * Delete user's avatar
     */
    public function avatarDelete()
    {
        $this->deleteUserAvatar();

        $this->createAppLog(
            "avatar_delete",
            "Użytkownik ".Auth::user()->name." usunął swój awatar."
        );

        $result = [
            'success' => true,
            'message' => 'Awatar został pomyślnie usunięty.',
            'avatarPath' => '/assets/images/avatar.png',
        ];

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Change user's password
     */
    public function passwordChange(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->new_password),
            'api_token' => Str::random(60)
        ]);

        $this->createAppLog(
            'change_password',
            'Użytkownik '.$user->name.' zmienił swoje hasło.'
        );

        return redirect()->route('options.show', 'haslo')
            ->with('password_success', 'Hasło zostało pomyślnie zmienione.');
    }

    /**
     * Change user's email
     */
    public function emailChange(ChangeEmailRequest $request)
    {
        $user = Auth::user();

        $this->createAppLog(
            'change_email',
            'Użytkownik '.$user->name.' zmienił e-mail z '.$user->email.'
             na '.$request->new_email.'.'
        );

        $user->update([
            'email' => $request->new_email
        ]);

        return redirect()->route('options.show', 'email')
            ->with('email_success', 'Email został pomyślnie zmieniony.');
    }

    /**
     * Validate form confirmation while deleting user's account
     */
    public function accountDelete(DeleteAccountRequest $request)
    {
        $this->deleteUserAccountByID(Auth::user()->id);

        $result = [
            'url' => route('home')
        ];

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Change user's token - logout from game
     */
    public function logoutFromGame()
    {
        $user = Auth::user();
        $user->update([
            'api_token' => Str::random(60)
        ]);

        $this->createAppLog(
            "game_total_logout",
            "Użytkownik ".$user->name." wylogował się z gry przez stronę."
        );

        $result = [
            'success' => true,
            'message' => 'Zostałeś pomyślnie wylogowany z gry na wszystkich urządzeniach.',
        ];

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Logout from all devices on website
     */
    public function logoutFromAccountOnWeb(LogoutFromOtherDevicesRequest $request)
    {
        Auth::logoutOtherDevices($request->password);

        $result = [
            'success' => true,
            'message' => 'Pomyślnie wylogowano z konta na stronie ze wszystkich urządzeń.',
        ];

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Return all login application logs specified user
     */
    public function getUserLoginApplicationLogs()
    {
        $logs = AppLog::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('type', '=', 'site_login')
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $logs
        ]);
    }

}
