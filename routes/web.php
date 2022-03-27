<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\GameHostingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingsController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;

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
        Route::post('/wyslij-wiadomosc', [MessageController::class, 'store'])->name('store');
        Route::post('/wyslij-wiadomosc-ajax', [MessageController::class,'storeAJAX'])->name('store-AJAX');
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

Route::middleware('guest')->group(function () {
    Route::get('/rejestracja', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/rejestracja', [RegisteredUserController::class, 'store'])->name('register');

    Route::get('/logowanie', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/logowanie', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::get('/zgubione-haslo', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('/zgubione-haslo', [PasswordResetLinkController::class, 'store'])->name('password.email')
        ->middleware('throttle:3,1');

    Route::get('/ustawianie-nowego-hasla/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/ustawianie-nowego-hasla', [NewPasswordController::class, 'store'])->name('password.update');
});

include(__DIR__ . '/web-user.php');
include(__DIR__ . '/web-admin.php');
