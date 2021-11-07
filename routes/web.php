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
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VisitorsUniqueController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\GameHostingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\SupportController;


/********************************************************* General routing *********************************************************/

Route::get('/', [PagesController::class, 'index'])->middleware('unique.visitor')->name('home');
Route::get('/strona-offline', [PagesController::class, 'offlineFallback'])->name('offline-fallback');

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
        Route::get('/punkty', [RankingsController::class, 'getPoints'])->name('get-points');
        Route::get('/monety', [RankingsController::class, 'getCoins'])->name('get-coins');
        Route::get('/easy', [RankingsController::class, 'getEasy'])->name('get-easy');
        Route::get('/medium', [RankingsController::class, 'getMedium'])->name('get-medium');
        Route::get('/hard', [RankingsController::class, 'getHard'])->name('get-hard');
        Route::get('/speed', [RankingsController::class, 'getSpeed'])->name('get-speed');
    });
});

/********************************************************* Admin routing *********************************************************/

Route::prefix('admin')->middleware('admin')->group(function() {
    Route::name('admin.')->group(function() {
        Route::put('/banowanie-ostatniego-ip/{id}', [UsersController::class, 'banLastUserIp'])->name('ban-last-ip');
        Route::put('/banowanie-konta/{id}', [UsersController::class, 'banAccount'])->name('ban-account');
        Route::put('/banowanie-konta-oraz-ip/{id}', [UsersController::class, 'banAccountAndIP'])->name('ban-ip-account');
        Route::delete('/usuwanie-konta/{id}', [UsersController::class, 'deleteUserAccount'])->name('delete-account');
        Route::put('/odbanowanie-ostatniego-ip/{id}', [UsersController::class, 'unbanLastUserIp'])->name('unban-last-ip');
        Route::put('/odbanowanie-konta/{id}', [UsersController::class, 'unbanAccount'])->name('unban-account');
        Route::put('/odbanowanie-konta-oraz-ip/{id}', [UsersController::class, 'unbanAccountAndIP'])->name('unban-ip-account');
        Route::put('/resetowanie-api-tokenu/{id}', [UsersController::class, 'resetApiToken'])->name('reset-api-token');

        Route::put('/zbanuj-konkretne-ip/{id}', [VisitorsUniqueController::class, 'banIp'])->name('ban-ip');
        Route::put('/odbanuj-konkretne-ip/{id}', [VisitorsUniqueController::class, 'unbanIp'])->name('unban-ip');

        Route::prefix('uzytkownicy')->group(function() {
            Route::name('users.')->group(function() {
                Route::get('/', [UsersController::class, 'index'])->name('index');
                Route::get('/uzytkownicy-wszyscy', [UsersController::class, 'getAllUsers'])->name('get-all-users');
                Route::get('/uzytkownicy-zbanowani', [UsersController::class, 'getBannedUsers'])->name('get-banned-users');
                Route::get('/uzytkownicy-niezbanowani', [UsersController::class, 'getNotBannedUsers'])->name('get-notbanned-users');
            });
        });

        Route::prefix('odwiedzajacy')->group(function() {
            Route::name('visitors.')->group(function() {
                Route::get('/', [VisitorsUniqueController::class, 'index'])->name('index');
                Route::get('/odwiedzajacy-wszyscy', [VisitorsUniqueController::class, 'getAllVisitors'])->name('get-all-visitors');
                Route::get('/odwiedzajacy-zbanowani', [VisitorsUniqueController::class, 'getBannedVisitors'])->name('get-banned-visitors');
                Route::get('/odwiedzajacy-niezbanowani', [VisitorsUniqueController::class, 'getNotBannedVisitors'])->name('get-notbanned-visitors');
            });
        });
    });
});

/********************************************************* User routing *********************************************************/

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





