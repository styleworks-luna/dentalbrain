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
use App\Traits\FileChecktrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class BannerController extends Controller{
    use FileChecktrait;

    public function index(){
        return response()->json([
           'banners' => Banner::whereNotNull('id')
               ->orderByDesc('id')
               ->paginate(10)
        ]);
    }

    public function show(){
        $banners = Banner::orderByDesc('id')->paginate(10);

        return response()->json([
            'banners' => $banners
        ]);
    }

    public function store(Request $request){

        $validatedData = $request->validate([
            'position'=>'required | numeric',
            'order'=>'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at'=> 'required|date_format:Y-m-d|after:started_at',
        ]);

        $validatedData['user_id'] = auth()->id();
        $banner = Banner::create($validatedData);

        if( $request->hasFile('mobile_file_id')){
            $this->bannerImageUpload($request->file('mobile_file_id'), $banner->id,$request->input('link'));
        }

        if( $request->hasFile('desktop_file_id')){
            $this->bannerImageUpload($request->file('desktop_file_id'), $banner->id, $request->input('link'));
        }

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    public function edit(Banner $banner){
        return response()->json([
            'banner'=>$banner->load('file')
        ]);
    }

    public function update(Request $request, Banner $banner){

        if( $request->hasFile('mobile_file_id')){
            $mobile_file_id = $this->bannerImageUpload($request->file('mobile_file_id'), $banner->id,$request->input('link'));
        }

        if( $request->hasFile('desktop_file_id')){
            $desktop_file_id = $this->bannerImageUpload($request->file('desktop_file_id'), $banner->id, $request->input('link'));
        }

        $validatedData = $request->validate([
            'position'=>'required | numeric',
            'order'=>'required | numeric',
            'title' => 'required',
            'link' => 'required',
            'started_at' => 'required|date_format:Y-m-d',
            'ended_at'=> 'required|date_format:Y-m-d|after:started_at',
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['mobile_file_id'] = $mobile_file_id;
        $validatedData['desktop_file_id'] = $desktop_file_id;

        if ($validatedData['desktop_file_id'] != $banner->desktop_file_id) {
            $this->fileDelete($banner);
        }
        if ($validatedData['mobile_file_id'] != $banner->mobile_file_id) {
            $this->fileDelete($banner);
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

        $this->fileDelete($banner);

        $banner->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }

    private function fileDelete(Banner $banner) {
        $path = $banner->file->path;
        $banner->file()->delete();
        return Storage::delete($path);
    }
}