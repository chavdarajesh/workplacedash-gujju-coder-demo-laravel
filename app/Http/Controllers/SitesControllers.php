<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserByTennat;
use App\Sites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Redirect;
use DB;

class SitesControllers extends Controller
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
        if(!$cuser->can('Sites')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $sitesActive=Sites::where('status',1)->where('site_type',1)->get();
        $sitesInactive=Sites::where('status',0)->where('site_type',1)->get();
        
        $page_title='Sites';
        return view('sites.sites',compact('sitesActive','sitesInactive','page_title','cuser'));
    }

    public function create()
    {
        $cuser = Auth::user();
        if(!$cuser->can('Sites Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $cuser = Auth::user();
        $Users=UserByTennat::where('status',1)->get();
        $page_title='Add New Site';
        return view('sites.create', compact('page_title','Users','cuser'));
    }

    public function store(Request $request)
    {   
        $cuser = Auth::user();
        $validatedData = $request->validate([
            'site_name' => ['required'],
            'site_id' => ['required', 'unique:sites', 'max:255'],
            'site_headofsafety' => ['required'],            
        ]);  

        $Sites = new \App\Sites;
        $Sites->site_name = $request->site_name;
        $Sites->site_id = $request->site_id;
        $Sites->site_timezone = $request->site_timezone;        
        $Sites->sos_mobile = $request->sos_mobile;
        $Sites->sos_email = $request->sos_email;
        $Sites->site_type = 1;
        $Sites->status = $request->status;
        $Sites->save(); 
        $id=$Sites->id;    
        $site_headofsafety=array();
        if($request->site_headofsafety){
            foreach ($request->site_headofsafety as $key => $value) {
                $single=array();
                $single['sh_site_id']=$id;
                $single['sh_user_id']=$value;
                $site_headofsafety[]=$single;
            }
            DB::table('site_headofsafety')->insert($site_headofsafety);                  
        }

        DB::table('sites')->where('id', $id)->update(['site_parent' => $id]);      
        return Redirect::route('sites')->with('success',__('Site successfully added.'));
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Sites Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        

        $cuser = Auth::user();
        $Sites=Sites::where('id',$request->id)->first();
        $Users=UserByTennat::where('status',1)->get();        
        $page_title='Edit Site';
        $site_headofsafetyarr=DB::table('site_headofsafety')->select('sh_user_id')->where('sh_site_id',$request->id)->get();   
        $site_headofsafety=array();
        if($site_headofsafetyarr){
            foreach ($site_headofsafetyarr as $key => $value) {
                $site_headofsafety[]=$value->sh_user_id;
            }
        }
        if($Sites->site_type!=1){
            if($Sites->site_type==2){$Field_name=__('Site Divisions');}
            if($Sites->site_type==3){$Field_name=__('Site Department');}
            if($Sites->site_type==4){$Field_name=__('Site Unit');}
            return view('sites.editsubarea', compact('Sites','page_title','Users','cuser','Field_name','site_headofsafety'));    
        }
        return view('sites.edit', compact('Sites','page_title','Users','cuser','site_headofsafety'));
    }

    public function update(Request $request)
    {    
        $cuser = Auth::user();
        $validatedData = $request->validate([
            'site_id' => 'required|unique:sites,site_id,'.$request->id,
            'site_name' => 'required',
            'site_headofsafety' => 'required',            
        ]);          

        $Sites =  \App\Sites::find($request->id);       
        $Sites->site_name = $request->site_name;
        $Sites->site_id = $request->site_id;
        $Sites->site_timezone = $request->site_timezone;
        $Sites->site_headofsafety = $request->site_headofsafety;
        $Sites->sos_mobile = $request->sos_mobile;
        $Sites->sos_email = $request->sos_email;
        $Sites->status = $request->status;
        $Sites->save(); 
        $id=$request->id;
        $site_headofsafety=array();
        if($request->site_headofsafety){
            DB::table('site_headofsafety')->where('sh_site_id',$id)->delete();   
            foreach ($request->site_headofsafety as $key => $value) {
                $single=array();
                $single['sh_site_id']=$id;
                $single['sh_user_id']=$value;
                $site_headofsafety[]=$single;
            }
            DB::table('site_headofsafety')->insert($site_headofsafety);                  
        }

        return Redirect::route('sites')->with('success',__('Site successfully updated.'));
    }
    public function delete($id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Sites Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }                
        Sites::where('id',$id)->delete();
        Sites::where('site_parent',$id)->delete();
        DB::table('site_headofsafety')->where('sh_site_id',$id)->delete();   
        return Redirect::route('sites')->with('success',__('Site successfully deleted.'));
    }
    public function GetDivisions(Request $request)
    {        
        $cuser = Auth::user();
        if(!$cuser->can('Sites Edit')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }   
        $SitesArr=array();     
        $Sites=Sites::where('id',$request->id)->first();
        if(!$Sites){
            return Redirect::route('sites')->with('error',__('Site not found.'));
        }

        $Sites= DB::table('sites as s')
                    ->select('s.*', 'uh.name as headofsafetyname', 'uh.email as heademail' )
                    ->leftJoin('users as uh', 'uh.id', '=', 's.site_headofsafety')                    
                    ->where('s.id',$request->id)->first();                        

        //$Sites0=Sites::where('site_parent',$request->id)->where('sub_parent',$request->id)->orderby('id','asc')->get();
        $Sites0= DB::table('sites as s')
        ->select('s.*', 'uh.name as head', 'us.name as superviser')
        ->leftJoin('users as uh', 'uh.id', '=', 's.site_headofsafety')
        ->leftJoin('users as us', 'us.id', '=', 's.site_supervisor')
        ->whereNull('s.deleted_at')->where('site_parent',$request->id)->where('sub_parent',$request->id)->orderby('id','asc')    
        ->get();


        $SiteDivistion=array(); $SiteDipartment=array(); $SiteUnit=array();
        foreach ($Sites0 as $key => $value) {
            $SiteDivistion[$value->id]=$value;
           // $Sites1=Sites::where('site_parent',$request->id)->where('sub_parent',$value->id)->orderby('id','asc')->get();
            $Sites1= DB::table('sites as s')
            ->select('s.*', 'uh.name as head', 'us.name as superviser')
            ->leftJoin('users as uh', 'uh.id', '=', 's.site_headofsafety')
            ->leftJoin('users as us', 'us.id', '=', 's.site_supervisor')
            ->whereNull('s.deleted_at')->where('site_parent',$request->id)->where('sub_parent',$value->id)->orderby('id','asc')    
            ->get();

            foreach ($Sites1 as $key => $valueone) {
                $SiteDipartment[$value->id][$valueone->id]=$valueone;
                    //$Sites2=Sites::where('site_parent',$request->id)->where('sub_parent',$valueone->id)->orderby('id','asc')->get();
                    $Sites2= DB::table('sites as s')
                    ->select('s.*', 'uh.name as head', 'us.name as superviser')
                    ->leftJoin('users as uh', 'uh.id', '=', 's.site_headofsafety')
                    ->leftJoin('users as us', 'us.id', '=', 's.site_supervisor')
                    ->whereNull('s.deleted_at')->where('site_parent',$request->id)->where('sub_parent',$valueone->id)->orderby('id','asc')    
                    ->get();
                    foreach ($Sites2 as $key => $valuetwo) {
                        $SiteUnit[$valueone->id][$valuetwo->id]=$valuetwo;                        
                    }    
            }
        }     
        
        $Users=UserByTennat::where('status',1)->get();        
        $page_title='Site Divisions';        
        return view('sites.divisions', compact('Sites','page_title','Users','cuser','SiteDivistion','SiteDipartment','SiteUnit'));        
    }

    public function AddSubArea(Request $request)
    {   
        $cuser = Auth::user();
        if(!$cuser->can('Sites Add')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $site_id=$request->site_id;
        $divi_id=$request->divi_id;
        $dep_id=$request->dep_id;  
        $site_type=2;      
        $sub_parent =$site_id;
        $Field_name='Division name'; 
        $Sites=Sites::where('id',$request->site_id)->first();
        $Users=UserByTennat::where('status',1)->get();
        if(!$Sites){
            return Redirect::route('sites')->with('error',__('Site not found.'));
        }
        if($request->is('sites/*/adddivisions')){
            $page_title='Site Divisions'; 
            $Field_name=__('Division name');
            $sub_parent =$site_id;
            $site_type=2;           
        }
        if($request->is('sites/*/*/adddepartment')){            
            $page_title='Site Department';            
            $Field_name=__('Department name'); 
            $sub_parent =$divi_id;
            $site_type=3;
        }
        if($request->is('sites/*/*/addunit')){
            $page_title='Site Unit'; 
            $Field_name=__('Unit name'); 
            $sub_parent =$dep_id;           
            $site_type=4;
        }        
        return view('sites.createsubarea', compact('Sites','page_title','Users','cuser','site_id','divi_id','dep_id','site_type','Field_name','sub_parent'));                        
    }    

    public function PostSubArea(Request $request)
    {   
        $cuser = Auth::user();
        $validatedData = $request->validate([
            'site_name' => ['required'],            
            'site_headofsafety' => ['required'],
            'site_supervisor' => ['required'],
            'status' => ['required'],
        ]);  

        $Sites = new \App\Sites;
        $Sites->site_name = $request->site_name;
        $Sites->site_parent = $request->site_parent;        
        $Sites->sub_parent = $request->sub_parent;        
        
        $Sites->site_supervisor = $request->site_supervisor;                
        $Sites->site_type = $request->site_type;                
        $Sites->status = $request->status;
        $Sites->save(); 

        $id=$Sites->id;    
        $site_headofsafety=array();
        if($request->site_headofsafety){
            foreach ($request->site_headofsafety as $key => $value) {
                $single=array();
                $single['sh_site_id']=$id;
                $single['sh_user_id']=$value;
                $site_headofsafety[]=$single;
            }
            DB::table('site_headofsafety')->insert($site_headofsafety);                  
        }

        if($request->site_type==2){$msg=__('Site Divisions successfully added');}
        if($request->site_type==3){$msg=__('Site Department successfully added');}
        if($request->site_type==4){$msg=__('Site Unit successfully added');}          
        return Redirect::route('getdivisions',['id'=>$request->site_parent])->with('success',$msg);
    }

    public function PostSubAreaUpdate(Request $request)
    {   
        $cuser = Auth::user();
        $validatedData = $request->validate([
            'site_name' => ['required'],            
            'site_headofsafety' => ['required'],
            'site_supervisor' => ['required'],
            'status' => ['required'],
        ]);  
        $site_parent=$request->site_parent;
        $site_type=$request->site_type;

        if($site_type==2){$msg=__('Site Divisions successfully Updated');}
        if($site_type==3){$msg=__('Site Department successfully Updated');}
        if($site_type==4){$msg=__('Site Unit successfully Updated');}

        $Sites =  \App\Sites::find($request->id);    
        $Sites->site_name = $request->site_name;        
        
        $Sites->site_supervisor = $request->site_supervisor;                        
        $Sites->status = $request->status;
        $Sites->save();           
        $id=$request->id;
        $site_headofsafety=array();
        if($request->site_headofsafety){
            DB::table('site_headofsafety')->where('sh_site_id',$id)->delete();   
            foreach ($request->site_headofsafety as $key => $value) {
                $single=array();
                $single['sh_site_id']=$id;
                $single['sh_user_id']=$value;
                $site_headofsafety[]=$single;
            }
            DB::table('site_headofsafety')->insert($site_headofsafety);                  
        }

        return Redirect::route('getdivisions',['id'=>$site_parent])->with('success',$msg);
    }

    public function deleteArea(Request $request,$id)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Sites Delete')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }        
        
        $Sites0=Sites::where('sub_parent',$request->id)->orderby('id','asc')->get();
        if($Sites0){
            foreach ($Sites0 as $key => $Sites0value) { 
                Sites::where('id',$Sites0value->id)->delete();               
                $Sites1=Sites::where('sub_parent',$Sites0value->id)->orderby('id','asc')->get();
                if($Sites1){
                    foreach ($Sites1 as $key => $Sites1value) {
                        Sites::where('id',$Sites1value->id)->delete();               
                        $Sites2=Sites::where('sub_parent',$Sites1value->id)->orderby('id','asc')->get();
                        if($Sites2){
                            foreach ($Sites2 as $key => $Sites2value) {
                                Sites::where('id',$Sites2value->id)->delete();               
                            }                
                        }    
                    }
                }    

            }
        }
                
        Sites::where('id',$id)->delete();
        Sites::where('site_parent',$id)->delete();
        DB::table('site_headofsafety')->where('sh_site_id',$id)->delete();   
        return Redirect::back()->with('success',__('Area successfully deleted.'));
    }

}
