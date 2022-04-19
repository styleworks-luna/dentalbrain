<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use App\Services\Recruit\RecruitService;
use App\Services\StatusChange\StatusChangeImpl;
use Illuminate\Http\Request;

class RecruitController extends Controller
{
    private $recruitService;

    public function __construct(RecruitService $recruitService)
    {
        $this->recruitService = $recruitService;
    }

    public function statusChange(Recruit $recruit)
    {
        $statusChange = new StatusChangeImpl();
        return $statusChange->statusChange($recruit, 'is_open');
    }
}
