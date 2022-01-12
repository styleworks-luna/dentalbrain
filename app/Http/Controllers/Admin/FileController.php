<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function uploadImage(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['required', 'image']
        ])->validate();

        $file = $this->createTempFileToDB($request->file('image'));

        return response()->json([
            'file' => $file,
        ]);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return File
     */
    private function createTempFileToDB($uploadedFile)
    {
        $name = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->extension();
        $size = $uploadedFile->getSize();
        $randomName = Str::random('50') . '.' . $extension;

        $path = Storage::putFileAs('temp', $uploadedFile, $randomName);

        $file = File::create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
        ]);
        $file->url = route('api.admin.download', $file->id);
        $file->save();

        return $file;
    }

    public function uploadFile(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required', 'file',]
        ])->validate();

        $file = $this->createTempFileToDB($request->file('file'));

        return response()->json([
            'file' => $file,
        ]);
    }

    public function download(File $file)
    {
        $headers = [];
        return Storage::download($file->path, $file->name, $headers);
    }

    /**
     *  강의 상세 이미지 업로드
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadProgramDetailImage(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['required', 'image']
        ])->validate();

        $uploadedFile = $request->file('image');

        $file = $this->uploadToStorage($uploadedFile, 'public/program/images');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }

    /**
     *  공개적인 파일 업로드 처리
     *
     * @param UploadedFile $uploadedFile
     * @param string $path 저장 폴더 (trailing slash X)
     * @param string|null $url 연결 URL
     * @return Builder|File
     */
    private function uploadToStorage($uploadedFile, string $path, string $url = null)
    {
        $name = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->extension();
        $size = $uploadedFile->getSize();

        $randomName = Str::random('50') . '.' . $extension;

        $path = Storage::putFileAs($path, $uploadedFile, $randomName);

        if ($url == null) {
            $url = str_replace('public/', '/storage/', $path);
        }

        return File::query()->create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
            'url' => $url
        ]);
    }

    public function uploadMailImage(Request $request) {
        Validator::make($request->all(), [
            'image' => ['required', 'image']
        ])->validate();

        $uploadedFile = $request->file('image');

        $file = $this->uploadToStorage($uploadedFile, 'public/mail/images');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }

    public function uploadArticleImage(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['required', 'image']
        ])->validate();

        $uploadedFile = $request->file('image');

        $file = $this->uploadToStorage($uploadedFile, 'public/article/images');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }

    public function uploadArticleFile(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required', 'file']
        ])->validate();

        $uploadedFile = $request->file('file');

        $file = $this->uploadToStorage($uploadedFile, 'public/article/files');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }

    public function uploadNoticeImage(Request $request)
    {
        Validator::make($request->all(), [
            'image' => ['required', 'image']
        ])->validate();

        $uploadedFile = $request->file('image');

        $file = $this->uploadToStorage($uploadedFile, 'public/notice/images');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }

    public function uploadNoticeFile(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required', 'file']
        ])->validate();

        $uploadedFile = $request->file('file');

        $file = $this->uploadToStorage($uploadedFile, 'public/notice/files');

        return response()->json([
            'link' => $file->url,
            'file' => $file,
        ]);
    }
}

