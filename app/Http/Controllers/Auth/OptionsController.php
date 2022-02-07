<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeAvatarRequest;
use App\Http\Requests\Auth\DeleteAccountRequest;
use App\Http\Requests\Auth\LogoutFromOtherDevicesRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Models\AppLog;
use App\Services\UsersService;
use App\Helpers\ApplicationLog;

class OptionsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

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
        $user = Auth::user();
        $this->usersService->handleChangeUserAvatar($request, $user);

        ApplicationLog::createAppLog(
            'avatar_change',
            'Użytkownik '.$user->name.' zmienił swój awatar.'
        );

        $result = [
            'success' => true,
            'message' => 'Awatar został pomyślnie zmieniony.'
        ];

        return response()->json([
            'result' => $result,
            'avatarPath' => $user->avatar_path
        ]);
    }

    /**
     * Delete user's avatar
     */
    public function avatarDelete()
    {
        $user = Auth::user();

        $this->usersService->handleDeleteUserAvatar($user);

        ApplicationLog::createAppLog(
            'avatar_delete',
            'Użytkownik '.$user->name.' usunął swój awatar.'
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

        $this->usersService->handlePasswordChange($request, $user);

        ApplicationLog::createAppLog(
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

        $this->usersService->handleEmailChange($request, $user);

        ApplicationLog::createAppLog(
            'change_email',
            'Użytkownik '.$user->name.' zmienił e-mail z '.$user->email.'
             na '.$request->new_email.'.'
        );

        return redirect()->route('options.show', 'email')
            ->with('email_success', 'Email został pomyślnie zmieniony.');
    }

    /**
     * Validate form confirmation while deleting user's account
     */
    public function accountDelete(DeleteAccountRequest $request)
    {
        $user = Auth::user();

        $this->usersService->handleDeleteUserAccount($user);

        ApplicationLog::createAppLog(
            'account_delete',
            'Konto użytkownika '.$user->name.' zostało usunięte manualnie.'
        );

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

        $this->usersService->handleLogoutFromGame($user);

        ApplicationLog::createAppLog(
            'game_total_logout',
            'Użytkownik '.$user->name.' wylogował się z gry przez stronę.'
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
