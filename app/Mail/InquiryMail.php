<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Manage\Inquiry;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    private $inquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('[DBV2020] 문의 답변 완료')
            ->view('emails.service.inquire_answer')
            ->with([
                'inquiry' => $this->inquiry
            ]);
    }
}
