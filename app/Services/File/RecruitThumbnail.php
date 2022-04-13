<?php

namespace App\Services\File;

use App\Models\File;
use App\Models\Recruit\Recruit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecruitThumbnail extends FileTemplate
{
    public function __construct(Recruit $recruit)
    {
        parent::__construct($recruit);
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

        $path = Storage::putFileAs('public/recruit/temp/thumbnail',
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
    protected function getSavePath(string $fileName)
    {
        $recruit = $this->model;
        return 'public/recruit/' . $recruit->id . '/thumbnail/' . $fileName;
    }

    /**
     * @inheritDoc
     */
    protected function deleteFileInDB()
    {
        /** @var Recruit $recruit */
        $recruit = $this->model;
        $paths = collect();

        if ($recruit->file()->exists()) {
            $path = $recruit->file->path;
            $recruit->file->delete();
            $paths->add($path);
        }
        if ($recruit->file1()->exists()) {
            $path = $recruit->file1->path;
            $recruit->file1->delete();
            $paths->add($path);
        }
        if ($recruit->file2()->exists()) {
            $path = $recruit->file2->path;
            $recruit->file2->delete();
            $paths->add($path);
        }
        if ($recruit->file3()->exists()) {
            $path = $recruit->file3->path;
            $recruit->file3->delete();
            $paths->add($path);
        }
        if ($paths->isEmpty()) {
            return false;
        }

        return $paths->toArray();
    }
}
