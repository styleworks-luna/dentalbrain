<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function uploadImage(Request $request)
    {
        // TODO: validation
        $this->uploadFile($request);
    }

    public function uploadFile(Request $request)
    {
        // TODO: validationl
        $file = $request->file('file');
        $name = $file->getFilename();
        $extension = $file->extension();
        $size = $file->getSize();
        $randomName = Str::random('50') . '.' . $extension;
        $path = Storage::putFileAs('temp', $file, $randomName);

        return File::create([
            'path' => $path,
            'url' => $path,
            'name' => $name,
            'size' => $size,
        ]);
    }
}
