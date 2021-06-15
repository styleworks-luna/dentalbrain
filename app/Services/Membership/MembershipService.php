<?php


namespace App\Services\Membership;


use App\DTO\Payment\CancelPaymentDto;
use App\Models\Membership\Membership;
use App\Models\User;
use App\Services\Payment\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MembershipService
{
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

            /** @var User $user */
            $user = $membership->user;
            $user->updateWhenMembershipCancel($membership);

            $membership->delete();

            PaymentService::cancelPaid($membership->payment, $membership->pay_status, $dto);

            DB::commit();
        } catch (Exception $exception) {
            Log::error('CANCEL ERROR', [$exception]);
            DB::rollBack();
            return false;
        }
    }
}
