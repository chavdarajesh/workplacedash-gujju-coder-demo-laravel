<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Tenant;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App;



class FrontUsersLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Session::has('locale'))
        {
           Session::put('locale',Config::get('app.locale'));
        }
        App::setLocale(session('locale'));
		Config::set('database.default', 'tenant');
        if(isset($request->autho_key)){
            $companywxites=User::where('companyname',$request->companyname)->first();        
            if(empty($companywxites)){
                return back()->withInput()->with('error', __('Company name does not exits.'));
                $responce = array('error'=>1,'responce'=>'','msg'=>__('Company name does not exits.'));
                json_encode($responce);
                die;
            }     
            Tenant::where('database_name',$companywxites->database_name)->firstOrFail()->configure()->use();      
            return $next($request);         
        }        
        $companywxites=User::where('companyname',$request->companyname)->first();        
        if(empty($companywxites)){
            return back()->withInput()->with('error', __('Company name does not exits.'));            
        }
        setcookie('asarcotenent', $companywxites->id, time() + (86400 * 30), "/");                
        Cookie::queue(Cookie::make('asarcotenent', $companywxites->database_name, time() + (86400 * 30), "/")); 
        Tenant::where('database_name',$companywxites->database_name)->firstOrFail()->configure()->use();
        return $next($request);        
    }
}
