<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MembershipExport implements FromView
{
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
