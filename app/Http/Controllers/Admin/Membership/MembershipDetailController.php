<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;

class MembershipDetailController extends Controller
{
    public function detail(Membership $membership)
    {
        $user = $membership->user;
        $memberships = $user->memberships()->with('payment:id,method,status')->get();
        return response()->json([
            'user' => $user,
            'memberships' => $memberships,
        ]);
    }
}
