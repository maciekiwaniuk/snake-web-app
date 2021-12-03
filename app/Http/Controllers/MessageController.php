<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageRequest;
use App\Models\Message;

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
        $message = new Message();
        $message->subject = $request->subject;
        $message->sender = $request->sender;
        $message->email = $request->email;
        $message->content = $request->content;

        if (Auth::check()) {
            $message->sent_as_user = true;
            $message->user_name = Auth::user()->name;
        } else {
            $message->sent_as_user = false;
        }
        $message->save();

        return redirect()->route('message.index')
            ->with('success', 'Wiadomość została pomyślnie wysłana.');
    }
}
