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

class ApiUserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
		Config::set('database.default', 'tenant');
        $companywxites=User::where('companyname',$request->companyname)->first();

        $lang = (isset($request->lang))?$request->lang:'en';
        app()->setLocale($lang);
        
        if(empty($companywxites)){
            $request->companyname='';
            return $next($request);
        }     
        Tenant::where('database_name',$companywxites->database_name)->firstOrFail()->configure()->use();      
        return $next($request);               
    }
}
