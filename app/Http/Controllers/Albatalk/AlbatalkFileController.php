<?php

namespace App\Http\Controllers\Albatalk;

use App\Services\File\RecruitThumbnail;
use App\Services\File\ResumeThumbnail;
use App\Services\Recruit\RecruitTemplate;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlbatalkFileController
{
    private $resumeService;
    private $recruitService;

    public function __construct(ResumeService $resumeService, RecruitTemplate $recruitService)
    {
        $this->resumeService = $resumeService;
        $this->recruitService = $recruitService;
    }

    public function uploadRecruit(Request $request): JsonResponse
    {
        $uploadedFile = $this->recruitService->validateFile($request);

        $file = RecruitThumbnail::saveFile($uploadedFile);

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'size' => $file->size,
            'url' => $file->url,
        ]);
    }

    public function uploadResume(Request $request): JsonResponse
    {
        $uploadedFile = $this->resumeService->validateFile($request);

        $file = ResumeThumbnail::saveFile($uploadedFile);

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'size' => $file->size,
            'url' => $file->url,
        ]);
    }

}
