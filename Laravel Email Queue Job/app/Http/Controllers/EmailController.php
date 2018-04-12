<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Mail\MessageMail;
use Illuminate\Http\Request;
use App\Jobs\SendEmailJobs;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    
    /**
     * php artisan make:mail MessageMail
     * 
     */
    public function sendEmail(){
        $user = User::find(2);

        Mail::to($user->email)->send(new MessageMail('Hallow', $user));
    }
    
    /**
     * php artisan make:job SendEmailJobs
     * php artisan queue:table
     * php artisan queue:work
     * 
     */
    public function sendEmailJob(){
        $user = User::find(2);

        SendEmailJobs::dispatch('Hellow', $user)
        		     ->delay(Carbon::now()
        			 ->addSeconds(10));
    }

}
