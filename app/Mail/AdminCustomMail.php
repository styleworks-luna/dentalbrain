<?php

namespace App\Mail;

use App\Models\Program\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AdminCustomMail extends Mailable
{
    use Queueable, SerializesModels;

    private $title;
    private $content;


    /**
     *  Create a new message instance.
     *
     * @param $title
     * @param $content
     */
    public function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->title)
            ->view('emails.content')
            ->with([
                'title' => $this->title,
                'content' => $this->content,
            ]);
    }
}
