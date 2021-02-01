<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:45
 */

namespace App\Services\File;

use App\Models\Manage\Banner;

class MobileFile extends FileTemplate
{
    public function __construct(Banner $banner)
    {
        parent::__construct($banner);
    }

    protected function getSavePath(string $fileName)
    {
        $banner = $this->model;
        return $path = 'public/banners/' . $banner->id . '/mobile/' . $fileName;
    }

    protected function deleteFileInDB()
    {
        $banner = $this->model;
        $path = $banner->mobileFile->path;
        $banner->mobileFile->delete();
        return $path;
    }
}
