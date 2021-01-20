<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-18
 * Time: 오전 10:16
 */

namespace App\Traits;

use App\Models\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FileTransferToStorage{
    public function tmpFileTransferToStorage(File $file,$bannerId,$isPc = true){
        $pcOrMobile = ($isPc ? 'pc' : 'mobile');
        $path = str_replace($file->path,'public/banners/'.$bannerId.'/'.$pcOrMobile.'/'.$file->name, $file->path);
        Storage::move($file->path, $path);
        DB::transaction(function() use ($file, $path){
            $file->path = $path;
            $file->save();
        });
    }
}