<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserByTennat;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use App;
use App\Tenant;
use DB;

class GeneralController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Home(Request $request)
    {
        if (!Session::has('locale'))
        {
           Session::put('locale',Config::get('app.locale'));
        }
        App::setLocale(session('locale'));
        return view('welcome');
    }
    public function AdminLogin(Request $request)
    {
        return view('admin.login');
    }

    public function AdminLoginPost(Request $request)
    {
        $input = $request->all();
   
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'], 'is_admin' =>1)))
        {
            return redirect()->route('admin');
        }else{
            return redirect()->route('adminlogin')->withInput()->with('error',__('Email-Address And Password Are Wrong.'));
        }
    }

    public function CompanyLoginPost(Request $request)
    {
        $input = $request->all();                
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);   
        $user = UserByTennat::where('email',  $input['email'])->first();   
        if($user){
            if($user->status!=1){
                return redirect()->route('login')->withInput()->with('error', __('Your Account is Inactive Please Contact Support.'));                
            }            
        }else{
            return redirect()->route('login')->withInput()->with('error', __('Email-Address And Password Are Wrong.'));            
        }

        $site_id=$request->companyname;
        $user_site = DB::table('user_site_relation')->where('site_id',$site_id)->where('user_id',$user->id)->first();
        if(empty($user_site)){
            return redirect()->route('login')->withInput()->with('error', __('Email-Address And Site / Location Are Wrong.'));            
        }

        Session::put('locale',$user->planguage);
        
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        { 
            return redirect()->route('dashboard');  
        }else{            
            Cookie::queue(Cookie::make('asarcotenent', env('LANDLORD_DB_DATABASE'), time() + (86400 * 30), "/"));
            Tenant::where('database_name',env('LANDLORD_DB_DATABASE'))->firstOrFail()->configure()->use();
            return redirect()->route('login')->withInput()->with('error', __('Email-Address And Password Are Wrong.'));            
        }
    }

    public function ClearData(Request $request)
    {   
        if($request->confirm==1 && $request->db){            
        Cookie::queue(Cookie::make($request->db, $request->db, time() + (86400 * 30), "/"));
        Tenant::where('database_name',$request->db)->firstOrFail()->configure()->use();
        DB::table('actions_master')->truncate();
        DB::table('actions_attachement_rel')->truncate();
        DB::table('actions_responsible')->truncate();
        DB::table('audit_answer_master')->truncate();
        DB::table('audit_checkbox_question_option')->truncate();
        DB::table('audit_gridview_option')->truncate();
        DB::table('audit_keyfinding')->truncate();
        DB::table('audit_master')->truncate();
        DB::table('audit_section_completed')->truncate();
        DB::table('audit_timeline')->truncate();
        DB::table('audit_usernotify')->truncate();
        DB::table('incidents_attachement_rel')->truncate();
        DB::table('incidents_investigation_team')->truncate();
        DB::table('incidents_master')->truncate();
        DB::table('incidents_victim')->truncate();
        DB::table('incidents_victim_bodypart')->truncate();
        DB::table('observations_attachement_rel')->truncate();
        DB::table('observations_master')->truncate();
        DB::table('observations_reply_attachement')->truncate();        
        }

    }
}

