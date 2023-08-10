<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\UserByTennat;
use App\Observation;
use App\CategoryType;
use App\Category;
use App\Actions;
use App\Sites;
use App\Control;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail;
use App;
use Artisan;

class ObservationsControllers extends Controller
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
        Artisan::call('nearmissoverdue');     
        $cuser = Auth::user();  $filterdatestart='';  $filterdateend='';
        $Sitesforuserarr=array('none');                    
        if($cuser->is_admin==6){
            $usersites=array('none');                    
            $user_site = DB::table('user_site_relation')->where('user_id',$cuser->id)->get();                     
            if($user_site){ foreach ($user_site as $key => $value) { $usersites[]=$value->site_id; }   }
            $Sitesforuser=Sites::where('status',1)->whereIn('id',$usersites)->OrwhereIn('site_parent',$usersites)->get();
            if($Sitesforuser){
                foreach ($Sitesforuser as $key => $value) {
                    $Sitesforuserarr[]=$value->id;
                }
            }
        }                    

        if(!$cuser->hasRole('Super Admin')){}
        $searchbykeywords=$request->searchbykeywords;
        if($request->searchbykeywords){
            $searchbykeywords = preg_replace("/[^0-9]/", "", $searchbykeywords );
        }
        $filterdate=$request->filterdate;
        $filtersite=$request->filtersite;
        $filtercat=$request->filtercat;
        if($request->filtersite && $request->filtersite!=0){
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

        if(isset($request->filtersite)){ 
            if(empty($filtersite)){
                $filtersite=array(0);
            }
        }
        $headofsafetyIDs=array();
        $site_headofsafetyarr=DB::table('site_headofsafety')->select('sh_site_id')->where('sh_user_id',$cuser->id)->get()->toArray();   
        if($site_headofsafetyarr){
            foreach ($site_headofsafetyarr as $key => $value) {
                $headofsafetyIDs[]=$value->sh_site_id;
            }
        }    

        $status=1;
        if ($request->ajax()) {  $status=$request->status; }
        $riskpotentiallevel=$request->riskpotentiallevel;        
        if($filterdate!=''){
            $filterdaterange=explode(' - ', $filterdate);
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));
        }

        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        if($status==3){
            $observations1->whereNotNull('om.deleted_at') ;         
        }else{
            $observations1->whereNull('om.deleted_at') ;
            if($cuser->is_admin!=6){
                $observations1->where('om.status',$status) ;
            }    
        }
        
        if($filtersite!=''){  $observations1->whereIn('om.site_id',$filtersite) ;   }
        if($filterdate!=''){  $observations1->whereBetween('om.created_at', [$filterdatestart,$filterdateend]); }
        if($filtercat!=''){   $observations1->where('om.oc_id',$filtercat);    }
        if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   $observations1->where('om.riskpotentiallevel',$riskpotentiallevel); }
        if(!$cuser->hasRole('Super Admin')){
            //$observations1->where('om.created_by',$cuser->id) ;
            if($cuser->is_admin==6){
                  $observations1->where('om.ob_srno','NM'.$searchbykeywords) ;                  
                  $observations1->whereIn('om.site_id',$Sitesforuserarr) ;
            }else{
                $observations1->where(function($query) use ($cuser,$headofsafetyIDs){
                    $query->orWhere('om.created_by',$cuser->id)
                   ->orWhereIn('om.site_id',$headofsafetyIDs);
                });    
            }
            
        }
        $ObservationOpen= $observations1->get();
        

        if ($request->ajax()) {
            return view('observations.observationsajax', compact('ObservationOpen','cuser'));    
        }

        $observations2= DB::table('observations_master as om');
        $observations2->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations2->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations2->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations2->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations2->whereNull('om.deleted_at') ;
        $observations2->where('om.status',0) ;
        if($filtersite!=''){  $observations2->whereIn('om.site_id',$filtersite) ;   }
        if($filterdate!=''){  $observations2->whereBetween('om.created_at', [$filterdatestart,$filterdateend]); }
        if($filtercat!=''){   $observations2->where('om.oc_id',$filtercat);    }
        if(!$cuser->hasRole('Super Admin')){
            if($cuser->is_admin==6){
                  $observations2->whereIn('om.site_id',$Sitesforuserarr) ;
            }else{
                $observations2->where('om.created_by',$cuser->id);    
            }            
        }
        $ObservationClose= $observations2->get();

        $observations3= DB::table('observations_master as om');
        $observations3->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations3->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations3->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations3->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations3->whereNull('om.deleted_at') ;
        $observations3->where('om.status',2) ;
        if($filtersite!=''){  $observations3->whereIn('om.site_id',$filtersite) ;   }
        if($filterdate!=''){  $observations3->whereBetween('om.created_at', [$filterdatestart,$filterdateend]); }
        if($filtercat!=''){   $observations3->where('om.oc_id',$filtercat);    }
        if(!$cuser->hasRole('Super Admin')){
            if($cuser->is_admin==6){
                  $observations3->whereIn('om.site_id',$Sitesforuserarr) ;
            }else{
                $observations3->where('om.created_by',$cuser->id);    
            }            
        }
        $ObservationOverdue= $observations3->get();

        $observations3= DB::table('observations_master as om');
        $observations3->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations3->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations3->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations3->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations3->whereNotNull('om.deleted_at') ;        
        if($filtersite!=''){  $observations3->whereIn('om.site_id',$filtersite) ;   }
        if($filterdate!=''){  $observations3->whereBetween('om.created_at', [$filterdatestart,$filterdateend]); }
        if($filtercat!=''){   $observations3->where('om.oc_id',$filtercat);    }
        if(!$cuser->hasRole('Super Admin')){$observations3->where('om.created_by',$cuser->id) ;}
        $ObservationDeleted= $observations3->get();
        
        
        $category = Category::where('type_id',1)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $page_title='Near Miss';
        if($cuser->is_admin==6){
            return view('observations.observations_uni', compact('category','Sites','page_title','ObservationOpen','ObservationClose','filterdate','filtercat','filtersite','cuser','ObservationDeleted','ObservationOverdue','searchbykeywords'));
        }else{
            return view('observations.observations', compact('category','Sites','page_title','ObservationOpen','ObservationClose','filterdate','filtercat','filtersite','cuser','ObservationDeleted','ObservationOverdue','searchbykeywords'));    
        }
        
    }

    public function create(Request $request)
    {
        $cuser = Auth::user();        
        $category = Category::where('type_id',1)->orderby('parent_id','asc')->get();
        $Sites = Sites::where('status',1)->get();
        $Users=UserByTennat::where('status',1)->get();
        $Control=Control::where('cm_status',1)->get();       
        $page_title='Create Near Miss';
        return view('observations.create', compact('category','page_title','Sites','Users','Control','cuser'));
    }

    public function store(Request $request)
    {     
        $cuser = Auth::user();
        $ErrorMessage = [
            'oc_id.required' => 'The Observation Type field is required.',
            'site_id.required' => 'Select Area field is required.',
            'description.required' => 'Description field is required.',
            'obdatetime.required' => 'Date and Time field is required.',
            'action_required.required' => 'Actions field is required.',
            'riskpotentiallevel.required' => 'Risk potential level field is required.',
            'Comments.required' => 'Make a suggestion field is required.',
            'listing_type.required' => 'Please select at least one is required.',
        ];
        $validatedData = $request->validate([
            'oc_id' => ['required'],
            'site_id' => ['required'],
            'description' => ['required'],
            'obdatetime' => ['required'],
            'action_required' => ['required'],
            'riskpotentiallevel' => ['required'],
            'Comments' => ['required'],
            'listing_type' => ['required'],
        ],$ErrorMessage);

        $parentuser = Auth::user(); 
        $Observation = new \App\Observation;
        $Observation->ob_srno = $request->ob_srno;
        $Observation->site_id = $request->site_id;
        $Observation->ob_describethelocation = $request->ob_describethelocation;
        $Observation->oc_id = $request->oc_id;
        $Observation->description = $request->description;
        $Observation->obdatetime = date('Y-m-d H:i:s',strtotime($request->obdatetime));
        $Observation->riskpotentiallevel = $request->riskpotentiallevel;
        $Observation->action_required = $request->action_required;
        $Observation->Comments = $request->Comments;
        $Observation->listing_type = $request->listing_type;
        $Observation->status = 1;
        $Observation->created_by = $parentuser->id;
        $Observation->ob_fullname = $request->ob_fullname;
        $Observation->ob_empid = $request->ob_empid;
        $Observation->ob_email = $request->ob_email;
        $Observation->save(); 
        $ob_id=$Observation->ob_id;
        $ob_srno=GetNMPrefix().str_pad($parentuser->companyid, 2, '0', STR_PAD_LEFT).str_pad( $ob_id, 4, '0', STR_PAD_LEFT);

        DB::table('observations_master')->where('ob_id', $ob_id)->update(['ob_srno' => $ob_srno]);
                

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
                    $single['ob_id']=$ob_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('observations_attachement_rel')->insert($attached);    
        }
        $sitesname= get_site_field($request->site_id, 'site_name');
        //Add Action Start
        $mlactions = array();
        if($request->action_description && $request->action_required==1){
            $action_description= $request->action_description;
            $due_date= $request->due_date;   
            $control= $request->control;   
            $remark= $request->remark;   
            $status= $request->am_status;   
            $user_id= $request->user_id; 
            $srno= $request->srno;

            

            foreach ($srno as $key => $i) {                
                $Actions = new \App\Actions;
                $Actions->am_parent_id = $ob_id;
                $Actions->am_module_type = 1;
                $Actions->am_site_id = $request->site_id;
                $Actions->am_description = $action_description[$key];
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date[$key]));
                $Actions->am_control = $control[$key];
                $Actions->am_remark = $remark[$key];
                $Actions->am_status = $status[$key];
                $Actions->am_created_by = $parentuser->id;
                $Actions->save(); 
                $am_id=$Actions->am_id;        
                
                $usernames = array();
                if($request->user_id){
                    $ararr=array();
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;

                        //For Email
                        $usernames[] = get_user_field($user_id_value, 'name');

                    }
                    DB::table('actions_responsible')->insert($ararr);    
                }

                //For Mail
                $mlaction = array();
                $mlaction['description'] = $action_description[$key];
                $mlaction['control'] = get_control_field($control[$key], 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($due_date[$key]));                     

                $mlstatus = GetActionStatusEmail($status[$key]);;
                
                $mlaction['status'] = $mlstatus;
                $mlaction['remarks'] = $remark[$key];
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                
                
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


                $mlactions[] = $mlaction;
                //****** End For Mail
            }

        }
        // Add Action End

        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name','c.category_name','s.site_name');
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations1->whereNull('om.deleted_at') ;
        $observations1->where('om.ob_id',$ob_id) ;        
        $ObservationOpen_value= $observations1->first();

        $respond='';
        $respond.='<div class="col-md-6 mb-4 gcobseritem gcobseritem'.$ObservationOpen_value->ob_id.'">';          
            $respond.='<div class="card riskpotentiallevel'.$ObservationOpen_value->riskpotentiallevel.'">';
            $respond.='<div class="gcspaction gcspobjaction">';
            if((($cuser->hasRole('Super Admin') || $cuser->id==$ObservationOpen_value->created_by))){
            $respond.='<a href="'.route('observationedit',['id'=>$ObservationOpen_value->ob_id]).'" class="ml-1 observationedit"><i class="fa fa-edit"></i></a>';
            }
            if((($cuser->hasRole('Super Admin') || $cuser->id==$ObservationOpen_value->created_by))){
            $respond.='<a  href="'.route('observationdelete',['id'=>$ObservationOpen_value->ob_id]).'" class="ml-1 observationdelete"><i class="fa fa-trash"></i></a>';
            }
          $respond.='</div>';
                $respond.='<div class="card-body">
                    <span class="d-flex gc-observsntitle">'.$ObservationOpen_value->category_name.' - '.$ObservationOpen_value->ob_srno.'</span>
                    <span class="d-flex">'.date('d M, Y D h:ia',strtotime($ObservationOpen_value->obdatetime)).'</span>
                    <span class="d-flex">'.$ObservationOpen_value->site_name.'</span>
                    <p class="card-text">'.substr($ObservationOpen_value->description,0,57).'...</p>
                    <div class="gc-observsntitle-userdtl clearfix">    
                        <div class="gc-observsntitle-nametag">
                            <span class="d-flex">'.__('By').':'.$ObservationOpen_value->name.'</span>
                            <span class="d-flex">'.date('d M, Y D h:ia',strtotime($ObservationOpen_value->created_at)).'</span>
                        </div> 
                        <div class="gc-observsntitle-subtag">
                            <label for="tag">0 of 1 '.__('Closed').'</label>
                        </div> 
                    </div>   
                </div>
            </div>
        </div>';
        echo $respond;

        //Send Mail to admin
        $observations = array();
        $observations['ob_srno'] =$ObservationOpen_value->ob_srno;
        $observations['observationtype'] = get_category_field($request->oc_id, 'category_name');
        $observations['description'] = $request->description;
        $observations['sites'] = $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$request->ob_describethelocation;
        $observations['datetime'] = $request->obdatetime;
        $risklevel = '';
        if($request->riskpotentiallevel == 1){ $risklevel = 'Minor'; }
        if($request->riskpotentiallevel == 2){ $risklevel = 'Serious'; }
        if($request->riskpotentiallevel == 3){ $risklevel = 'Fatal'; }
        $observations['risklevel'] = $risklevel;
        $observations['comments'] = $request->Comments;
        $observations['actions'] = $mlactions;

        
        /*$adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                App::setLocale($ademl->planguage); 
                $useremail = $ademl->email;
                $username = $ademl->name;
                $subject = __('New Near Miss report created');
                Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }*/

        //Send to creator                
        $useremail =$parentuser->email;
        $username = $parentuser->name;
        App::setLocale($parentuser->planguage); 
        $subjectforcreatror = __('New Near Miss report successfully created.');
        Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
            $m->to($useremail, $username)->subject($subjectforcreatror);
        });
        

        //Send Mail to Site head of safety        
        $headid = GetHeadofSafetyEmailName($request->site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                App::setLocale($value['planguage']);
                $useremail = $value['email'];
                $username =  $value['name']; 
                $subject = __('New Near Miss report created');   
                Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });   
            }            
        }            
        

       
    }

    public function edit(Request $request)
    {
        $cuser = Auth::user();

        $Observation = Observation::where('ob_id',$request->id)->first();
        if(empty($Observation)){
            return Redirect::route('observations')->with('error',__('Near Miss not found.'));   
        }
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Observation->created_by)){
            return Redirect::route('dashboard')->with('error',__('You can not access this section.')); 
        }
        $category = Category::where('type_id',1)->orderby('parent_id','asc')->get();
        
        $observations_attachement_rel=DB::table('observations_attachement_rel')->where('ob_id',$request->id)->get();
        $observations_reply_attachement=DB::table('observations_reply_attachement')->where('ora_ob_id',$request->id)->get();
        $Sites = Sites::where('status',1)->get();
        $Users=UserByTennat::where('status',1)->get();

        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'u.name','cm.cm_name','s.site_name','c.category_name','om.*');
        $Actions->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $Actions->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $Actions->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $Actions->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_parent_id',$request->id) ;        
        $Actions->where('am.am_module_type',1) ;        
        $Actions = $Actions->get();
        $Control=Control::where('cm_status',1)->get();       
        $page_title='Edit Near Miss';
        return  view('observations.edit', compact('category','page_title','Sites','Observation','observations_attachement_rel','Users','Actions','Control','cuser','observations_reply_attachement'));
    }

    public function update(Request $request)
    {     
        $cuser = Auth::user();

        $ErrorMessage = [
            'oc_id.required' => __('The Near Miss Type field is required.'),
            'site_id.required' => __('Select Area field is required.'),
            'description.required' => __('Description field is required.'),
            'obdatetime.required' => __('Date and Time field is required.'),
            'action_required.required' => __('Actions field is required'),
            'riskpotentiallevel.required' => __('Risk potential level field is required.'),
            'Comments.required' => __('Make a suggestion field is required.'),            
        ];
        $validatedData = $request->validate([
            'oc_id' => ['required'],
            'site_id' => ['required'],
            'description' => ['required'],
            'obdatetime' => ['required'],
            'action_required' => ['required'],
            'riskpotentiallevel' => ['required'],
            'Comments' => ['required'],        
        ],$ErrorMessage);

        $parentuser = Auth::user(); 
        $ob_id=$request->ob_id;  
              
        $Observation =  \App\Observation::find($ob_id);   
        $Observation->site_id = $request->site_id;
        $Observation->ob_describethelocation = $request->ob_describethelocation;
        $Observation->oc_id = $request->oc_id;
        $Observation->description = $request->description;
        $Observation->obdatetime = date('Y-m-d H:i:s',strtotime($request->obdatetime));
        $Observation->riskpotentiallevel = $request->riskpotentiallevel;
        $Observation->action_required = $request->action_required;
        $Observation->Comments = $request->Comments;        
        $Observation->status = $request->status; 
        if($request->ob_closing_comments && $request->status!=1){
            $Observation->ob_closing_comments = $request->ob_closing_comments;     
        }else{
            $Observation->ob_closing_comments = '';     
        }

        $Observation->ob_more_information_required = $request->ob_more_information_required; 
        if($request->ob_more_information_required==1){
            $Observation->ob_more_information_required = $request->ob_more_information_required; 
            if($request->ob_information_required){
                $Observation->ob_information_required = $request->ob_information_required;                 
            }
        }else{
            $Observation->ob_more_information_required =Null; 
            $Observation->ob_information_required = Null;     
            $Observation->ob_reply_information_requested = Null;
        }
        if($request->ob_reply_information_requested){
            $Observation->ob_reply_information_requested = $request->ob_reply_information_requested;
        }

        
               
        $Observation->save();
         $mlactions = array();
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
                    $single['ob_id']=$ob_id;
                    $single['attachament']=str_replace('public/', '', $attachament);
                    $single['attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('observations_attachement_rel')->insert($attached);    
        }

        $attachedimgname_ora=$request->attachedimgname_ora;        
        if($request->attachedmain_ora){            
            $attached=array();
            $attachedimgname_ora=array_unique($attachedimgname_ora);
            foreach ($request->attachedmain_ora as $key => $attached_value) {                 
                if (in_array($attached_value->getClientOriginalName(), $attachedimgname_ora)) 
                {  
                    $pos = array_search($attached_value->getClientOriginalName(), $attachedimgname_ora);
                    unset($attachedimgname_ora[$pos]);                    
                    $attachament = Storage::putFile('public/'.$parentuser->companyname, $attached_value);                    
                    $single=array();    
                    $single['ora_ob_id']=$ob_id;
                    $single['ora_attachament']=str_replace('public/', '', $attachament);
                    $single['ora_attachement_name']=$attached_value->getClientOriginalName();
                    $attached[]=$single;
                }    
            }
            DB::table('observations_reply_attachement')->insert($attached);    
        } 
        $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$request->ob_describethelocation;
        //Add Action Start
        if($request->action_description && $request->action_required==1){
            $action_description= $request->action_description;
            $due_date= $request->due_date;   
            $control= $request->control;   
            $remark= $request->remark;   
            $status= $request->am_status;   
            $user_id= $request->user_id; 
            $srno= $request->srno; 

            foreach ($srno as $key => $i) {                
                $Actions = new \App\Actions;
                $Actions->am_parent_id = $ob_id;
                $Actions->am_module_type = 1;
                $Actions->am_site_id = $request->site_id;
                $Actions->am_description = $action_description[$key];
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date[$key]));
                $Actions->am_control = $control[$key];
                $Actions->am_remark = $remark[$key];
                $Actions->am_status = $status[$key];
                $Actions->am_created_by = $parentuser->id;
                $Actions->save(); 
                $am_id=$Actions->am_id; 
                $usernames = array();                       
                if($request->user_id){
                    $ararr=array();
                    foreach ($user_id[$i] as $keysub => $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                        //For Email
                        $usernames[] = get_user_field($user_id_value, 'name');
                    }
                    DB::table('actions_responsible')->insert($ararr);    
                }

                
                

                //For Mail
                $mlaction = array();
                $mlaction['description'] = $action_description[$key];
                $mlaction['control'] = get_control_field($control[$key], 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($due_date[$key]));                     

                $mlstatus = GetActionStatusEmail($status[$key]);
                
                $mlaction['status'] = $mlstatus;
                $mlaction['remarks'] = $remark[$key];
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                                
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


                $mlactions[] = $mlaction;            
            }
        }

        DB::table('actions_master')->where('am_parent_id', $ob_id)->where('am_module_type',1)->update(['am_site_id'=>$request->site_id]);
        // Add Action End

        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name','c.category_name','s.site_name');
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations1->whereNull('om.deleted_at') ;
        $observations1->where('om.ob_id',$ob_id) ;        
        $ObservationOpen_value= $observations1->first();

        
        $data=array();
        $data['respond']='';
        $observations1= DB::table('observations_master');        
        $observations1->whereNull('deleted_at') ;
        $observations1->where('status',1) ;        
        $ObservationOpen= $observations1->count();

        $observations2= DB::table('observations_master');        
        $observations2->whereNull('deleted_at') ;
        $observations2->where('status',0) ;        
        $ObservationClose= $observations2->count();
        $data['open']=$ObservationOpen;
        $data['closed']=$ObservationClose;

        
        
        //Send Mail to admin
        $observations = array();
        $observations['ob_srno'] = $ObservationOpen_value->ob_srno;
        $observations['ob_information_required'] = '';
        $observations['observationtype'] = get_category_field($request->oc_id, 'category_name');
        $observations['description'] = $request->description;
        $observations['sites'] = $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$request->ob_describethelocation;
        $observations['datetime'] = $request->obdatetime;
        $risklevel = '';
        if($request->riskpotentiallevel == 1){ $risklevel = 'Minor'; }
        if($request->riskpotentiallevel == 2){ $risklevel = 'Serious'; }
        if($request->riskpotentiallevel == 3){ $risklevel = 'Fatal'; }
        $observations['risklevel'] = $risklevel;
        $observations['comments'] = $request->Comments;
        $observations['actions'] = $mlactions;


        if($request->ob_information_required && $request->ob_more_information_required==1 && $request->status==1 && $cuser->id!=$ObservationOpen_value->created_by){
            $observations['ob_information_required'] = $ObservationOpen_value->ob_information_required;
            $created_by = DB::table('users')->where('id', $ObservationOpen_value->created_by)->where('status', 1)->first();                
            $useremail =$created_by->email;
            $username = $created_by->name;
            App::setLocale($created_by->planguage);       
            $subjectforcreatror = __('Near Miss report').' '.$ObservationOpen_value->ob_srno.' '.__('required more information.');
            Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
                $m->to($useremail, $username)->subject($subjectforcreatror);
            });
            return json_encode($data);    
        }

       

        /*$adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                App::setLocale($ademl->planguage); 
                $useremail = $ademl->email;
                $username = $ademl->name;
                $subject = __('Near Miss report updated');
                Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }*/

        //Send to creator
        $created_by = DB::table('users')->where('id', $ObservationOpen_value->created_by)->where('status', 1)->first();                
        $useremail =$created_by->email;
        $username = $created_by->name;
        App::setLocale($created_by->planguage); 
        $subjectforcreatror = __('Near Miss report successfully updated.');
        Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
            $m->to($useremail, $username)->subject($subjectforcreatror);
        });
        

        //Send Mail to Site head of safety        
        $headid = GetHeadofSafetyEmailName($request->site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];
                App::setLocale($value['planguage']);  
                $subject = __('Near Miss report updated');   
                Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });   
            }            
        }


        return json_encode($data);
               
       
    }

    public function delete($id)
    {   
        $cuser = Auth::user();
        $Observation = Observation::withTrashed()->where('ob_id',$id)->first();
        if((!$cuser->hasRole('Super Admin') && $cuser->id!=$Observation->created_by)){
            return Redirect::route('dashboard')->with('error',__('You can not access this section.')); 
        }  
        if($Observation->deleted_at){
            Observation::where('ob_id',$id)->forceDelete();       
        }else{
            Observation::where('ob_id',$id)->delete();       
        }   
        
        return $id;     
        
    }

    public function restore($id)
    {   
        $cuser = Auth::user();
        $Observation = Observation::where('ob_id',$id)->first();
        if((!$cuser->hasRole('Super Admin') && $cuser->can('Observations Delete'))){
            return Redirect::route('dashboard')->with('error',__('You can not access this section.')); 
        }     
        Observation::where('ob_id',$id)->restore();   
        return $id;             
    }

    public function DeleteFile($id)
    {   
        $observations_attachement_rel=DB::table('observations_attachement_rel')->where('oar_id',$id)->first();
        Storage::delete('public/'.$observations_attachement_rel->attachament);
        DB::table('observations_attachement_rel')->where('oar_id',$id)->delete(); 
        return $id;                    
        return Redirect::back()->with('success',__('Near Miss attachament deleted.'));
    }

    public function DeleteFileOra($id)
    {           
        $observations_reply_attachement=DB::table('observations_reply_attachement')->where('ora_id',$id)->first();
        Storage::delete('public/'.$observations_reply_attachement->ora_attachament);
        DB::table('observations_reply_attachement')->where('ora_id',$id)->delete(); 
        return $id;                            
    }

    public function AddAction(Request $request)
    {   
        $srno= $request->srno;    
        $Users=UserByTennat::where('status',1)->get();  
        $Control=Control::where('cm_status',1)->get();             
        return view('observations.action_create', compact('Users','srno','Control'));
    }

    public function Details(Request $request)
    {
        $cuser = Auth::user();
        $Observation = Observation::where('ob_id',$request->id)->first();  

        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations1->whereNull('om.deleted_at') ;
        $observations1->where('om.ob_id',$request->id) ;        
        $Observation= $observations1->first();


        $observations_attachement_rel=DB::table('observations_attachement_rel')->where('ob_id',$request->id)->get();
        $Sites = Sites::where('status',1)->get();
        $Users=UserByTennat::where('status',1)->get();
        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'u.name','u.empid','cm.cm_name','s.site_name','c.category_name','om.*');
        $Actions->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $Actions->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $Actions->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $Actions->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_parent_id',$request->id) ;        
        $Actions->where('am.am_module_type',1) ;        
        $Actions = $Actions->get();                
        return  view('observations.details', compact('Observation','observations_attachement_rel','Actions','cuser'));
    }

    public function StoreAction(Request $request)
    {             
        $parentuser = Auth::user(); 
        $ob_id=$request->ob_id;        
        //Add Action Start
        
        $action_description= $request->action_description;
        $due_date= $request->due_date;   
        $control= $request->control;   
        $remark= $request->remark;   
        $status= $request->am_status;   
        $user_id= $request->user_id; 
        $srno= $request->srno;   

        foreach ($srno as $key => $i) {                
            $Actions = new \App\Actions;
            $Actions->am_parent_id = $ob_id;
            $Actions->am_module_type = 1;
            $Actions->am_site_id = $request->site_id;
            $Actions->am_description = $action_description[$key];
            $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date[$key]));
            $Actions->am_control = $control[$key];
            $Actions->am_remark = $remark[$key];
            $Actions->am_status = $status[$key];
            $Actions->am_created_by = $parentuser->id;
            $Actions->save(); 
            $am_id=$Actions->am_id;        
            
            if($request->user_id){
                $ararr=array();
                foreach ($user_id[$i] as $keysub => $user_id_value) {
                    $single=array();    
                    $single['am_id']= $am_id;
                    $single['user_id']=$user_id_value;
                    $ararr[]=$single;
                }
                DB::table('actions_responsible')->insert($ararr);    
            }            
        }            
        // Add Action End
        return $ob_id;
    }
}


