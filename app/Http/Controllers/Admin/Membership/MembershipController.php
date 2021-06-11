<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Exports\MembershipExport;
use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $active = User::query()->paid()->count();

        $inactive = User::query()->doesntPaid()->count();

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

        $search = new SearchService(Membership::query()->with([
            'user' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'login_id', 'name', 'email', 'phone', 'job_id']);
            },
            'payment' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'method']);
            }
        ]));

        if ($keyword !== null) {
            $search->setJoinModel('user')
                ->addJoinOption('login_id', 'like', '%' . $keyword . '%', 'or')
                ->addJoinOption('name', 'like', '%' . $keyword . '%', 'or')
                ->addJoinOption('phone', 'like', '%' . $keyword . '%', 'or')
                ->addJoinOption('email', 'like', '%' . $keyword . '%', 'or')
                ->join();
        }

        if ($job_name_id !== null) {
            $result = $search->setJoinModel('user.job')
                ->addJoinOption('job_name_id', '=', $job_name_id)
                ->join()->search();
        } else {
            $result = $search->search();
        }

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
            /** @var User $user */
            $user = $membership->user;
            $user->updateWhenMembershipPaid($membership->applied_days);

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
