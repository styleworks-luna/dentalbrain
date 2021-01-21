<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-20
 * Time: 오전 11:10
 */

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\UserJob;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController {
    public function index(){
        return response()->json(
            ['user' =>  User::whereNotNull('id')
                ->orderByDesc('id')
                ->paginate(10)
            ]
        );
    }

    public function edit(User $user){
        return response()->json(['user' => $user]);
    }

    public function update(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required'],
            'job_id' => ['required', 'min:0', 'max:5'],
            'allow_email' => ['nullable','boolean']
        ])->sometimes('license_num', 'required|min:0|max:40', function ($input) {
            // 직업군에 따라 면허번호 필요 여부 다르므로.
            return $input->job <= 2;
        });
        $data = $v->validate();
        $user = User::find($request->id);

        if ($user->job->license_num != $data['license_num'] || $user->job->job_name_id != $data['job_id']) {
            $license_num = $data['license_num'] ?? null;
            $userJob = UserJob::find($user->job_id);
            $userJob->license_num = $license_num;
            $userJob->job_name_id = $data['job_id'];
            $userJob->save();
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];
        $user->allow_email = $data['allow_email'];
        $user->save();

        return response()->json([
            'success'=> true,
            'msg' => '성공하였습니다.'
        ]);
    }
}