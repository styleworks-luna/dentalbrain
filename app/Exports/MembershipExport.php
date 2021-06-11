<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class MembershipExport implements FromView
{
    use Exportable;

    private $memberships;

    public function __construct($memberships)
    {
        $this->memberships = $memberships;
    }

    public function view(): View
    {
        return view('excels.memberships', ['memberships' => $this->memberships]);
    }
}
