<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PaymentExport implements FromView
{
    use Exportable;

    private $payments;

    public function __construct($payments)
    {
        $this->payments = $payments;
    }

    /**
     * StudentExport constructor.
     * @return View
     */

    public function view(): View
    {
        return view('excels.payments', [
            'payments' => $this->payments,
        ]);
    }
}
