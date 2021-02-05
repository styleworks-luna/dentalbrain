<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-02-05
 * Time: 오전 9:59
 */

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FindIdController extends Controller
{
    /**
     * 아이디 찾기 결과
     *
     * @return View
     */
    public function findIdWithNameAndPhone(Request $request)
    {
        /* TODO : scope 분리 */
        $user = User::where([
            'name' => $request->name,
            'phone' => $request->phone
        ])->first();

        return $this->getResultByUserExist($user);
    }

    private function getResultByUserExist($user){
        if(isset($user) && !empty($user)){
            return response()->json([
                'message' => '가입 된 아이디는 "'.$user->login_id.'" 입니다.',
                'success' => true
            ]);
        }else {
            return response()->json([
                'message' => '해당 정보와 일치하는 아이디가 없습니다.',
                'success' => false
            ]);
        }
    }

    public function findId(Request $request){
        $validatedData = $request->validate([
            'login_id' => 'required'
        ]);

        $user = User::where('login_id',$validatedData['login_id'])->first();
        return isset($user) && !empty($user);
    }
}