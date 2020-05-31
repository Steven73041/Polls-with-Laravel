<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PollClosed extends Mailable {
    use Queueable, SerializesModels;

    public $user;
    public $poll;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $poll) {
        $this->user = $user;
        $this->poll = $poll;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.pollClosed');
    }
}
