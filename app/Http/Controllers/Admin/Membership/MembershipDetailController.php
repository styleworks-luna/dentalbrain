<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Payments\TossPayment;
use App\Models\Program\ProgramStudent;
use App\Models\User;
use App\Services\Membership\MembershipService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MembershipDetailController extends Controller
{
    public function edit(User $user): JsonResponse
    {
        $memberships = $user->memberships()->with('payment:id,method,status')->orderByDesc('last_applied_at')->get();
        $payment = TossPayment::query()->whereHas('membership', function ($query) use ($memberships) {
            $query->whereIn("id", $memberships->pluck('id'));
        })->sum('totalAmount');

        return response()->json([
            'user' => $user,
            'memberships' => $memberships,
            'membership_paid' => $payment
        ]);
    }

    public function studentsHistories(User $user)
    {
        $students = $user->students()->with(['payment' => function (BelongsTo $query) {
            $query->select('id', 'totalAmount', 'status');
        }, 'program:id,title,minor_category_id'])
            ->orderByDesc('applied_at')
            ->paginate(5);

        return response()->json([
            'students' => $students,
        ]);
    }

    public function studentStat(User $user)
    {

        $available = $user->students()
            ->whereIn('pay_status', ProgramStudent::$USER_PAID_STATUS)
            ->where('expired_at', '>=', Carbon::now())->count();

        $expired = $user->students()
            ->whereIn('pay_status', ProgramStudent::$USER_PAID_STATUS)
            ->where('expired_at', '<', Carbon::now())->count();

        $paid = TossPayment::query()->whereHas('student', function ($query) use ($user) {
            $query->where('pay_status', ProgramStudent::$PAY_PAID)->whereIn('id', $user->students()->pluck('id'));
        })->sum('totalAmount');


        return response()->json([
            'available' => $available,
            'expired' => $expired,
            'paid' => $paid,
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $data = Validator::make($request->all(), [
            'memberships' => ['present', 'array']
        ])->validate();

        try {
            DB::beginTransaction();
            MembershipService::validateAndUpdateAtAdmin($request, $user);
            DB::commit();
        } catch (ValidationException $exception) {
            DB::rollBack();
            Log::error('UPDATE Failed at membership update', [$exception]);
            return response()->json(['errors' => $exception->errors(),], 422);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('UPDATE Failed at membership update', [$exception]);
            return response()->json(['msg' => '오류가 발생하였습니다.', 'exception' => $exception->getMessage()], 500);
        }
        return response()->json(['msg' => '수정되었습니다.']);
    }
}
