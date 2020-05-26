<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\User;

class UsersCreated extends Mailable {
    use Queueable, SerializesModels;

    public $password;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password) {
        $this->user = User::where('email', $email)->first();
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('emails.usersCreated');
    }
}
