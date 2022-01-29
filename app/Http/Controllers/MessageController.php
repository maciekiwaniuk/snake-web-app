<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\MessageAjaxRequest;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Rules\MessageSubject;
use App\Rules\reCAPTCHAv2;

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
     * Add user's message to database
     */
    public function store(MessageRequest $request)
    {
        $message = Message::make([
            'subject' => $request->subject,
            'sender' => $request->sender,
            'email' => $request->email,
            'content' => $request->content
        ]);

        if (Auth::check()) {
            $message->fill([
                'sent_as_user' => true,
                'user_name' => Auth::user()->name
            ]);
        } else {
            $message->fill([
                'sent_as_user' => false,
            ]);
        }
        $message->save();

        return redirect()->route('message.index')
            ->with('success', 'Wiadomość została pomyślnie wysłana.');
    }

    /**
     * Add user's message to database
     */
    public function storeAJAX(MessageAjaxRequest $request)
    {
        $message = Message::make([
            'subject' => $request->subject,
            'sender' => $request->sender,
            'email' => $request->email,
            'content' => $request->content,
        ]);

        if (Auth::check()) {
            $message->fill([
                'sent_as_user' => true,
                'user_name' => Auth::user()->name
            ]);
        } else {
            $message->fill([
                'sent_as_user' => false
            ]);
        }
        $message->save();

        $result = [
            'success' => true,
            'message' => 'Wiadomość została pomyślnie wysłana.'
        ];

        return response()->json([
            'result' => $result
        ]);
    }
}
