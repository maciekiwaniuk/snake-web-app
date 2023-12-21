<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\MessagesService;

class MessagesController extends Controller
{
    public function __construct(MessagesService $service)
    {
        $this->messagesService = $service;
    }

    public function index()
    {
        return view('admin.messages');
    }

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

    public function destroy($message_id)
    {
        $this->messagesService->destroy($message_id);

        return back();
    }
}
