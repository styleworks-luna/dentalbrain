<?php

namespace App\Http\Controllers\Admin\Payment;

use App\Exports\PaymentExport;
use App\Http\Controllers\Controller;
use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Program\OfflineProgramConcrete;
use App\Services\Program\OnlineProgramConcrete;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::query()
            ->orderByDesc('id')
            ->with(['student.ticket.program' => function ($query) {
                $query->select('id', 'is_online', 'title');
            }])
            ->select('id', 'totalAmount', 'receiptUrl', 'method', 'status', 'requestedAt', 'approvedAt')
            ->paginate(10);

        return response()->json([
            'payments' => $payments,
        ]);
    }

    public function paymentExport()
    {
        return Excel::download(new PaymentExport(),'결제 정보 엑셀.xlsx');
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
    public function cancel(Request $request, Program $program, ProgramStudent $student)
    {
        if ($program->is_online) {
            $concrete = new OnlineProgramConcrete();
        } else {
            $concrete = new OfflineProgramConcrete();
        }

        $validatedData = $concrete->validateAdminCancel($request, $program, User::find($student->user_id));
        if ($validatedData) {
            $response = $concrete->cancel($program, $student, $validatedData);
        } else {
            return response()->json(['message' => '유효하지 않은 요청입니다.'], 422);
        }

        if ($response === false) {
            return response()->json(['message' => '취소 오류 발생 하였습니다.'], 500);
        }
        return response()->json(['message' => '취소되었습니다.']);
    }
}
