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
use App\Http\Controllers\Admin\UsersActionsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\GameHostingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\ActionsController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\SupportController;




Route::get('/', [PagesController::class, 'index'])->middleware('unique.visitor')->name('home');

Route::get('/pobierz-gre', [GameHostingsController::class, 'index'])->name('download');
Route::get('/profil/{name}', [ProfileController::class, 'show'])->name('profile');

Route::prefix('pomoc')->group(function() {
    Route::name('support.')->group(function() {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::get('/{selected}', [SupportController::class, 'show'])->name('show');
    });
});

Route::prefix('ranking')->group(function() {
    Route::name('ranking.')->group(function() {
        Route::get('/', [RankingsController::class, 'index'])->name('index');
        Route::get('/coins', [RankingsController::class, 'getCoins'])->name('get-coins');
        Route::get('/easy', [RankingsController::class, 'getEasy'])->name('get-easy');
        Route::get('/medium', [RankingsController::class, 'getMedium'])->name('get-medium');
        Route::get('/hard', [RankingsController::class, 'getHard'])->name('get-hard');
    });
});

/********************************************************* Admin routing *********************************************************/

Route::prefix('admin')->middleware('admin')->group(function()  {
    Route::name('admin.')->group(function()  {
        Route::put('/banowanie-uzytkownika/{id}', [UsersActionsController::class, 'banIP'])->name('ban-ip');
        Route::delete('/usuwanie-uzytkownika/{id}', [UsersActionsController::class, 'deleteUserAccount'])->name('delete-user');
    });
});

/********************************************** Routing available when user is logged **********************************************/

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
        });
    });

    Route::prefix('akcje')->group(function() {
        Route::name('actions.')->group(function() {
            Route::get('/', [ActionsController::class, 'index'])->name('index');

            Route::post('/wczytaj-progres', [ActionsController::class, 'loadProgress'])->name('progress-load');
            Route::get('/pokaz-progres', [ActionsController::class,'showProgress'])->name('progress-show');
            Route::delete('/usun-progres/{id}', [ActionsController::class, 'deleteProgress'])->name('progress-delete');
            Route::post('/pobierz-progres/{id}', [ActionsController::class, 'downloadProgress'])->name('progress-download');
            Route::post('/wybierz-progres/{id}', [ActionsController::class, 'selectProgress'])->name('progress-select');
        });
    });
});


/********************************************** Routing related with user's account **********************************************/

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
    Route::get('/weryfikacja-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');

    Route::get('/potwierdzenie-hasla', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('/potwierdzenie-hasla', [ConfirmablePasswordController::class, 'store'])->name('password.confirm');

    Route::post('/wylogowanie', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/weryfikacja-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
    ->middleware(['signed', 'throttle:6,1']);

    Route::post('/email/weryfikacja-powiadomienia', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
        ->middleware('throttle:6,1');
});





