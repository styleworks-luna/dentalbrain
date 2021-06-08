<?php

namespace App\Mail;

use App\Models\Program\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Lecture extends Mailable
{
    use Queueable, SerializesModels;

    private $title;
    private $content;
    private $program;


    /**
     *  Create a new message instance.
     *
     * @param $title
     * @param $content
     * @param Program|int $program
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct($title, $content, $program)
    {
        if ($program instanceof Program) {
            $this->program = $program;
        } else {
            $this->program = Program::query()->find($program);
        }

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
                'content' => $this->content,
                'program' => $this->program,
            ]);
    }
}
