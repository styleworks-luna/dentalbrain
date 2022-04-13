<?php

namespace App\Http\Controllers\Albatalk;

use App\Models\File;
use App\Models\Resume\Resume;
use App\Services\File\ResumeThumbnail;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AlbatalkFileController
{
    private $resumeService;

    public function __construct(ResumeService $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    public function uploadRecruit()
    {

    }

    public function uploadResume(Request $request)
    {
        $validator = $this->resumeService->getFileValidator($request);

        $uploadedFile = $validator->validate()['image'];

        $file = ResumeThumbnail::saveFile($uploadedFile);

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'size' => $file->size,
            'url' => $file->url,
        ]);
    }

}
