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
    public function destroy($id)
    {
        $message = Message::query()
            ->where('id', '=', $id)
            ->first();

        $message->update([
            'deleted' => true
        ]);

        return back();
    }
}
