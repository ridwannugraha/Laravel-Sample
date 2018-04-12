<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\TestNotification;

class NotificationController extends Controller
{
    
    public function index(){
    	$user = User::find(2);

    	// return view('email.message', ['message' => $user->unreadNotifications->count() ]);
    	
    	return $user->unreadNotifications->count();
    }

    public function create(){
    	$user = User::find(2);

    	$user->notify(new TestNotification('hallow', $user));

    	return redirect()->back();
    }

    public function read(){
    	$user = User::find(2);
    	
    	// $user->unreadNotifications()->update(['read_at' => Carbon::now()]);
    	
    	$user->unreadNotifications->markAsRead();

    	return redirect()->back();
    }

    public function delete(){
		$user = User::find(2);

    	$user->notifications()->delete();

    	return redirect()->back();
    }
}
