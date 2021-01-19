<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
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

}

