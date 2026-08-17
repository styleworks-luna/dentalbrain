<?php

namespace App\Rules;

use App\Services\Captcha\ImageCaptcha;
use Illuminate\Contracts\Validation\Rule;

class Captcha implements Rule
{
    /** @var string 세션에 저장된 캡챠 구분 키 */
    private $key;

    /** @var ImageCaptcha */
    private $captcha;

    public function __construct(string $key, ImageCaptcha $captcha = null)
    {
        $this->key = $key;
        $this->captcha = $captcha ?: app(ImageCaptcha::class);
    }

    public function passes($attribute, $value)
    {
        return $this->captcha->verify($this->key, $value);
    }

    public function message()
    {
        return '※ 보안문자가 일치하지 않습니다. 다시 입력해주세요.';
    }
}
