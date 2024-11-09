<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGameHostingRequest;
use App\Models\GameHosting;
use App\Services\GameHostingsService;

class GameHostingsController extends Controller
{
    public function __construct(GameHostingsService $service)
    {
        $this->gameHostingsService = $service;

        $this->game_hostings = GameHosting::query()
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function index()
    {
        return view('admin.game-hostings', [
            'game_hostings' => $this->game_hostings
        ]);
    }

    public function store(StoreGameHostingRequest $request)
    {
        $this->gameHostingsService->store($request);

        return back()->with([
            'success' => 'Hosting gry został dodany pomyślnie.'
        ]);
    }

    public function destroy($hosting_id)
    {
        $this->gameHostingsService->destroy($hosting_id);

        return back()->with([
            'success' => 'Hosting gry został usunięty pomyślnie.'
        ]);
    }

    public function update(Request $request, $hosting_id)
    {
        $this->gameHostingsService->update($request, $hosting_id);
    }

}
