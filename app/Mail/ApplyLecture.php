<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyLecture extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $student;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $student)
    {
        $this->user = $user;
        $this->student = $student;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('[DBV2020] 강의 신청 완료')
            ->view('emails.lecture.lecture_apply')
            ->with([
                'user' => $this->user,
                'student' => $this->student
            ]);;
    }
}
