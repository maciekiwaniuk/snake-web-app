<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Admin\ModifyUserDataRequest;
use App\Http\Requests\Auth\ChangeAvatarRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterAccountRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\VisitorUnique;
use App\Models\UserDeleted;
use App\Models\UserGameData;
use App\Models\User;
use App\Mail\WelcomeMail;

class UsersService
{
    /**
     * Handle ban user's last ip
     */
    public function handleBanLastUserIP(User $user)
    {
        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->firstOrFail();

        $banned_ip->update([
            'ip_banned' => VisitorUnique::BANNED
        ]);
    }

    /**
     * Handle unban user's last ip
     */
    public function handleUnbanLastUserIP(User $user)
    {
        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->firstOrFail();

        $banned_ip->update([
            'ip_banned' => VisitorUnique::NOT_BANNED
        ]);
    }

    /**
     * Handle ban user's acount
     */
    public function handleBanAccount(User $user)
    {
        if (!$user->isAdmin()) {
            $user->update([
                'user_banned' => User::BANNED
            ]);
        }
    }

    /**
     * Handle unban user's account
     */
    public function handleUnbanAccount(User $user)
    {
        $user->update([
            'user_banned' => User::NOT_BANNED
        ]);
    }

    /**
     * Handle delete account by user_id
     */
    public function handleDeleteUserAccount(User $user)
    {
        UserDeleted::create([
            'name' => $user->name,
            'password' => $user->password,
            'email' => $user->email,
            'previous_id' => $user->id,
            'last_login_ip' => $user->last_login_ip,
            'last_login_time' => $user->last_login_time,
            'created_at' => $user->created_at,
        ]);

        $user->delete();
    }

    /**
     * Handle reset user's api token
     */
    public function handleResetApiToken(User $user)
    {
        $user->update([
            'api_token' => Str::random(60)
        ]);
    }

    /**
     * Handle delete user's avatar
     */
    public function handleDeleteUserAvatar(User $user)
    {
        if ($user->avatar_path != '/assets/images/avatar.png') {
            $previous_avatar = $user->avatar_path;
            Storage::delete($previous_avatar);

            $user->update([
                'avatar_path' => '/assets/images/avatar.png'
            ]);
        }
    }

    /**
     * Handle change user's avatar
     */
    public function handleChangeUserAvatar(ChangeAvatarRequest $request, User $user)
    {
        $image = $request->file('image');

        $extension = $image->getClientOriginalExtension();

        $filename = 'avatar.'.$extension;
        $folder = '/users_avatars/'.$user->name;

        $image->storeAs($folder, $filename, 'public');

        $current_avatar = explode('/', $user->avatar_path);

        if ($current_avatar != '/assets/images/avatar.png') {
            $previous_avatar = $user->avatar_path;
            Storage::delete($previous_avatar);
        }

        $user->update([
            'avatar_path' => '/storage/'.$folder.'/'.'avatar.'.$extension
        ]);
    }

    /**
     * Handle modify user's data
     */
    public function handleModifyData(ModifyUserDataRequest $request, User $user)
    {
        $modifiedData = [];
        if (isset($request->name)) {
            $user->fill([
                'name' => $request->name
            ]);
            $modifiedData[] = 'nazwa';
            $this->handleDeleteUserAvatar($user);
        }

        if (isset($request->email)) {
            $user->fill([
                'email' => $request->email,
                'email_verified_at' => null
            ]);
            $modifiedData[] = 'e-mail';
        }

        if (isset($request->password)) {
            $user->fill([
                'password' => Hash::make($request->password)
            ]);
            $modifiedData[] = 'hasło';
        }

        $user->save();

        return $modifiedData;
    }

    /**
     * Handle change user's password
     */
    public function handlePasswordChange(ChangePasswordRequest $request, User $user)
    {
        $user->update([
            'password' => Hash::make($request->new_password),
            'api_token' => Str::random(60)
        ]);
    }

    /**
     * Handle change user's email
     */
    public function handleEmailChange(ChangeEmailRequest $request, User $user)
    {
        $user->update([
            'email' => $request->new_email,
            'email_verified_at' => null
        ]);
    }

    /**
     * Handle logout from game event
     */
    public function handleLogoutFromGame(User $user)
    {
        $user->update([
            'api_token' => Str::random(60)
        ]);
    }

    /**
     * Handle register account
     */
    public function handleRegisterAccount(RegisterAccountRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'api_token' => Str::random(60),
            'last_login_ip' => $request->getClientIp(),
            'last_login_time' => Carbon::now()->toDateTimeString(),
            'last_user_agent' => substr($request->server('HTTP_USER_AGENT'), 0, 200),
        ]);

        if (env('MAIL_SERVICE_ENABLED')) {
            Mail::to($user->email)
                ->queue(new WelcomeMail($user));
        }

        event(new Registered($user));

        Auth::login($user);

        UserGameData::create([
            'user_id' => $user->id
        ]);

        return $user;
    }

    /**
     * Handle login to website event
     */
    public function handleLoginIntoWebsite(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // saving user's ip and login's time
        $user = Auth::user();
        $user->update([
            'last_login_ip' => $request->getClientIp(),
            'last_login_time' => Carbon::now()->toDateTimeString(),
            'last_user_agent' => substr($request->server('HTTP_USER_AGENT'), 0, 200)
        ]);

        if ($user->user_banned && $user->isUser()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'banned' => 'Konto na które próbujesz się zalogować zostało zbanowane.'
            ]);
        }

        return $user;
    }

}
