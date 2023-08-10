<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        
        if ( $request->user() ){
            if(auth()->user()->companyid == 1){
                return $next($request);
            }
        } else {
            return redirect('dashboard')->with('error',__('You do not have access.'));
        }

        
        //return redirect('dashboard')->with('sucess','You do not have access. ');
        return redirect('dashboard')->with('sucess',__('You do not have access.'));

    }
}
