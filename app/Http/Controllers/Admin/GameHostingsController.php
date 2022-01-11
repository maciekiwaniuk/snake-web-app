<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameHosting;
use Illuminate\Http\Request;

class GameHostingsController extends Controller
{
    /**
     * Get list of all game hostings
     */
    public function __construct()
    {
        $this->game_hostings = GameHosting::query()
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * Show game hostings index page
     */
    public function index()
    {
        return view('admin.game-hostings', [
            'game_hostings' => $this->game_hostings
        ]);
    }

    /**
     * Add game hosting
     */
    public function store(Request $request)
    {

    }

    /**
     * Delete game hosting
     */
    public function destroy($id)
    {

    }

    /**
     * Modify game hosting
     */
    public function put($id)
    {

    }




}
