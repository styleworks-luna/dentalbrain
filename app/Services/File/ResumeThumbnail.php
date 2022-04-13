<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\Resume\Resume;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
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
        return 'public/resume/' . $resume->id . '/thumbnail/' . $fileName;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return Builder|Model
     */
    public static function saveFile($uploadedFile)
    {
        $name = $uploadedFile->getClientOriginalName();
        $size = $uploadedFile->getSize();
        $extension = $uploadedFile->getClientOriginalExtension();

        $randomName = Str::random('20') . '.' . $extension;

        $path = Storage::putFileAs('public/resume/temp/thumbnail',
            $uploadedFile, $randomName);

        /** @var File $file */
        return File::query()->create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
            'url' => str_replace('public', '/storage', $path),
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
