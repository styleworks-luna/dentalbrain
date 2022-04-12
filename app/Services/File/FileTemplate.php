<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class FileTemplate
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param File $original
     * @return File | null
     */
    static function duplicate(File $original)
    {
        /*
         * 1. $this->model 에서 file 추출.
         * 2. file 을 temp 로 복사.
         * 3. 복사한 file로 File Model 만들기.
         * 4. return.
         */
        $filePath = 'temp/' . Str::random('4') . '/' . $original->name;
        if (!Storage::copy($original->path, $filePath)) {
            Log::error('File Duplicate Error');
            return null;
        }
        $file = File::create([
            'path' => $filePath,
            'name' => $original->name,
            'size' => $original->size,
        ]);
        return $file;
    }

    /**
     * temp 파일을 반영구보관할 곳인 public 으로 옮김.
     *
     * @param File $file Temp File
     * @return File|false 실패하면 false 반환.
     */
    public function moveTempToPublic(File $file)
    {
        $path = $this->getSavePath($file->name);
        try {
            DB::beginTransaction();

            if (!Storage::move($file->path, $path)) {
                DB::rollBack();
                Log::error('FAILED TO MOVE FILE');
                return false;
            }

            $file->path = $path;
            $file->save();

            $file->url = $this->getDownloadUrl($path);

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
     * ex) 'public/banners/' . $this->model->id . '/desktop/' . $fileName;
     * @param string $fileName
     * @return string
     */
    abstract protected function getSavePath(string $fileName);

    /**
     * 다운로드 할 수 있는 링크 지정.
     * ex) /storage/program/1/tnumbnail/hello.jpg , http:://dbv2020.onoffmix.test/api/admin/download/13
     * @param $path
     * @return string|string[]
     */
    protected function getDownloadUrl($path)
    {
        return str_replace('public', '/storage', $path);
    }

    /**
     * 이미 생성된 모델의 파일 삭제 진행.
     *
     * @return bool 실패시 false 반환, 성공시 true 반환.
     */
    public function deleteFile()
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
    protected abstract function deleteFileInDB();
}
