<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Exports\MembershipExport;
use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Search\SearchService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $active = User::query()->useMembership()->count();

        $inactive = User::query()->doesntUseMembership()->count();

        return response()->json([
            $this->search($request)->paginate(10),
            'active' => $active,
            'inactive' => $inactive,
        ]);
    }

    private function search(Request $request)
    {
        $job_name_id = $request->get('job_name_id');
        $keyword = $request->get('keyword');

        $search = new SearchService(User::query()
            ->with(['memberships' => function ($query) {
                $query->inUse()->limit(1)->with('payment:id,method');
            }])
            ->whereHas('memberships', function ($query) {
                $query->with('payment:id,method');
            })->select(['id', 'login_id', 'name', 'email', 'phone', 'job_id']));


        if ($keyword !== null) {
            $search
                ->addKeyword('login_id', $keyword)
                ->addKeyword('name', $keyword)
                ->addKeyword('phone', $keyword)
                ->addKeyword('email', $keyword);
        }

        if ($job_name_id !== null) {
            $search
                ->setJoinModel('job')
                ->addJoinOption('job_name_id', '=', $job_name_id)
                ->join();
        }

        $result = $search->search();
        return $result->orderByDesc('id');
    }

    public function membershipExport(Request $request)
    {
        $memberships = $this->search($request)->get();
        return Excel::download(new MembershipExport($memberships), '유료 회원 정보 엑셀.xlsx');
    }

    public function confirmAnotherPay(Request $request, Membership $membership)
    {
        try {

            $membership->updateWhenConfirmAnotherPay($membership->user);
            $membership->payment->updateWhenConfirmAnotherPay();

        } catch (\Exception $exception) {
            Log::error('CONFIRM ANOTHER PAY ERROR IN CONTROLLER', [$exception]);

            return response()->json([
                'msg' => '오류가 발생하였습니다.'
            ], 500);
        }

        return response()->json([
            'msg' => '확인 처리되었습니다.'
        ]);
    }
}
