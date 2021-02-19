<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-20
 * Time: 오전 11:10
 */

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use App\Models\UserJobName;
use App\Models\UserJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Services\Search\SearchService;

class UserController
{
    private $search;

    public function __construct()
    {
        $this->search = new SearchService(User::query());
    }

    public function index(Request $request)
    {
        return response()->json([
            'user' => $this->search($request)
        ]);
    }

    public function edit(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'job_name_id' => ['required', 'min:1', 'max:6'],
            'allow_email' => ['nullable', 'boolean']
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            // 직업군에 따라 면허번호 필요 여부 다르므로.
            return UserJobName::find($input->job_name_id)->need_license == true;
        });
        $data = $v->validate();
        $license_num = $data['license_num'] ?? null;

        if ($user->job->license_num != $license_num || $user->job->job_name_id != $data['job_name_id']) {
            $userJob = UserJob::find($user->job_id);
            $userJob->license_num = $license_num;
            $userJob->job_name_id = $data['job_name_id'];
            $userJob->save();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->allow_email = $data['allow_email'];
        $user->save();

        return response()->json([
            'success' => true,
            'msg' => '성공하였습니다.'
        ]);
    }

    public function getUserJobNameCategory(){
        return response()->json(['userJob' => UserJobName::all()]);
    }

    private function search(Request $request){
        $this->setJoin($request->input('job_name_id'));

        $this->search
            ->addKeyword('login_id',$request->keyword)
            ->addKeyword('name',$request->keyword)
            ->addKeyword('phone',$request->keyword)
            ->addKeyword('email',$request->keyword);

        $result = $this->search->search()->orderBy('id','desc')->paginate('20');
        return $result;
    }

    private function setJoin($jobNameId){
        if(isset($jobNameId) && is_numeric($jobNameId)){
            $this->search->setJoinModel('job')->addJoinOption('job_name_id','=',$jobNameId)->join();
        }
    }
}
