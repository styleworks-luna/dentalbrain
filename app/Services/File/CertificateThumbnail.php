<?php

namespace App\Services\File;

use App\Models\Certificate\CompletionProfile;
use App\Models\File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CertificateThumbnail extends FileTemplate
{

    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    protected function getSavePath(string $fileName)
    {
        return 'public/certificate/image/' . $fileName;
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

        $path = Storage::putFileAs('public/certificate/image',
            $uploadedFile, $randomName);

        /** @var File $file */
        return File::query()->create([
            'path' => $path,
            'name' => $name,
            'size' => $size,
            'url' => str_replace('public', '/storage', $path),
        ]);
    }

    protected function deleteFileInDB()
    {
        $profile = $this->model;
        if ($profile->file()->exists()) {
            $path = $profile->file->path;
            $profile->file->delete();
            return $path;
        }
        return false;
    }
}
