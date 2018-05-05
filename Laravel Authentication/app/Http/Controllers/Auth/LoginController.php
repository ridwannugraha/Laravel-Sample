<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Rules\StatusUserRule;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => ['required','email', 'exists:users', new StatusUserRule],
            'password' => 'required|string',
        ], $this->ValidateErorrMessage());
    }

    public function ValidateErorrMessage(){
        return [
            'exists' => 'Email Not found Click <a href="#">Register</a>',
        ];
    }
    
    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest  $request
     * @return Response
     */
    public function postLogin(Request $request)
    {

      if (Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return redirect('home');
      }

      return redirect()->back()->withErrors([
          'email' => 'The credentials you entered did not match our records. Try again?',
      ]);
    }

}
