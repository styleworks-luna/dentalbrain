<?php

namespace App\DTO\Recruit;

class AlbatalkPopup
{
    const STYLE_REDIRECT = 1;
    const STYLE_ALERT = 2;

    private $style;
    private $link;
    private $message;
    private $buttonText;

    /**
     * @param int $style
     * @param string|null $link
     * @param string $message
     * @param string $buttonText
     */
    private function __construct(int $style, ?string $link, string $message, string $buttonText)
    {
        $this->style = $style;
        $this->link = $link;
        $this->message = $message;
        $this->buttonText = $buttonText;
    }

    /**
     * @param string $message
     * @param string $buttonText
     * @param string|null $link
     * @return AlbatalkPopup
     */
    static function createAlert(string $message, string $buttonText = '확인', string $link = null): AlbatalkPopup
    {
        return new AlbatalkPopup(self::STYLE_ALERT, $link, $message, $buttonText);
    }

    /**
     * @param string $link
     * @param string $message
     * @param string $buttonText
     * @return AlbatalkPopup
     */
    static function createRedirect(string $link, string $message, string $buttonText): AlbatalkPopup
    {
        return new AlbatalkPopup(self::STYLE_REDIRECT, $link, $message, $buttonText);
    }

    public function isAlert(): bool
    {
        return $this->style == self::STYLE_ALERT;
    }

    public function isRedirect(): bool
    {
        return $this->style == self::STYLE_REDIRECT;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->buttonText;
    }
}
