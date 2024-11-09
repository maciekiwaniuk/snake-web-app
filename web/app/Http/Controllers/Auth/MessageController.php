<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageAjaxRequest;
use App\Http\Requests\MessageRequest;
use App\Services\MessagesService;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function __construct(MessagesService $service)
    {
        $this->messagesService = $service;
    }

    public function index()
    {
        return view('pages.message', [
            'selected' => 'kontakt'
        ]);
    }

    public function show($selected)
    {
        return view('pages.message', [
            'selected' => $selected
        ]);
    }

    public function store(MessageRequest $request)
    {
        // method may not create message -> anti spam detection
        $message = $this->messagesService->store($request);

        if (Auth::check() && isset($message)) {
            $user = Auth::user();
            $this->messagesService->updateMessageSentAsUser($message, $user);
        }

        return redirect()->route('message.index')
            ->with('success', 'Wiadomość została pomyślnie wysłana.');
    }

    public function storeAJAX(MessageAjaxRequest $request)
    {
        // method may not create message -> anti spam detection
        $message = $this->messagesService->storeAJAX($request);

        if (Auth::check() && isset($message)) {
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
