<?php

namespace App\Mail;

use App\Models\Manage\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;

    private $inquiry;

    /**
     * Create a new message instance.
     *
     * @return void
     * @deprecated 2021-02-16 답변 완료 메일은 나가지 않음.
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
            ->subject('[덴탈브레인] 문의 답변 완료')
            ->view('emails.service.inquire_answer')
            ->with([
                'inquiry' => $this->inquiry
            ]);
    }
}
