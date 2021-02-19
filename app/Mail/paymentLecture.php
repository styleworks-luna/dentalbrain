<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentLecture extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $program;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$program)
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
            ->subject('[DBV2020] 강의 결제 완료')
            ->view('emails.lecture.lecture_payment')
            ->with([
                'user' => $this->user,
                'program' => $this->program
            ]);;
    }
}
