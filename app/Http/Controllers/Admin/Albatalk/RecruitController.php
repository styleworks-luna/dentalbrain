<?php

namespace App\Http\Controllers\Admin\Albatalk;

use App\Http\Controllers\Controller;
use App\Models\Recruit\Recruit;
use App\Models\Resume\AppliedResume;
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

    public function stats()
    {
        $recruitTotal = Recruit::all()->count();
        $recruitIsOpen = Recruit::where('expired_at', '>=', now())->count();
        $recruitIsNotOpen = Recruit::where('expired_at', '<', now())->count();

        return response()->json([
            'recruitTotal' => $recruitTotal,
            'recruitIsOpen' => $recruitIsOpen,
            'recruitIsNotOpen' => $recruitIsNotOpen,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['nullable', 'string'],
            'ongoing' => ['nullable', 'boolean'],
        ]);

        $listForAdmin = $this->recruitService->searchForAdmin($request->get('keyword', null),$request->get('ongoing', null));
        return response()->json($listForAdmin);
    }

    public function statusChange(Recruit $recruit)
    {
        $statusChange = new StatusChangeImpl();
        return $statusChange->statusChange($recruit, 'is_open');
    }
}
