<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Redirect;
use Session;
use App\Tenant;

use App;

class APIMiddleware 
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
        if ($request->autho_key!=123456789) {
            $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid authentication key.');
            echo json_encode($responce);  
            //Tenant::where('database_name',auth()->user()->database_name)->firstOrFail()->configure()->use();            
            die;                        
        }
        
        $lang = (isset($request->lang))?$request->lang:'en';
        app()->setLocale($lang);

        $database_name = isset($request->database_name)?$request->database_name:'';
        if(!empty($database_name)){
            Tenant::where('database_name',$database_name)->firstOrFail()->configure()->use();
        }

	   return $next($request);
    }
}
