<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\Resume\Resume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ResumeThumbnail extends FileTemplate
{
    public function __construct(Resume $resume)
    {
        parent::__construct($resume);
    }

    /**
     * @inheritDoc
     */
    protected function getSavePath(string $fileName)
    {
        $resume = $this->model;
        return $path = 'public/resume/' . $resume->id . '/thumbnail/' . $fileName;
    }

    public function saveFile($uploadedFile)
    {
        $name = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->extension();
        $size = $uploadedFile->getSize();

        $prefix = Auth::id() ?? 'null';

        /** @var Resume $resume */
        $resume = $this->model;

        $path = Storage::putFileAs('resume/' . $resume->id . '/thumbnail',
            $uploadedFile, $name);

        $file = File::create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
        ]);

        $file->url = $this->getDownloadUrl($file, $file->path);
        $file->save();

        return $file;
    }

    /**
     * @inheritDoc
     */
    protected function deleteFileInDB()
    {
        /** @var Resume $resume */
        $resume = $this->model;
        $path = $resume->file->path;
        $resume->file->delete();
        return $path;
    }
}
