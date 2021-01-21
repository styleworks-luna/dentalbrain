<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오후 5:31
 */

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Manage\Banner;
use App\Services\File\DesktopFile;
use App\Services\File\MobileFile;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    public function index()
    {
        return response()->json([
            'banners' => Banner::whereNotNull('id')
                ->orderByDesc('id')
                ->paginate(10)
        ]);
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'position' => 'required | numeric',
            'order' => 'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'mobile_file_id' => 'required | numeric',
            'desktop_file_id' => 'required | numeric',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at' => 'required|date_format:Y-m-d|after:started_at',
        ]);

        $validatedData['user_id'] = auth()->id();
        $banner = Banner::create($validatedData);

        $desktopFile = new DesktopFile($banner);
        $desktopFile->moveTempToPublic(File::find($banner->desktop_file_id));

        $mobileFile = new MobileFile($banner);
        $mobileFile->moveTempToPublic(File::find($banner->mobile_file_id));

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Banner $banner)
    {
        return response()->json([
            'banner' => $banner
        ]);
    }

    public function update(Request $request, Banner $banner)
    {

        $validatedData = $request->validate([
            'position' => 'required | numeric',
            'order' => 'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'mobile_file_id' => 'required | numeric',
            'desktop_file_id' => 'required | numeric',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at' => 'required|date_format:Y-m-d|after:started_at',
        ]);

        if ($validatedData['desktop_file_id'] != $banner->desktop_file_id) {
            $desktopFile = new DesktopFile($banner);
            $desktopFile->deletePublicFile();
            $desktopFile->moveTempToPublic(File::find($validatedData['desktop_file_id']));
        }
        if ($validatedData['mobile_file_id'] != $banner->mobile_file_id) {
            $mobileFile = new MobileFile($banner);
            $mobileFile->deletePublicFile();
            $mobileFile->moveTempToPublic(File::find($validatedData['mobile_file_id']));
        }

        $validatedData['user_id'] = auth()->id();
        $banner->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }

    public function destroy(Banner $banner)
    {
        $desktopFile = new DesktopFile($banner);
        $desktopFile->deletePublicFile();

        $mobileFile = new MobileFile($banner);
        $mobileFile->deletePublicFile();

        $banner->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }

    public function statusChange(Banner $banner)
    {
        $statusChange = new StatusChangeImpl();
        return $statusChange->statusChange($banner, 'is_open');
    }
}
