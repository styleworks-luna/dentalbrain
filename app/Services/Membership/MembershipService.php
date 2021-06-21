<?php


namespace App\Services\Membership;


use App\DTO\Payment\CancelPaymentDto;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Payment\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MembershipService
{
    public static function validateAndUpdateAtAdmin(Request $request, User $user, array $additionalRules = []): Collection
    {
        $membershipData = self::validateAtAdmin($request, $additionalRules);
        return self::updateOrCreateAtAdmin($user, $membershipData);
    }

    /**
     * @param Request $request
     * @param array $additionalRules
     * @return Collection
     */
    private static function validateAtAdmin(Request $request, array $additionalRules = []): Collection
    {
        $v = Validator::make($request->all(), array_merge([
                'memberships.*.started_at' => ['required_with:memberships.*.expired_at', 'nullable', 'before_or_equal:memberships.*.expired_at',],
                'memberships.*.expired_at' => ['required_with:memberships.*.started_at', 'nullable', 'after_or_equal:memberships.*.started_at',],
                'memberships.*.id' => ['nullable', Rule::exists('memberships', 'id')],
            ], $additionalRules)
        );

        $validatedData = $v->validate();


        return collect($validatedData['memberships']);
    }

    private static function updateOrCreateAtAdmin(User $user, Collection $membershipsData): Collection
    {
        $returnable = collect();
        $originalMemberships = $user->memberships()->get();

        foreach ($membershipsData as $datum) {
            if (!isset($datum['started_at']) && !isset($datum['expired_at'])) {
                continue;
            }

            //'Y-m-d H:i:00'
            $started_at = Carbon::parse($datum['started_at'] . ':00');
            $expired_at = Carbon::parse($datum['expired_at'] . ':00');

            if (isset($datum['id'])) {
                // 기존 항목
                /** @var Membership $membership */
                $membership = $originalMemberships->find($datum['id']);
                if ($started_at != $membership->started_at || $expired_at != $membership->expired_at) {
                    // 업데이트
                    $membership->update([
                        'started_at' => $started_at,
                        'expired_at' => $expired_at,
                    ]);
                    $returnable->push($membership);
                }
            } else {
                // 새 항목
                $returnable->push(Membership::createByAdmin($user, $started_at, $expired_at));
            }
        }

        return $returnable;
    }

    /**
     * @param Request $request
     * @param Membership $membership
     * @return CancelPaymentDto|null
     */
    public function validateAdminCancel(Request $request, Membership $membership): ?CancelPaymentDto
    {
        return CancelPaymentDto::createWhenMembershipCancelAdmin($request, $membership);
    }

    public function cancel(Membership $membership, CancelPaymentDto $dto): bool
    {
        try {
            DB::beginTransaction();

            PaymentService::cancelPaid($membership->payment, $membership->pay_status, $dto);
            $membership->updateWhenMembershipCancel();

            DB::commit();
            return true;

        } catch (Exception $exception) {
            Log::error('CANCEL ERROR', [$exception]);
            DB::rollBack();
            return false;
        }
    }
}
