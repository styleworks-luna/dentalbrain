<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-20
 * Time: 오전 11:10
 */

namespace App\Http\Controllers\Admin\User;

use App\Exports\UserExport;
use App\Models\User;
use App\Models\UserJob;
use App\Models\UserJobName;
use App\Services\Search\SearchService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UserController
{
    private $searchService;

    public function __construct()
    {
        $this->searchService = new SearchService(User::query());
    }

    public function index(Request $request)
    {
        $queryBase = User::query();

        $paid = (clone $queryBase)->paid()->count();

        $normal = (clone $queryBase)->doesntPaid()->count();

        return response()->json([
            'user' => $this->search($request)->paginate(20),
            'paid' => $paid,
            'normal' => $normal,
            'total' => $queryBase->count(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function search(Request $request)
    {
        $keyword = $request->input('keyword', null);
        $hasMembership = $request->input('is_paid', null);
        $job = $request->input('job_name_id', null);

        $this->setJoin($job);

        $this->searchService
            ->addKeyword('login_id', $keyword)
            ->addKeyword('name', $keyword)
            ->addKeyword('phone', $keyword)
            ->addKeyword('email', $keyword);

        $result = $this->searchService->search();

        if ($hasMembership !== null) {
            // (null == 0) 이 true이므로 한번 걸러냄.
            if ($hasMembership == 1) {
                //유료 회원
                $result = $result->Paid();
            } elseif ($hasMembership == 0) {
                //일반 회원
                $result = $result->doesntPaid();
            }
        }

        return $result->orderBy('id', 'desc');
    }

    private function setJoin($jobNameId)
    {
        if (isset($jobNameId) && is_numeric($jobNameId)) {
            $this->searchService->setJoinModel('job')->addJoinOption('job_name_id', '=', $jobNameId)->join();
        }
    }

    public function emailList(Request $request)
    {
        $result = $this->search($request)->where('allow_email', true)->get();
        return response()->json($result);
    }

    public function smsList(Request $request)
    {
        $result = $this->search($request)->where('allow_sms', true)->get();
        return response()->json($result);
    }

    public function edit(User $user)
    {
        $user->addHidden(['memberships']);

        $data = collect([
            'user' => $user,
            'membership_started_at' => $user->membership_started_at,
            'membership_expired_at' => $user->membership_expired_at,
        ]);
        return response()->json([$data]);
    }

    public function update(Request $request, User $user)
    {
        $v = $this->getUpdateValidator($request, $user);

        $data = $v->validate();
        $license_num = $data['license_num'] ?? null;

        try {
            DB::beginTransaction();
            if ($user->job->license_num != $license_num || $user->job->job_name_id != $data['job_name_id']) {
                $userJob = UserJob::find($user->job_id);
                $userJob->license_num = $license_num;
                $userJob->job_name_id = $data['job_name_id'];
                $userJob->save();
            }

            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'allow_email' => $data['allow_email'],
                'allow_sms' => $data['allow_sms'],
                'membership_started_at' => $data['membership_started_at'],
                'membership_expired_at' => $data['membership_expired_at'],
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            Log::error('ACCOUNT UPDATE ERROR', [$exception]);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'msg' => '오류가 발생하였습니다.'
            ]);
        }


        return response()->json([
            'success' => true,
            'msg' => '성공하였습니다.'
        ]);
    }

    /**
     * @param Request $request
     * @param User|Authenticatable $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function getUpdateValidator(Request $request, $user): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at')->ignore($user->id)],
            'phone' => ['required',
                Rule::unique('users', 'phone')->whereNull('deleted_at')->ignore($user->id)],
            'job_name_id' => ['required', 'min:1', 'max:6'],
            'allow_email' => ['nullable', 'boolean'],
            'allow_sms' => ['nullable', 'boolean'],
            'membership_started_at' => ['required_with:membership_expired_at', 'nullable', 'date_format:Y-m-d H:i', 'before_or_equal:membership_expired_at'],
            'membership_expired_at' => ['required_with:membership_started_at', 'nullable', 'date_format:Y-m-d H:i', 'after_or_equal:membership_started_at'],
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            // 직업군에 따라 면허번호 필요 여부 다르므로.
            return UserJobName::find($input->job_name_id)->need_license == true;
        });
    }

    public function getUserJobNameCategory()
    {
        return response()->json(['userJob' => UserJobName::all()]);
    }

    public function userExport(Request $request)
    {
        $users = $this->search($request)->get();
        return Excel::download(new UserExport($users), '회원 정보 ' . now()->toDateString() . '.xlsx');
    }
}
