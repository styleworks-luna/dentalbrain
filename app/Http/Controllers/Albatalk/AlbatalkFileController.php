<?php

namespace App\Http\Controllers\Albatalk;

use App\Services\File\RecruitEditorFile;
use App\Services\File\RecruitEditorImage;
use App\Services\File\RecruitThumbnail;
use App\Services\File\ResumeThumbnail;
use App\Services\Recruit\RecruitService;
use App\Services\Recruit\ResumeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AlbatalkFileController
{
    private $resumeService;
    private $recruitService;

    public function __construct(ResumeService $resumeService, RecruitService $recruitService)
    {
        $this->resumeService = $resumeService;
        $this->recruitService = $recruitService;
    }

    public function uploadRecruitEditorImage(Request $request): JsonResponse
    {
        $uploadedFile = $this->recruitService->validateEditorImage($request);

        $file = RecruitEditorImage::saveFile($uploadedFile);

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'size' => $file->size,
            'url' => $file->url,
        ]);
    }

    public function uploadRecruitEditorFile(Request $request): JsonResponse
    {
        $uploadedFile = $this->recruitService->validateEditorFile($request);

        $file = RecruitEditorFile::saveFile($uploadedFile);

        return response()->json([
            'id' => $file->id,
            'name' => $file->name,
            'size' => $file->size,
            'url' => $file->url,
        ]);
    }

    public function uploadRecruitThumbnail(Request $request): JsonResponse
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
