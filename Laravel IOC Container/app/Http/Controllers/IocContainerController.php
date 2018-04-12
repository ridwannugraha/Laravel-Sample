<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IocContainerController extends Controller
{

	public static $message ;

    public static function send($msg = array()){

    	// Set Variable
		self::$message = $msg;
        
		return new static;
    }

    public function to($user){

    	return [
    		'data' => self::$message,
    		'username' => $user
    	];

    }
}
