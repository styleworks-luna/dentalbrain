<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Program\ProgramCancelTemplate;
use App\Services\Program\ProgramTemplate;
use Carbon\Carbon;
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
                'programs.is_online', 'programs.title',
                'program_students.id as student_id', 'program_students.user_id', 'program_students.pay_status',
                'program_tickets.program_id',
                'users.name', 'users.email', 'users.phone'
            )
            ->join('program_students', 'program_students.payment_id', '=', 'payments.id')
            ->join('program_tickets', 'program_students.ticket_id', '=', 'program_tickets.id')
            ->join('programs', 'programs.id', '=', 'program_tickets.program_id')
            ->join('users', 'users.id', '=', 'program_students.user_id');

        if (isset($request->is_online)) {
            $payments->where('programs.is_online', '=', $request->is_online);
        }

        if (isset($request->status)) {
            $payments->where('payments.status', '=', $request->status);
        }

        if (isset($request->keyword)) {
            $payments->where(function ($query) use ($request) {
                $query->orWhere('programs.title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $request->keyword . '%')
                    ->orWhere('payments.totalAmount', '=', $request->keyword);
            });
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
     * 어드민 환불 처리
     *
     * @param Request $request
     * @param Program $program
     * @param ProgramStudent $student
     * @return JsonResponse
     * @see OfflineStudentController @cancel
     */
    public function cancel(Request $request, Program $program, ProgramStudent $student): JsonResponse
    {
        $concrete = ProgramCancelTemplate::getProgramCancelConcrete($program);

        $validatedData = $concrete->validateAdminCancel($request, $program, User::find($student->user_id));
        if ($validatedData === false) {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        $response = $concrete->cancel($program, $student, $validatedData);

        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }
        return response()->json(['message' => '취소되었습니다.']);
    }

    /**
     *  별도결제 확인 시에 호출하는 함수.
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
            $concrete->confirmAnotherPay($program, $student, $expired_at);
        } catch (\Exception $exception) {
            Log::error('CONFIRM ANOTHER PAY ERROR IN CONTROLLER',[$exception]);
            return response()->json([
                'msg' => '오류가 발생하였습니다.'
            ], 500);
        }

        return response()->json([
            'msg' => '확인 처리되었습니다.'
        ]);
    }
}
