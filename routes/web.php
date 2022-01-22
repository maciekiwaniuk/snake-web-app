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
use App\Http\Controllers\Admin\AppLogsController;
use App\Http\Controllers\Admin\ServerLogsController;
use App\Http\Controllers\Admin\ArtisanToolsController;
use App\Http\Controllers\Admin\EmailsController;
use App\Http\Controllers\Admin\PHPInfoController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\GameHostingsController as AdminGameHostingsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\GameHostingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\MessageController;

/********************************************************* General routing *********************************************************/

Route::get('/', [PagesController::class, 'index'])->middleware(['unique.visitor', 'welcome.page.visitor'])->name('home');
Route::get('/strona-offline', [PagesController::class, 'showOfflineFallback'])->name('offline-fallback');

Route::get('/gra', [PagesController::class, 'showMiniGamePage'])->name('mini-game');
Route::get('/profil/{name}', [ProfileController::class, 'show'])->name('profile');

Route::prefix('/pobierz-gre')->group(function() {
    Route::name('game-hostings.')->group(function() {
        Route::get('/', [GameHostingsController::class, 'index'])->name('index');
        Route::post('/zwieksz-liczbe-pobran', [GameHostingsController::class, 'increaseDownloads'])->name('increase-downloads');
    });
});

Route::prefix('pomoc')->group(function() {
    Route::name('help.')->group(function() {
        Route::get('/', [HelpController::class, 'index'])->name('index');
        Route::get('/{selected}', [HelpController::class, 'show'])->name('show');
    });
});

Route::prefix('wiadomosc')->group(function() {
    Route::name('message.')->group(function() {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('/{selected}', [MessageController::class, 'show'])->name('show');
        Route::post('/', [MessageController::class, 'store'])->name('index');
        Route::post('/wyslij-wiadomosc', [MessageController::class,'storeAJAX'])->name('store-AJAX');
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

Route::prefix('administrator')->middleware('admin')->group(function() {
    Route::name('admin.')->group(function() {

        Route::prefix('email')->group(function() {
            Route::name('email.')->group(function() {
                Route::get('/powitalny', [EmailsController::class, 'showWelcomeMail'])->name('welcome');
            });
        });

        Route::put('/banowanie-konta/{id}', [UsersController::class, 'banAccount'])->name('ban-account');
        Route::put('/odbanowanie-konta/{id}', [UsersController::class, 'unbanAccount'])->name('unban-account');
        Route::put('/banowanie-ostatniego-ip/{id}', [UsersController::class, 'banLastUserIp'])->name('ban-last-ip');
        Route::put('/odbanowanie-ostatniego-ip/{id}', [UsersController::class, 'unbanLastUserIp'])->name('unban-last-ip');
        Route::put('/banowanie-konta-oraz-ostatniego-ip/{id}', [UsersController::class, 'banAccountAndIP'])->name('ban-last-ip-account');
        Route::put('/odbanowanie-konta-oraz-ostatniego-ip/{id}', [UsersController::class, 'unbanAccountAndIP'])->name('unban-last-ip-account');
        Route::put('/resetowanie-api-tokenu/{id}', [UsersController::class, 'resetApiToken'])->name('reset-api-token');
        Route::put('/modyfikacja-danych/{id}', [UsersController::class, 'modifyData'])->name('modify-data');
        Route::delete('/usuwanie-konta/{id}', [UsersController::class, 'deleteUserAccount'])->name('delete-account');
        Route::delete('/usuniecie-awatara/{id}', [UsersController::class, 'deleteAvatar'])->name('delete-avatar');

        Route::put('/zbanuj-konkretne-ip/{id}', [VisitorsUniqueController::class, 'banIp'])->name('ban-ip');
        Route::put('/odbanuj-konkretne-ip/{id}', [VisitorsUniqueController::class, 'unbanIp'])->name('unban-ip');

        Route::prefix('uzytkownicy')->group(function() {
            Route::name('users.')->group(function() {
                Route::get('/uzytkownicy-wszyscy', [UsersController::class, 'getAllUsers'])->name('get-all-users');
                Route::get('/uzytkownicy-zbanowani', [UsersController::class, 'getBannedUsers'])->name('get-banned-users');
                Route::get('/uzytkownicy-niezbanowani', [UsersController::class, 'getNotBannedUsers'])->name('get-notbanned-users');
                Route::get('/', [UsersController::class, 'index'])->name('index');
                Route::get('/wyszukaj/{value}', [UsersController::class, 'show'])->name('show');
                Route::get('/wyszukaj-uzytkownika/{id}', [UsersController::class, 'showNameByUserID'])->name('show-name-by-id');
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

        Route::prefix('wiadomosci')->group(function() {
            Route::name('messages.')->group(function() {
                Route::get('/', [MessagesController::class, 'index'])->name('index');
                Route::get('/wyswietl-wiadomosci', [MessagesController::class, 'getMessages'])->name('get-messages');
                Route::delete('/usun-wiadomosc/{id}', [MessagesController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('hostingi-gry')->group(function() {
            Route::name('game-hostings.')->group(function() {
                Route::get('/', [AdminGameHostingsController::class, 'index'])->name('index');
                Route::post('/dodaj', [AdminGameHostingsController::class, 'store'])->name('store');
                Route::delete('/usun/{id}', [AdminGameHostingsController::class, 'destroy'])->name('destroy');
                Route::put('/zmodyfikuj/{id}', [AdminGameHostingsController::class, 'update'])->name('update');
            });
        });

        Route::prefix('logi')->group(function() {
            Route::name('app-logs.')->group(function() {
                Route::get('/aplikacja', [AppLogsController::class, 'index'])->name('index');
                Route::get('/lista-logow-applikacji', [AppLogsController::class, 'getAppLogs'])->name('get-app-logs');
            });

            Route::name('server-logs.')->group(function() {
                Route::get('/serwer', [ServerLogsController::class, 'index'])->name('index');
                Route::get('/lista-logow-serwera', [ServerLogsController::class, 'getServerLogs'])->name('get-server-logs');
                Route::delete('/czyszczenie-logow-serwera', [ServerLogsController::class, 'clearServerLogs'])->name('clear-server-logs');
            });
        });

        Route::prefix('statystyki')->group(function() {
            Route::name('statistics.')->group(function() {
                Route::get('/', [StatisticsController::class, 'index'])->name('index');
            });
        });

        Route::prefix('narzedzia')->group(function() {
            Route::name('artisan-tools.')->group(function() {
                Route::get('/', [ArtisanToolsController::class, 'index'])->name('index');
                Route::put('/wyczysc-cache-aplikacji', [ArtisanToolsController::class, 'clearApplicationCache'])->name('clear-app-cache');
                Route::put('/wyczysc-cache-routingu', [ArtisanToolsController::class, 'clearRouteCache'])->name('clear-route-cache');
                Route::put('/wyczysc-cache-konfiguracji', [ArtisanToolsController::class, 'clearConfigCache'])->name('clear-config-cache');
            });
        });

        Route::prefix('php-info')->group(function() {
            Route::name('php-info.')->group(function() {
                Route::get('/', [PHPInfoController::class, 'index'])->name('index');
                Route::get('/src', [PHPInfoController::class, 'src'])->name('src');
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
            Route::post('/wylogowanie-ze-strony', [OptionsController::class, 'logoutFromAccountOnWebsite'])->name('logout-from-website');

            Route::get('/pokaz/logi-logowania', [OptionsController::class, 'getUserLoginApplicationLogs'])->name('get-user-login-logs');
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

    Route::get('/ustawianie-nowego-hasla/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/ustawianie-nowego-hasla', [NewPasswordController::class, 'store'])->name('password.update');
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
