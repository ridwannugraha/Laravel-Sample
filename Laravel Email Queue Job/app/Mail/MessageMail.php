<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class MessageMail extends Mailable
{

    public $message;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.message', [
            'data' => $this->message
        ]);
    }
}
