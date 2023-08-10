<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\UserByTennat;
use App\Observation;
use App\Incident;
use App\Actions;
use App\CategoryType;
use App\Category;
use App\Sites;
use App\Control;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail;
use App;

class ActionsControllers extends Controller
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
    public function index(Request $request)
    {
        $cuser = Auth::user();  $filterdatestart='';  $filterdateend='';
        if(!$cuser->can('Actions') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        //dd($cuser->hasRole('Super Admin')); 

        $filterdate=$request->filterdate;
        $filtersite=$request->filtersite;
        
        if($request->filtercat){
            $filtercat=array($request->filtercat);
        }else{
            if($cuser->hasRole('Super Admin')){
                $filtercat=array(1,2,3,4);
            }else{
                $filtercat=array();
                if($cuser->can('Observations')){$filtercat[]=1;}
                if($cuser->can('Incident')){$filtercat[]=2;}
                if($cuser->can('Audit')){$filtercat[]=4;}
                
            }    
            
        }
        if($filterdate!=''){
            $filterdaterange=explode(' - ', $filterdate);
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));
        }

        if($request->filtersite){
            $filtersite=array();
            $Sites = Sites::where('status',1)->where('id',$request->filtersite)->first(); 
            $filtersite[]=$Sites->id;
            /*$filtersite[]=$Sites->sub_parent;
            $filtersite[]=$Sites->site_parent;*/
            if($Sites->site_type==1){
                $SitesOne = Sites::where('status',1)->where('site_parent',$Sites->id)->get(); 
                foreach ($SitesOne as $key => $value) {
                    $filtersite[]=$value->id;                    
                }
            }
            if($Sites->site_type==2){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;

                    
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                        
                    
                }
            }

            if($Sites->site_type==3){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                        
                    
                }
            }

            

        }
        
        $status=1;
        if ($request->ajax()) {  $status=$request->status; }
        $actionsids=array();
        if(!$cuser->hasRole('Super Admin')){
            $responsibilityactions=DB::table('actions_responsible')->where('user_id',$cuser->id)->get();
            if($responsibilityactions){
                foreach ($responsibilityactions as $key => $value) {
                   $actionsids[]=$value->am_id;
                }
            }
            $actions_master=DB::table('actions_master')->where('am_created_by',$cuser->id)->get();
            if($actions_master){
                foreach ($actions_master as $key => $value) {
                    $actionsids[]=$value->am_id;
                }
            }
        }

        $ActionsOpen= DB::table('actions_master as am');
        $ActionsOpen->select('am.*', 'u.name','.ims.site_name as im_site_name','s.site_name','adms.site_name as auditsitename','imc.category_name as im_category_name','admc.category_name as audit_category_name','c.category_name','om.ob_srno','om.oc_id','om.ob_id','om.site_id','om.description as ob_description','om.obdatetime','om.riskpotentiallevel','im.im_id','im.im_srno','im.im_site_id','im.im_ic_id','im.im_description','im.im_datetime','im.created_at as im_created_at','sm.sm_name','ir.rating','ir.severity','ir.likelihood','ir.rating_text','ir.rating_type','adm.adm_id','adm.adm_srno','adm.adm_ac_id','adm_site_id','adm.adm_start_from','adm.adm_start_from','adm.adm_status');
        $ActionsOpen->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $ActionsOpen->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $ActionsOpen->leftJoin('incidents_master as im', 'im.im_id', '=', 'am.am_parent_id');    
        $ActionsOpen->leftJoin('audit_master as adm', 'adm.adm_id', '=', 'am.am_parent_id');    
        $ActionsOpen->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $ActionsOpen->leftJoin('sites as ims', 'ims.id', '=', 'im.im_site_id');
        $ActionsOpen->leftJoin('sites as adms', 'adms.id', '=', 'adm.adm_site_id');
        $ActionsOpen->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $ActionsOpen->leftJoin('category as imc', 'imc.id', '=', 'im.im_ic_id');
        $ActionsOpen->leftJoin('category as admc', 'admc.id', '=', 'adm.adm_ac_id');
        $ActionsOpen->leftJoin('shift_master as sm', 'sm.sm_id', '=', 'im.im_shift');
        $ActionsOpen->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $ActionsOpen->whereNull('am.deleted_at') ;
        $ActionsOpen->where('am.am_status',$status) ;
        if(!$cuser->hasRole('Super Admin') ){
            $ActionsOpen->whereIN('am.am_id',$actionsids) ;
        }        
        if($filtersite!=''){    $ActionsOpen->whereIn('am.am_site_id',$filtersite);            }
        if($filterdate!=''){  $ActionsOpen->whereBetween('am_due_date', [$filterdatestart,$filterdateend]); }        
        if($filtercat!=''){   $ActionsOpen->whereIn('am.am_module_type',$filtercat);    }
        $ActionsOpen= $ActionsOpen->get();         
        if($request->ajax()) {
            return view('actions.actionsajax', compact('ActionsOpen','cuser'));    
        }

        $category = Category::where('type_id',1)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $page_title='Actions';
        return view('actions.actions',compact('category','page_title','ActionsOpen','filtersite','filterdate','filtercat','Sites','cuser'));
    }

    public function create()
    {      
        return Redirect::route('actions')->with('error',__('Action not found.'));     
        $Observation = Observation::where('action_required',1)->where('status',1)->get();
        $Users=UserByTennat::where('status',1)->get();
        $Control=Control::where('cm_status',1)->get();
        $page_title='Create Action';
        return view('actions.create', compact('Observation','page_title','Users','Control'));
    }

    public function store(Request $request)
    {    
        $cuser = Auth::user(); 
        $customMessages = [
            'parent_id.required'=> __('Observation is Required'), // custom message
            'description.min'=> __('The description field is required.'), // custom message
            'user_id.required'=> __('The Responsibility field is required.'), // custom message            
        ];

        $validatedData = $request->validate([
            'parent_id' => ['required'],
            'user_id' => ['required'],
            'description' => ['required'],
            'control' => ['required'],            
        ],$customMessages);

        $parentuser = Auth::user(); 
        $Actions = new \App\Actions;
        $Actions->am_parent_id = $request->parent_id;
        $Actions->am_module_type = 1;
        $Actions->am_description = $request->description;
        $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($request->due_date));
        $Actions->am_control = $request->control;
        $Actions->am_remark = $request->remark;
        $Actions->am_status = $request->status;        
        $Actions->am_created_by = $parentuser->id;
        $Actions->save(); 
        $am_id=$Actions->am_id;        
        
        if($request->user_id){
            $ararr=array();
            foreach ($request->user_id as $key => $user_id_value) {
                $single=array();
                $single['am_id']= $am_id;
                $single['user_id']=$user_id_value;
                $ararr[]=$single;
            }
            DB::table('actions_responsible')->insert($ararr);    
        }

        if($request->attached){
            $attached=array();
            foreach ($request->attached as $key => $attached_value) {                
                $attachament = Storage::putFile('public/'.$parentuser->companyname, $attached_value);                    
                $single=array();    
                $single['am_id']= $am_id;
                $single['attachament']=str_replace('public/', '', $attachament);
                $attached[]=$single;
            }
            DB::table('actions_attachement_rel')->insert($attached);    
        }        
        return Redirect::route('actions')->with('success',__('Action successfully added.'));
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();
        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'cm.cm_name', 'ct.ct_name');        
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');                
        $Actions->leftJoin('category_type as ct', 'ct.ct_id', '=', 'am.am_module_type');                
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_id',$request->id) ;
        $Actions= $Actions->first(); 
        if(empty($Actions)){
            return Redirect::route('actions')->with('error',__('Action not found.'));   
        }        
        $actions_responsible=array('none');
        $actions_responsible_arr=DB::table('actions_responsible')->select('user_id')->where('am_id',$request->id)->get();   
        if($actions_responsible_arr){
            foreach ($actions_responsible_arr as $key => $value) { 
                $actions_responsible[]=$value->user_id;
            }
        }

        $actions_attachement_rel=DB::table('actions_attachement_rel')->where('am_id',$request->id)->get(); 
        $Users=UserByTennat::where('status',1)->get();
        $Control=Control::where('cm_status',1)->get();       
        $page_title='Edit Action';
        return view('actions.edit', compact('page_title','Actions','actions_responsible','actions_attachement_rel','Users','Control','cuser'));
    }

    public function update(Request $request)
    {     
        
        $validatedData = $request->validate([            
            'user_id' => ['required'],
            'description' => ['required'],
            'control' => ['required'],            
        ]);

        $parentuser = Auth::user(); 
        $am_id=$request->am_id;        
        $Actions =  \App\Actions::find($am_id);           
        $Actions->am_description = $request->description;
        $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($request->due_date));
        $Actions->am_control = $request->control;
        $Actions->am_remark = $request->remark;
        $Actions->am_status = $request->status;                
        $Actions->save();
        $usernames = array();
        if($request->user_id){
            $ararr=array();
            DB::table('actions_responsible')->where('am_id',$am_id)->delete();
            foreach ($request->user_id as $key => $user_id_value) {
                $single=array();    
                $single['am_id']= $am_id;
                $single['user_id']=$user_id_value;
                $ararr[]=$single;
                 $usernames[] = get_user_field($user_id_value, 'name');
            }
            DB::table('actions_responsible')->insert($ararr);    
        }


        $attachedimgname=$request->attachedimgname;        
        if($request->attachedmain && !empty($attachedimgname)){            
            $attached=array();
            $attachedimgname=array_unique($attachedimgname);
            foreach ($request->attachedmain as $key => $attached_value) {                 
                if (in_array($attached_value->getClientOriginalName(), $attachedimgname)) 
                {  
                    $pos = array_search($attached_value->getClientOriginalName(), $attachedimgname);
                    unset($attachedimgname[$pos]);                    
                    $attachament = Storage::putFile('public/'.$parentuser->companyname, $attached_value);                    
                    $single=array();    
                    $single['am_id']=$am_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('actions_attachement_rel')->insert($attached);    
        }


        $ActionsOpen= DB::table('actions_master as am');
        $ActionsOpen->select('am.*', 'u.name','.ims.site_name as im_site_name','s.site_name','adms.site_name as auditsitename','imc.category_name as im_category_name','admc.category_name as audit_category_name','c.category_name','om.ob_srno','om.oc_id','om.ob_id','om.site_id','om.description as ob_description','om.obdatetime','om.riskpotentiallevel','im.im_id','im.im_srno','im.im_site_id','im.im_ic_id','im.im_description','im.im_datetime','im.created_at as im_created_at','sm.sm_name','ir.rating','ir.severity','ir.likelihood','ir.rating_text','ir.rating_type','adm.adm_id','adm.adm_srno','adm.adm_ac_id','adm_site_id','adm.adm_start_from','adm.adm_start_from','adm.adm_status');
        $ActionsOpen->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $ActionsOpen->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $ActionsOpen->leftJoin('incidents_master as im', 'im.im_id', '=', 'am.am_parent_id');    
        $ActionsOpen->leftJoin('audit_master as adm', 'adm.adm_id', '=', 'am.am_parent_id');    
        $ActionsOpen->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $ActionsOpen->leftJoin('sites as ims', 'ims.id', '=', 'im.im_site_id');
        $ActionsOpen->leftJoin('sites as adms', 'adms.id', '=', 'adm.adm_site_id');
        $ActionsOpen->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $ActionsOpen->leftJoin('category as imc', 'imc.id', '=', 'im.im_ic_id');
        $ActionsOpen->leftJoin('category as admc', 'admc.id', '=', 'adm.adm_ac_id');
        $ActionsOpen->leftJoin('shift_master as sm', 'sm.sm_id', '=', 'im.im_shift');
        $ActionsOpen->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $ActionsOpen->whereNull('am.deleted_at') ;
        $ActionsOpen->where('am.am_id',$am_id) ;
        $ActionsOpen= $ActionsOpen->first();

        //For Mail
        $mlaction = array();
        $mlaction['description'] = $ActionsOpen->am_description;
        $mlaction['control'] = get_control_field($ActionsOpen->am_control, 'cm_name');
        $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($ActionsOpen->am_due_date));                     

        $mlstatus = GetActionStatusEmail($ActionsOpen->am_status);

        $mlaction['status'] = $mlstatus;
        $mlaction['remarks'] = $ActionsOpen->am_remark;
        $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';   
        $sitesname= get_site_field($ActionsOpen->am_site_id, 'site_name');             
        
        if($request->user_id){                    
                    foreach ($request->user_id as $keysub => $user_id_value) {
                        $EmailUsers=get_user_all_field($user_id_value);
                        if($EmailUsers){
                            App::setLocale($EmailUsers->planguage);                            
                            $subject = __($mlstatus).': '.__('An action has been updated');
                            $useremail = $EmailUsers->email;
                            $username = $EmailUsers->name;
                            Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                                $m->to($useremail, $username)->subject($subject);
                            });  
                        }
                    }                    
                }

        return view('actions.actionssingle', compact('ActionsOpen'));

    }

    public function delete($id)
    {        
        Actions::where('am_id',$id)->delete();    
        return $id;    
        return Redirect::route('actions')->with('success',__('Action successfully deleted.'));
    }

    public function DeleteFile($id)
    {   
        $actions_attachement_rel=DB::table('actions_attachement_rel')->where('aa_id',$id)->first();
        Storage::delete('public/'.$actions_attachement_rel->attachament);
        DB::table('actions_attachement_rel')->where('aa_id',$id)->delete();   
        return $id;                        
    }

    public function Details(Request $request)
    {                     
        $parentuser = Auth::user(); 
        $am_id=$request->id;                
        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'cm.cm_name', 'ct.ct_name');        
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');                
        $Actions->leftJoin('category_type as ct', 'ct.ct_id', '=', 'am.am_module_type');                
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_id',$am_id) ;
        $Actions= $Actions->first(); 
        $actions_attachement_rel=DB::table('actions_attachement_rel')->where('am_id',$am_id)->get(); 
        return view('actions.actionsdetails', compact('Actions','actions_attachement_rel'));

    }

    public function DetailsUpdate(Request $request)
    {     
        $parentuser = Auth::user(); 
        $am_id=$request->am_id;  

        $Actions =  \App\Actions::find($am_id);           
        $old_status= $Actions->am_status;
        $old_remark= $Actions->am_remark;     
        $Actions->am_remark = $request->remark;
        $Actions->am_status = $request->status;                
        $Actions->save(); 

        if($old_status!=$request->status || $old_remark!=$request->remark){

            $ActionsOpen= DB::table('actions_master as am');
            $ActionsOpen->select('am.*', 'u.name','.ims.site_name as im_site_name','s.site_name','adms.site_name as auditsitename','imc.category_name as im_category_name','admc.category_name as audit_category_name','c.category_name','om.ob_srno','om.oc_id','om.ob_id','om.site_id','om.description as ob_description','om.obdatetime','om.riskpotentiallevel','im.im_id','im.im_srno','im.im_site_id','im.im_ic_id','im.im_description','im.im_datetime','im.created_at as im_created_at','sm.sm_name','ir.rating','ir.severity','ir.likelihood','ir.rating_text','ir.rating_type','adm.adm_id','adm.adm_srno','adm.adm_ac_id','adm_site_id','adm.adm_start_from','adm.adm_start_from','adm.adm_status');
            $ActionsOpen->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
            $ActionsOpen->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
            $ActionsOpen->leftJoin('incidents_master as im', 'im.im_id', '=', 'am.am_parent_id');    
            $ActionsOpen->leftJoin('audit_master as adm', 'adm.adm_id', '=', 'am.am_parent_id');    
            $ActionsOpen->leftJoin('sites as s', 's.id', '=', 'om.site_id');
            $ActionsOpen->leftJoin('sites as ims', 'ims.id', '=', 'im.im_site_id');
            $ActionsOpen->leftJoin('sites as adms', 'adms.id', '=', 'adm.adm_site_id');
            $ActionsOpen->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
            $ActionsOpen->leftJoin('category as imc', 'imc.id', '=', 'im.im_ic_id');
            $ActionsOpen->leftJoin('category as admc', 'admc.id', '=', 'adm.adm_ac_id');
            $ActionsOpen->leftJoin('shift_master as sm', 'sm.sm_id', '=', 'im.im_shift');
            $ActionsOpen->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
            $ActionsOpen->whereNull('am.deleted_at') ;
            $ActionsOpen->where('am.am_id',$am_id) ;
            $ActionsOpen= $ActionsOpen->first(); 

            $actions_responsible=array('none');
            $usernames=array();
            $actions_responsible_arr=DB::table('actions_responsible')->select('user_id')->where('am_id',$am_id)->get();   
            if($actions_responsible_arr){
                foreach ($actions_responsible_arr as $key => $value) { 
                    $actions_responsible[]=$value->user_id;
                    $usernames[] = get_user_field($value->user_id, 'name');
                }
            }

            //For Mail
            $mlaction = array();
            $mlaction['description'] = $ActionsOpen->am_description;
            $mlaction['control'] = get_control_field($ActionsOpen->am_control, 'cm_name');
            $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($ActionsOpen->am_due_date));                     

            $mlstatus = GetActionStatus($ActionsOpen->am_status);

            $mlaction['status'] = $mlstatus;
            $mlaction['remarks'] = $ActionsOpen->am_remark;
            $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';   
            $sitesname= get_site_field($ActionsOpen->am_site_id, 'site_name');             
            
            if($actions_responsible){                    
                foreach ($actions_responsible as $keysub => $user_id_value) {
                    $EmailUsers=get_user_all_field($user_id_value);
                    if($EmailUsers){
                        App::setLocale($EmailUsers->planguage);                            
                        $subject = __($mlstatus).': '.__('An action has been updated');
                        $useremail = $EmailUsers->email;
                        $username = $EmailUsers->name;
                        Mail::send('email.action_update', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                            $m->to($useremail, $username)->subject($subject);
                        });  
                    }
                }                    
            }
        }
            
        return $request->status; 
    }
}