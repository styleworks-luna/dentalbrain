<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {
        $able = User::query()->whereHas('memberships', function (Builder $query) {
            $query->where('expired_at', '>', now());
        })->count();

        $disable = User::query()->whereHas('memberships')->count() - $able;


        return response()->json([
            $this->search($request),
            'able' => $able,
            'disable' => $disable,
        ]);
    }

    private function search(Request $request)
    {
        $search = new SearchService(Membership::withTrashed()->with([
            'user' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'login_id', 'name', 'email', 'phone', 'job_id']);
            },
            'payment' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'method']);
            }
        ]));

        $result = $search->setJoinModel('user')->join()->search();

        return $result->orderByDesc('id')->paginate(10);
    }
}
