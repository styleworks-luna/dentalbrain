<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Payments\Payment;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeApplication;
use App\Models\Recruit\Option\TypeBenefit;
use App\Models\Recruit\Option\TypeDay;
use App\Models\Recruit\Option\TypeJob;
use App\Models\Recruit\Option\TypeSalary;
use App\Models\Recruit\Option\TypeStudy;
use App\Models\Recruit\Option\TypeWork;
use App\Models\Recruit\Recruit;
use App\Models\Recruit\RecruitPrice;
use App\Payments\TossPayments\TossPayments;
use App\Payments\TossPayments\TossPaymentsException;
use App\Services\Recruit\RecruitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecruitController extends Controller
{
    protected $recruitService;

    public function __construct()
    {
        $this->recruitService = new RecruitService();
    }

    public function createForm()
    {
        // 회원 상태 확인
        $user = Auth::user();

        // 회원 상태에 따른 결제 금액
        $price = RecruitPrice::getRecruitPrice($user);

        return view(viewPrefix() . 'pages.albatalk.albatalk_post')->with([
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'price' => $price,
        ]);
    }


    public function detail(Recruit $recruit)
    {
        $applications = RecruitApplication::query()->where('recruit_id', '=', $recruit->id)->get();
        $salaries = RecruitSalary::query()->where('recruit_id', '=', $recruit->id)->get();
        $days = RecruitDay::query()->where('recruit_id', '=', $recruit->id)->get();
        $benefits = RecruitBenefit::query()->where('recruit_id', '=', $recruit->id)->get();

        $recruit->with('typeWork', 'typeJob', 'typeStudy', 'file', 'file1', 'file2', 'file3');

        return view(viewPrefix() . 'pages.albatalk.albatalk_detail', [
            'recruit' => $recruit,
            'applications' => $applications,
            'salaries' => $salaries,
            'days' => $days,
            'benefits' => $benefits,
        ]);
    }

    public function saveRecruitDataToSession(Request $request): \Illuminate\Http\JsonResponse
    {
        // 구인 등록 유효성 검사
        $validator = $this->recruitService->getValidatorRecruit($request->all());
        if ($validator->fails()) {
            $messageBag = $validator->errors();

            $collection = collect($messageBag)->map(function ($item, $key) {
                return ['name' => $key, 'message' => $item[0]];
            });

            return response()->json($collection->toArray(), 400);
        }

        // 검사한 데이터 세션에 저장
        session([Recruit::SESSION_KEY => $validator->validated()]);

        return response()->json(['massage' => 'ok']);
    }

    public function success(SuccessPayments $request)
    {
        $user = Auth::user();
        $realPrice = RecruitPrice::getRecruitPrice($user);

        if ($realPrice != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.']);
        }

        try {
            DB::beginTransaction();

            // 구인등록 인스턴스 생성
            $recruitData = $request->session()->get(Recruit::SESSION_KEY);
            $recruit = $this->recruitService->storeRecruit($recruitData);
            $application = $this->recruitService->storeRecruitApplication($recruit, $recruitData);
            $salary = $this->recruitService->storeRecruitSalary($recruit, $recruitData);
            $day = $this->recruitService->storeRecruitDay($recruit, $recruitData);
            $benefit = $this->recruitService->storeRecruitBenefit($recruit, $recruitData);

            $this->recruitService->attachThumbnails($recruit, $recruitData);

            // 결제 승인 API
            $tossPayments = new TossPayments($request['paymentKey']);
            $tossResponse = $tossPayments->success($request['orderId'], $request['amount']);

            if (!$tossResponse) {
                return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
            }

            // session 지우기
            session()->forget(Recruit::SESSION_KEY);

            // 페이먼츠 인스턴스 생성
            $payment = Payment::createByTossSuccess($tossResponse);

            $recruit->payment_id = $payment->id;
            $recruit->save();

            DB::commit();

        } catch (TossPaymentsException $exception) {
            DB::rollBack();

            Log::error('RECRUIT TOSS SUCCESS ERROR : TOSS_EXCEPTION', [$exception]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('RECRUIT TOSS SUCCESS ERROR : EXCEPTION', [$exception]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
        }

        return redirect()->route('albatalk.recruit.detail', $recruit->id);
    }

    public function edit(Recruit $recruit)
    {
        $userId = Auth::id();

        if ($recruit->user_id != $userId) {
            return redirect()->back()->with(['alert' => '구인 등록한 유저가 아닙니다.']);
        }

        $recruit = Recruit::query()->with(['file', 'typeWork', 'typeJob', 'typeStudy'])
            ->where('id', $recruit->id)->first();

        $recruitApplications = RecruitApplication::query()->where('recruit_id', $recruit->id)->pluck('type_application_id');
        $recruitSalaries = RecruitSalary::query()->where('recruit_id', $recruit->id)->get(['type_salary_id', 'value']);
        $recruitDays = RecruitDay::query()->where('recruit_id', $recruit->id)->get(['type_day_id', 'value']);
        $recruitBenefits = RecruitBenefit::query()->where('recruit_id', $recruit->id)->pluck('type_benefit_id');

        return view(viewPrefix() . 'pages.albatalk.albatalk_post_edit', [
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'recruit' => $recruit,
            'recruitApplications' => $recruitApplications,
            'recruitSalaries' => $recruitSalaries,
            'recruitDays' => $recruitDays,
            'recruitBenefits' => $recruitBenefits,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'haerh' => ['required']
        ]);
    }
}
