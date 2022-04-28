<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserSecession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Secession extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $userSecession;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,UserSecession $userSecession)
    {
        $this->user = $user;
        $this->userSecession = $userSecession;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[덴탈브레인] 탈퇴 완료')
            ->view('emails.user.secession_complete')
            ->with([
                'user' => $this->user,
                'userSecession' => $this->userSecession
            ]);
    }
}
