<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:45
 */

namespace App\Services\File;

use App\Models\Manage\Banner;

class DesktopFile extends FileTemplate
{
    public function __construct(Banner $banner)
    {
        parent::__construct($banner);
    }

    function getPublicPath(string $fileName)
    {
        $banner = $this->model;
        return $path = 'public/banners/' . $banner->id . '/desktop/' . $fileName;
    }

    function deleteFileInDB()
    {
        $banner = $this->model;
        $path = $banner->desktopFile->path;
        $banner->desktopFile->delete();
        return $path;
    }
}
