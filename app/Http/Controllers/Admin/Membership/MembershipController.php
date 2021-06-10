<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Exports\MembershipExport;
use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $active = User::query()->whereHas('memberships', function (Builder $query) {
            $query->active();
        })->count();

        $inactive = User::query()->whereHas('memberships')->count() - $active;

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

        $search = new SearchService(Membership::withTrashed()->with([
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
}
