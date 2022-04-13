<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        return $this->subject('[덴탈브레인] 비밀번호 재설정')
            ->view('emails.user.password_find')
            ->with([
                'user' => $this->user,
                'newPassword'=> $this->newPassword
            ]);
    }
}
