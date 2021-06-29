<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function showMembershipDescForm(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $hasMembership = $user ? $user->hasMembership : false;
        $membershipLeftDays = $hasMembership ? $user->getMembershipLeftDays() : 0;

        return view(viewPrefix() . "pages.membership.membership", [
            'hasMembership' => $hasMembership,
            'membershipLeftDays' => $membershipLeftDays,
        ]);
    }

    public function apply(Request $request)
    {
        $v = Validator::make($request->all(), [
            'days' => ['nullable', Rule::in(array_keys(Membership::$PriceMap))]
        ]);

        /** @var User $user */
        $user = Auth::user();
        $hasMembership = $user ? $user->hasMembership : false;
        $membershipLeftDays = $hasMembership ? $user->getMembershipLeftDays() : 0;

        if ($v->fails()) {
            return redirect('/')->with('alert', '잘못된 접근입니다.');
        }

        $days = $request->get('days', 30);

        return view(viewPrefix() . "pages.membership.membership_payment", [
            'days' => $days,
            'hasMembership' => $hasMembership,
            'membershipLeftDays' => $membershipLeftDays,
        ]);
    }


    public function result()
    {
        return view(viewPrefix() . "pages.membership.membership_result");
    }
}
