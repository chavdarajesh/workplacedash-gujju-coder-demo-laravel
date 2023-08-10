<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\UserByTennat;
use App\Observation;
use App\Incident;
use App\CategoryType;
use App\Category;
use App\Actions;
use App\Sites;
use App\Shift;
use App\VictimType;
use App\BodyPart;
use App\Victim;
use App\RootCause;
use App\RootCauseItem;
use App\Control;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail;
use App;

class IncidentsControllers extends Controller
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
        if(!$cuser->can('Incident') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }

        $filterdate=$request->filterdate;
        $filtersite=$request->filtersite;
        $filtercat=$request->filtercat;

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
        if ($request->ajax()) {  $status=($request->status==0)?0:1; }
        $riskpotentiallevel=$request->riskpotentiallevel;        
        if($filterdate!=''){
            $filterdaterange=explode(' - ', $filterdate);
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));
        }

        $incidents1= DB::table('incidents_master as im');
        $incidents1->select('im.*', 'u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text');
        $incidents1->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $incidents1->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $incidents1->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $incidents1->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $incidents1->whereNull('im.deleted_at') ;
        $incidents1->where('im.im_status',$status) ;
        if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   $incidents1->where('ir.rating_type',$riskpotentiallevel);    }
        if($filtersite!=''){  $incidents1->whereIn('im.im_site_id',$filtersite) ;   }        
        if($filterdate!=''){  $incidents1->whereBetween('im.created_at', [$filterdatestart,$filterdateend]); }
        if($filtercat!=''){   $incidents1->where('im.im_ic_id',$filtercat);    }
        if(!$cuser->hasRole('Super Admin')){$incidents1->where('im.im_created_by',$cuser->id) ;}             
        $IncidentsOpen= $incidents1->get();        
        if ($request->ajax()) {
            return view('incidents.incidentsajax', compact('IncidentsOpen','cuser'));    
        }
        
        $category = Category::where('type_id',2)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $Shifts = Shift::where('sm_status',1)->get();
        $page_title='Incidents';
        return view('incidents.incidents',compact('category','page_title','Sites','IncidentsOpen','filtersite','filterdate','filtercat','cuser','Shifts'));
    }

    public function create()
    {
        $cuser = Auth::user();
        if(!$cuser->can('Incident Add') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }

        $category = Category::where('type_id',2)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $Shifts = Shift::where('sm_status',1)->get();
        $page_title='Create Incident';
        return view('incidents.create', compact('category','page_title','Sites','Shifts','cuser'));
    }

    public function store(Request $request)
    {   
        $cuser = Auth::user();  
        $customMessages = [
            'im_ic_id.required'=> __('Select incident type is Required'), // custom message            
        ];
                
        $validatedData = $request->validate([
            'im_ic_id' => ['required'],
            'im_description' => ['required'],
            'im_site_id' => ['required'],
            'im_shift' => ['required'],
            'im_datetime' => ['required'],            
        ],$customMessages);

        $parentuser = Auth::user(); 
        $Incident = new \App\Incident;        
        $Incident->im_site_id = $request->im_site_id;
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;        
        $Incident->im_created_by = $parentuser->id;
        $Incident->im_status = 1;
        $Incident->save(); 
        $im_id=$Incident->im_id;
        $im_srno='INC'.str_pad($parentuser->companyid, 2, '0', STR_PAD_LEFT).str_pad( $im_id, 4, '0', STR_PAD_LEFT);

        DB::table('incidents_master')->where('im_id', $im_id)->update(['im_srno' => $im_srno]);        

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
                    $single['im_id']=$im_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('incidents_attachement_rel')->insert($attached);    
        }

        $incidents1= DB::table('incidents_master as im');
        $incidents1->select('im.*', 'u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text');
        $incidents1->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $incidents1->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $incidents1->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $incidents1->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $incidents1->whereNull('im.deleted_at') ;
        $incidents1->where('im.im_id',$im_id) ;        
        $Incident_value= $incidents1->first(); 
        $new=1;  



        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
        $incidents['description'] = $request->im_description;
        $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');                        

        

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                App::setLocale($ademl->planguage); 
                $subject = __('New incidents report created');
                $useremail = $ademl->email;
                $username = $ademl->name;
                Mail::send('email.incidents', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
        
            

            $headid = GetHeadofSafetyEmailName($request->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name'];    
                    App::setLocale($value['planguage']); 
                    $subject = __('New incidents report created');
                    Mail::send('email.incidents', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }    

            
        




        return view('incidents.incidentssingle', compact('Incident_value','cuser','new'));
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Incident Edit') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        $Incident = Incident::where('im_id',$request->id)->first();
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Incident->im_created_by)){
            return Redirect::route('dashboard')->with('error','You can not access this section.'); 
        }

        
        if(empty($Incident)){
            return Redirect::route('incidents')->with('error',__('Incident not found.'));   
        }                
        $incidents_attachement_rel=DB::table('incidents_attachement_rel')->where('im_id',$request->id)->get();
        $category = Category::where('type_id',2)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $Users=UserByTennat::where('status',1)->get();        
        $Shifts = Shift::where('sm_status',1)->get();
        $page_title='Edit Incident';
        return view('incidents.edit', compact('category','page_title','Sites','Incident','incidents_attachement_rel','Users','Shifts','cuser'));
    }

    public function update(Request $request)
    {    
        $cuser = Auth::user(); 
        $customMessages = [
            'im_ic_id.required'=> __('Select incident type is Required'), // custom message            
        ];
        $validatedData = $request->validate([
            'im_ic_id' => ['required'],
            'im_description' => ['required'],
            'im_site_id' => ['required'],
            'im_shift' => ['required'],
            'im_datetime' => ['required'],            
        ]);

        $parentuser = Auth::user(); 
        $im_id=$request->im_id;        
        $Incident =  \App\Incident::find($im_id);   
        $Incident->im_site_id = $request->im_site_id;
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;                        
        $Incident->save(); 
        
        DB::table('actions_master')->where('am_parent_id', $im_id)->where('am_module_type',2)->update(['am_site_id' => $request->im_site_id]);

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
                    $single['im_id']=$im_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('incidents_attachement_rel')->insert($attached);    
        }                   
        
        $incidents1= DB::table('incidents_master as im');
        $incidents1->select('im.*', 'u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text');
        $incidents1->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $incidents1->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $incidents1->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $incidents1->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $incidents1->whereNull('im.deleted_at') ;
        $incidents1->where('im.im_id',$im_id) ;        
        $Incident_value= $incidents1->first(); 
        $new=0; 

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
        $incidents['description'] = $request->im_description;
        $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');                        

        $subject = __('Incidents report updated.');

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Incidents report updated.');
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
            $headid = GetHeadofSafetyEmailName($request->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name'];  
                    App::setLocale($value['planguage']); 
                    $subject = __('Incidents report updated.');  
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }    

                      
        return view('incidents.incidentssingle', compact('Incident_value','cuser','new'));
    }

    public function UpdateRating(Request $request)
    {   
        $cuser = Auth::user();  
        $customMessages = [
            'im_ratinganincident.required'=> __('Select Incident Classification Matrix is Required'), // custom message            
            'im_investigationisrequired.required'=> __('Select Investigation Investigation required is Required'), // custom message            
        ];
        $validatedData = $request->validate([
            'im_ratinganincident' => ['required'],
            'im_investigationisrequired' => ['required'],        
        ],$customMessages);
        
        $im_id=$request->im_id;        
        $Incident =  \App\Incident::find($im_id);   
        $Incident->im_ratinganincident = $request->im_ratinganincident;
        $Incident->im_investigationisrequired = $request->im_investigationisrequired;
        $Incident->save(); 

        $incidents1= DB::table('incidents_master as im');
        $incidents1->select('im.*', 'u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text');
        $incidents1->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $incidents1->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $incidents1->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $incidents1->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $incidents1->whereNull('im.deleted_at') ;
        $incidents1->where('im.im_id',$im_id) ;        
        $Incident_value= $incidents1->first();     
        $new=0;        
        return view('incidents.incidentssingle', compact('Incident_value','cuser','new'));
    }

    public function delete($id)
    { 
        $cuser = Auth::user();
        $Incident = Incident::where('im_id',$id)->first();
        if(!$cuser->can('Incident Delete') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Incident->im_created_by)){
            return Redirect::route('dashboard')->with('error','You can not access this section.'); 
        }
        Incident::where('im_id',$id)->delete(); 
        return $id;       
        //return Redirect::route('incidents')->with('success','incident successfully deleted.');
    }

    public function DeleteFile($id)
    {   
        $incidents_attachement_rel=DB::table('incidents_attachement_rel')->where('ia_id',$id)->first();
        Storage::delete('public/'.$incidents_attachement_rel->attachament);
        DB::table('incidents_attachement_rel')->where('ia_id',$id)->delete();  
        return $id;                         
    }

    public function Details($id,$step)
    {
        $cuser = Auth::user();
        if(!$cuser->can('Incident') && !$cuser->hasRole('Super Admin')){return Redirect::route('dashboard')->with('error',__('You can not access this section.')); }

        if($step>=6){
          return Redirect::route('incidentsdetails',array('id'=>$id,'step'=>1));       
        }            
        $Incident= DB::table('incidents_master as im');
        $Incident->select('im.*','u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text','ir.severity','ir.likelihood');
        $Incident->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $Incident->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $Incident->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $Incident->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $Incident->whereNull('im.deleted_at') ;        
        $Incident->where('im.im_id',$id) ;        
        $Incident->WhereNotNull('im.im_ratinganincident') ;        
        $Incident= $Incident->first();
        if(empty($Incident)){
            return Redirect::route('incidents')->with('error','Before incident edit you have to set rating first.');   
        }

        if($Incident->im_investigationisrequired!=1 && $step>1){
            return Redirect::route('incidentsdetails',array('id'=>$id,'step'=>1));       
        }    
        if($Incident->im_lastsubmitedstep==''){
            if($step!=1){
                return Redirect::route('incidentsdetails',array('id'=>$id,'step'=>1))->with('error','Please complete this step first');       
            }            
        }else{
            $laststep=$Incident->im_lastsubmitedstep+1;
            if($step>($laststep)){
                return Redirect::route('incidentsdetails',array('id'=>$id,'step'=>$laststep))->with('error','Please complete this step first');       
            }
            if($step==5 && $Incident->im_actionapproved!=1){
                return Redirect::route('incidentsdetails',array('id'=>$id,'step'=>4))->with('error','You can proceed to “Step 5: Review and Closure” only after all approvals are obtained from authorized users.');         
            } 
        }
        $Control=''; $Actions=''; $UsersApproval='';
        $category = Category::where('type_id',2)->orderby('parent_id','asc')->get();
        $incidents_attachement_rel=DB::table('incidents_attachement_rel')->where('im_id',$id)->get();
        $Sites = Sites::where('status',1)->get();
        $Users= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')    
        ->get();

        $InvestigationTeam= DB::table('incidents_investigation_team as iit')
        ->select('iit.*', 'u.name')
        ->leftJoin('users as u', 'u.id', '=', 'iit.iit_user_id')
        ->where('iit.iit_im_id',$id)    
        ->get();   

        $AddedVictims=array();
        if($step==1){
            $AddedVictims= DB::table('incidents_victim as iv')
            ->select('iv.*', 'vt.vtm_name',DB::raw('COUNT(ivbp.ivbp_iv_id) AS bodypart_count'))
            ->leftJoin('victimtype_master as vt', 'vt.vtm_id', '=', 'iv.iv_vtm_id')
            ->leftJoin('incidents_victim_bodypart as ivbp', 'ivbp.ivbp_iv_id', '=', 'iv.iv_id')
            ->where('iv.iv_im_id',$id) 
            ->groupBy('iv.iv_id')   
            ->get(); 
            $Actions = Actions::where('am_parent_id',$id)->where('am_module_type',2)->get();               
        }
        $incidents_investigation_team=array();
        if($step==2){
            $incidents_investigation_team_data=DB::table('incidents_investigation_team')->select('iit_user_id')->where('iit_im_id',$id)->get();
            foreach ($incidents_investigation_team_data as $key => $incidents_investigation_team_datavalue) {
                $incidents_investigation_team[]=$incidents_investigation_team_datavalue->iit_user_id;
            }
        }
        $RootCause=array(); $RootCauseItem=array(); $AddedRootCauseItem=array('none'); $AddedRootCauseDesciption=array();
        if($step==3){
            $RootCause=RootCause::where('rc_status',1)->get();
            foreach ($RootCause as $key => $RootCause_value) {
                $RootCauseItem[$RootCause_value->rc_id]= RootCauseItem::where('rci_rc_id',$RootCause_value->rc_id)->orderby('rci_parent_id','asc')->get()->toArray();
                $AddedRootCauseDesciption[$RootCause_value->rc_id]='';
            }
            $AddedRootCauseItemArr=DB::table('incidents_root_cause')->select('irc_rcid')->where('irc_im_id',$id)->get()->toArray();
            foreach ($AddedRootCauseItemArr as $key => $AddedRootCauseItemArr_value) {
                $AddedRootCauseItem[]=$AddedRootCauseItemArr_value->irc_rcid;
            }
            $AddedRootCauseDescArr=DB::table('incidents_root_cause_description')->where('ircd_im_id',$id)->get()->toArray();            
            if($AddedRootCauseDescArr){                
                foreach ($AddedRootCauseDescArr as $key => $AddedRootCauseDescArr_value) {
                    $AddedRootCauseDesciption[$AddedRootCauseDescArr_value->ircd_rcid]=$AddedRootCauseDescArr_value->ircd_text;
                }   
            }
        }
        
        if($step==4 || $step==5){
            $Control=Control::where('cm_status',1)->get();
            $Actions = Actions::where('am_parent_id',$id)->where('am_module_type',2)->get();
            $UsersApproval= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')    
        ->where('users.id',1)    
        ->first();
        }        
        $Shifts = Shift::where('sm_status',1)->get();
        $page_title=__('Incident').' : '.$Incident->im_srno;

        if($Incident->im_investigationisrequired!=1){
            $Control=Control::where('cm_status',1)->get();
            $Shifts = Shift::where('sm_status',1)->get();    

                return view('incidents.stepnonivistigation', compact('category','page_title','Sites','Incident','incidents_attachement_rel','Users','Shifts','step','incidents_investigation_team','RootCause','RootCauseItem','AddedRootCauseItem','AddedRootCauseDesciption','InvestigationTeam','Control','Actions','UsersApproval','AddedVictims','cuser'));            
        }

        return view('incidents.step'.$step, compact('category','page_title','Sites','Incident','incidents_attachement_rel','Users','Shifts','step','incidents_investigation_team','RootCause','RootCauseItem','AddedRootCauseItem','AddedRootCauseDesciption','InvestigationTeam','Control','Actions','UsersApproval','AddedVictims','cuser'));
    }

    public function AddVictim(Request $request)
    {   
        $cuser = Auth::user();
        $srno= $request->srno;    
        $Users=UserByTennat::where('status',1)->get();  
        $VictimType=VictimType::where('vtm_status',1)->get();          
        $BodyPart=BodyPart::where('bpm_status',1)->get();          
        return view('incidents.victim_create', compact('Users','srno','VictimType','BodyPart','cuser'));
    }

    public function AddAction(Request $request)
    {   
        $cuser = Auth::user();
        $insrno= $request->insrno;    
        $Users= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')    
        ->get();
        $Control=Control::where('cm_status',1)->get();             
        return view('incidents.action_create', compact('Users','insrno','Control'));
    }

    public function StepOne(Request $request)
    {
        $cuser = Auth::user();     
        $customMessages = [
            'im_ic_id.required'=> 'Select incident type is Required', // custom message            
        ];
        $validatedData = $request->validate([
            'im_ic_id' => ['required'],
            'im_description' => ['required'],            
            'im_shift' => ['required'],
            'im_datetime' => ['required'],            
            'im_immediateactiontaken' => ['required'],            
        ],$customMessages);

        $parentuser = Auth::user(); 
        $im_id=$request->im_id; 
        $step=$request->step;         
        $Incident =  \App\Incident::find($im_id);           
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;                        
        $Incident->im_immediateactiontaken = $request->im_immediateactiontaken;                        
        $Incident->im_machineno_extralocation = $request->im_machineno_extralocation;     
        $Incident->im_extendofdamange = $request->im_extendofdamange;  
        $Incident->im_anyvictim = $request->im_anyvictim;                                  
        $Incident->im_lastsubmitedstep = 1;                                  
        $Incident->save();         

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
                    $single['im_id']=$im_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('incidents_attachement_rel')->insert($attached);    
        }    

        //Add Victim Start
        if($request->srno && $request->im_anyvictim==1){
            $iv_vtm_id= $request->iv_vtm_id;   
            $iv_name= $request->iv_name;            
            $iv_gender= $request->iv_gender;   
            $iv_age_range= $request->iv_age_range;   
            $bpm_id= $request->bpm_id;   
            $iv_details_injury= $request->iv_details_injury; 
            $iv_taken_hospital= $request->iv_taken_hospital; 
            $iv_when_returntowork= $request->iv_when_returntowork; 
            $iv_details_treatment= $request->iv_details_treatment; 
            $srno= $request->srno; 
            
            foreach ($srno as $key => $i) {                
                $Victim = new \App\Victim;
                $Victim->iv_im_id = $im_id;                
                $Victim->iv_vtm_id = $iv_vtm_id[$i];                
                $Victim->iv_name = $iv_name[$i];                
                $Victim->iv_gender = $iv_gender[$i];                
                $Victim->iv_age_range = $iv_age_range[$i];                
                $Victim->iv_details_injury = $iv_details_injury[$i];                
                $Victim->iv_taken_hospital = $iv_taken_hospital[$i];                
                $Victim->iv_when_returntowork = $iv_when_returntowork[$i];                
                $Victim->iv_details_treatment = $iv_details_treatment[$i];                
                $Victim->save(); 
                $iv_id=$Victim->iv_id;        
                
                if($request->bpm_id){
                    $ararr=array();
                    foreach ($bpm_id[$i] as $key => $bpm_id_value) {
                        $single=array();    
                        $single['ivbp_im_id']= $im_id;
                        $single['ivbp_iv_id']= $iv_id;
                        $single['ivbp_bpm_id']=$bpm_id_value;
                        $ararr[]=$single;
                    }
                    DB::table('incidents_victim_bodypart')->insert($ararr);    
                }            
            }

        }
        // Add Victim End                              
        $step++;

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
        $incidents['description'] = $request->im_description;
        $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');                        
        $incidents['victims'] =  DB::table('incidents_victim')->where('iv_im_id', $im_id)->get();

        

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Incidents report updated.');
                Mail::send('email.incidentsedit_step1', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
        $headid = GetHeadofSafetyEmailName($request->im_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];
                App::setLocale($value['planguage']); 
                $subject = __('Incidents report updated.');      
                Mail::send('email.incidentsedit_step1', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        }    

        return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('success',__('Incident Successfully Updated.'));
    }

    public function StepTwo(Request $request)
    {    
        $cuser = Auth::user(); 
        $customMessages = [
            'im_investigateteamlead.required'=> 'Investigation team lead is Required',
            'iit_user_id.required'=> 'Investigation team members is Required',
            'im_dateofcomplete.required'=> 'Target date to complete is Required',
        ];
        $validatedData = $request->validate([
            'im_investigateteamlead' => ['required'],
            'iit_user_id' => ['required'],            
            'im_dateofcomplete' => ['required'],            
        ],$customMessages);

        $parentuser = Auth::user(); 
        $im_id=$request->im_id; 
        $step=$request->step;         
        $Incident =  \App\Incident::find($im_id);           
        $Incident->im_investigateteamlead = $request->im_investigateteamlead;        
        $Incident->im_dateofcomplete = date('Y-m-d H:i:s',strtotime($request->im_dateofcomplete));
        $Incident->im_lastsubmitedstep = 2;                                          
        $Incident->save(); 
        $teammenbers=array();
        $teammenbers[]=$request->im_investigateteamlead;    
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['im_srno'] = $Incident->im_srno;
        $incidents['rating'] = get_rating_field($Incident->im_ratinganincident, 'rating');
        $incidents['rating_text'] = get_rating_field($Incident->im_ratinganincident, 'rating_text');
        $incidents['severity'] = get_rating_field($Incident->im_ratinganincident, 'severity');
        $incidents['likelihood'] = get_rating_field($Incident->im_ratinganincident, 'likelihood');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        

        
        if($request->iit_user_id){
            $iit_user_id=array();
            DB::table('incidents_investigation_team')->where('iit_im_id',$im_id)->delete();
            foreach ($request->iit_user_id as $key => $iit_user_id_value) {                                
                $single=array();    
                $single['iit_im_id']= $im_id;
                $single['iit_user_id']=$iit_user_id_value;
                $attached[]=$single;
                $teammenbers[]=$iit_user_id_value;
            }
            DB::table('incidents_investigation_team')->insert($attached);    
        } 
        
        $TeamUsers= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')->whereIn('users.id',$teammenbers)
        ->get();        

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Investigation Team Created').': '.$incidents['incidentsype'].' '.__('Incident Report').' '.$incidents['severity'].' & '.$incidents['likelihood'].' ( '.$incidents['rating'].' - '.$incidents['rating_text'].' ) '.__('at').' '.$incidents['sites'].' '.__('On').' '.date('d-M-Y').': '. $incidents['im_srno'];        

                Mail::send('email.investigation_team', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents,'TeamUsers'=>$TeamUsers], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        if($TeamUsers){
            foreach ($TeamUsers as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Investigation Team Created').': '.$incidents['incidentsype'].' '.__('Incident Report').' '.$incidents['severity'].' & '.$incidents['likelihood'].' ( '.$incidents['rating'].' - '.$incidents['rating_text'].' ) '.__('at').' '.$incidents['sites'].' '.__('On').' '.date('d-M-Y').': '. $incidents['im_srno'];        

                Mail::send('email.investigation_team', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents,'TeamUsers'=>$TeamUsers], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }



        $step++;
        return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('success',__('Incident Successfully Updated.'));
    }

    public function StepThree(Request $request)
    {   
        $cuser = Auth::user();  
        $customMessages = [
            'irc_rcid.required'=> 'Root Cause Analysis is Required',            
        ];
        $validatedData = $request->validate([
            'irc_rcid' => ['required'],            
        ],$customMessages);        
        $im_id=$request->im_id; 

        $Incident =  \App\Incident::find($im_id);                   
        $Incident->im_lastsubmitedstep = 3;                                          
        $Incident->save();                                 

        $step=$request->step;                 
        if($request->irc_rcid){
            $irc_rcid=array();
            DB::table('incidents_root_cause')->where('irc_im_id',$im_id)->delete();
            foreach ($request->irc_rcid as $key => $irc_rcid_value) {                                
                $single=array();    
                $single['irc_im_id']= $im_id;
                $single['irc_rcid']=$irc_rcid_value;
                $irc_rcid[]=$single;
            }
            DB::table('incidents_root_cause')->insert($irc_rcid);    
        }

        if($request->rc){            
            DB::table('incidents_root_cause_description')->where('ircd_im_id',$im_id)->delete();
            foreach ($request->rc as $key => $rc_value) {                                
                $single=array();
                $description='description'.$rc_value;    
                $single['ircd_im_id']= $im_id;
                $single['ircd_rcid']= $rc_value;
                $single['ircd_text']=$request->$description;
                if($request->$description){
                    DB::table('incidents_root_cause_description')->insert($single);   
                }    
            }             
        }

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        

        

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Incidents report updated.');
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
            $headid = GetHeadofSafetyEmailName($Incident->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name'];  
                    App::setLocale($value['planguage']); 
                    $subject = __('Incidents report updated.');  
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }    


        $step++;
        return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('success',__('Incident Successfully Updated.'));
    }

    public function StepFour(Request $request)
    { 
        $cuser = Auth::user();
        $im_id=$request->im_id; 
        $step=$request->step;
        $am_parent_id=$im_id;        

        $action_description= $request->action_description;
        $due_date= $request->due_date;   
        $control= $request->control;                   
        $user_id= $request->user_id; 
        $srno= $request->insrno; 
        $am_id_arr= $request->am_id; 

        $Incident =  \App\Incident::find($im_id);                   
        $Incident->im_lastsubmitedstep = 4;                                          
        $Incident->save();   
        $mlstatus=1;          
        if($request->action_description){
            foreach ($srno as $key => $i) {  
                if($am_id_arr[$key]!=0){
                    $Actions =  \App\Actions::find($am_id_arr[$i]); 
                    $mlstatus=$Actions->am_status;   
                }else{
                    $Actions = new \App\Actions;
                    $mlstatus=1;          
                }
                $Actions->am_parent_id = $am_parent_id;
                $Actions->am_module_type = 2;
                $Actions->am_site_id = $Incident->im_site_id;
                $Actions->am_description = $action_description[$key];
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date[$key]));
                $Actions->am_control = $control[$key];
                $Actions->am_created_by = $cuser->id;
                $Actions->am_status = $mlstatus;
                $Actions->save(); 
                $sitesname= get_site_field($Incident->im_site_id, 'site_name');
                $am_id=$Actions->am_id;        
                $usernames=array();
                if($request->user_id){
                    $ararr=array();
                    DB::table('actions_responsible')->where('am_id',$am_id)->delete();
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                        $usernames[] = get_user_field($user_id_value, 'name');
                    }
                    DB::table('actions_responsible')->insert($ararr);    
                } 

                $mlaction = array();
                $mlaction['description'] = $action_description[$key];
                $mlaction['control'] = get_control_field($control[$key], 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($due_date[$key]));                     
                $mlstatus = GetActionStatusEmail($mlstatus);                
                $mlaction['status'] = $mlstatus;                
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                
                $subject = $mlstatus.': An action assigned to you';
                if($request->user_id){                    
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $EmailUsers=get_user_all_field($user_id_value);
                        if($EmailUsers){
                            App::setLocale($EmailUsers->planguage);                            
                            $subject = __($mlstatus).': '.__('An action assigned to you');
                            $useremail = $EmailUsers->email;
                            $username = $EmailUsers->name;
                            Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                                $m->to($useremail, $username)->subject($subject);
                            });  
                        }
                    }                    
                }

            }
        }

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        

       

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Incidents report updated.');
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
            $headid = GetHeadofSafetyEmailName($Incident->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name'];
                    App::setLocale($value['planguage']); 
                    $subject = __('Incidents report updated.');    
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }    


        if($Incident->im_actionapproved!=1){
            return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('error',__('You can proceed to “Step 5: Review and Closure” only after all approvals are obtained from authorized users.'));    
        }        
        $step++;
        return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('success',__('Incident Successfully Updated.'));
    }

    public function StepFourApproval(Request $request)
    {   
        $cuser = Auth::user();          
        $parentuser = Auth::user(); 
        $im_id=$request->im_id; 
        $step=$request->step;         
        $Incident =  \App\Incident::find($im_id);                 
        $Incident->im_actionapproved = $request->approve;
        $Incident->im_approved_by = $request->im_approved_by;
        $Incident->im_approved_at = date('Y-m-d H:i:s');
        $Incident->im_lastsubmitedstep = 4;
        $Incident->save();

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        
        if($request->approve==1){
            $subject = 'Incidents report approved.';
        }else{
            $subject = 'Incidents report rejected.';
        }

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject(__($subject));
                });
            }
        }

        //Send Mail to Site head & Supervisor
            $headid = GetHeadofSafetyEmailName($Incident->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name']; 
                    App::setLocale($value['planguage']);    
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject(__($subject));
                    });
                }    
            }  


        if($request->approve==1){
            DB::table('actions_master')->where('am_parent_id', $im_id)->where('am_module_type', 2)->update(['am_status' => 1]);
            $step++;
            return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>$step])->with('success',__('Incident Successfully Updated.'));        
        }else{
            return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>4])->with('error','Incident rejected');        
        }

        
    }

    public function StepFive(Request $request)
    {   
        $cuser = Auth::user();          
        $parentuser = Auth::user(); 
        $im_id=$request->im_id; 
        $step=$request->step;      
        $newstatus= $request->im_status;   
        $Incident =  \App\Incident::find($im_id);                         
        $oldstatus= $Incident->im_status;   
        $Incident->im_status = $request->im_status;        
        $Incident->im_lastsubmitedstep = 5;
        $Incident->save();

        if($newstatus!=$oldstatus){
        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        
        if($request->im_status==1){
            $subject = 'Incidents report status changed as Open.';
        }else{
            $subject = 'Incidents report status changed as Close.';
        }

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage);  
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject(__($subject));
                });
            }
        }

        //Send Mail to Site head & Supervisor
        $headid = GetHeadofSafetyEmailName($Incident->im_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];   
                App::setLocale($value['planguage']);   
                Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject(__($subject));
                });
            }    
        } 

        }     

        return Redirect::route('incidents')->with('success',__('Incident Successfully Updated.'));   
    }

    public function StepNonInvistiGation(Request $request)
    {   

        $cuser = Auth::user();
        $customMessages = [
            'im_ic_id.required'=> 'Select incident type is Required', 
            'im_site_id.required'=> 'Select name the location is Required', 
            'im_description.required'=> 'Select shift is Required', 
            'im_shift.required'=> 'Select incident type is Required', 
            'im_datetime.required'=> 'When? select date and time is Required', 
            'im_immediateactiontaken.required'=> 'Immediate action taken is Required', 
        ];
        $validatedData = $request->validate([
            'im_ic_id' => ['required'],
            'im_site_id' => ['required'],            
            'im_description' => ['required'],            
            'im_shift' => ['required'],
            'im_datetime' => ['required'],            
            'im_immediateactiontaken' => ['required'],            
        ],$customMessages);

        $parentuser = Auth::user(); 
        $im_id=$request->im_id; 
        $step=$request->step;         
        $Incident =  \App\Incident::find($im_id);           
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_site_id = $request->im_site_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;                        
        $Incident->im_immediateactiontaken = $request->im_immediateactiontaken;                        
        $Incident->im_machineno_extralocation = $request->im_machineno_extralocation;     
        $Incident->im_extendofdamange = $request->im_extendofdamange;  
        $Incident->im_anyvictim = $request->im_anyvictim;                                  
        $Incident->im_lastsubmitedstep = 1;                                  
        $Incident->save();         

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
                    $single['im_id']=$im_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('incidents_attachement_rel')->insert($attached);    
        }    

        //Add Victim Start
        if($request->srno && $request->im_anyvictim==1){
            $iv_vtm_id= $request->iv_vtm_id;   
            $iv_name= $request->iv_name;            
            $iv_gender= $request->iv_gender;   
            $iv_age_range= $request->iv_age_range;   
            $bpm_id= $request->bpm_id;   
            $iv_details_injury= $request->iv_details_injury; 
            $iv_taken_hospital= $request->iv_taken_hospital; 
            $iv_when_returntowork= $request->iv_when_returntowork; 
            $iv_details_treatment= $request->iv_details_treatment; 
            $srno= $request->srno; 
            
            foreach ($srno as $key => $i) {                
                $Victim = new \App\Victim;
                $Victim->iv_im_id = $im_id;                
                $Victim->iv_vtm_id = $iv_vtm_id[$i];                
                $Victim->iv_name = $iv_name[$i];                
                $Victim->iv_gender = $iv_gender[$i];                
                $Victim->iv_age_range = $iv_age_range[$i];                
                $Victim->iv_details_injury = $iv_details_injury[$i];                
                $Victim->iv_taken_hospital = $iv_taken_hospital[$i];                
                $Victim->iv_when_returntowork = $iv_when_returntowork[$i];                
                $Victim->iv_details_treatment = $iv_details_treatment[$i];                
                $Victim->save(); 
                $iv_id=$Victim->iv_id;        
                
                if($request->bpm_id){
                    $ararr=array();
                    foreach ($bpm_id[$i] as $key => $bpm_id_value) {
                        $single=array();    
                        $single['ivbp_im_id']= $im_id;
                        $single['ivbp_iv_id']= $iv_id;
                        $single['ivbp_bpm_id']=$bpm_id_value;
                        $ararr[]=$single;
                    }
                    DB::table('incidents_victim_bodypart')->insert($ararr);    
                }            
            }

        }
        // Add Victim End   

        //Action start        
        $am_parent_id=$im_id;        

        $action_description= $request->action_description;
        $due_date= $request->due_date;   
        $control= $request->control;                   
        $user_id= $request->user_id; 
        $srno= $request->insrno; 
        $am_id_arr= $request->am_id; 
        $mlactions = array();
        $sitesname= get_site_field($request->im_site_id, 'site_name');
        if($request->action_description){
            foreach ($srno as $key => $i) {  
                if($am_id_arr[$key]!=0){
                    $Actions =  \App\Actions::find($am_id_arr[$i]);    
                    $mlstatus=$Actions->am_status;
                }else{
                    $Actions = new \App\Actions; 
                    $mlstatus=1;       
                }
                $Actions->am_parent_id = $am_parent_id;
                $Actions->am_module_type = 2;
                $Actions->am_site_id = $Incident->im_site_id;
                $Actions->am_description = $action_description[$key];
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date[$key]));
                $Actions->am_control = $control[$key];
                $Actions->am_status = 1;
                $Actions->am_created_by = $cuser->id;
                $Actions->save(); 

                $am_id=$Actions->am_id;        
                $usernames = array();
                if($request->user_id){
                    $ararr=array();
                    DB::table('actions_responsible')->where('am_id',$am_id)->delete();
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                        $usernames[] = get_user_field($user_id_value, 'name');

                    }
                    DB::table('actions_responsible')->insert($ararr);    
                }

                //For Mail

                $mlaction = array();
                $mlaction['description'] = $action_description[$key];
                $mlaction['control'] = get_control_field($control[$key], 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($due_date[$key]));                     
                $mlstatus = GetActionStatusEmail($mlstatus);                
                $mlaction['status'] = $mlstatus;                
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                
                $subject = $mlstatus.': An action assigned to you';
                if($request->user_id){                    
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $EmailUsers=get_user_all_field($user_id_value);
                        if($EmailUsers){
                            App::setLocale($EmailUsers->planguage);                            
                            $subject = __($mlstatus).': '.__('An action assigned to you');
                            $useremail = $EmailUsers->email;
                            $username = $EmailUsers->name;
                            Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                                $m->to($useremail, $username)->subject($subject);
                            });  
                        }
                    }                    
                }



            }
        }
        //Action End

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');   
        $incidents['victims'] =  DB::table('incidents_victim')->where('iv_im_id', $im_id)->get();                     

        

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage); 
                $subject = __('Incidents report updated.');
                Mail::send('email.incidentsedit_nonvictim', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

        //Send Mail to Site head & Supervisor
            $headid = GetHeadofSafetyEmailName($Incident->im_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name'];  
                    App::setLocale($value['planguage']); 
                    $subject = __('Incidents report updated.');  
                    Mail::send('email.incidentsedit_nonvictim', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }    

        
        return Redirect::route('incidentsdetails',['id'=>$im_id,'step'=>1])->with('success',__('Incident Successfully Updated.'));
    }

}
