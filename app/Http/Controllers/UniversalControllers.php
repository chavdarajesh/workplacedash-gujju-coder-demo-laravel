<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserByTennat;
use App\Roles;
use App\Sites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use App\RolePermission;
use DB;
use Mail;
use App;
use Illuminate\Foundation\Auth\RegistersUsers;

class UniversalControllers extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('FrontUsers');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$Users=UserByTennat::all();
        $cuser = Auth::user(); 
        if(!$cuser->can('User')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $Users= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')    
        ->where('roles.id',6)    
        ->get();

        $page_title='Universal Users';            
        return view('universal-login.users',compact('Users','page_title','cuser'));
    }

    public function deleted()
    {
        //$Users=UserByTennat::all();
        $cuser = Auth::user(); 
        if(!$cuser->can('User')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $Users= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNotNull('users.deleted_at')    
        ->get();

        $page_title='Users';            
        return view('universal-login.usersdeleted',compact('Users','page_title','cuser'));
    }

    
    public function create()
    {        
        $cuser = Auth::user(); 
        if(!$cuser->can('User Add')){ return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $Roles=Roles::orderby('id','desc')->get();
        $sites=Sites::where('site_type',1)->get();
        $page_title='Add New User';        
        return view('universal-login.create', compact('Roles','page_title','sites','cuser'));
    }

    public function store(Request $request)
    {    
        $cuser = Auth::user(); 
        $ErrorMassage=[
            'email.required' => __('The Email has already been taken.'),
            'empid.required' => __('The Employee ID has already been taken.'),
            'empid.unique' => __('The Employee ID has already been taken.'),
            'email.unique' => __('The Email has already been taken.'),
        ];
        $validatedData = $request->validate([
            'email' => ['required', 'unique:users', 'max:255'],
            'name' => ['required'],
            'sites' => ['required'],
            'empid' => ['required', 'unique:users', 'max:255'],
        ],$ErrorMassage);
        $roleID=$request->is_admin;
        $password = randString(8);
        $parentuser = Auth::user();   
        $registeruser = UserByTennat::create([
            'name' => $request->name,            
            'companyname' => $parentuser->companyname,
            'email' => $request->email,
            'password' => Hash::make($password),
        ]);  

        $User = UserByTennat::where('id',$registeruser->id)->first();        
        $User->companyid = $parentuser->companyid;        
        $User->database_name = $parentuser->database_name; 
        $User->planguage = $request->planguage;              
        $User->empid = $request->empid;                    
        $User->is_admin = $request->is_admin;
        $User->status = NULL;        
        $User->save(); 
        $upd_user_id=$User->id;
        $User->sendEmailVerificationNotification();

        $companyname=$parentuser->companyname;
        $invidedByname=$parentuser->name;

        $sitenames = array();
        foreach ($request->sites as $key => $value) {
            $sitenames[] = GetSiteAreaName($value);
            DB::table('user_site_relation')->insert(array('user_id' => $upd_user_id, 'site_id' => $value));
        }
        DB::table('role_log')->insert(['rl_r_id' => $roleID, 'rl_user_id' => $upd_user_id]);
        DB::table('users_roles')->insert(['user_by_tennat_id' => $upd_user_id,'roles_id'=>$roleID]);
        $permissions=array();                
        $upd_pm_id_arr=RolePermission::where('roles_id',$roleID)->get();        
        foreach ($upd_pm_id_arr as $key => $upd_pm_id) {                                
            $single=array();    
            $single['user_by_tennat_id']= $upd_user_id;
            $single['permission_pm_id']= $upd_pm_id->permission_pm_id;
            $permissions[]=$single;
        }
        DB::table('users_permissions')->insert($permissions);

        //*** Send Mail
        $username = $request->name;
        $useremail = $request->email;
        $role = get_role_field($request->is_admin, 'r_name');
        $sites = ($sitenames)?implode(', ', $sitenames):'';
        App::setLocale($request->planguage);        
        Mail::send('email.usercreate', ['username' => $username, 'useremail' => $useremail, 'password' => $password, 'role' => $role, 'sites' => $sites,'companyname'=>$companyname,'invidedByname'=>$invidedByname], function ($m) use ($username, $useremail,$invidedByname) {            
            $m->to($useremail, $username)->subject($invidedByname.' '.__('has invited you to').' ASARCO');
        });

        return Redirect::route('universal-login')->with('success',__('User successfully added.'));
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user(); 
        if(!$cuser->can('User Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $Users=UserByTennat::where('id',$request->id)->first();
        if(empty($Users)){
            return Redirect::route('universal-login')->with('error',__('User not found.'));   
        } 
        $Roles=Roles::orderby('id','desc')->get();
        $user_site_relation=DB::table('user_site_relation')->select('site_id')->where('user_id',$request->id)->get();
        $user_site=array('none');
        if(!empty($user_site_relation)){
            foreach ($user_site_relation as $key => $value) {
                $user_site[]=$value->site_id;   
            }
        }


        
        $sites=Sites::where('site_type',1)->get();
        $page_title='Edit User';        
        return view('universal-login.edit', compact('Roles','page_title','Users','sites','user_site','cuser'));
    }

    public function update(Request $request)
    {    
        $cuser = Auth::user();
        $ErrorMassage=[
            'email.required' => __('The Email has already been taken.'),
            'empid.required' => __('The Employee ID has already been taken.'),
            'empid.unique' => __('The Employee ID has already been taken.'),
            'email.unique' => __('The Email has already been taken.'),
        ];
        $validatedData = $request->validate([
            'email' => 'required|unique:users,email,'.$request->id,
            'name' => 'required',
            'empid' => 'required|unique:users,empid,'.$request->id,
        ],$ErrorMassage);   
             
        $User =  \App\UserByTennat::find($request->id);       
        $User->name = $request->name;
        $User->email = $request->email;
        //$User->password = Hash::make(123456789);            
        if($request->password){
            $User->password = Hash::make($request->password);            
        }
        $User->empid = $request->empid;        
        $User->is_admin = $request->is_admin;
        $User->status = $request->status;
        $User->planguage = $request->planguage;                
        $User->save();  
        DB::table('user_site_relation')->where('user_id', $request->id)->delete();
        if($request->sites){
            foreach ($request->sites as $key => $value) {
                DB::table('user_site_relation')->insert(array('user_id' => $request->id, 'site_id' => $value));
            }             
        }

        if($request->is_admin!=$request->old_role){
            DB::table('role_log')->insert(['rl_r_id' => $request->is_admin, 'rl_user_id' => $request->id]);            
            DB::table('users_roles') ->where('user_by_tennat_id', $request->id)->update(array('roles_id' =>$request->is_admin));
            $permissions=array(); 
            DB::table('users_permissions')->where('user_by_tennat_id',$request->id)->delete();                                  
            $upd_pm_id_arr=RolePermission::where('roles_id',$request->is_admin)->get();        
            foreach ($upd_pm_id_arr as $key => $upd_pm_id) {                                
                $single=array();    
                $single['user_by_tennat_id']= $request->id;
                $single['permission_pm_id']= $upd_pm_id->permission_pm_id;
                $permissions[]=$single;
            }
            DB::table('users_permissions')->insert($permissions);
        }

        
        return Redirect::route('universal-login')->with('success',__('User successfully updated.'));
    }
    public function delete($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('User Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        if($id==1){
            return Redirect::route('universal-login')->with('error','You can not delete this user.');    
        }
        UserByTennat::where('id',$id)->delete();
        return Redirect::route('universal-login')->with('success',__('User successfully deleted.'));
    }

    public function restore($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('User Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        if($id==1){
            return Redirect::route('universal-login')->with('error','You can not delete this user.');    
        }
        UserByTennat::where('id',$id)->restore();
        return Redirect::route('universal-login')->with('success',__('User successfully restored.'));
    }
    
    public function GetPermission($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('User Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $cuser = Auth::user();
        $Users=UserByTennat::where('id',$id)->first();
        if(empty($Users)){
            return Redirect::route('universal-login')->with('error',__('User not found.'));   
        }  
        $Roles=Roles::orderby('id','desc')->get();
        $permissions=array('none');
        $permissions_arr=DB::table('users_permissions')->where('user_by_tennat_id',$id)->get(); 
        if($permissions_arr){
            foreach ($permissions_arr as $key => $value) {
                $permissions[]=$value->permission_pm_id;
            }
        }
        $page_title='User Licenses and Access Privileges';        
        return view('universal-login.permission', compact('Roles','page_title','Users','permissions','cuser'));    
    }

    public function PostPermission(Request $request)
    {
        $cuser = Auth::user();
        $customMessages = [
            'upd_pm_id.required'=> __('At least one user licenses and access privileges is required')
        ];            
        $validatedData = $request->validate([
            'upd_pm_id' => ['required'],            
        ],$customMessages);

        $permissions=array();
        $upd_user_id=$request->upd_user_id;
        $upd_pm_id_arr=$request->upd_pm_id;
        DB::table('users_permissions')->where('user_by_tennat_id',$upd_user_id)->delete();                   
        foreach ($upd_pm_id_arr as $key => $upd_pm_id) {                                
            $single=array();    
            $single['user_by_tennat_id']= $upd_user_id;
            $single['permission_pm_id']= $upd_pm_id;
            $permissions[]=$single;
        }
        DB::table('users_permissions')->insert($permissions);
        return Redirect::route('universal-login')->with('success',__('User successfully Updated.'));
    }

    public function ResendVarification($id)
    {    
        $cuser = Auth::user();                 
        $password = randString(8);
        $parentuser = Auth::user();           

        $User = UserByTennat::where('id',$id)->first();        
        $User->password =  Hash::make($password);                
        $User->status = NULL;        
        $User->save();         
        $User->sendEmailVerificationNotification();

        $companyname=$parentuser->companyname;
        $invidedByname=$parentuser->name;

        $user_site_relation=DB::table('user_site_relation')->select('site_id')->where('user_id',$User->id)->get();
        $sitenames=array('none');
        if(!empty($user_site_relation)){
            foreach ($user_site_relation as $key => $value) {
                $sitenames[]=GetSiteAreaName($value->site_id);   
            }
        }

        //*** Send Mail
        $username = $User->name;
        $useremail = $User->email;
        $role = get_role_field($User->is_admin, 'r_name');
        $sites = ($sitenames)?implode(', ', $sitenames):'';
        App::setLocale($User->planguage);        
        Mail::send('email.usercreate', ['username' => $username, 'useremail' => $useremail, 'password' => $password, 'role' => $role, 'sites' => $sites,'companyname'=>$companyname,'invidedByname'=>$invidedByname], function ($m) use ($username, $useremail,$invidedByname) {            
            $m->to($useremail, $username)->subject($invidedByname.' '.__('has invited you to').' ASARCO');
        });

        return Redirect::route('universal-login')->with('success',__('Email verification notification sent successfully.'));
    }

}

