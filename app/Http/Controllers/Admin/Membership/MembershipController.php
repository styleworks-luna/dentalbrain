<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Services\Search\SearchService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(Request $request)
    {

        return response()->json([
            $this->search($request)
        ]);
    }

    private function search(Request $request)
    {
        $search = new SearchService(Membership::query()->with([
            'user' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'login_id', 'name', 'email', 'phone', 'job_id']);
            },
            'payment' => /* @param BelongsTo $query */ function ($query) {
                $query->select(['id', 'method']);
            }
        ]));

        return $search->setJoinModel('user')->join()->search()->paginate(10);
    }
}
