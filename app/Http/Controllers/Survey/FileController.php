<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use App\Models\Program\Survey\Survey;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download(Survey $survey, SurveyAnswer $answer)
    {
        $file = $answer->file;
        if (!$file) {
            return response()->json(['alert' => '파일이 없습니다.'], 404);
        }
        // TODO : Policy 작성해야함.
        if (Auth::user()->is_admin) {
            $headers = [];
            return Storage::download($file->path, $file->name, $headers);
        }
        if ($answer->user()->exists()) {
            $headers = [];
            return Storage::download($file->path, $file->name, $headers);
        }
        return response()->json(['alert' => '허용되지 않은 권한입니다.'], 403);

    }
}
