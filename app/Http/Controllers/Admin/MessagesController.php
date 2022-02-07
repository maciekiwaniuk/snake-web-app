<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\MessagesService;

class MessagesController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(MessagesService $service)
    {
        $this->messagesService = $service;
    }

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
        $messages = Message::query()
            ->where('deleted', '=', 0)
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $messages
        ]);
    }

    /**
     * Delete message
     */
    public function destroy($message_id)
    {
        $this->messagesService->destroy($message_id);

        return back();
    }
}
