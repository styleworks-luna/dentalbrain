<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-19
 * Time: 오후 4:45
 */

namespace App\Services\File;

use App\Models\File;
use App\Models\Manage\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DesktopFile extends FileAbstractService
{

    public function __construct()
    {
        parent::__construct('desktop');
    }

    public function fileDelete(Banner $banner)
    {
        $file = $banner->desktopFile();
        $path = $banner->desktopFile->path;
        $file->delete();
        return Storage::delete($path);
    }

    public function tempFileTransferToStorage(Banner $banner, File $file)
    {
        $path = 'public/banners/' . $banner->id . '/desktop/' . $file->name;
        Storage::move($file->path, $path);
        DB::transaction(function () use ($file, $path) {
            $file->path = $path;
            $file->save();
        });
    }
}
