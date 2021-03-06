<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModifyUserDataRequest;
use App\Models\User;
use App\Services\UsersService;
use App\Helpers\Helper;
use App\Helpers\ApplicationLog;

class UsersController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }

    /**
     * Show users admin index page
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Show users admin index page with specific value in search bar
     */
    public function show($searched_bar_value)
    {
        return view('admin.users', [
            'search_bar_value' => $searched_bar_value
        ]);
    }

    /**
     * Show users admin index page with searched user's name
     */
    public function showNameByUserID($user_id)
    {
        $name = Helper::getUserInstanceById($user_id)->name;

        return view('admin.users', [
            'search_bar_value' => $name
        ]);
    }

    /**
     * Return all users
     */
    public function getAllUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Return all banned users
     */
    public function getBannedUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->where('user_banned', '=', 1)
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Return all not banned users
     */
    public function getNotBannedUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->where('user_banned', '=', 0)
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Ban user's last ip
     */
    public function banLastUserIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleBanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanowa?? IP: '.$ip.' u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy banowaniu IP '.$ip.' u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'IP '.$ip.' u??ytkownika '.$user->name.' zosta??o pomy??lnie zbanowane.');
    }

    /**
     * Unban user's last ip
     */
    public function unbanLastUserIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleUnbanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_unban',
                'Administrator '.Auth::user()->name.' odbanowa?? IP: '.$ip.' u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy odbanowaniu IP '.$ip.' u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'IP '.$ip.' u??ytkownika '.$user->name.' zosta??o pomy??lnie odbanowane.');
    }

    /**
     * Ban user's account
     */
    public function banAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleBanAccount($user);

            ApplicationLog::createAppLog(
                'account_ban',
                'Administrator '.Auth::user()->name.' zbanowa?? konto u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy banowaniu konta u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto u??ytkownika '.$user->name.' zosta??o pomy??lnie zbanowane.');
    }

    /**
     * Unban user's account
     */
    public function unbanAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleUnbanAccount($user);

            ApplicationLog::createAppLog(
                'account_unban',
                'Administrator '.Auth::user()->name.' odbanowa?? konto u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy odbanowaniu konta u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto u??ytkownika '.$user->name.' zosta??o pomy??lnie odbanowane.');
    }

    /**
     * Ban user's last ip and user's account
     */
    public function banAccountAndIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleBanAccount($user);

            ApplicationLog::createAppLog(
                'account_ban',
                'Administrator '.Auth::user()->name.' zbanowa?? konto u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy banowaniu konta u??ytkownika '.$user->name.'.'
            ]);
        }

        try {
            $this->usersService->handleBanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanowa?? IP: '.$ip.' u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Konto zosta??o zbanowane, natomiast co?? posz??o nie tak przy banowaniu IP '.$ip.' u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto u??ytkownika '.$user->name.' oraz IP zosta??o pomy??lnie zbanowane.');

    }

    /**
     * Unban user's last ip and user's account
     */
    public function unbanAccountAndIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleUnbanAccount($user);

            ApplicationLog::createAppLog(
                'account_unban',
                'Administrator '.Auth::user()->name.' odbanowa?? konto u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy odbanowaniu konta u??ytkownika '.$user->name.'.'
            ]);
        }

        try {
            $this->usersService->handleUnbanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_unban',
                'Administrator '.Auth::user()->name.' odbanowa?? IP: '.$ip.' u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy odbanowaniu IP '.$ip.' u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto u??ytkownika '.$user->name.' oraz IP zosta??o pomy??lnie odbanowane.');
    }

    /**
     * Delete account by user's ID
     */
    public function deleteUserAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleDeleteUserAccount($user);

            if (Auth::user()->isAdmin()) {
                ApplicationLog::createAppLog(
                    'account_delete',
                    'Administrator '.Auth::user()->name.' usun???? konto u??ytkownika '.$user->name.'.'
                );
            } else {
                ApplicationLog::createAppLog(
                    'account_delete',
                    'Konto u??ytkownika '.$user->name.' zosta??o usuni??te manualnie.'
                );
            }
        } catch (\Exception) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy usuwanie konta dla u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto u??ytkownika '.$user->name.' zosta??o usuni??te pomy??lnie.');
    }

    /**
     * Reset user's API Token
     */
    public function resetApiToken($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleResetApiToken($user);

            ApplicationLog::createAppLog(
                'token_reset',
                'Administrator '.Auth::user()->name.' zresetowa?? api_token u??ytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Co?? posz??o nie tak przy resetowaniu api tokenu dla u??ytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'API token u??ytkownika '.$user->name.' zosta??o zresetowany pomy??lnie.');
    }

    /**
     * Delete user's avatar
     */
    public function deleteAvatar($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        $this->usersService->handleDeleteUserAvatar($user);

        ApplicationLog::createAppLog(
            'avatar_delete',
            'Administrator '.Auth::user()->name.' usun???? awatar u??ytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'Awatar u??ytkownika '.$user->name.' zosta?? pomy??lnie usuni??ty.');
    }

    /**
     * Modify user's account data
     */
    public function modifyData(ModifyUserDataRequest $request, $user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        $modifiedData = $this->usersService->handleModifyData($request, $user);

        if (count($modifiedData) > 0) {
            $text = implode(', ', $modifiedData);

            ApplicationLog::createAppLog(
                'user_data_modify',
                'Administrator '.Auth::user()->name.' zmodyfikowa?? dane ('.$text.') u??ytkownika '.$user->name.'.'
            );

            return back()
                ->with('success', 'Dane ('.$text.') u??ytkownika '.$user->name.' zosta??y pomy??lnie zmodyfikowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Co?? posz??o nie tak przy modyfikacji danych dla u??ytkownika '.$user->name.'.'
            ]);
    }

}
