<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class ArtisanToolsController extends Controller
{
    /**
     * Showing artisan tools index page
     */
    public function index()
    {
        return view('admin.artisan-tools');
    }

    /**
     * Clearing application cache
     */
    public function clearApplicationCache()
    {
        Cache::flush();

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache aplikacji');
    }

    /**
     * Clearing routing cache
     */
    public function clearRouteCache()
    {
        Artisan::call('route:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache routingu aplikacji');
    }

    /**
     * Clearing config cache
     */
    public function clearConfigCache()
    {
        Artisan::call('config:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache konfiguracji aplikacji');
    }
}
