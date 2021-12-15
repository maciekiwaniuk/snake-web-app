<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
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

    /**
     * Add user's message to database
     */
    public function storeAJAX(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:100', new MessageSubject],
            'sender' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'content' => ['required', 'string', 'max:500'],
            'g_recaptcha_response' => [new reCAPTCHAv2]
        ],
        [
            'email.email' => 'E-mail jest niepoprawny.',
            'sender.required' => 'Twoja nazwa jest wymagana.',
            'email.required' => 'Twój e-mail jest wymagany.',
            'content.required' => 'Treść wiadomości jest wymagana.'
        ]);

        if ($validator->fails()) {
            $result = [
                'error' => true,
                'message' => $validator->errors()->first(),
            ];
            return response()->json([
                'result' => $result
            ]);
        }

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

        $result = [
            'success' => true,
            'message' => 'Wiadomość została pomyślnie wysłana.'
        ];

        return response()->json([
            'result' => $result
        ]);
    }
}
