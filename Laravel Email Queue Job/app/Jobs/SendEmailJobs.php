<?php

namespace App\Jobs;

use App\Mail\MessageMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJobs implements ShouldQueue
{
    use Dispatchable;

    public $message, $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new MessageMail('Hallow', $this->user));
    }
}
