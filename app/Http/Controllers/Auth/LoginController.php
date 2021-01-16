<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
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
    protected $redirectTo = '/relatorio/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('login');
    }

    public function authenticate(Request $request){
        $creds = $request->only(['usuario', 'password']);
        if(Auth::attempt($creds)){
            return redirect('/relatorio/home');
        }else{
            echo 'entrou';
            return redirect('/login')->with('error', 'Usuário e/ou senha inválidos.');
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
}
