<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:45
 */
namespace App\Services\File;

use Illuminate\Support\Facades\Storage;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use App\Models\Manage\Banner;

class PCFile extends FileAbstractService{

    public function PCFile()
    {
        parent::FileAbstractService('pc');
    }

    public function fileDelete(Banner $banner){
        $file = $banner->deskTopFile();
        $path = $banner->deskTopFile->path;
        $file->delete();
        return Storage::delete($path);
    }

    public function tmpFileTransferToStorage(Banner $banner,File $file){
        $path = str_replace($file->path,'public/banners/'.$banner->id.'/pc/'.$file->name, $file->path);
        Storage::move($file->path, $path);
        DB::transaction(function() use ($file, $path){
            $file->path = $path;
            $file->save();
        });
    }
}