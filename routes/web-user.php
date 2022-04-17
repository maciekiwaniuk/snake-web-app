<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\OptionsController;
use App\Http\Controllers\Auth\ProfileController;

Route::middleware('auth')->group(function() {
    Route::prefix('ustawienia')->group(function() {
        Route::name('options.')->group(function() {
            Route::get('/', [OptionsController::class, 'index'])->name('index');
            Route::get('/{selected}', [OptionsController::class, 'show'])->name('show');

            Route::put('/zmiana-hasla', [OptionsController::class, 'passwordChange'])->name('password-change');
            Route::put('/zmiana-emaila', [OptionsController::class, 'emailChange'])->name('email-change');

            Route::post('/zmiana-awatara', [OptionsController::class, 'avatarChange'])->name('avatar-change');
            Route::delete('/usuniecie-awatara', [OptionsController::class, 'avatarDelete'])->name('avatar-delete');
            Route::delete('/usuniecie-konta', [OptionsController::class, 'accountDelete'])->name('account-delete');
            Route::post('/wylogowanie-z-gry', [OptionsController::class, 'logoutFromGame'])->name('logout-from-game');
            Route::post('/wylogowanie-ze-strony', [OptionsController::class, 'logoutFromAccountOnWeb'])->name('logout-from-website');

            Route::get('/pokaz/logi-logowania', [OptionsController::class, 'getUserLoginApplicationLogs'])->name('get-user-login-logs');
        });
    });

    Route::prefix('profil/ustawienia')->group(function() {
        Route::name('profile.options.')->group(function() {
            Route::post('/zmiana-widocznosci-profilu', [ProfileController::class, 'changeProfileVisibilityStatus'])->name('change-profile-visibility-status');
        });
    });

    Route::get('/weryfikacja-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');

    Route::get('/potwierdzenie-hasla', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/potwierdzenie-hasla', [ConfirmablePasswordController::class, 'store']);

    Route::post('/wylogowanie', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/weryfikacja-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
        ->middleware(['signed', 'throttle:3,1']);

    Route::post('/email/weryfikacja-powiadomienia', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
        ->middleware('throttle:3,1');
});
