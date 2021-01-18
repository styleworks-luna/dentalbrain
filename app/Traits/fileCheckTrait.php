<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-18
 * Time: 오전 10:16
 */

namespace App\Traits;

use App\Models\File;

trait FileChecktrait{
    function bannerImageUpload($bannerImage, $banner_id,$link){
        $size = $bannerImage->getSize();
        $name = $bannerImage->getClientOriginalName();
        $ext = $bannerImage->getClientOriginalExtension();
        if ($this->isNotValidThumbnail($bannerImage)) {
            return redirect()->back()->with('alert', '허용되지 않은 확장자입니다');
        }

        $path = $bannerImage->storeAs('public/banner/' . $banner_id , 'banner.' . $ext);
        $id = File::insertGetId([
            'path' => $path,
            'url' => $link,
            'name' => $name,
            'size' => $size,
        ]);
        return $id;
    }

    function isNotValidThumbnail($thumbnail)
    {
        if (in_array($thumbnail->getClientOriginalExtension(), array('jpg', 'jpeg', 'png', 'gif', 'bmp'))) {
            return false;
        }
        return true;
    }
}