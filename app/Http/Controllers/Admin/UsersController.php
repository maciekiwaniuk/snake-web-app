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
    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }

    public function index()
    {
        return view('admin.users');
    }

    public function show($searched_bar_value)
    {
        return view('admin.users', [
            'search_bar_value' => $searched_bar_value
        ]);
    }

    public function showNameByUserID($user_id)
    {
        $name = Helper::getUserInstanceById($user_id)->name;

        return view('admin.users', [
            'search_bar_value' => $name
        ]);
    }

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

    public function banLastUserIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleBanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy banowaniu IP '.$ip.' użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'IP '.$ip.' użytkownika '.$user->name.' zostało pomyślnie zbanowane.');
    }

    public function unbanLastUserIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleUnbanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_unban',
                'Administrator '.Auth::user()->name.' odbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy odbanowaniu IP '.$ip.' użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'IP '.$ip.' użytkownika '.$user->name.' zostało pomyślnie odbanowane.');
    }

    public function banAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleBanAccount($user);

            ApplicationLog::createAppLog(
                'account_ban',
                'Administrator '.Auth::user()->name.' zbanował konto użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy banowaniu konta użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' zostało pomyślnie zbanowane.');
    }

    public function unbanAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleUnbanAccount($user);

            ApplicationLog::createAppLog(
                'account_unban',
                'Administrator '.Auth::user()->name.' odbanował konto użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy odbanowaniu konta użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' zostało pomyślnie odbanowane.');
    }

    public function banAccountAndIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleBanAccount($user);

            ApplicationLog::createAppLog(
                'account_ban',
                'Administrator '.Auth::user()->name.' zbanował konto użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy banowaniu konta użytkownika '.$user->name.'.'
            ]);
        }

        try {
            $this->usersService->handleBanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Konto zostało zbanowane, natomiast coś poszło nie tak przy banowaniu IP '.$ip.' użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' oraz IP zostało pomyślnie zbanowane.');

    }

    public function unbanAccountAndIP($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);
        $ip = $user->last_login_ip;

        try {
            $this->usersService->handleUnbanAccount($user);

            ApplicationLog::createAppLog(
                'account_unban',
                'Administrator '.Auth::user()->name.' odbanował konto użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy odbanowaniu konta użytkownika '.$user->name.'.'
            ]);
        }

        try {
            $this->usersService->handleUnbanLastUserIP($user);

            ApplicationLog::createAppLog(
                'ip_user_unban',
                'Administrator '.Auth::user()->name.' odbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy odbanowaniu IP '.$ip.' użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' oraz IP zostało pomyślnie odbanowane.');
    }

    public function deleteUserAccount($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleDeleteUserAccount($user);

            if (Auth::user()->isAdmin()) {
                ApplicationLog::createAppLog(
                    'account_delete',
                    'Administrator '.Auth::user()->name.' usunął konto użytkownika '.$user->name.'.'
                );
            } else {
                ApplicationLog::createAppLog(
                    'account_delete',
                    'Konto użytkownika '.$user->name.' zostało usunięte manualnie.'
                );
            }
        } catch (\Exception $exception) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy usuwanie konta dla użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' zostało usunięte pomyślnie.');
    }

    public function resetApiToken($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        try {
            $this->usersService->handleResetApiToken($user);

            ApplicationLog::createAppLog(
                'token_reset',
                'Administrator '.Auth::user()->name.' zresetował api_token użytkownika '.$user->name.'.'
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Coś poszło nie tak przy resetowaniu api tokenu dla użytkownika '.$user->name.'.'
            ]);
        }

        return back()
            ->with('success', 'API token użytkownika '.$user->name.' zostało zresetowany pomyślnie.');
    }

    public function deleteAvatar($user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        $this->usersService->handleDeleteUserAvatar($user);

        ApplicationLog::createAppLog(
            'avatar_delete',
            'Administrator '.Auth::user()->name.' usunął awatar użytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'Awatar użytkownika '.$user->name.' został pomyślnie usunięty.');
    }

    public function modifyData(ModifyUserDataRequest $request, $user_id)
    {
        $user = Helper::getUserInstanceById($user_id);

        $modifiedData = $this->usersService->handleModifyData($request, $user);

        if (count($modifiedData) > 0) {
            $text = implode(', ', $modifiedData);

            ApplicationLog::createAppLog(
                'user_data_modify',
                'Administrator '.Auth::user()->name.' zmodyfikował dane ('.$text.') użytkownika '.$user->name.'.'
            );

            return back()
                ->with('success', 'Dane ('.$text.') użytkownika '.$user->name.' zostały pomyślnie zmodyfikowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Coś poszło nie tak przy modyfikacji danych dla użytkownika '.$user->name.'.'
            ]);
    }

}
