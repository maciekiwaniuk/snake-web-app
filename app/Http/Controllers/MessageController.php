<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MessageAjaxRequest;
use App\Http\Requests\MessageRequest;
use App\Services\MessagesService;

class MessageController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(MessagesService $service)
    {
        $this->messagesService = $service;
    }

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
        $message = $this->messagesService->store($request);

        if (Auth::check()) {
            $user = Auth::user();
            $this->messagesService->updateMessageSentAsUser($message, $user);
        }

        return redirect()->route('message.index')
            ->with('success', 'Wiadomość została pomyślnie wysłana.');
    }

    /**
     * Add user's message to database
     */
    public function storeAJAX(MessageAjaxRequest $request)
    {
        $message = $this->messagesService->storeAJAX($request);

        if (Auth::check()) {
            $user = Auth::user();
            $this->messagesService->updateMessageSentAsUser($message, $user);
        }

        $result = [
            'success' => true,
            'message' => 'Wiadomość została pomyślnie wysłana.'
        ];

        return response()->json([
            'result' => $result
        ]);
    }
}
