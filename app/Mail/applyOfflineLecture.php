<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class applyOfflineLecture extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $program;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $program)
    {
        $this->user = $user;
        $this->program = $program;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('[DBV2020] 오프라인 강의 신청 완료')
            ->view('emails.lecture.offline_apply')
            ->with([
                'user' => $this->user,
                'program' => $this->program
            ]);;
    }
}
