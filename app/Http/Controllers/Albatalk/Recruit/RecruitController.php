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
use App\Services\Recruit\RecruitTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecruitController extends Controller
{
    protected $recruitTemplate;
    protected $price;

    public function __construct()
    {
        $this->recruitTemplate = new RecruitTemplate();
    }

    public function createForm()
    {
        // 회원 상태 확인
        $user = Auth::user();
        $hasMembership = $user ? $user->hasMembership : false;

        // 회원 상태에 따른 결제 금액
        if ($hasMembership) {
            $recruitPrice = RecruitPrice::find(RecruitPrice::$HAS_MEMBERSHIP);
            $this->price = $recruitPrice->price;
        } else {
            $recruitPrice = RecruitPrice::find(RecruitPrice::$HAS_NOT_MEMBERSHIP);
            $this->price = $recruitPrice->price;
        }

        return view(viewPrefix() . 'pages.albatalk.albatalk_post')->with([
            'typeApplication' => TypeApplication::all(),
            'typeWork' => TypeWork::all(),
            'typeJob' => TypeJob::all(),
            'typeSalary' => TypeSalary::all(),
            'typeStudy' => TypeStudy::all(),
            'typeDay' => TypeDay::all(),
            'typeBenefit' => TypeBenefit::all(),
            'price' => $this->price,
        ]);
    }

    public function detail(Recruit $recruit)
    {
        $applications = RecruitApplication::query()->where('recruit_id', '=', $recruit->id)->get();
        $salaries = RecruitSalary::query()->where('recruit_id', '=', $recruit->id)->get();
        $days = RecruitDay::query()->where('recruit_id', '=', $recruit->id)->get();
        $benefits = RecruitBenefit::query()->where('recruit_id', '=', $recruit->id)->get();

        $recruit->with('typeWork', 'typeJob', 'typeStudy');

        return view(viewPrefix() . 'pages.albatalk.albatalk_detail', [
            'recruit' => $recruit,
            'applications' => $applications,
            'salaries' => $salaries,
            'days' => $days,
            'benefits' => $benefits,
        ]);
    }

    public function create(Request $request)
    {
        // 구인 등록 유효성 검사
        $validator = $this->recruitTemplate->getValidatorRecruit($request->all());
        if ($validator->fails()) {
            $messageBag = $validator->errors();

            $collection = collect($messageBag)->map(function ($item, $key) {
                return ['name' => $key, 'message' => $item[0]];
            });

            return response()->json($collection->toArray());
        }

        // 검사한 데이터 세션에 저장
        session(['recruit_create_data' => $validator->validated()]);

        // 결제 폼으로 이동
        return response()->json(['massage' => 'ok']);
    }

    public function success(SuccessPayments $request)
    {
        // validation : amount (금액) 확인
//        $validator = Validator::make($request->all(), [
//            'amount', ['required', 'numeric', 'min:100'],
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
//        }

        $realPrice = $program->getUserSpecificPrice();

        if ($realPrice != $request->get('amount')) {
            return redirect()->back()->with(['alert' => '결제 금액이 맞지 않습니다.', 'fromApply' => true]);
        }

        // 결제 승인 API
        try {

            // TossPayment 객체생성
            $tossPayments = new TossPayments($request['paymentKey']);
            $tossResponse = $tossPayments->success($request['orderId'], $request['amount']);

            // response 오류
            if (!$tossResponse) {
                return redirect()->back()->with(['alert' => '오류가 발생했습니다.', 'fromApply' => true]);
            }

            DB::beginTransaction();

            // 구인등록 인스턴스 생성
            $recruitData = $request->session()->get('data');
            $recruit = $this->recruitTemplate->storeRecruit($recruitData);
            $application = $this->recruitTemplate->storeRecruitApplication($recruit, $recruitData);
            $salary = $this->recruitTemplate->storeRecruitSalary($recruit, $recruitData);
            $day = $this->recruitTemplate->storeRecruitDay($recruit, $recruitData);
            $benefit = $this->recruitTemplate->storeRecruitBenefit($recruit, $recruitData);

            // session 지우기
            session()->forget('data');

            // 페이먼츠 인스턴스 생성
            $payment = Payment::createByTossSuccess($tossResponse);

            // 구인등록 페이먼츠 생성
            // 방금 만들어진 구인등록에 대한 처리가 필요!
            $recruitUpdate = Recruit::where("id", "=", $recruit->id)->where('user_id', "=", Auth::id())->update(['payment_id' => $payment->id]);

            // 결제 취소 됐을 때 처리도 필요함

            DB::commit();
        } catch (TossPaymentsException $exception) {
            DB::rollBack();

        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('PROGRAM TOSS SUCCESS ERROR', [$exception]);
            return redirect()->back()->with(['alert' => '오류가 발생했습니다.']);
        }

        return view('emails.content')->with(
            [
                "title" => "payments",
                "content" => "success",
            ]
        );
    }
}
