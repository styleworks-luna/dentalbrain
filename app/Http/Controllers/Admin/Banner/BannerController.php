<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-15
 * Time: 오후 5:31
 */

namespace App\Http\Controllers\Admin\Banner;

use App\Models\Manage\BannerCategory;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Manage\Banner;
use App\Services\File\DesktopFile;
use App\Services\File\MobileFile;
use App\Services\Search\BannerSearchImpl;
use App\Services\StatusChange\StatusChangeImpl;
use App\Services\ViewCount\ViewCountImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Storage;
use App\Traits\SearchFunctions;
use App\Services\Search\SearchService;
use DateTime;

class BannerController extends Controller
{
    use SearchFunctions;
    private $search;
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
            'position' => ['required', 'numeric'],
            'order' => ['required', 'numeric'],
            'title' => ['string','nullable'],
            'link' => ['required'],
            'mobile_file_id' => ['required ', ' numeric'],
            'desktop_file_id' => ['required', 'numeric'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
            'is_open' => ['required', 'boolean']
        ]);

        $validatedData['user_id'] = auth()->id();
        $banner = Banner::firstOrCreate($validatedData);
        //여러번 누르면 여러개 만들어져서 firstOrCreate 사용

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
        $banner->load('desktopFile','mobileFile');

        return response()->json([
            'banner' => $banner
        ]);
    }

    public function update(Request $request, Banner $banner)
    {
        $validatedData = $request->validate([
            'position' => ['required', 'numeric'],
            'order' => ['required', 'numeric'],
            'title' => ['string', 'nullable'],
            'link' => ['required',],
            'mobile_file_id' => ['required', 'numeric',],
            'desktop_file_id' => ['required', 'numeric'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
            'is_open' => ['required', 'boolean']
        ]);

        logger($validatedData);
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

        Storage::disk('banners')->deleteDirectory($banner->id); // 배너 자체가 사라지니까 폴더 자체를 없애버림.
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


    public function search(Request $request){
        $this->search = new SearchService(Banner::query());
        $this->addKeywordToSearchService($this->search,['link'],$request->keyword);
        $this->addCategoryDate($request->date);
        $this->addPosition($request->position);
        $result = $this->search->search()->paginate('10');

        return response()->json(['search' => $result]);
    }

    public function addCategoryDate(string $date = null){
        if(isset($date) && DateTime::createFromFormat('Y-m-d', $date) !== false){
            $this->search->addCategory('started_at','<=',$date);
            $this->search->addCategory('ended_at','>=',$date);
        }
    }

    public function addPosition(string $position = null){
        if(isset($position) && is_numeric($position)){
            $this->search->addCategory('position','=',$position);
        }
    }

    public function redirectToLink(Banner $banner)
    {
        $viewCountIncrement = new ViewCountImpl();
        $viewCountIncrement->viewCountAdd($banner);
        return redirect($banner->link);
    }

    public function getBannerCategory(){
        return response()->json([
            'category' => BannerCategory::all()
        ]);
    }
}
