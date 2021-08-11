<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Funkcja wyszukująca użytkownika
     * po jego nazwie
     */
    public function findUserByUsername($username)
    {
        $user = User::query()
            ->where('name', '=', $username)
            ->first();

        if(!isset($user)) return abort(404);

        return $user;
    }

    /**
     * Funkcja która:
     * - dodaje awatar użytkownika
     * - usuwa poprzedni awatar użytkownika
     * - zapisuje linka do awatara użytkownika w bazie danych
     */
    public function changeUserAvatar($image)
    {
        $extension = $image->getClientOriginalExtension();

        $filename = 'avatar.'.$extension;
        $folder = 'users_avatars/'.Auth::user()->name;

        $image->storeAs($folder, $filename, 'public');

        $current_avatar = explode('/', Auth::user()->avatar);

        if ($current_avatar != 'assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);
        }

        $user = Auth::user();
        $user->avatar = 'storage/'.$folder.'/'.'avatar.'.$extension;
        $user->save();
    }

    /**
     * Funkcja usuwająca awatar użytkownika
     * oraz zastępująca go default.png
     */
    public static function deleteUserAvatar()
    {
        if (Auth::user()->avatar != 'assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);

            $user = Auth::user();
            $user->avatar = 'assets/images/avatar.png';
            $user->save();
        }
    }
}
