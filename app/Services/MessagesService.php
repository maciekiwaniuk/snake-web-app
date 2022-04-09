<?php

namespace App\Services;

use App\Http\Requests\MessageAjaxRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;

class MessagesService
{

    /**
     * Handle destroy message
     */
    public function destroy(int $message_id)
    {
        $message = Message::query()
            ->where('id', '=', $message_id)
            ->first();

        $message->update([
            'deleted' => true
        ]);
    }

    /**
     * Handle store message
     */
    public function store(MessageRequest $request)
    {
        $message = Message::create([
            'subject' => $request->subject,
            'sender' => $request->sender,
            'email' => $request->email,
            'content' => $request->content,
            'sent_as_user' => false
        ]);
        return $message;
    }

    /**
     * Handle store message
     */
    public function storeAJAX(MessageAjaxRequest $request)
    {
        $message = Message::create([
            'subject' => $request->subject,
            'sender' => $request->sender,
            'email' => $request->email,
            'content' => $request->content,
            'sent_as_user' => false
        ]);
        return $message;
    }

    /**
     * Update message - update message sent as logged user
     */
    public function updateMessageSentAsUser(Message $message, User $user)
    {
        $message->update([
            'sent_as_user' => true,
            'user_name' => $user->name
        ]);
    }

}
