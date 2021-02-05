<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class Reset extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('비밀번호 재설정 테스트')
            ->view('emails.user.password_find')
            ->with([
                'user' => $this->user,
                'newPassword'=> $this->newPassword
            ]);
    }
}
