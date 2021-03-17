<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Mail\Secession;
use App\Models\Program\Survey\SurveyCategory;
use App\Models\User;
use App\Models\UserSecession;
use App\Services\File\SurveyFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SecessionController extends Controller
{
    public function secessionForm()
    {
        return view(viewPrefix() . 'pages.user.mypage.mypage_secession', ['user' => Auth::user()]);
    }

    public function userSecession(Request $request)
    {

        $validator = Validator::make($request->except('_token'), [
            'password' => 'required | min:6',
            'secession-radio' => 'required'
        ])->sometimes('secession-reason', 'required', function ($input) {
            return $input->get('secession-radio') == '기타';
        });

        if (Auth::user()->is_admin) {
            return redirect()->back()->with('alert', '관리자는 회원 탈퇴가 불가능합니다.');
        }

        $validatedData = $validator->validate();

        if (!$this->checkPasswordOfCurrentUser($validatedData['password'])) {
            throw ValidationException::withMessages([
                'password_wrong' => '※ 비밀번호가 일치하지 않습니다.',
            ]);
        }

        try {
            DB::beginTransaction();

            $userSecession = new UserSecession();
            $userSecession->user_id = Auth::id();
            $userSecession->reason = isset($validatedData['secession-reason']) ? $validatedData['secession-reason'] : $validatedData['secession-radio'];
            $userSecession->save();

            $user = User::find(Auth::id());

            // 추가정보 답변 파일 삭제
            $surveyFiles = $user->surveyAnswers()->whereNotNull('file_id')->get()
                ->mapInto(SurveyFile::class);
            $surveyFiles->each(function ($item, $key) {
                $item->deleteFile();
            });

            // 추가정보 삭제
            $user->surveyAnswers()->delete();

            // 강의 질문 삭제
            $user->lectureQuestions()->delete();

            // 강의 좋아요 삭제
            $user->likes()->delete();

            // 대댓글 삭제.
            if ($user->comments) {
                $user->comments->each(function ($item, $key) {
                    $item->children()->delete();
                });
            }
            // 댓글 삭제
            $user->comments()->delete();

            if ($user->students) {
                $user->students->each(function ($item, $key) {
                    $item->payment()->delete();
                });
                $user->students()->delete();
            }
            DB::commit();

        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('USER SECESSION ERROR', [$exception]);
            return redirect()->back()->with('alert', '에러가 발생했습니다.');
        }

        Mail::to(Auth::user()->email)->send(new Secession(Auth::user(), $userSecession));
        Auth::user()->delete();
        return redirect('/')->with('alert', '회원 탈퇴 되었습니다.');

    }

    public function checkPasswordOfCurrentUser($password)
    {
        return (Hash::check($password, auth()->user()->password)) ? true : false;
    }
}
