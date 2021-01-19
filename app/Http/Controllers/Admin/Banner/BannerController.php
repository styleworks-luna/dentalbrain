<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오후 5:31
 */

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Services\File\MobileFile;
use App\Services\File\PCFile;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;
use App\Models\File;

class BannerController extends Controller{

    public function index(){
        return response()->json([
           'banners' => Banner::whereNotNull('id')
               ->orderByDesc('id')
               ->paginate(10)
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'position'=>'required | numeric',
            'order'=>'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'mobile_file_id' => 'required | numeric',
            'desktop_file_id'=> 'required | numeric',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at'=> 'required|date_format:Y-m-d|after:started_at',
        ]);

        $validatedData['user_id'] = auth()->id();
        $banner = Banner::create($validatedData);

        $pcFile = new PCFile();
        $pcFile->tmpFileTransferToStorage($banner,File::find($banner->desktop_file_id));

        $mobileFile = new MobileFile();
        $mobileFile->tmpFileTransferToStorage($banner,File::find($banner->mobile_file_id));

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Banner $banner){
        return response()->json([
            'banner'=>$banner
        ]);
    }

    public function update(Request $request,Banner $banner){

        $validatedData = $request->validate([
            'position'=>'required | numeric',
            'order'=>'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'mobile_file_id' => 'required | numeric',
            'desktop_file_id'=> 'required | numeric',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at'=> 'required|date_format:Y-m-d|after:started_at',
        ]);

        if ($validatedData['desktop_file_id'] != $banner->desktop_file_id) {
            $pcFile = new PCFile();
            $pcFile ->fileDelete($banner);
            $pcFile->tmpFileTransferToStorage($banner,File::find($validatedData['desktop_file_id']));
        }
        if ($validatedData['mobile_file_id'] != $banner->mobile_file_id) {
            $mobileFile = new MobileFile();
            $mobileFile ->fileDelete($banner);
            $mobileFile->tmpFileTransferToStorage($banner,File::find($validatedData['mobile_file_id']));
        }

        $banner->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }

    public function destroy(Banner $banner)
    {
        $banner->file; // eager loading

        $pcFile = new PCFile();
        $pcFile->fileDelete($banner);

        $mobileFile = new MobileFile();
        $mobileFile->fileDelete($banner);

        $banner->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }

    public function statusChange(Banner $banner){
        $statusChange = new StatusChangeImpl();
        return $statusChange->statusChange($banner,'is_open');
    }
}