<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AfterEndProgram extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $program;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$program)
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
            ->subject('[덴탈브레인] 강의 시청 마감 안내')
            ->view('emails.lecture.lecture_end')
            ->with([
                'user' => $this->user,
                'program' => $this->program
            ]);;
    }
}
