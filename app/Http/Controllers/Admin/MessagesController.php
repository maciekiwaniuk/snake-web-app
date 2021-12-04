<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;

class MessagesController extends Controller
{
    /**
     * Show messages index page
     */
    public function index()
    {
        return view('admin.messages');
    }

    /**
     * Return messages sent via site
     */
    public function getMessages()
    {
        $messages = Message::all();

        return response()->json([
            'data' => $messages
        ]);
    }
}
