<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Http\Requests\MessageAjaxRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\User;

class MessagesService
{
    public function destroy(int $message_id)
    {
        $message = Message::query()
            ->where('id', '=', $message_id)
            ->first();

        $message->update([
            'deleted' => true
        ]);
    }

    public function save(Request $request)
    {
        $content = str_replace(['\'', '"'], '', $request->getContent());
        $sender = $request->sender;
        $email = $request->email;

        $amount_of_similar_messages = Message::query()
            ->where('sender', '=', $sender)
            ->orWhere('email', '=', $email)
            ->orWhere('content', '=', $content)
            ->get()
            ->count();

        // prevent creating spam messages
        if ($amount_of_similar_messages >= 10) return;

        return Message::create([
            'subject' => $request->subject,
            'sender' => $sender,
            'email' => $email,
            'content' => $content,
            'sent_as_user' => false
        ]);
    }

    public function store(MessageRequest $request)
    {
        return $this->save($request);
    }

    public function storeAJAX(MessageAjaxRequest $request)
    {
        return $this->save($request);
    }

    public function updateMessageSentAsUser(Message $message, User $user)
    {
        $message->update([
            'sent_as_user' => true,
            'user_name' => $user->name
        ]);
    }

}
