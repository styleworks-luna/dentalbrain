<?php

namespace App\Http\Controllers\Albatalk\Recruit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payments\SuccessPayments;
use App\Models\Payments\Payment;
use App\Models\Recruit\Option\RecruitApplication;
use App\Models\Recruit\Option\RecruitBenefit;
use App\Models\Recruit\Option\RecruitDay;
use App\Models\Recruit\Option\RecruitJob;
use App\Models\Recruit\Option\RecruitSalary;
use App\Models\Recruit\Option\TypeApplication;
use App\Models\Recruit\Option\TypeBenefit;
use App\Models\Recruit\Option\TypeCareer;
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
use App\Services\Recruit\ResumeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecruitController extends Controller
{
    protected $recruitService;
    protected $resumeService;

    public function __construct(RecruitService $recruitService, ResumeService $resumeService)
    {
        $this->recruitService = $recruitService;
        $this->resumeService = $resumeService;
    }

    public function createForm()
    {
        // 회원 상태 확인
        $user = Auth::user();

        // 회원 상태에 따른 결제 금액
        $price = RecruitPrice::getRecruitPrice($user);

        // 게재일 별 금액 처리
        $termPrice = RecruitPrice::getTermPrice($price);

        return view(viewPrefix() . 'pages.albatalk.albatalk_post')->with([
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeCareer' => TypeCareer::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'termPrice' => $termPrice,
        ]);
    }

    public function saveRecruitDataToSession(Request $request): \Illuminate\Http\JsonResponse
    {
        // 구인 등록 유효성 검사
        $validator = $this->recruitService->getValidatorRecruit($request, [
            'term' => ['required', 'numeric'],
        ]);

        if ($validator->fails()) {
            return response()->json([], 400);
        }

        // 검사한 데이터 세션에 저장
        session([Recruit::SESSION_KEY => $validator->validated()]);

        return response()->json(['massage' => 'ok']);
    }

    public function success(SuccessPayments $request): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();

        // 회원 별 구인 등록 가격
        $realPrice = RecruitPrice::getRecruitPrice($user);

        // 게재기간 별 구인 등록 가격
        $term = $request->session()->get(Recruit::SESSION_KEY)['term'];
        $termPrice = RecruitPrice::getTermPrice($realPrice);

        // 구인 등록 가격 확인
        if ($termPrice[$term] != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.']);
        }

        try {
            DB::beginTransaction();

            // 구인등록 인스턴스 생성
            $recruitData = $request->session()->get(Recruit::SESSION_KEY);
            $recruit = $this->recruitService->storeRecruit($recruitData);
            $application = $this->recruitService->storeRecruitApplication($recruit, $recruitData);
            $job = $this->recruitService->storeRecruitJob($recruit, $recruitData);
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
            if ($tossResponse->isCard() || $tossResponse->isTransfer()) {
                $recruit->payment_id = $payment->id;
                $recruit->pay_status = Recruit::$PAY_PAID;
            } else {
                return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
            }
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

        return redirect()->route('albatalk.recruit.detail', $recruit->id)->with(['alert' => '구인공고 게시물이 등록되었습니다.']);
    }

    public function edit(Recruit $recruit)
    {
        $userId = Auth::id();

        if (!Auth::user()->isAdmin() && $recruit->user_id != $userId) {
            return redirect()->back()->with(['alert' => '구인 등록한 유저가 아닙니다.']);
        }

        $recruit = Recruit::query()->with(['file', 'file1', 'file2', 'file3', 'typeWork', 'typeStudy'])
            ->where('id', $recruit->id)->first();

        $recruitApplications = RecruitApplication::query()->where('recruit_id', $recruit->id)->pluck('type_application_id');
        $recruitJobs = RecruitJob::query()->where('recruit_id', $recruit->id)->pluck('type_job_id');
        $recruitSalaries = RecruitSalary::query()->where('recruit_id', $recruit->id)->get(['type_salary_id', 'value']);
        $recruitDays = RecruitDay::query()->where('recruit_id', $recruit->id)->get(['type_day_id', 'value']);
        $recruitBenefits = RecruitBenefit::query()->where('recruit_id', $recruit->id)->pluck('type_benefit_id');

        return view(viewPrefix() . 'pages.albatalk.albatalk_post_edit', [
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeCareer' => TypeCareer::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'recruit' => $recruit,
            'recruitApplications' => $recruitApplications,
            'recruitJobs' => $recruitJobs,
            'recruitSalaries' => $recruitSalaries,
            'recruitDays' => $recruitDays,
            'recruitBenefits' => $recruitBenefits,
        ]);
    }

    public function update(Recruit $recruit, Request $request)
    {
        $validator = $this->recruitService->getValidatorRecruit($request, [
            'term' => ['nullable', 'numeric'],
        ]);
        if ($validator->fails()) {
            $errorBags = $validator->errors();

            return \redirect(url()->previous())
                ->withInput($request->input())
                ->withErrors($errorBags);
        }
        try {
            $recruitData = $validator->validated();

            $recruit = $this->recruitService->updateRecruit($recruit, $recruitData);
            $recruit->save();

            $recruit->recruitApplications()->delete();
            $recruit->recruitJobs()->delete();
            $recruit->recruitSalaries()->delete();
            $recruit->recruitDays()->delete();
            $recruit->recruitBenefits()->delete();

            $application = $this->recruitService->storeRecruitApplication($recruit, $recruitData);
            $job = $this->recruitService->storeRecruitJob($recruit, $recruitData);
            $salary = $this->recruitService->storeRecruitSalary($recruit, $recruitData);
            $day = $this->recruitService->storeRecruitDay($recruit, $recruitData);
            $benefit = $this->recruitService->storeRecruitBenefit($recruit, $recruitData);

            $this->recruitService->attachThumbnails($recruit, $recruitData);

        } catch (\Exception $exception) {
            report($exception);
            return redirect(url()->previous())->withInput($request->input())->with('alert', '에러가 발생했습니다. 다시 작성해주세요.');
        }

        return redirect()->route('albatalk.recruit.detail', $recruit->id)->with('alert', '수정되었습니다.');
    }

    public function duplicateForm(Recruit $recruit)
    {
        // 회원 상태 확인
        $user = Auth::user();

        // 회원 상태에 따른 결제 금액
        $price = RecruitPrice::getRecruitPrice($user);

        // 게재일 별 금액 처리
        $termPrice = RecruitPrice::getTermPrice($price);

        $recruit = Recruit::query()->with(['file', 'file1', 'file2', 'file3', 'typeWork', 'typeStudy'])
            ->where('id', $recruit->id)->first();

        $recruitApplications = RecruitApplication::query()->where('recruit_id', $recruit->id)->pluck('type_application_id');
        $recruitJobs = RecruitJob::query()->where('recruit_id', $recruit->id)->pluck('type_job_id');
        $recruitSalaries = RecruitSalary::query()->where('recruit_id', $recruit->id)->get(['type_salary_id', 'value']);
        $recruitDays = RecruitDay::query()->where('recruit_id', $recruit->id)->get(['type_day_id', 'value']);
        $recruitBenefits = RecruitBenefit::query()->where('recruit_id', $recruit->id)->pluck('type_benefit_id');

        return view(viewPrefix() . 'pages.albatalk.albatalk_post_duplicate')->with([
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeCareer' => TypeCareer::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'termPrice' => $termPrice,
            'recruit' => $recruit,
            'recruitApplications' => $recruitApplications,
            'recruitJobs' => $recruitJobs,
            'recruitSalaries' => $recruitSalaries,
            'recruitDays' => $recruitDays,
            'recruitBenefits' => $recruitBenefits,
        ]);
    }
}
