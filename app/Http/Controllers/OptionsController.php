<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Rules\LoggedUserPassword;

class OptionsController extends Controller
{
    /**
     * Showing options index page
     */
    public function index()
    {
        return view('pages.options');
    }

    /**
     * Showing options index page with
     * selected one tab
     */
    public function show($selected)
    {
        return view('pages.options', [
            'selected' => $selected
        ]);
    }

    /**
     * Mechanism of changing user's avatar - AJAX
     */
    public function avatarChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpeg,jpg,png', 'max:10000', 'dimensions:max_width=800,max_height=800']
        ]);

        $result = [
            'success' => true,
            'message' => 'Awatar został pomyślnie zmieniony.'
        ];

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => 'Wystąpił błąd podczas dodawania obrazka.'
            ];
        } else {
            $this->changeUserAvatar($request->file('image'));
        }

        return response()->json([
            'result' => $result,
            'avatarPath' => Auth::user()->avatar
        ]);
    }

    /**
     * Mechanism of user's deleting avatar - AJAX
     */
    public function avatarDelete(Request $request)
    {
        $result = [
            'success' => true,
            'message' => 'Awatar został pomyślnie usunięty.',
            'avatarPath' => 'assets/images/avatar.png',
        ];

        $this->deleteUserAvatar();

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Mechanism of changing user's password
     */
    public function passwordChange(ChangePasswordRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('options.selected', 'haslo')
            ->with('password_success', 'Hasło zostało pomyślnie zmienione.');
    }

    /**
     * Mechanism of changing user's email
     */
    public function emailChange(ChangeEmailRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $user->email = $request->new_email;
        $user->save();

        return redirect()->route('options.selected', 'email')
            ->with('email_success', 'Email został pomyślnie zmieniony.');
    }

    /**
     * Mechanism and validation confirmation
     * of deleting user's account
     */
    public function accountDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['bail', 'required', new LoggedUserPassword]
        ]);

        if ($validator->fails()) {
            $result = [
                'error' => true,
                'message' => $validator->errors()->first(),
            ];

            return response()->json([
                'result' => $result,
            ]);
        }

        $this->deleteUserAccountByID(Auth::user()->id);

        $result = [
            'error' => false,
            'url' => route('home'),
        ];
        return response()->json([
            'result' => $result,
        ]);
    }

}
