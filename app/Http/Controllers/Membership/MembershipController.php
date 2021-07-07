<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class MembershipController extends Controller
{

    public function apply(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $hasMembership = $user ? $user->hasMembership : false;
        $membershipLeftDays = $hasMembership ? $user->getMembershipLeftDays() : 0;

        redirect()->setIntendedUrl(Route::current()->uri);

        return view(viewPrefix() . "pages.membership.membership", [
            'hasMembership' => $hasMembership,
            'membershipLeftDays' => $membershipLeftDays,
        ]);
    }


    public function result()
    {
        return view(viewPrefix() . "pages.membership.membership_result");
    }
}
