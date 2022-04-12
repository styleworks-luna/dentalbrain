<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\Resume\Resume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $size = $uploadedFile->getSize();

        /** @var Resume $resume */
        $resume = $this->model;

        $path = Storage::putFileAs('resume/' . $resume->id . '/thumbnail',
            $uploadedFile, $name);

        /** @var File $file */

        return File::query()->create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
            'url' => $this->getDownloadUrl($path),
        ]);
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
