<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Program\ProgramTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->search($request);

        // 원본 쿼리에서 필요한 조건만 포함하는 새 쿼리 생성
        $sumQuery = $query->clone()
            ->selectRaw('SUM(payments.totalAmount) as total, COUNT(*) as count')
            ->whereIn('payments.status', [Payment::$DONE, Payment::$ANOTHER_DONE]);

        $sumAndCount = $sumQuery->first();

        $sum = $sumAndCount->total ?? 0;
        $count = $sumAndCount->count ?? 0;

        // 페이지네이션 적용
        $payments = $query->paginate(10);

        return response()->json([
            'payments' => $payments,
            'sum' => number_format($sum),
            'count' => $count,
        ]);
    }

    private function search(Request $request)
    {
        $category = $request->get('category');
        $status = $request->get('status');
        $keyword = $request->get('keyword');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $payments = Payment::query()
            ->select(
                'payments.id', 'payments.totalAmount', 'payments.receiptUrl', 'payments.method', 'payments.status', 'payments.requestedAt', 'payments.approvedAt',

                'programs.is_online', 'programs.title', 'programs.id as program_id',
                'program_students.id as student_id', 'program_students.user_id', 'program_students.pay_status as program_pay_status',

                'memberships.id as membership_id', 'memberships.pay_status as membership_pay_status', 'memberships.applied_days',

                'recruits.id as recruit_id', 'recruits.company_name as recruit_company_name', 'recruits.pay_status as recruit_pay_status',

                'users.name', 'users.email', 'users.phone'
            )
            ->leftJoin('program_students', 'program_students.payment_id', '=', 'payments.id')
            ->leftJoin('memberships', 'memberships.payment_id', '=', 'payments.id')
            ->leftJoin('programs', 'programs.id', '=', 'program_students.program_id')
            ->leftJoin('recruits', 'recruits.payment_id', '=', 'payments.id')
            ->leftJoin('users', function (JoinClause $join) {
                $join->on('users.id', '=', 'program_students.user_id')
                    ->orOn('users.id', '=', 'memberships.user_id')
                    ->orOn('users.id', '=', 'recruits.user_id');
            });


        if ($category == '온라인') {
            $payments->where('programs.is_online', '=', 1);
        } elseif ($category == '오프라인') {
            $payments->where('programs.is_online', '=', 0);
        } elseif ($category == '유료회원') {
            $payments->whereHas('membership');
        } elseif ($category == '알바톡') {
            $payments->whereHas('recruit');
        }

        if ($status == Payment::$DONE) {
            $payments->where(/* @param Builder $query */ function ($query) use ($status) {
                $query->orWhere('payments.status', '=', Payment::$DONE)
                    ->orWhere('payments.status', '=', Payment::$ANOTHER_DONE);
            });

        } elseif ($status == Payment::$CANCELED) {
            $payments->where(/* @param Builder $query */ function ($query) use ($status) {
                $query->orWhere('payments.status', '=', Payment::$CANCELED)
                    ->orWhere('payments.status', '=', Payment::$ANOTHER_REJECTED);
            });
        }

        if ($keyword !== null) {
            $payments->where(function ($query) use ($keyword) {
                $query->orWhere('programs.title', 'like', '%' . $keyword . '%')
                    ->orWhere('users.name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%')
                    ->orWhere('payments.totalAmount', '=', $keyword);
            });
        }

        if ($start_date !== null) {
            $payments->where('payments.requestedAt', '>', $start_date);
        }

        if ($end_date !== null) {
            $payments->where('payments.requestedAt', '<', $end_date);
        }

        return $payments->orderBy('payments.id', 'desc');
    }

    public function paymentExport(Request $request)
    {
        $payments = $this->search($request)->get();

        return Excel::download(new PaymentExport($payments), '결제 정보 엑셀' . now()->toDateString() . '.xlsx');
    }

    /**
     *  계좌입금 확인 시에 호출하는 함수.
     *
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return JsonResponse
     */
    public function confirmAnotherPay(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        $concrete = ProgramTemplate::getProgramConcrete($program);

        try {
            $expired_at = $request['date'];

            if ($concrete->confirmAnotherPay($program, $student, $expired_at) == false) {
                Log::error('CONFIRM ANOTHER PAY ERROR IN CONTROLLER', [$program, $student, $expired_at]);
                return response()->json([
                    'msg' => '오류가 발생하였습니다.'
                ], 500);
            }

        } catch (\Exception $exception) {
            Log::error('CONFIRM ANOTHER PAY ERROR IN CONTROLLER', [$exception]);

            return response()->json([
                'msg' => '오류가 발생하였습니다.'
            ], 500);
        }

        return response()->json([
            'msg' => '확인 처리되었습니다.'
        ]);
    }
}
