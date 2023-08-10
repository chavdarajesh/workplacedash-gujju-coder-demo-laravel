<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Tenant;
use App;
use Session;
use Config;

class FrontUsers
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
        if ( $request->user() ){
            if(auth()->user()->companyid != 1){
                //Tenant::where('database_name',auth()->user()->database_name)->firstOrFail()->configure()->use();
                return $next($request);
            }
        } else {
            return redirect('/')->with('error',__('You do not have access.'));
        }
        return redirect('/')->with('error',__('You do not have access.'));
    }
}
