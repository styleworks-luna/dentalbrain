<?php

namespace App\Exports;

use App\Models\Payments\Payment;
use App\Models\Program\Program;
use App\Models\Program\ProgramStudent;
use App\Models\Program\Survey\SurveyAnswer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PaymentExport implements FromView
{
    use Exportable;

    private $payment;

    /**
     * StudentExport constructor.
     * @param Program $program
     */
    public function __construct()
    {
        $this->payment = Payment::query()->orderBy('id','desc');
    }

    public function view(): View
    {
        $payments = Payment::query()
            ->orderByDesc('id')
            ->with(['student.ticket.program' => function ($query) {
                $query->select('id', 'is_online', 'title');
            },'student.user'])
            ->has('student.ticket.program')
            ->select('id', 'totalAmount', 'receiptUrl', 'method', 'status', 'requestedAt', 'approvedAt')
            ->get();

        return view('excels.payments', [
            'payments' => $payments
        ]);
    }
}
