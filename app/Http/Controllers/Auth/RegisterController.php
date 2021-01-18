<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Gate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = '/relatorio';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }
    public function index(){
        $data = [
            'admin' => Gate::allows('admin')
        ];
        return view('relatorio.register', $data);
    }
    public function register(Request $request){
        $data = $request->only(['nome', 'login', 'divisao', 'password', 'admin']);
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect('/register')->withErrors($validator)->withInput();
        }
        $this->create($data);
        return redirect('/relatorio/usuarios')->with('success', 'Usuário cadastrado com sucesso.');
    }   
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', 'max:255', 'unique:users,usuario'],
            'password' => ['required', 'string', 'min:3'],
            'divisao' => ['required', 'string']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if(empty($data['admin'])){
            $data['admin'] = 0;
        }
        return User::create([
            'name' => $data['nome'],
            'usuario' => $data['login'],
            'divisao' => $data['divisao'],
            'admin' => $data['admin'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
