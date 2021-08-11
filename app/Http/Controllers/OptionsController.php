<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeEmailRequest;
use App\Rules\LoggedUserPassword;

use App\Models\User;

class OptionsController extends Controller
{
    /**
     * Wyświetla główną stronę z opcjami
     */
    public function index()
    {
        return view('pages.options');
    }

    /**
     * Wyświetla główną stronę z opcjami
     * wraz z rozwiniętą wybraną opcją
     */
    public function show($selected)
    {
        return view('pages.options', [
            'selected' => $selected
        ]);
    }

    /**
     * Obsługa zmiany awataru - AJAX
     */
    public function avatarChange(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['image', 'mimes:jpeg,jpg,png', 'max:10000']
        ]);

        $result = [
            'success' => true,
            'message' => '<i class="bi bi-check-lg me-1"></i> Awatar został pomyślnie zmieniony.'
        ];

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => '<i class="bi bi-exclamation-circle me-1"></i> Wystąpił błąd podczas dodawania obrazka.'
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
     * Obsługa usunięcia awataru
     */
    public function avatarDelete(Request $request)
    {
        $result = [
            'success' => true,
            'message' => '<i class="bi bi-check-lg me-1"></i> Awatar został pomyślnie usunięty.'
        ];

        Controller::deleteUserAvatar();

        return response()->json([
            'result' => $result
        ]);
    }

    /**
     * Obsługa zmiany hasła
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
     * Obsługa zmiany emaila
     */
    public function emailChange(ChangeEmailRequest $request)
    {
        $validated = $request->validated();

        $user = Auth::user();
        $user->email = $request->new_email;
        $user->save();

        return redirect()->route('options.selected', 'email')
            ->with('email_success', 'Email zostało pomyślnie zmienione.');
    }

    /**
     * Obsługa kasowania konta - AJAX
     */
    public function accountDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => ['bail', 'required', new LoggedUserPassword]
        ]);
        logger(print_r($validator, true));

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => '<i class="bi bi-exclamation-circle me-1"></i> Wystąpił błąd podczas dodawania obrazka.'
            ];
        } else {
            $this->changeUserAvatar($request->file('image'));
        }

        return response()->json([
            'result' => $result,
            'avatarPath' => Auth::user()->avatar
        ]);
    }
}
