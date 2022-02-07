<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class ArtisanToolsController extends Controller
{
    /**
     * Show artisan tools index page
     */
    public function index()
    {
        return view('admin.artisan-tools');
    }

    /**
     * Clear application cache
     */
    public function clearApplicationCache()
    {
        Cache::flush();

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache aplikacji');
    }

    /**
     * Clear routing cache
     */
    public function clearRouteCache()
    {
        Artisan::call('route:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache routingu aplikacji');
    }

    /**
     * Clear config cache
     */
    public function clearConfigCache()
    {
        Artisan::call('config:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache konfiguracji aplikacji');
    }
}
