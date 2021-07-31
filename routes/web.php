<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\PagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PagesController::class, 'index'])->name('home');


/********************************************** ACCOUNT MANAGMENT **********************************************/

Route::middleware('guest')->group(function () {
    Route::get('/rejestracja', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/rejestracja', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('/logowanie', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/logowanie', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::get('/zgubione-haslo', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/zgubione-haslo', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::get('/resetowanie-hasla/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])->name('password.confirm');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');



