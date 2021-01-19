<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:22
 */

namespace App\Services\File;

use App\Models\File;
use App\Models\Manage\Banner;

abstract class FileAbstractService{
    private $category;

    public function FileAbstractService($category)
    {
        $this->setCategory($category);
    }

    public function getCategory(){
        return $this->category;
    }

    public function setCategory($category){
        $this->category = $category;
    }

    abstract function fileDelete(Banner $banner);
    abstract function tmpFileTransferToStorage(Banner $banner,File $file);
}