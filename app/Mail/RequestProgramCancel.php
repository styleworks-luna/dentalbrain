<?php

namespace App\Mail;

use App\Models\Program\ProgramStudent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RequestProgramCancel extends Mailable
{
    use Queueable, SerializesModels;

    protected $student;
    protected $reason;
    protected $bank;
    protected $accountNumber;
    protected $holderName;

    /**
     * Create a new message instance.
     *
     * @param ProgramStudent $student
     * @param string $reason
     * @param string|null $bank
     * @param string|null $accountNumber
     * @param string|null $holderName 예금주
     */
    public function __construct(ProgramStudent $student, string $reason, ?string $bank, ?string $accountNumber, ?string $holderName)
    {
        $this->student = $student;
        $this->reason = $reason;
        $this->bank = $bank;
        $this->accountNumber = $accountNumber;
        $this->holderName = $holderName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('[DENTALBRAIN] 강의 환불이 신청되었습니다')
            ->view('emails.payment.cancel_request')->with([
                'student' => $this->student,
                'reason' => $this->reason,
                'bank' => $this->bank,
                'accountNumber' => $this->accountNumber,
                'holderName' => $this->holderName,
            ]);
    }
}
