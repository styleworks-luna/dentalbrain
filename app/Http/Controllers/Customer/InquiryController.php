<?php
/**
 * Created by PhpStorm.
 * User: onoffmix
 * Date: 2021-01-13
 * Time: 오전 10:28
 */

namespace App\Http\Controllers\Customer;

use App\Models\Manage\Inquiry;
use App\Models\Manage\InquiryCategory;
use App\Rules\Captcha as CaptchaRule;
use App\Services\Captcha\ImageCaptcha;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class InquiryController
{
    /** 문의하기 폼에서 사용하는 캡챠 세션 키 */
    const CAPTCHA_KEY = 'inquiry';

    public function index()
    {
        $categories = InquiryCategory::all();
        return view(viewPrefix() . 'pages.service.inquire', ['categories' => $categories]);
    }

    /**
     * 문의하기 보안문자 이미지
     */
    public function captcha(ImageCaptcha $captcha)
    {
        $code = $captcha->make(self::CAPTCHA_KEY);

        return response($captcha->render($code), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
        ]);
    }

    public function store()
    {
        //'phone' => 'required|regex:/^\d{2,3}[-]?\d{3,4}[-]?\d{4}$/',
        $validateData = request()->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:255',
            'title' => ['required','string','max:255'],
            'content' => ['required','string', 'max:2000'],
            'category_id' => ['required', Rule::exists('inquiry_categories', 'id')],
            'captcha' => ['required', 'string', new CaptchaRule(self::CAPTCHA_KEY)],
        ], [
            'captcha.required' => '※ 보안문자를 입력해주세요.',
        ]);

        // captcha 는 검증 전용 입력값이므로 저장 대상에서 제외한다
        Inquiry::create(Arr::except($validateData, 'captcha'));

        return redirect(request()->url())->with('alert','문의가 접수되었습니다.');
    }
}
