<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Rules\ValidGameFile;

class ActionsController extends Controller
{
    /**
     * Wyświetla główną stronę z akcjami
     */
    public function index()
    {
        return view('pages.actions');
    }

    /**
     * Obsługa wczytania progresu przez użytkownika
     */
    public function loadProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'progressFile' => new ValidGameFile,
        ]);

        $result = [
            'success' => true,
            'message' => 'Progress został wczytany pomyślnie.',
        ];

        if ($validator->fails()) {
            $result = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
        } else {

        }




        return response()->json([
            'result' => $result,
        ]);
    }
}
