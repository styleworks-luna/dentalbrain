<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class CertificationExport implements FromView
{
    use Exportable;

    private $profiles;

    public function __construct($certifications)
    {
        $this->profiles = $certifications;
    }

    public function view(): View
    {
        return view('excels.certifications', ['profiles' => $this->profiles]);
    }
}
