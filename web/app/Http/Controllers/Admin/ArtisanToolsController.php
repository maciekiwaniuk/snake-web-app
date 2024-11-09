<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class ArtisanToolsController extends Controller
{
    public function index()
    {
        return view('admin.artisan-tools');
    }

    public function clearApplicationCache()
    {
        Cache::flush();

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache aplikacji');
    }

    public function clearRouteCache()
    {
        Artisan::call('route:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache routingu aplikacji');
    }

    public function clearConfigCache()
    {
        Artisan::call('config:clear');

        return back()
            ->with('message', 'Pomyślnie wyczyszczono cache konfiguracji aplikacji');
    }
}
