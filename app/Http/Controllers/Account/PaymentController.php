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
    private $search;

    public function __construct()
    {
        $this->search = new SearchService(Payment::query());
    }

    public function index(Request $request)
    {
        $payments = Payment::query()
            ->select(
                'payments.id', 'payments.totalAmount', 'payments.receiptUrl', 'payments.method', 'payments.status', 'payments.requestedAt', 'payments.approvedAt', 'payments.status',
                'programs.is_online', 'programs.title',
                'program_students.phone', 'program_students.email', 'program_students.user_id',
                'program_tickets.program_id',
                'users.name'
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
                    ->orWhere('program_students.phone', 'like', '%' . $request->keyword . '%')
                    ->orWhere('program_students.email', 'like', '%' . $request->keyword . '%');
            });
        }

        return response()->json([
            'payments' => $payments->paginate(10)
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
