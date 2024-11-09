<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\VisitorsUniqueController;
use App\Http\Controllers\Admin\AppLogsController;
use App\Http\Controllers\Admin\ServerLogsController;
use App\Http\Controllers\Admin\ArtisanToolsController;
use App\Http\Controllers\Admin\EmailsController;
use App\Http\Controllers\Admin\PHPInfoController;
use App\Http\Controllers\Admin\MessagesController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\GameHostingsController;

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
                Route::get('/', [GameHostingsController::class, 'index'])->name('index');
                Route::post('/dodaj', [GameHostingsController::class, 'store'])->name('store');
                Route::delete('/usun/{id}', [GameHostingsController::class, 'destroy'])->name('destroy');
                Route::put('/zmodyfikuj/{id}', [GameHostingsController::class, 'update'])->name('update');
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
