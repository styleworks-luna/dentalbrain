<?php

namespace App\Services\Captcha;

use Illuminate\Support\Facades\Session;

/**
 * 세션 기반 이미지 캡챠.
 *
 * 정답 문자열은 세션에만 저장하고 클라이언트에는 이미지로만 노출한다.
 * 검증은 1회용이며(성공/실패 모두 폐기) 유효시간이 지나면 무효 처리한다.
 */
class ImageCaptcha
{
    /** 세션 키 접두어 */
    const SESSION_PREFIX = 'captcha.';

    /** 문자 수 */
    const LENGTH = 5;

    /** 유효시간(초) */
    const TTL = 300;

    /** 사람이 혼동하는 문자(I, l, O, 0, 1)는 제외 */
    const CHARSET = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';

    const WIDTH = 150;
    const HEIGHT = 50;

    /**
     * 새 캡챠 코드를 만들어 세션에 저장한다.
     */
    public function make(string $key): string
    {
        $code = '';
        $max = strlen(self::CHARSET) - 1;

        for ($i = 0; $i < self::LENGTH; $i++) {
            $code .= self::CHARSET[random_int(0, $max)];
        }

        Session::put(self::SESSION_PREFIX . $key, [
            'code' => $code,
            'expires_at' => time() + self::TTL,
        ]);

        return $code;
    }

    /**
     * 입력값을 검증한다. 대소문자는 무시하며, 검증 후 코드는 폐기한다.
     */
    public function verify(string $key, $input): bool
    {
        $stored = Session::get(self::SESSION_PREFIX . $key);
        $this->forget($key);

        if (!is_array($stored) || !isset($stored['code'], $stored['expires_at'])) {
            return false;
        }

        if ($stored['expires_at'] < time()) {
            return false;
        }

        if (!is_string($input) || $input === '') {
            return false;
        }

        return hash_equals(strtoupper($stored['code']), strtoupper(trim($input)));
    }

    public function forget(string $key): void
    {
        Session::forget(self::SESSION_PREFIX . $key);
    }

    /**
     * 코드를 PNG 이미지 바이너리로 렌더링한다.
     */
    public function render(string $code): string
    {
        $image = imagecreatetruecolor(self::WIDTH, self::HEIGHT);

        $background = imagecolorallocate($image, 245, 246, 248);
        imagefilledrectangle($image, 0, 0, self::WIDTH, self::HEIGHT, $background);

        $this->drawNoise($image);
        $this->drawCode($image, $code);
        $this->drawLines($image);

        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        return $png;
    }

    /**
     * 배경 점 노이즈
     */
    private function drawNoise($image): void
    {
        for ($i = 0; $i < 400; $i++) {
            $color = imagecolorallocate($image, random_int(180, 225), random_int(180, 225), random_int(180, 225));
            imagesetpixel($image, random_int(0, self::WIDTH - 1), random_int(0, self::HEIGHT - 1), $color);
        }
    }

    /**
     * 문자별로 색·크기·각도·위치를 흔들어 그린다.
     */
    private function drawCode($image, string $code): void
    {
        $font = $this->fontPath();
        $step = (int) floor((self::WIDTH - 20) / self::LENGTH);

        for ($i = 0; $i < strlen($code); $i++) {
            $color = imagecolorallocate($image, random_int(20, 90), random_int(20, 90), random_int(90, 160));
            $size = random_int(20, 24);
            $angle = random_int(-22, 22);
            $x = 12 + ($i * $step) + random_int(-2, 2);
            $y = random_int(34, 42);

            if ($font !== null) {
                imagettftext($image, $size, $angle, $x, $y, $color, $font, $code[$i]);
                continue;
            }

            // FreeType 이나 폰트 파일을 쓸 수 없는 환경에서는 내장 폰트로 대체
            imagestring($image, 5, $x, (int) ($y / 2), $code[$i], $color);
        }
    }

    /**
     * 문자를 가로지르는 방해선
     */
    private function drawLines($image): void
    {
        for ($i = 0; $i < 4; $i++) {
            $color = imagecolorallocate($image, random_int(120, 190), random_int(120, 190), random_int(120, 190));
            imageline(
                $image,
                random_int(0, (int) (self::WIDTH / 3)),
                random_int(0, self::HEIGHT),
                random_int((int) (self::WIDTH / 2), self::WIDTH),
                random_int(0, self::HEIGHT),
                $color
            );
        }
    }

    /**
     * 렌더링에 쓸 TTF 경로. FreeType 이 없거나 폰트가 없으면 null.
     */
    private function fontPath(): ?string
    {
        if (!function_exists('imagettftext')) {
            return null;
        }

        $font = public_path('fonts/ChosunGs_pdf.TTF');

        return is_readable($font) ? $font : null;
    }
}
