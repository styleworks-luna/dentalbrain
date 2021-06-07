<?php


namespace App\Services\Membership;


use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MembershipService
{
    /**
     * @param string|Carbon $startedAt
     * @param string|Carbon $expiredAt
     * @param User|null|Authenticatable $user
     */
    public static function EditUsersMembership($startedAt, $expiredAt, $user = null): bool
    {
        if ($user == null) {
            $user = Auth::user();
        }

        if ($user->availableMembershipsBuilder()->doesntExist()) {
            return false;
        }

        try {
            DB::beginTransaction();
            self::editUserMembershipStartedAt($startedAt, $user);
            self::editUserMembershipExpiredAt($expiredAt, $user);
            DB::commit();
        } catch (\Exception $exception) {
            Log::error('User Membership Edit Error In Service', [$exception]);

            return false;
        }

        return true;
    }

    /**
     * @param $startedAt
     * @param User|Authenticatable $user
     */
    protected static function editUserMembershipStartedAt($startedAt, $user): void
    {
        $earliest = $user->availableEarliestMembership();

        if ($earliest->started_at != $startedAt) {
            return;
        }

        if ($earliest->started_at > $startedAt) {
            $earliest->started_at = $startedAt;
            $earliest->save();
        } else {
            $user->memberships()->where('expired_at', '<', $startedAt)->delete();
            $user->memberships()->where('started_at', '<', $startedAt)->update([
                'started_at' => $startedAt
            ]);
        }
    }

    protected static function editUserMembershipExpiredAt($expiredAt, $user): void
    {
        $latest = $user->availableLatestMembership();

        if ($latest->expired_at == $expiredAt) {
            return;
        }

        if ($latest->expired_at < $expiredAt) {
            $latest->expired_at = $expiredAt;
            $latest->save();
        } else {
            $user->memberships()->where('stated_at', '>', $expiredAt)->delete();
            $user->memberships()->where('expired_at', '>', $expiredAt)->update([
                'expired_at' => $expiredAt
            ]);
        }
    }

}
