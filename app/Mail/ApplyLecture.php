<?php

namespace App\Mail;

use App\Models\Program\ProgramStudent;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplyLecture extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $programStudent;
    private $program;

    /**
     * Create a new message instance.
     *
     * @param User|Authenticatable $user
     * @param ProgramStudent $programStudent
     */
    public function __construct(User $user, ProgramStudent $programStudent)
    {
        $this->user = $user;
        $this->programStudent = $programStudent;
        $this->program = $programStudent->program()->get()->first();
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
                'programStudent' => $this->programStudent,
                'program' => $this->program
            ]);
    }
}
