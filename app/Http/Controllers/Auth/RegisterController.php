<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Config;
use Artisan;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Redirect;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        Config::set('database.default', 'landlord');
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
            'name' => ['required', 'string', 'max:255'],
            'companyname' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {                
        $registeruser = User::create([
            'name' => $data['name'],            
            'companyname' => $data['companyname'],
            'planguage' => $data['planguage'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user = User::where('id',$registeruser->id)->first();
        $user->database_name = 'asarco_udb_'.$registeruser->id;        
        $user->companyid = $registeruser->id;
        $user->status = 1;
        $user->save();
        Auth::login($user);
        setcookie('asarcotenent', $registeruser->id, time() + (86400 * 30), "/");                
        Cookie::queue(Cookie::make('asarcotenent', 'asarco_udb_'.$registeruser->id, time() + (86400 * 30), "/")); 
        Artisan::call('db:create asarco_udb_'.$registeruser->id);
        Artisan::call('userdb:migrate asarco_udb_'.$registeruser->id);
        Auth::logout();
        return $registeruser;
        
    }
}
