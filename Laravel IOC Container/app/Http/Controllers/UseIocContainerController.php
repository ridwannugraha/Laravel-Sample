<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UseIocContainerController extends Controller
{

	public function Action(Request $request){

    	// Use IoC Container:
    	\IocContainer::Send([
    		//
    	])->to($user);

    }
}
