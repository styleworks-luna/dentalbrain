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
        $randomName = Str::random('5');
        return 'public/recruit/' . $recruit->id . '/thumbnail/' . $randomName . '/' . $fileName;
    }

    /**
     * @inheritDoc
     */
    protected function deleteFileInDB()
    {
        throw new \Exception("이 구현체는 이 함수를 쓰지 않음.");
    }

    public function deleteFile()
    {
        throw new \Exception("이 구현체는 이 함수를 쓰지 않음.");
    }
}
