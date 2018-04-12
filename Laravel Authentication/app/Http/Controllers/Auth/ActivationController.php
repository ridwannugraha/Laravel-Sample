<?php

namespace App\Http\Controllers\auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivationController extends Controller
{
    public function activation($token){
        User::where('verify_token', $token)->firstOrfail()->update(['status' => 1]);

        return redirect()->route('login')
            ->withSuccess('Success Activation');

    }

    public function ResendActivation($email){
        $user = User::where('email', $email)->firstOrfail();

        $user->update(['verify_token' => Str::random(40)]);

        $user->notify(new VerifyEmail($user));
    }
}
