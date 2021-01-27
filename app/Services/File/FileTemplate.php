<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class FileTemplate
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * temp 파일을 반영구보관할 곳인 public 으로 옮김.
     *
     * @param File $file Temp File
     * @return File|false 실패하면 false 반환.
     */
    public function moveTempToPublic(File $file)
    {
        $path = $this->getPublicPath($file->name);
        try {
            DB::beginTransaction();

            if (!Storage::move($file->path, $path)) {
                DB::rollBack();
                Log::error('FAILED TO MOVE FILE');
                return false;
            }

            $file->path = $path;
            $file->url = route('api.admin.download', $file->id);
            //$file->url = str_replace('public', '/storage', $path);
            $file->save();
            DB::commit();

            return $file;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error("MOVE TEMP TO PUBLIC ERROR", [$exception, $file, $path]);

            return false;
        }
    }

    /**
     * 저장할 곳 지정.
     *
     * @param string $fileName
     * @return string
     */
    abstract function getPublicPath(string $fileName);

    /**
     * 이미 생성된 모델의 파일 삭제 진행.
     *
     * @return bool 실패시 false 반환, 성공시 true 반환.
     */
    public function deletePublicFile()
    {
        $path = $this->deleteFileInDB();
        if ($path === false) {
            return false;
        }
        return Storage::delete($path);
    }

    /**
     * 모델에서 파일 접근하여 DB 상의 파일 삭제.
     *
     * @return false|string 실패시 false 반환, 성공시 file 의 path 반환
     */
    abstract function deleteFileInDB();
}
