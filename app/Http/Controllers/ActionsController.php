<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Rules\ValidGameFile;
use App\Models\UserGameData;
use App\Models\User;

class ActionsController extends Controller
{
    /**
     * Showing actions index page
     */
    public function index()
    {
        return view('pages.actions');
    }

    /**
     * Mechanism of loading user file progress - AJAX
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
            $content = json_decode(file_get_contents($request->file('progressFile')), true);

            //name of file without .json
            $name_of_file = explode('.', $request->file('progressFile')->getClientOriginalName())[0];
            $this->insertGameDataToDatabase($content, $name_of_file);
        }

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Returning user's progress data - AJAX
     */
    public function showProgress()
    {
        $user_game_data = UserGameData::query()
            ->select('id', 'filename', 'created_at',)
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($user_game_data as $element) {
            $date = substr($element['created_at'], 0, 10);
            $time = substr($element['created_at'], 11, 5);
            $sec = strtotime($date);
            $newdate = date('d.m.Y', $sec);

            $element['date'] = $newdate.' '.$time;
        }

        return response()->json([
            'data' => $user_game_data
        ]);
    }

    /**
     * Deleting user's progress data
     * after clicking delete button - AJAX
     */
    public function deleteProgress(Request $request)
    {
        $progress = UserGameData::findOrFail($request->id);

        if (!$this->hasPermision($progress->user_id)) {
            return abort('403');
        }

        $progress->delete();

        $result = [
            'success' => true,
            'message' => 'Postęp w grze został pomyślnie usunięty.',
        ];

        return response()->json([
            'result' => $result,
        ]);
    }

    /**
     * Setting current selected progress to show
     * for example in profile or global ranking
     */
    public function selectProgress(Request $request)
    {
        $progress = UserGameData::findOrFail($request->id);

        if (!$this->hasPermision($progress->user_id)) {
            return abort('403');
        }

        $user = Auth::user();
        $user->user_game_data_id = $progress->id;
        $user->save();

        $result = [
            'success' => true,
            'message' => 'Postęp w grze został wybrany pomyślnie.',
        ];

        return response()->json([
            'result' => $result,
        ]);
    }


    /**
     * Downloading clicked user's game progress
     */
    public function downloadProgress(Request $request)
    {
        $progress = UserGameData::findOrFail($request->id);

        if (!$this->hasPermision($progress->user_id)) {
            return abort('403');
        }

        $filename = $progress->filename.'.json';
        $data = $this->getValidGameData($progress);

        $result = [
            'success' => true,
            'message' => 'Pomyślnie rozpoczęto pobieranie postępu w grze.',
            'filename' => $filename,
            'data' => $data,
        ];

        return response()->json([
            'result' => $result,

        ]);
    }
}
