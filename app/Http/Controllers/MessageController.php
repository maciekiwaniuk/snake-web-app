<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    /**
     * Show message index page with selected contact option
     */
    public function index()
    {
        return view('pages.message', [
            'selected' => 'kontakt'
        ]);
    }

    /**
     * Show message index page with selected exact option
     */
    public function show($selected)
    {
        return view('pages.message', [
            'selected' => $selected
        ]);
    }

    /**
     * Mechanism of adding user's message to database
     */
    public function store(MessageRequest $request)
    {
        return back();
    }
}
