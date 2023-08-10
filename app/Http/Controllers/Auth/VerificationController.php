<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Auth;
use Illuminate\Http\Request;
use App\User;
use Closure;
use App\Tenant;
use App\UserByTennat;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
       // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        
        Tenant::where('database_name',env('LANDLORD_DB_DATABASE'))->firstOrFail()->configure()->use();
        $companywxites=User::where('companyname',$request->rpcompanyname)->first();                
        if(empty($companywxites)){                                        
        return Redirect::back()->withInput()->with('error', 'Company name does not exits.');
        }     
        Tenant::where('database_name',$companywxites->database_name)->firstOrFail()->configure()->use(); 
        $user = UserByTennat::where('email',$request->email)->first();
        
        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }
        $user->markEmailAsVerified();
        $user->status=1;
        $user->save();
        Auth::logout();
        return redirect($this->redirectPath())->with('verified', true);
    }
}
