<?php

namespace App\Http\Controllers\Admin\Membership;

use App\Http\Controllers\Controller;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Membership\MembershipService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MembershipDetailController extends Controller
{
    public function edit(User $user): JsonResponse
    {
        $memberships = $user->memberships()->with('payment:id,method,status')->orderByDesc('last_applied_at')->get();
        return response()->json([
            'user' => $user,
            'memberships' => $memberships,
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
