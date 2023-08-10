<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\Roles;
use DB;
use Auth;

class RolesControllers extends Controller
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
        $cuser = Auth::user();
       if(!$cuser->can('Roles')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

       $Roles= DB::table('roles')
        ->select('roles.*', DB::raw('COUNT(users.is_admin) AS users_count'))
        ->leftJoin('users', 'users.is_admin', '=', 'roles.id')
        ->whereNull('roles.deleted_at')
        ->groupBy('roles.id')
        ->orderby('roles.id','desc')
        ->get();

        $page_title='Roles';
        return view('roles.roles',compact('Roles','page_title','cuser'));
    }

    public function create()
    {    
        $cuser = Auth::user();
        if(!$cuser->can('Roles Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $page_title='Roles Create';
        $permissions=array();
        return view('roles.create',compact('page_title','permissions','cuser'));
    }

    public function store(Request $request)
    {     
        $cuser = Auth::user();
        $customMessages = [
            'upd_pm_id.required'=> __('At least one user licenses and access privileges is required')
        ];            
        $validatedData = $request->validate([
            'upd_pm_id' => ['required'],            
        ],$customMessages);

        $Roles = new \App\Roles;
        $Roles->r_name = $request->r_name;
        $Roles->r_status = $request->r_status;
        $Roles->save();                   
        $permissions=array();

        $rpm_r_id=$Roles->id;
        $upd_pm_id_arr=$request->upd_pm_id;        
        foreach ($upd_pm_id_arr as $key => $rpm_pm_id) {                                
            $single=array();    
            $single['roles_id']= $rpm_r_id;
            $single['permission_pm_id']= $rpm_pm_id;
            $permissions[]=$single;
        }
        DB::table('role_permissions_master')->insert($permissions);

        return Redirect::route('roles')->with('success',__('Roles successfully added.'));
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Roles Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $Roles=Roles::where('id',$request->id)->first();
        if(!$Roles){
            return Redirect::route('roles')->with('error',__('Roles not found.'));
        }
        $permissions=array('none');
        $permissions_arr=DB::table('role_permissions_master')->where('roles_id',$request->id)->get(); 
        if($permissions_arr){
            foreach ($permissions_arr as $key => $value) {
                $permissions[]=$value->permission_pm_id;
            }
        }    
        $page_title='Edit Role';        
        return view('roles.edit', compact('Roles','page_title','permissions','cuser'));
    }

    public function update(Request $request)
    {   
        $cuser = Auth::user(); 
        $customMessages = [
            'upd_pm_id.required'=> __('At least one user licenses and access privileges is required')
        ];            
        $validatedData = $request->validate([
            'upd_pm_id' => ['required'],            
        ],$customMessages);
        
        DB::table('roles')->where('id',$request->id)->update(['r_name' => $request->r_name,'r_status' => $request->r_status]);
        $rpm_r_id=$request->id;
        $upd_pm_id_arr=$request->upd_pm_id; 
        
        DB::table('role_permissions_master')->where('roles_id',$rpm_r_id)->delete();      
        foreach ($upd_pm_id_arr as $key => $rpm_pm_id) {                                
            $single=array();    
            $single['roles_id']= $rpm_r_id;
            $single['permission_pm_id']= $rpm_pm_id;
            $permissions[]=$single;
        }
        DB::table('role_permissions_master')->insert($permissions);
        return Redirect::route('roles')->with('success',__('Roles successfully Updated.'));
    }

    public function delete($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Roles Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        
        Roles::where('id',$id)->delete();
        return Redirect::route('roles')->with('success',__('Roles successfully deleted.'));
    }

}
