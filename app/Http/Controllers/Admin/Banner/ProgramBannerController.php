<?php

namespace App\Http\Controllers\Admin\Banner;

use App\Http\Controllers\Controller;
use App\Models\Manage\Banner;
use App\Models\Manage\BannerCategory;
use App\Models\Program\Program;
use App\Services\Search\SearchService;
use App\Services\StatusChange\StatusChangeImpl;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProgramBannerController extends Controller
{

    private $search;

    public function index(Request $request)
    {
        return response()->json([
            'banners' => $this->search($request)
        ]);
    }

    private function search(Request $request)
    {
        $this->search = new SearchService(Banner::query());

        $this->search->addKeyword('title', $request->keyword);
        $this->addCategoryDate($request->date);
        $this->addPositionCategoryId($request->category_id);
        $result = $this->search->search()->with('categories')->orderBy('id', 'desc')->paginate('20');

        return $result;
    }

    private function addCategoryDate(string $date = null)
    {
        if (isset($date) && DateTime::createFromFormat('Y-m-d', $date) !== false) {
            $this->search->addCategory('started_at', '<=', $date);
            $this->search->addCategory('ended_at', '>=', $date);
        }
    }

    private function addPositionCategoryId(string $category_id = null)
    {
        if (isset($category_id) && is_numeric($category_id)) {
            $this->search->addCategory('category_id', '=', $category_id);
        }
    }


    // 배너 만들기
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedData = $this->validateStoreProgramBanner($request);

        Banner::query()->create($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '추가되었습니다.',
        ]);
    }

    // 배너 수정 페이지 데이터
    public function edit(Banner $banner)
    {
        return response()->json([
            'banner' => $banner
        ]);
    }

    // 배너 수정
    public function update(Request $request, Banner $banner): \Illuminate\Http\JsonResponse
    {
        $validatedData = $this->validateUpdateProgramBanner($request);

        $banner->update($validatedData);

        return response()->json([
            'success' => true,
            'msg' => '수정되었습니다.',
        ]);
    }

    // 배너 삭제
    public function destroy(Banner $banner)
    {
        $banner->delete();

        return response()->json([
            'success' => true,
            'msg' => '삭제되었습니다.',
        ]);
    }

    // 공개 비공개
    public function statusChange(Banner $banner)
    {
        $statusChange = new StatusChangeImpl();
        return $statusChange->statusChange($banner, 'is_open');
    }

    // 배너 종류 보기 - (구역2, 구역3)
    public function getBannerCategory()
    {
        $banners = BannerCategory::all();
        return response()->json([
            'category' => $banners->only([Banner::$POSITION_AREA2, Banner::$POSITION_AREA3])
        ]);
    }

    /**
     * @param Request $request
     * @param bool $isNew
     * @return array
     * @throws ValidationException
     */
    private function validateProgramBanner(Request $request, bool $isNew): array
    {
        $validator = Validator::make($request->all(), [
            'category_id' => ['required', Rule::in([Banner::$POSITION_AREA2, Banner::$POSITION_AREA3])],
            'order' => ['required', 'numeric'],
            'title' => ['string', 'nullable'],
            'program_id' => ['required', 'numeric'],
            'started_at' => ['required', 'date_format:Y-m-d'],
            'ended_at' => ['required', 'date_format:Y-m-d', 'after:started_at'],
            'is_open' => ['required', 'boolean']
        ]);

        $validatedData = $validator->validate();

        $program = Program::find($validatedData['program_id']);

        if (!$program) {
            $validator->getMessageBag()->add('program_id.exists', '해당하는 강의가 존재하지 않습니다.');
            throw new ValidationException($validator);
        }

        if ($isNew) {
            $isDuplicated = Banner::query()->where('program_id', "=", $validatedData['program_id'])
                ->where('category_id', '=', $validatedData['category_id'])->exists();

            if ($isDuplicated) {
                $validator->getMessageBag()->add('program_id.duplicated', '배너가 이미 존재합니다.');
                throw new ValidationException($validator);
            }
        }

        $validatedData['user_id'] = auth()->id();
        $validatedData['link'] = "/lectures/" . $validatedData['program_id'];

        return $validatedData;
    }

    private function validateStoreProgramBanner(Request $request): array
    {
        return $this->validateProgramBanner($request, true);
    }

    private function validateUpdateProgramBanner(Request $request): array
    {
        return $this->validateProgramBanner($request, false);
    }
}
