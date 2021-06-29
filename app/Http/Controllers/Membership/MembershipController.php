<?php

namespace App\Http\Controllers\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\Payments\Payment;
use App\Payments\TossPayments\TossPayments;
use App\Payments\TossPayments\TossPaymentsException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipController extends Controller
{
    public function showMembershipDescForm(Request $request)
    {
        return view(viewPrefix() . "pages.membership.membership");
    }

    public function apply(Request $request)
    {
        $v = Validator::make($request->all(), [
            'days' => ['nullable', Rule::in(array_keys(Membership::$PriceMap))]
        ]);

        if ($v->fails()) {
            return redirect('/')->with('alert', '잘못된 접근입니다.');
        }

        $days = $request->get('days', 30);

        return view(viewPrefix() . "pages.membership.membership_payment", ['days' => $days]);
    }


    public function result()
    {
        return view(viewPrefix() . "pages.membership.membership_result");
    }
}
