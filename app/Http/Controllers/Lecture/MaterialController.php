<?php

namespace App\Http\Controllers\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Program\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function download(Program $program)
    {
        $file = $program->material();
        if (!$file) {
            return response()->json(['alert' => '파일이 없습니다.'], 404);
        }
        // TODO : Policy 작성해야함.
        if (Auth::user()->is_admin) {
            $headers = [];
            return Storage::download($file->path, $file->name, $headers);
        }
        if ($program->students()->where('user_id', '=', Auth::id())->exists()) {
            $headers = [];
            return Storage::download($file->path, $file->name, $headers);
        }
        return response()->json(['alert' => '허용되지 않은 권한입니다.'], 403);
    }

}
