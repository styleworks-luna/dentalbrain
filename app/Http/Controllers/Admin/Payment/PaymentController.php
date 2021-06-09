<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Services\Program\ProgramTemplate;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->select(
                'payments.id', 'payments.totalAmount', 'payments.receiptUrl', 'payments.method', 'payments.status', 'payments.requestedAt', 'payments.approvedAt',

                'programs.is_online', 'programs.title', 'programs.id as program_id',
                'program_students.id as student_id', 'program_students.user_id', 'program_students.pay_status as program_pay_status',

                'memberships.id as membership_id', 'memberships.pay_status as membership_pay_status',

                'users.name', 'users.email', 'users.phone'
            )
            ->leftJoin('program_students', 'program_students.payment_id', '=', 'payments.id')
            ->leftJoin('memberships', 'memberships.payment_id', '=', 'payments.id')
            ->leftJoin('programs', 'programs.id', '=', 'program_students.program_id')
            ->leftJoin('users', function (JoinClause $join) {
                $join->on('users.id', '=', 'program_students.user_id')
                    ->orOn('users.id', '=', 'memberships.user_id');
            });


        if (isset($request->category)) {
            if ($request->category == '온라인') {
                $payments->where('programs.is_online', '=', 1);
            } elseif ($request->category == '오프라인') {
                $payments->where('programs.is_online', '=', 0);
            } elseif ($request->category == '유료회원') {
                $payments->whereHas('membership');
            }
        }

        if (isset($request->status)) {
            if ($request->status == 'DONE') {
                $payments->where('payments.status', '=', $request->status)
                    ->orWhere('payments.status', '=', Payment::$ANOTHER_DONE);
            } elseif ($request->status == 'CANCELED') {
                $payments->where('payments.status', '=', $request->status)
                    ->orWhere('payments.status', '=', Payment::$ANOTHER_REJECTED);
            }
        }

        if (isset($request->keyword)) {
            $payments->where(function ($query) use ($request) {
                $query->orWhere('programs.title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('payments.totalAmount', '=', $request->keyword);
            });
        }

        if (isset($request->start_date)) {
            $payments->where('payments.requestedAt', '>', $request->start_date);
        }

        if (isset($request->end_date)) {
            $payments->where('payments.requestedAt', '<', $request->end_date);
        }

        return response()->json([
            'payments' => $payments->orderBy('payments.id', 'desc')->paginate(10)
        ]);
    }

    public function paymentExport()
    {
        return Excel::download(new PaymentExport(), '결제 정보 엑셀.xlsx');
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
