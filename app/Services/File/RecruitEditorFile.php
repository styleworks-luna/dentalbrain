<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecruitEditorFile extends FileTemplate
{
    private function __construct(Model $model)
    {
        parent::__construct($model);
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

        $randomName = Str::random('50') . '.' . $extension;

        $path = Storage::putFileAs('public/recruit/editor/file',
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
        // TODO: Implement getSavePath() method.
    }

    /**
     * @inheritDoc
     */
    protected function deleteFileInDB()
    {
        // TODO: Implement deleteFileInDB() method.
    }
}
