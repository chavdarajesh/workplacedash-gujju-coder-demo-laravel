<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Redirect;
use App\User;
use App\UserByTennat;
use App\CategoryType;
use App\Category;
use App\Actions;
use App\Sites;
use App\Audits;
use App\AuditQuestions;
use App\Control;
use DB;
use View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mail;
use App;

class AuditsControllers extends Controller
{
    public function __construct()
    {        
        $this->middleware('FrontUsers');
    }
    public function index(Request $request)
    {
        $cuser = Auth::user();
        $page_title='Audits';
        $status=1;
        if ($request->ajax()) {  $status=$request->status; }
        $adm_af_id=$adm_site_id=$adm_ac_id=$filterdate=$searchbykeywords='';
        if($request->adm_af_id){$adm_af_id=$request->adm_af_id;}
        if($request->adm_site_id){$adm_site_id=$request->adm_site_id; $siteids=GetsiteIdsTree($adm_site_id); }
        if($request->adm_ac_id){$adm_ac_id=$request->adm_ac_id;}
        if($request->filterdate){
            $filterdate=$request->filterdate;
            $filterdaterange=explode(' - ', $filterdate);
            $year=date('Y',strtotime($filterdaterange[0]));
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));            
        }
        if($request->searchbykeywords){
            $searchbykeywords=$request->searchbykeywords;
            $audit_templates_arr=array();$audit_auditor_arr=array(); 
            $audit_templates=DB::table('audit_templates_master')->where('atm_audit_name', 'like', '%'.$searchbykeywords.'%')->pluck('atm_id');
            if(count($audit_templates)){foreach ($audit_templates as $key => $value) { $audit_templates_arr[]=$value; }}
            $audit_auditor=DB::table('users')->where('name', 'like', '%'.$searchbykeywords.'%')->pluck('id');            
            if(count($audit_auditor)){foreach ($audit_auditor as $key => $value) { $audit_auditor_arr[]=$value; }}            
        }


        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','atm.atm_audit_name','af.af_name','u.name as auditor','shead.name as auditee',DB::raw('COUNT(akf.ak_id) AS Findings'),DB::raw('(SELECT COUNT(am.am_id) FROM actions_master as am WHERE am.am_parent_id = adm.adm_id and am.am_module_type = 4) AS actions'));
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor');
        $AuditsItems->leftJoin('users as shead', 'shead.id', '=', 's.site_headofsafety');
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');
        $AuditsItems->leftJoin('audit_keyfinding as akf', 'akf.ak_adm_id', '=', 'adm.adm_id');        
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->where('adm.adm_status',$status);
        if($adm_af_id!=''){$AuditsItems->where('adm.adm_af_id',$adm_af_id);}
        if($adm_site_id!=''){$AuditsItems->whereIn('adm.adm_site_id',$siteids);}
        if($adm_ac_id!=''){$AuditsItems->where('adm.adm_ac_id',$adm_ac_id);}
        if($filterdate!=''){$AuditsItems->whereBetween('adm.adm_start_from', [$filterdatestart,$filterdateend]);}
        if($searchbykeywords!=''){
            $AuditsItems->Where(function($query) use ($audit_templates_arr,$audit_auditor_arr) {
                $query->orWhereIn('adm.adm_atm_id',$audit_templates_arr);
                $query->orWhereIn('adm.adm_auditor',$audit_auditor_arr);
            });
        }
        $AuditsItems->groupBy('adm.adm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->get();

        $AuditsScheduled=Audits::where('adm_status',1)->count();
        $AuditsInprogress=Audits::where('adm_status',2)->count();
        $AuditsOverdue=Audits::where('adm_status',3)->count();
        $AuditsCompleted=Audits::where('adm_status',4)->count();
        $AuditsApproved=Audits::where('adm_status',5)->count();

        $GetTimeline=DB::table('audit_timeline');
        //$GetTimeline->groupBy('atl_adm_id');        
        $GetTimeline->orderby('atl_id','DESC') ;        
        $GetTimeline=$GetTimeline->get()->unique('atl_adm_id')->groupBy('atl_adm_id');        
        
        
        if ($request->ajax()) {
            $view=View::make('audits.audits_list',compact('Audits','GetTimeline'));
            $html = $view->render();
            $data=array();
            $data['view']=$html;
            $data['curentcount']=count($Audits);            
            return json_encode($data);
        }
        return view('audits.audits',compact('page_title','cuser','Audits','AuditsScheduled','AuditsInprogress','AuditsOverdue','AuditsCompleted','AuditsApproved','GetTimeline'));
    }

    public function GetSitewise(Request $request)
    {
        $cuser = Auth::user();
        $page_title='Audits';    
        $year=date('Y');   
        $sites=Sites::where('site_type',1)->get();  

        $adm_af_id=$adm_site_id=$adm_ac_id=$filterdate=$searchbykeywords='';
        if($request->adm_af_id){$adm_af_id=$request->adm_af_id;}
        if($request->adm_site_id){$adm_site_id=$request->adm_site_id; $siteids=GetsiteIdsTree($adm_site_id); }
        if($request->adm_ac_id){$adm_ac_id=$request->adm_ac_id;}
        if($request->filterdate){
            $filterdate=$request->filterdate;
            $filterdaterange=explode(' - ', $filterdate);
            $year=date('Y',strtotime($filterdaterange[0]));
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));            
        }
        if($request->searchbykeywords){
            $searchbykeywords=$request->searchbykeywords;
            $audit_templates_arr=array();$audit_auditor_arr=array(); 
            $audit_templates=DB::table('audit_templates_master')->where('atm_audit_name', 'like', '%'.$searchbykeywords.'%')->pluck('atm_id');
            if(count($audit_templates)){foreach ($audit_templates as $key => $value) { $audit_templates_arr[]=$value; }}
            $audit_auditor=DB::table('users')->where('name', 'like', '%'.$searchbykeywords.'%')->pluck('id');            
            if(count($audit_auditor)){foreach ($audit_auditor as $key => $value) { $audit_auditor_arr[]=$value; }}            
        }

        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','s.site_parent','atm.atm_audit_name',DB::raw('YEAR(adm.adm_start_from) year, MONTH(adm.adm_start_from) month'));
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->whereYear('adm.adm_start_from', $year);
        if($adm_af_id!=''){$AuditsItems->where('adm.adm_af_id',$adm_af_id);}
        if($adm_site_id!=''){$AuditsItems->whereIn('adm.adm_site_id',$siteids);}
        if($adm_ac_id!=''){$AuditsItems->where('adm.adm_ac_id',$adm_ac_id);}
        if($filterdate!=''){$AuditsItems->whereBetween('adm.adm_start_from', [$filterdatestart,$filterdateend]); }
        if($searchbykeywords!=''){
            $AuditsItems->Where(function($query) use ($audit_templates_arr,$audit_auditor_arr) {
                $query->orWhereIn('adm.adm_atm_id',$audit_templates_arr);
                $query->orWhereIn('adm.adm_auditor',$audit_auditor_arr);
            });
        }
        $AuditsItems->groupBy('site_parent','adm.adm_atm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->get()->groupBy('site_parent');        
        
        $AuditsCount= DB::table('audit_master as adm');
        $AuditsCount->select('adm.adm_id','adm.adm_status','adm.adm_atm_id', DB::raw('YEAR(adm.adm_start_from) year, MONTH(adm.adm_start_from) month'),'adm.adm_start_from','s.site_name','s.site_parent');
        $AuditsCount->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');        
        $AuditsCount->whereNull('adm.deleted_at');
        $AuditsCount->whereYear('adm.adm_start_from', $year);
        if($adm_af_id!=''){$AuditsItems->where('adm.adm_af_id',$adm_af_id);}
        if($adm_site_id!=''){$AuditsItems->whereIn('adm.adm_site_id',$siteids);}
        if($adm_ac_id!=''){$AuditsItems->where('adm.adm_ac_id',$adm_ac_id);}
        if($filterdate!=''){$AuditsItems->whereBetween('adm.adm_start_from', [$filterdatestart,$filterdateend]); }        
        $AuditsCount->orderby('adm.adm_start_from','asc') ;        
        $AuditsCount= $AuditsCount->get(); 

        $AuditsCountScheduledArr=array();
        $AuditsCountCompletedArr=array();
        if($AuditsCount){
            foreach ($AuditsCount as $key => $value) {
                if(in_array($value->adm_status, array(1,2,3))){
                    $AuditsCountScheduledArr[]=$value->site_parent.$value->adm_atm_id.$value->month.$value->year;
                }else{
                    $AuditsCountCompletedArr[]=$value->site_parent.$value->adm_atm_id.$value->month.$value->year;
                } 
               
            }
        }        
        $AuditsCountScheduledArr=array_count_values($AuditsCountScheduledArr);        
        $AuditsCountCompletedArr=array_count_values($AuditsCountCompletedArr); 

        if ($request->ajax()) {
            $view=View::make('audits.auditsbysitescontent',compact('page_title','cuser','Audits','sites','AuditsCountScheduledArr','AuditsCountCompletedArr','year'));
            $html = $view->render();
            $data=array();
            $data['view']=$html;
            $data['curentcount']=0;            
            return json_encode($data);
        }
        

        return view('audits.auditsbysites',compact('page_title','cuser','Audits','sites','AuditsCountScheduledArr','AuditsCountCompletedArr','year'));
    }

    public function GetSiteUsers(Request $request)
    {
        $sites=Sites::where('id',$request->site_id)->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Auditor=$user_site_relation->get();
        $html='';
        $html.='<label for="exampleInputEmail1">'.__("Select Auditor").'<span class="required">*</span></label><select required name="adm_auditor" class="form-control"  ><option value="">'.__("Select name").'</option>';
        if($Auditor){
            foreach ($Auditor as $key => $AuditorItem) {
                $html.='<option value="'.$AuditorItem->id.'">'.$AuditorItem->name.' - '.$AuditorItem->r_name.'</option>';        
            }
        }
        $html.='</select>';
        return $html;
    }
    public function store(Request $request)
    {        
        $sites=Sites::where('id',$request->adm_site_id)->first();
        if($sites){
            $site_id=$sites->site_parent;        
        }
        $cuser = Auth::user();
        $Audits = new \App\Audits;
        $Audits->adm_ac_id = $request->adm_ac_id;        
        $Audits->adm_atm_id = $request->adm_atm_id;        
        $Audits->adm_site_id = $request->adm_site_id;
        $Audits->adm_main_site_id = $site_id;
        $Audits->adm_af_id = $request->adm_af_id;
        $Audits->adm_start_from = $request->adm_start_from;        
        $Audits->adm_end_on = $request->adm_end_on;        
        $Audits->adm_auditor = $request->adm_auditor;        
        $Audits->adm_created_by = $cuser->id;   
        $Audits->adm_status = 1;
        $Audits->save(); 
        $adm_id=$Audits->adm_id;
        $adm_srno='AUD'.str_pad($cuser->companyid, 2, '0', STR_PAD_LEFT).str_pad( $adm_id, 4, '0', STR_PAD_LEFT);
        DB::table('audit_master')->where('adm_id', $adm_id)->update(['adm_srno' => $adm_srno]);


        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail','u.planguage as auditorplanguage');
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
        $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->where('adm.adm_id',$adm_id);
        $AuditsItems->groupBy('adm.adm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->first();

        $headid = GetHeadofSafetyEmailName($request->adm_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];  
                App::setLocale($value['planguage']);                            
                $subject=__('New Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name;
                              
                Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        }

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage);                            
                $subject=__('New Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name;
                            
               Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }
        
        $useremail = $Audits->auditoremail;
        $username =  $Audits->auditor;
        App::setLocale($Audits->auditorplanguage);                            
        $subject=__('New Audit Assigned to you as').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name;    
        Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
            $m->to($useremail, $username)->subject($subject);
        });
            



        return Redirect::route('audits')->with('success',__('Audits successfully added.'));
    }

    public function Edit(Request $request)
    {
        $Audits = Audits::find($request->adm_id);
        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Auditor=$user_site_relation->get();
        return view('audits.edit',compact('Audits','Auditor'));
    }

    public function update(Request $request)
    {
        $cuser = Auth::user();
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);  

        $old_adm_start_from=$Audits->adm_start_from;
        $old_adm_end_on=$Audits->adm_end_on;

        $Audits->adm_start_from = $request->adm_start_from;        
        $Audits->adm_end_on = $request->adm_end_on;        
        $Audits->save(); 

        if(strtotime($old_adm_start_from)!=strtotime($request->adm_start_from) || strtotime($old_adm_end_on)!=strtotime($request->adm_end_on)){
            $AuditsItems= DB::table('audit_master as adm');
            $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail','u.planguage as auditorplanguage');
            $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
            $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
            $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
            $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
            $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
            $AuditsItems->whereNull('adm.deleted_at') ;
            $AuditsItems->where('adm.adm_id',$adm_id);
            $AuditsItems->groupBy('adm.adm_id');        
            $AuditsItems->orderby('adm.adm_start_from','asc') ;        
            $Audits= $AuditsItems->first();

            
            $headid = GetHeadofSafetyEmailName($Audits->adm_site_id);
            if(!empty($headid)){
                foreach ($headid as $key => $value) {
                    $useremail = $value['email'];
                    $username =  $value['name']; 
                    App::setLocale($value['planguage']);       
                    $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('in').' '.$Audits->site_name.' '.__('has been rescheduled');
                    Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }

            $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
            if($adminemails){
                foreach ($adminemails as $ademl) {
                    $useremail = $ademl->email;
                    $username = $ademl->name;
                    App::setLocale($ademl->planguage);       
                    $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('in').' '.$Audits->site_name.' '.__('has been rescheduled');
                    Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }
            }
            
            $useremail = $Audits->auditoremail;
            $username =  $Audits->auditor;
            App::setLocale($Audits->auditorplanguage);     
            $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('has been rescheduled in').' '.$Audits->site_name;    
            Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                $m->to($useremail, $username)->subject($subject);
            });
            
        }    


        return Redirect::route('audits')->with('success',__('Audits successfully updated.'));
    }
    public function delete(Request $request)
    {   
        $cuser = Auth::user();   
        $adm_id=$request->adm_id;     
        Audits::where('adm_id',$adm_id)->delete();   
        return $adm_id;             
    }

    public function GetAuditSection(Request $request)
    {                   
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);
        if(!$Audits){
            return Redirect::route('audits')->with('error',__('Audit not found.'));
        } 
        if($Audits->adm_status==4 ||$Audits->adm_status==5){
            return Redirect::route('audits')->with('error',__('Audit not edited after once submited.'));
        }
        $atm_id=$Audits->adm_atm_id;
        $atp_id=$request->atp_id;
        $cuser = Auth::user();
        $page_title='Audit';
        $AuditTemplates = \App\AuditTemplates::find($atm_id);        
        if(!$AuditTemplates){
            return Redirect::route('audittemplates')->with('error',__('Audit Templates not found.'));
        }
        $AuditSection = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->where('atp_status',1)->orderby('atp_id','ASC')->get();        
        $AllAtpIds=array();
        $audit_section_completed = DB::table('audit_section_completed')->where('asc_adm_id',$adm_id)->orderby('asc_atp_id','desc')->first();
       // print_r($audit_section_completed);
        foreach ($AuditSection as $key => $value) {$AllAtpIds[]=$value->atp_id;}
        

        if($atp_id){
            $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_id',$atp_id)->first();
            if(!$AuditSectionDetails){
                return Redirect::route('getauditsection',['adm_id'=>$adm_id]);
            }
            if($audit_section_completed){
                 $lastsection=$audit_section_completed->asc_atp_id;
                $key= array_search($lastsection,$AllAtpIds);
                if(isset($AllAtpIds[$key+1])){                    
                    if($AllAtpIds[$key+1]==$atp_id || $lastsection==$atp_id || $lastsection>=$atp_id){
                       /*//return Redirect::route('getauditsection',['adm_id'=>$adm_id]); 
                        echo $AllAtpIds[$key+1];*/
                        //echo 1;exit();
                    }else{
                       return Redirect::route('getauditsection',['adm_id'=>$adm_id]);
                    }
                }
                
            }else{
                return Redirect::route('getauditsection',['adm_id'=>$adm_id]);
            }
            


        }else{
            $AuditSectionDetails = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->orderby('atp_id','ASC')->first();        
        }
        $atp_id=$AuditSectionDetails->atp_id;
        $AuditQuestions=AuditQuestions::whereNull('atpq_parent_id')->where('atpq_atm_id',$AuditSectionDetails->atp_atm_id)->where('atpq_atp_id',$AuditSectionDetails->atp_id)->get(); 

        $AuditSubQuestionsArr=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$AuditSectionDetails->atp_atm_id)->where('atpq_atp_id',$AuditSectionDetails->atp_id)->get()->groupBy('atpq_option_id');         

        
        
        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atp_id',$AuditSectionDetails->atp_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        } 
        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atp_id',$AuditSectionDetails->atp_id)->get()->groupBy('acqo_atpq_id')->toArray();        

        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->withTrashed()->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Auditor=$user_site_relation->get(); 

        $ActionItemCount=DB::table('actions_master')->whereNull('deleted_at')->where('am_adm_id',$adm_id)->count();         

        $KeyFinding=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->get()->groupBy('ak_atpq_id');        
        //dd($KeyFinding);
        $KeyFindingCount=count($KeyFinding);
        $AuditUserNotify=DB::table('audit_usernotify')->where('aun_atp_id',$AuditSectionDetails->atp_id)->where('aun_adm_id',$adm_id)->get()->groupBy('aun_atpq_id');

        
        $AuditAnswerMaster=DB::table('audit_answer_master')->where('aam_atp_id',$AuditSectionDetails->atp_id)->where('aam_adm_id',$adm_id)->get()->groupBy('aam_atpq_id'); 


        $GetTimeline=DB::table('audit_timeline as atl');
        $GetTimeline->select('atl.*','u.name');
        $GetTimeline->leftJoin('users as u','u.id', '=', 'atl.atl_userid');
        $GetTimeline->where('atl_adm_id',$adm_id);        
        $GetTimeline=$GetTimeline->get();         
        

        return view('audits.auditsform', compact('cuser','page_title','AuditTemplates','AuditSection','atp_id','AuditSectionDetails','AuditQuestions','GridViewOption','AuditSubQuestionsArr','CheckBoxQuestionOption','Audits','Auditor','ActionItemCount','KeyFindingCount','KeyFinding','AuditUserNotify','AuditAnswerMaster','GetTimeline'));
    }

    public function PostKeyFindings(Request $request)
    {
        $ak_keyfinding=$request->ak_keyfinding;     
        $ak_atpq_id=$request->ak_atpq_id;     
        $ak_atp_id=$request->ak_atp_id;     
        $ak_atm_id=$request->ak_atm_id;     
        $ak_adm_id=$request->ak_adm_id;
        $deleted=$request->deleted;
        if($deleted==1){
            DB::table('audit_keyfinding')->where('ak_atpq_id',$ak_atpq_id)->where('ak_adm_id',$ak_adm_id)->delete();              
        }else{
            $exitskeyfindig=DB::table('audit_keyfinding')->where('ak_atpq_id',$ak_atpq_id)->where('ak_adm_id',$ak_adm_id)->first();
            if($exitskeyfindig){
                DB::table('audit_keyfinding')->where('ak_id',$exitskeyfindig->ak_id)->update(array('ak_keyfinding'=>$ak_keyfinding));      
            }else{
                DB::table('audit_keyfinding')->insert(array('ak_keyfinding'=>$ak_keyfinding,'ak_atpq_id'=>$ak_atpq_id,'ak_atp_id'=>$ak_atp_id,'ak_atm_id'=>$ak_atm_id,'ak_adm_id'=>$ak_adm_id));          
            }            
        }
        return DB::table('audit_keyfinding')->where('ak_adm_id',$ak_adm_id)->count();
    }

    public function PostNotify(Request $request)
    {

        $audit_notify=$request->audit_notify;     
        $aun_atpq_id=$request->aun_atpq_id;     
        $aun_atp_id=$request->aun_atp_id;     
        $aun_atm_id=$request->aun_atm_id;     
        $aun_adm_id=$request->aun_adm_id;
        $deleted=$request->deleted;        
        if($deleted==1 || empty($audit_notify)){
            DB::table('audit_usernotify')->where('aun_atpq_id',$aun_atpq_id)->where('aun_adm_id',$aun_adm_id)->delete();              
        }else{
            $exits=DB::table('audit_usernotify')->select('aun_user_id')->where('aun_atpq_id',$aun_atpq_id)->where('aun_adm_id',$aun_adm_id)->get();
            $exixtsarr=array(0);
            if($exits){
                foreach ($exits as $key => $value) {
                    $exixtsarr[]=$value->aun_user_id;
                }
            }            
            if($audit_notify){
                foreach ($audit_notify as $key => $value) {
                    if(in_array($value, $exixtsarr)){

                    }else{                                    
                        DB::table('audit_usernotify')->insert(array('aun_user_id'=>$value,'aun_atpq_id'=>$aun_atpq_id,'aun_atp_id'=>$aun_atp_id,'aun_atm_id'=>$aun_atm_id,'aun_adm_id'=>$aun_adm_id));

                        $getauditQuestion=DB::table('audit_template_parts_questions')->where('atpq_id',$aun_atpq_id)->first();
                        $getauditQuestionAns=DB::table('audit_answer_master')->where('aam_atpq_id',$aun_atpq_id)->where('aam_adm_id',$aun_adm_id)->get();
                        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atp_id',$aun_atp_id)->get();
                        $GridViewOption=array();
                            if($GridViewOptionVal){
                                foreach ($GridViewOptionVal as $key => $value) {
                                    $GridViewOption[$value->ago_keyword]=$value->ago_value;
                                }
                            } 
                        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atp_id',$aun_atp_id)->get()->groupBy('acqo_atpq_id')->toArray();    

                        $AuditsItems= DB::table('audit_master as adm');
                        $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail','u.planguage as auditorplanguage');
                        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
                        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
                        $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
                        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
                        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
                        $AuditsItems->whereNull('adm.deleted_at') ;
                        $AuditsItems->where('adm.adm_id',$aun_adm_id);
                        $AuditsItems->groupBy('adm.adm_id');        
                        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
                        $Audits= $AuditsItems->first();
                        $cuser = Auth::user();
                        $useremail = $Audits->auditoremail;
                        $username =  $Audits->auditor;
                        App::setLocale($Audits->auditorplanguage);     
                        $subject=__('Notification Alert').': '.$Audits->af_name.' '.$Audits->atm_audit_name;    
                        Mail::send('email.audit_notify', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'cuser'=>$cuser,'getauditQuestion'=>$getauditQuestion,'getauditQuestionAns'=>$getauditQuestionAns,'GridViewOptionVal'=>$GridViewOptionVal,'GridViewOption'=>$GridViewOption,'CheckBoxQuestionOption'=>$CheckBoxQuestionOption], function ($m) use ($username, $useremail, $subject) {            
                            $m->to('pareshs.gc@gmail.com', $username)->subject($subject);
                        }); 

                    }                    
                }

                DB::table('audit_usernotify')->where('aun_atpq_id',$aun_atpq_id)->where('aun_adm_id',$aun_adm_id)->whereNotIn('aun_user_id',$audit_notify)->delete(); 

            }

        }
    }

    

    public function GetActionPopup(Request $request)
    {
        $atpq_id=$request->atpq_id;     
        $adm_id=$request->adm_id;
        $atp_id=$request->atp_id;
        $Audits = Audits::find($adm_id);
        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Users=$user_site_relation->get();        
        $Control=Control::where('cm_status',1)->get(); 
        return view('audits.action_create', compact('Audits','Users','Control','atpq_id','adm_id','atp_id'));    
        
    }

    public function AddAuditAction(Request $request)
    {
        $parentuser = Auth::user(); 
        $atpq_id=$request->atpq_id;     
        $adm_id=$request->adm_id;
        $atp_id=$request->atp_id;
        $action_description= $request->action_description;
        $due_date= $request->due_date;   
        $control= $request->control;                   
        $user_id= $request->user_id;
        $site_id =$request->site_id;

        $Actions = new \App\Actions;
        $Actions->am_parent_id = $adm_id;
        $Actions->am_module_type = 4;
        $Actions->am_site_id = $site_id;
        $Actions->am_description = $action_description;
        $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($due_date));
        $Actions->am_control = $control;        
        $Actions->am_atpq_id = $atpq_id;        
        $Actions->am_adm_id = $adm_id;        
        $Actions->am_atp_id = $atp_id;        
        $Actions->am_status = 1;
        $Actions->am_created_by = $parentuser->id;
        $Actions->save(); 
        $am_id=$Actions->am_id;
        $usernames=array();
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

        //For Mail
        $mlaction = array();
        $mlaction['description'] = $action_description;
        $mlaction['control'] = get_control_field($control, 'cm_name');
        $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($due_date));                     

        $mlstatus = GetActionStatusEmail(1);
        
        $mlaction['status'] = $mlstatus;
        $mlaction['remarks'] = '';
        $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):''; 
        $sitesname= get_site_field($request->site_id, 'site_name');               
        
        if($request->user_id){                    
            foreach ($request->user_id as $keysub => $user_id_value) {
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


        return DB::table('actions_master')->whereNull('deleted_at')->where('am_adm_id',$adm_id)->count();
    }


    public function GetEditActionPopup(Request $request)
    {
        $cuser = Auth::user();
        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'cm.cm_name', 'ct.ct_name');        
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');                
        $Actions->leftJoin('category_type as ct', 'ct.ct_id', '=', 'am.am_module_type');                
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_id',$request->am_id) ;
        $Actions= $Actions->first(); 
        if(empty($Actions)){
            return Redirect::route('actions')->with('error',__('Action not found.'));   
        }        
        $actions_responsible=array('none');
        $actions_responsible_arr=DB::table('actions_responsible')->select('user_id')->where('am_id',$request->am_id)->get();   
        if($actions_responsible_arr){
            foreach ($actions_responsible_arr as $key => $value) { 
                $actions_responsible[]=$value->user_id;
            }
        }

        $actions_attachement_rel=DB::table('actions_attachement_rel')->where('am_id',$request->am_id)->get(); 
        $Users=UserByTennat::where('status',1)->get();
        $Control=Control::where('cm_status',1)->get();               
        return view('audits.action_edit', compact('Actions','actions_responsible','actions_attachement_rel','Users','Control','cuser'));
    }

    public function PostEditActionPopup(Request $request)
    {
        $parentuser = Auth::user(); 
        $am_id=$request->am_id;        
        $Actions =  \App\Actions::find($am_id);           
        $Actions->am_description = $request->action_description;
        $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($request->due_date));
        $Actions->am_control = $request->control;        
        $Actions->save();
        $usernames=array();
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

        //For Mail
        $mlaction = array();
        $mlaction['description'] = $request->action_description;
        $mlaction['control'] = get_control_field($request->control, 'cm_name');
        $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($request->due_date));                     

        $mlstatus = GetActionStatusEmail($Actions->am_status);
        
        $mlaction['status'] = $mlstatus;
        $mlaction['remarks'] = '';
        $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):''; 
        $sitesname= get_site_field($Actions->am_site_id, 'site_name');               
        $subject = $mlstatus.': '.__('An action assigned to you has been changed');
        if($request->user_id){                    
            foreach ($request->user_id as $keysub => $user_id_value) {
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

    public function DeleteActionItem(Request $request)
    {
        Actions::where('am_id',$request->am_id)->delete(); 
    }

    public function PostAnsewerToAudit(Request $request)
    {

        $atpq_id=$request->atpq_id;             
        $atpq_atp_id=$request->atpq_atp_id;     
        $atpq_atm_id=$request->atpq_atm_id;
        $adm_id=$request->adm_id;
        $aam_answer=$request->aam_answer;
        $atpq_type=$request->atpq_type;
        $cuser = Auth::user();
        if(is_array($aam_answer)){$aam_answer=implode(',',$aam_answer);}
        DB::table('audit_master')->where('adm_id',$adm_id)->update(array('adm_status'=>2));
        $exitsanswers=DB::table('audit_answer_master')->where('aam_atpq_id',$atpq_id)->where('aam_adm_id',$adm_id)->first();
        if($exitsanswers){
            DB::table('audit_answer_master')->where('aam_id',$exitsanswers->aam_id)->update(array('aam_answer'=>$aam_answer));      
        }else{
            DB::table('audit_answer_master')->insert(array('aam_answer'=>$aam_answer,'aam_atpq_id'=>$atpq_id,'aam_atp_id'=>$atpq_atp_id,'aam_atm_id'=>$atpq_atm_id,'aam_adm_id'=>$adm_id));          
        }

        //Time Line Start
        $audit_timeline=DB::table('audit_timeline')->where('atl_adm_id',$adm_id)->orderby('atl_id','desc')->first();             
        if($audit_timeline==''){            
            $data = [
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>1],
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2],    
            ];
            DB::table('audit_timeline')->insert($data);                         
        }else{
            if($audit_timeline->atl_userid!=$cuser->id){
                $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2]];
                DB::table('audit_timeline')->insert($data);
            }  
        }
        //Time Line End


        if($atpq_type==2){
            $AuditSubQuestions=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_option_id',$aam_answer)->where('atpq_parent_id',$atpq_id)->where('atpq_atm_id',$atpq_atm_id)->where('atpq_atp_id',$atpq_atp_id)->get();
            if(count($AuditSubQuestions)){
                $Audits = \App\Audits::find($adm_id);
                $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atp_id',$atpq_atp_id)->get();
                $GridViewOption=array();
                if($GridViewOptionVal){
                    foreach ($GridViewOptionVal as $key => $value) {
                        $GridViewOption[$value->ago_keyword]=$value->ago_value;
                    }
                } 

                $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atp_id',$atpq_atp_id)->get()->groupBy('acqo_atpq_id')->toArray();        

                $site_id= $Audits->adm_site_id;
                $sites=Sites::where('id',$site_id)->first();
                if($sites->site_parent==''){
                    $site_id=$sites->id;
                }else{
                    $site_id=$sites->site_parent;
                }
                $user_site_relation=DB::table('user_site_relation as usr');
                $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
                $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
                $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
                $user_site_relation->where('usr.site_id',$site_id);        
                $Auditor=$user_site_relation->get(); 

                $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atp_id',$atpq_atp_id)->get();
                $GridViewOption=array();
                if($GridViewOptionVal){
                    foreach ($GridViewOptionVal as $key => $value) {
                        $GridViewOption[$value->ago_keyword]=$value->ago_value;
                    }
                } 
                $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atp_id',$atpq_atp_id)->get()->groupBy('acqo_atpq_id')->toArray();            
                
                $AuditAnswerMaster=DB::table('audit_answer_master')->where('aam_atp_id',$atpq_atp_id)->where('aam_adm_id',$adm_id)->get()->groupBy('aam_atpq_id');         

                return view('audits.auditssubqueform', compact('GridViewOption','AuditSubQuestions','CheckBoxQuestionOption','Audits','Auditor','AuditAnswerMaster'));            
            }else{
                $AuditSubQuestions=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_option_id','!=',$aam_answer)->where('atpq_parent_id',$atpq_id)->where('atpq_atm_id',$atpq_atm_id)->where('atpq_atp_id',$atpq_atp_id)->get();
                if(count($AuditSubQuestions)){
                    foreach ($AuditSubQuestions as $key => $value) {
                        DB::table('audit_answer_master')->where('aam_atpq_id',$value->atpq_id)->where('aam_adm_id',$adm_id)->delete();
                        DB::table('actions_master')->where('am_atpq_id',$value->atpq_id)->where('am_adm_id',$adm_id)->delete();
                        DB::table('audit_keyfinding')->where('ak_atpq_id',$value->atpq_id)->where('ak_adm_id',$adm_id)->delete();
                    }                    
                }                
                return 1;        
            }
        }
        return 1;
    }

    public function PostAnsewerToAuditFiles(Request $request)
    {
        $atpq_id=$request->atpq_id;             
        $atpq_atp_id=$request->atpq_atp_id;     
        $atpq_atm_id=$request->atpq_atm_id;
        $adm_id=$request->adm_id;
        $aam_answer=$request->aam_answer;
        $attachedmain=$request->attachedmain;
         
        $cuser = Auth::user();
        //Time Line Start
        $audit_timeline=DB::table('audit_timeline')->where('atl_adm_id',$adm_id)->orderby('atl_id','desc')->first();             
        if($audit_timeline==''){            
            $data = [
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>1],
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2],    
            ];
            DB::table('audit_timeline')->insert($data);                         
        }else{
            if($audit_timeline->atl_userid!=$cuser->id){
                $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2]];
                DB::table('audit_timeline')->insert($data);
            }  
        }
        //Time Line End

        DB::table('audit_master')->where('adm_id',$adm_id)->update(array('adm_status'=>2));
        if($attachedmain){
            $attached=array();
            foreach ($attachedmain as $key => $attached_value) {                
                $attachament = Storage::putFile('public/'.$cuser->companyname, $attached_value);                    
                $single=array();       
                $aam_answer=str_replace('public/', '', $attachament);             
                $ID=DB::table('audit_answer_master')->insertGetId(array('aam_answer'=>$aam_answer,'aam_atpq_id'=>$atpq_id,'aam_atp_id'=>$atpq_atp_id,'aam_atm_id'=>$atpq_atm_id,'aam_adm_id'=>$adm_id)); 
                $single['attachament']=$aam_answer;
                $single['aam_id']=$ID;
                $attached[]=$single;
            }            
        }
        $html='';
        foreach ($attached as $key => $value) {
                $attachamentsrc=url('storage/'.$value['attachament']);

                $path_info = pathinfo($attachamentsrc);                    
                if($path_info['extension']=='pdf'){$attachamentsrc=asset('images/pdf.png');}
                if($path_info['extension']=='docx'){$attachamentsrc=asset('images/doc.png');}
                if($path_info['extension']=='xlsx'){$attachamentsrc=asset('images/excel.png');}
                if($path_info['extension']=='bin'){$attachamentsrc=asset('images/ppt.png');}
                if($path_info['extension']=='pptx'){$attachamentsrc=asset('images/ppt.png');}
                $html.='<span data-fileid="0"  class="pip pip'.$value['aam_id'].'"><img class="imageThumb" src="'.$attachamentsrc.'" title=""><br><span class="removeimgaudit" data-aam_id="'.$value['aam_id'].'"><i class="fa fa-times-circle"></i></span></span>';    
        }
        
        return $html;
    }
    public function DeleteAnsAttachment(Request $request)
    {
        $aam_id=$request->aam_id;
        $exitsanswers=DB::table('audit_answer_master')->where('aam_id',$aam_id)->first();
        if($exitsanswers){
            Storage::delete('public/'.$exitsanswers->aam_answer);
        }
        DB::table('audit_answer_master')->where('aam_id',$aam_id)->delete();
    }    

    public function PostGridAnswer(Request $request)
    {
        $aam_answer=$request->aam_answer;     
        $aam_opt_id=$request->aam_opt_id;     
        $atpq_id=$request->aun_atpq_id;     
        $atpq_atp_id=$request->aun_atp_id;     
        $atpq_atm_id=$request->aun_atm_id;     
        $adm_id=$request->aun_adm_id; 
        $cuser = Auth::user();
        
         //Time Line Start
        $audit_timeline=DB::table('audit_timeline')->where('atl_adm_id',$adm_id)->orderby('atl_id','desc')->first();             
        if($audit_timeline==''){            
            $data = [
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>1],
                ['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2],    
            ];
            DB::table('audit_timeline')->insert($data);                         
        }else{
            if($audit_timeline->atl_userid!=$cuser->id){
                $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>2]];
                DB::table('audit_timeline')->insert($data);
            }  
        }
        //Time Line End


        DB::table('audit_master')->where('adm_id',$adm_id)->update(array('adm_status'=>2));       
        $exitsanswers=DB::table('audit_answer_master')->where('aam_opt_id',$aam_opt_id)->where('aam_atpq_id',$atpq_id)->where('aam_adm_id',$adm_id)->first();
        if($exitsanswers){
            DB::table('audit_answer_master')->where('aam_id',$exitsanswers->aam_id)->update(array('aam_answer'=>$aam_answer));      
        }else{
            DB::table('audit_answer_master')->insert(array('aam_answer'=>$aam_answer,'aam_atpq_id'=>$atpq_id,'aam_atp_id'=>$atpq_atp_id,'aam_atm_id'=>$atpq_atm_id,'aam_adm_id'=>$adm_id,'aam_opt_id'=>$aam_opt_id));          
        }
    }

    public function GetKeyFindings(Request $request)
    {                
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);
        if(!$Audits){
            return Redirect::route('audits')->with('error','Audit not found.');
        } 
        $KeyFinding= DB::table('audit_keyfinding as akf');
        $KeyFinding->select('akf.*','atpq.*','atp.atp_name');
        $KeyFinding->leftJoin('audit_template_parts_questions as atpq', 'atpq.atpq_id', '=', 'akf.ak_atpq_id');
        $KeyFinding->leftJoin('audit_templates_parts as atp', 'atp.atp_id', '=', 'akf.ak_atp_id');
        $KeyFinding->where('akf.ak_adm_id',$adm_id) ;        
        $KeyFinding->orderby('akf.ak_atpq_id','asc') ;        
        $KeyFindings= $KeyFinding->get()->groupBy('ak_atp_id');
        //dd($KeyFindings);

        $AuditSubQuestionsArr=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$Audits->adm_atm_id)->get()->groupBy('atpq_option_id');
        //dd($AuditSubQuestionsArr);
        
        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atm_id',$Audits->adm_atm_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        } 
        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atm_id',$Audits->adm_atm_id)->get()->groupBy('acqo_atpq_id')->toArray();
        
        $atm_id=$Audits->adm_atm_id;
        $atp_id=$request->atp_id;
        $cuser = Auth::user();
        $page_title='Key Finding(s)';
        $AuditTemplates = \App\AuditTemplates::find($atm_id);                
        $AuditSection = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->orderby('atp_id','ASC')->get();  
        $ActionItemCount=DB::table('actions_master')->whereNull('deleted_at')->where('am_adm_id',$adm_id)->count();         
        $KeyFindingCount=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->count();   

        $AuditAnswerMaster=DB::table('audit_answer_master')->where('aam_adm_id',$adm_id)->get()->groupBy('aam_atpq_id');             
        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Auditor=$user_site_relation->get();
        $ActionsAdded=array();
        $KeyFinding=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->get()->groupBy('ak_atpq_id'); 

        $GetTimeline=DB::table('audit_timeline as atl');
        $GetTimeline->select('atl.*','u.name');
        $GetTimeline->leftJoin('users as u','u.id', '=', 'atl.atl_userid');
        $GetTimeline->where('atl_adm_id',$adm_id);        
        $GetTimeline=$GetTimeline->get();  

        return view('audits.getkeyfindings', compact('Audits','AuditTemplates','AuditSection','ActionItemCount','KeyFindingCount','cuser','page_title','KeyFindings','AuditAnswerMaster','AuditSubQuestionsArr','GridViewOption','CheckBoxQuestionOption','Auditor','KeyFinding','ActionsAdded','GetTimeline'));    
    }

    public function GetActionItems(Request $request)
    {                
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);
        if(!$Audits){
            return Redirect::route('audits')->with('error','Audit not found.');
        }
        $GetActionsQuestions= DB::table('actions_master')->select('am_atpq_id')->whereNull('deleted_at')->where('am_adm_id',$adm_id)->get();
        $queids=array();
        if($GetActionsQuestions){
            foreach ($GetActionsQuestions as $key => $value) {
                $queids[]=$value->am_atpq_id;
            }
        }

        $GetActionsQuestions= DB::table('audit_template_parts_questions')->select('atpq_id','atpq_parent_id')->whereIn('atpq_id',$queids)->get();
        if($GetActionsQuestions){
            $queids=array();
            foreach ($GetActionsQuestions as $key => $value) {
                $queids[]=$value->atpq_id;
                if($value->atpq_parent_id){
                    $queids[]=$value->atpq_parent_id;    
                }                
            }
        }


        $GetActions= DB::table('audit_template_parts_questions as atpq');
        $GetActions->select('atpq.*','atp.*','ak.*');        
        $GetActions->leftJoin('audit_templates_parts as atp', 'atp.atp_id', '=', 'atpq.atpq_atp_id');        
        $GetActions->leftJoin('audit_keyfinding as ak',  function($join) use ($adm_id){
            $join->on('ak.ak_atpq_id', '=', 'atpq.atpq_id')->where('ak.ak_adm_id',  $adm_id);            
        });        
        $GetActions->WhereIn('atpq.atpq_id',$queids); 
        $GetActions->WhereNull('atpq_parent_id');        
        $GetActions->orderby('atpq.atpq_id','asc') ;
        $GetActions->groupBy('atpq.atpq_id') ;        
        $GetActions = $GetActions->get()->groupBy('atp_id');


        $ActionsAdded= DB::table('actions_master as am');
        $ActionsAdded->select('am.*', 'u.name','cm.cm_name');
        $ActionsAdded->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $ActionsAdded->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $ActionsAdded->whereNull('am.deleted_at') ;        
        $ActionsAdded->where('am.am_adm_id',$adm_id) ;        
        $ActionsAdded= $ActionsAdded->get()->groupBy('am_atpq_id'); 
        

        $AuditSubQuestionsArr=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$Audits->adm_atm_id)->get()->groupBy('atpq_option_id');
        //dd($AuditSubQuestionsArr);
        
        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atm_id',$Audits->adm_atm_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        } 
        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atm_id',$Audits->adm_atm_id)->get()->groupBy('acqo_atpq_id')->toArray();
        
        $atm_id=$Audits->adm_atm_id;
        $atp_id=$request->atp_id;
        $cuser = Auth::user();
        $page_title='Key Finding(s)';
        $AuditTemplates = \App\AuditTemplates::find($atm_id);                
        $AuditSection = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->orderby('atp_id','ASC')->get();  
        $ActionItemCount=DB::table('actions_master')->whereNull('deleted_at')->where('am_adm_id',$adm_id)->count();         
        $KeyFindingCount=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->count();   

        $AuditAnswerMaster=DB::table('audit_answer_master')->where('aam_adm_id',$adm_id)->get()->groupBy('aam_atpq_id');             
        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }

        $user_site_relation=DB::table('user_site_relation as usr');
        $user_site_relation->select('usr.site_id','u.id','u.name','r.r_name');
        $user_site_relation->leftJoin('users as u','u.id', '=', 'usr.user_id');
        $user_site_relation->leftJoin('roles as r','r.id', '=', 'u.is_admin');
        $user_site_relation->where('usr.site_id',$site_id);        
        $Auditor=$user_site_relation->get();
        $KeyFinding=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->get()->groupBy('ak_atpq_id');

        $GetTimeline=DB::table('audit_timeline as atl');
        $GetTimeline->select('atl.*','u.name');
        $GetTimeline->leftJoin('users as u','u.id', '=', 'atl.atl_userid');
        $GetTimeline->where('atl_adm_id',$adm_id);        
        $GetTimeline=$GetTimeline->get(); 
        
        return view('audits.getactionitems', compact('Audits','AuditTemplates','AuditSection','ActionItemCount','KeyFindingCount','cuser','page_title','GetActions','AuditAnswerMaster','AuditSubQuestionsArr','GridViewOption','CheckBoxQuestionOption','Auditor','KeyFinding','ActionsAdded','GetTimeline')); 
    }

    public function AuditSectionComplete(Request $request)
    {                
        $adm_id=$request->adm_id;
        $atp_id=$request->atp_id;
        DB::table('audit_section_completed')->where('asc_adm_id',$adm_id)->where('asc_atp_id',$atp_id)->delete();
        DB::table('audit_section_completed')->insert(array('asc_adm_id'=>$adm_id,'asc_atp_id'=>$atp_id));

    }
    public function AuditChangeToComplate(Request $request)
    {                
        $cuser = Auth::user();
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);          
        $Audits->adm_status = 4;
        $Audits->adm_status_date = date('Y-m-d h:i:s');        
        $Audits->save(); 
        $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>4]];
        DB::table('audit_timeline')->insert($data);
        DB::table('actions_master')->where('am_adm_id', $adm_id)->update(['am_status' => 1]);


        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail');
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
        $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->where('adm.adm_id',$adm_id);
        $AuditsItems->groupBy('adm.adm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->first();

        
        $headid = GetHeadofSafetyEmailName($Audits->adm_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name']; 
                App::setLocale($value['planguage']);                    
                $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been completed.');
                Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        }

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                App::setLocale($ademl->planguage);    
                $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been completed.');
                Mail::send('email.audit_create', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }
        

        return Redirect::route('getreport',['adm_id'=>$adm_id])->with('success',__('Audits successfully completed.'));
    }
    public function AuditChangeToReject(Request $request)
    {                
        $cuser = Auth::user();
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);          
        $Audits->adm_status = 2;
        $Audits->adm_status_date = date('Y-m-d h:i:s');        
        $Audits->save();
        $reject_note = $request->atl_reason;
        $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>3,'atl_reason'=>$request->atl_reason]];
        DB::table('audit_timeline')->insert($data);
        DB::table('actions_master')->where('am_adm_id', $adm_id)->update(['am_status' =>6]);

        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail','u.planguage as auditorplanguage');
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
        $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->where('adm.adm_id',$adm_id);
        $AuditsItems->groupBy('adm.adm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->first();

        
        $headid = GetHeadofSafetyEmailName($Audits->adm_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name']; 
                App::setLocale($value['planguage']);       
                $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been rejected.');
                Mail::send('email.audit_rejected_approve', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject,'reject_note'=>$reject_note], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        }

        $useremail = $Audits->auditoremail;
        $username =  $Audits->auditor;        
        App::setLocale($Audits->auditorplanguage);       
        $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been rejected.');
        Mail::send('email.audit_rejected_approve', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject,'reject_note'=>$reject_note], function ($m) use ($username, $useremail, $subject) {            
            $m->to($useremail, $username)->subject($subject);
        });

        return Redirect::route('audits')->with('success','Audits successfully rejected.');
    }
    public function AuditChangeToApproved(Request $request)
    {                
        $cuser = Auth::user();
        $adm_id=$request->adm_id;
        $Audits = \App\Audits::find($adm_id);          
        $Audits->adm_status = 5;
        $Audits->adm_status_date = date('Y-m-d h:i:s');        
        $Audits->save(); 
        $reject_note = $request->atl_reason;
        $data = [['atl_adm_id'=>$adm_id,'atl_userid'=>$cuser->id,'atl_type'=>5,'atl_reason'=>$request->atl_reason]];
        DB::table('audit_timeline')->insert($data);
        DB::table('actions_master')->where('am_adm_id', $adm_id)->update(['am_status' => 1]);

        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.*','s.site_name','c.category_name','atm.atm_audit_name','af.af_name','u.name as auditor','u.email as auditoremail','u.planguage as auditorplanguage');
        $AuditsItems->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $AuditsItems->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor'); 
        $AuditsItems->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');       
        $AuditsItems->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $AuditsItems->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');        
        $AuditsItems->whereNull('adm.deleted_at') ;
        $AuditsItems->where('adm.adm_id',$adm_id);
        $AuditsItems->groupBy('adm.adm_id');        
        $AuditsItems->orderby('adm.adm_start_from','asc') ;        
        $Audits= $AuditsItems->first();

        
        $headid = GetHeadofSafetyEmailName($Audits->adm_site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];
                App::setLocale($value['planguage']);  
                $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been approved.');         
                Mail::send('email.audit_rejected_approve', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject,'reject_note'=>$reject_note], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        }

        $useremail = $Audits->auditoremail;
        $username =  $Audits->auditor;
        App::setLocale($Audits->auditorplanguage);   
        $subject=__('Audit').' '.$Audits->atm_audit_name.' '.__('schedule in').' '.$Audits->site_name.' '.__('has been approved.');                
        Mail::send('email.audit_rejected_approve', ['username' => $username, 'useremail' => $useremail, 'Audits' => $Audits,'subject'=>$subject,'reject_note'=>$reject_note], function ($m) use ($username, $useremail, $subject) {            
            $m->to($useremail, $username)->subject($subject);
        });


        return Redirect::route('getreport',['adm_id'=>$adm_id])->with('success',__('Audits successfully completed.'));
    }            

    public function GetAuditByMonth(Request $request)
    {
        $site_id=$request->site_id;
        $atm_id=$request->atm_id;
        $month=$request->month;
        $year=$request->year;
        $sites=Sites::where('id',$site_id)->first();
        $AuditTemplates = \App\AuditTemplates::find($atm_id);  
        $month_name = date("M", mktime(0, 0, 0, $month, 10));    
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);  

        $AuditsCount= DB::table('audit_master as adm');
        $AuditsCount->select('adm.adm_id','adm.adm_status','adm.adm_atm_id', DB::raw('YEAR(adm.adm_start_from) year, MONTH(adm.adm_start_from) month,DAY(adm.adm_start_from) day'),'adm.adm_start_from','s.site_name','s.site_parent',DB::raw('count(*) as auditsbyday'));
        $AuditsCount->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');        
        $AuditsCount->whereNull('adm.deleted_at');
        $AuditsCount->whereYear('adm.adm_start_from', $year);
        $AuditsCount->whereMonth('adm.adm_start_from', $month);  
        $AuditsCount->where('adm.adm_main_site_id', $sites->site_parent);
        $AuditsCount->where('adm.adm_atm_id', $atm_id);
        $AuditsCount->groupBy('adm.adm_start_from');                
        $AuditsCount->orderby('adm.adm_start_from','asc') ;        
        $AuditsCount= $AuditsCount->get()->groupBy('day');

        $KeyFindingCount= DB::table('audit_keyfinding as akf');
        $KeyFindingCount->select('akf.*','adm.adm_id','adm.adm_status','adm.adm_atm_id', DB::raw('YEAR(adm.adm_start_from) year, MONTH(adm.adm_start_from) month,DAY(adm.adm_start_from) day'),'adm.adm_start_from','s.site_name','s.site_parent',DB::raw('count(*) as auditskeyfindnigbyday'));
        $KeyFindingCount->leftJoin('audit_master as adm', 'adm.adm_id', '=', 'akf.ak_adm_id');        
        $KeyFindingCount->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');        
        $KeyFindingCount->whereNull('adm.deleted_at');
        $KeyFindingCount->whereYear('adm.adm_start_from', $year);
        $KeyFindingCount->whereMonth('adm.adm_start_from', $month);  
        $KeyFindingCount->where('adm.adm_main_site_id', $sites->site_parent);
        $KeyFindingCount->where('adm.adm_atm_id', $atm_id);
        $KeyFindingCount->groupBy('adm.adm_start_from');                
        $KeyFindingCount->orderby('adm.adm_start_from','asc') ;        
        $KeyFindingCount= $KeyFindingCount->get()->groupBy('day');

        $ActionsCount= DB::table('actions_master as am');
        $ActionsCount->select('am.*','adm.adm_id','adm.adm_status','adm.adm_atm_id', DB::raw('YEAR(adm.adm_start_from) year, MONTH(adm.adm_start_from) month,DAY(adm.adm_start_from) day'),'adm.adm_start_from','s.site_name','s.site_parent',DB::raw('count(*) as actionsbyday'));
        $ActionsCount->leftJoin('audit_master as adm', 'adm.adm_id', '=', 'am.am_parent_id');        
        $ActionsCount->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');        
        $ActionsCount->where('am.am_module_type',4);
        $ActionsCount->whereNull('adm.deleted_at');
        $ActionsCount->whereYear('adm.adm_start_from', $year);
        $ActionsCount->whereMonth('adm.adm_start_from', $month);  
        $ActionsCount->where('adm.adm_main_site_id', $sites->site_parent);
        $ActionsCount->where('adm.adm_atm_id', $atm_id);
        $ActionsCount->groupBy('adm.adm_start_from');                
        $ActionsCount->orderby('adm.adm_start_from','asc') ;        
        $ActionsCount= $ActionsCount->get()->groupBy('day');
        
        
        return view('audits.auditsmonth',compact('sites','AuditTemplates','year','month_name','days','AuditsCount','KeyFindingCount','ActionsCount'));
    }

    public function GetAuditReport(Request $request)
    {
        $cuser = Auth::user();
        $adm_id=$request->adm_id;
        $page_title='Audits Summery';        
        $Audits= DB::table('audit_master as adm');
        $Audits->select('adm.*','c.category_name','s.site_name','atm.atm_audit_name','af.af_name','r.r_name','u.name as auditor','shead.name as auditee',DB::raw('COUNT(akf.ak_id) AS Findings'),DB::raw('(SELECT COUNT(am.am_id) FROM actions_master as am WHERE am.am_parent_id = adm.adm_id and am.am_module_type = 4) AS actions'));
        $Audits->leftJoin('sites as s', 's.id', '=', 'adm.adm_site_id');
        $Audits->leftJoin('category as c', 'c.id', '=', 'adm.adm_ac_id');
        $Audits->leftJoin('users as u', 'u.id', '=', 'adm.adm_auditor');
        $Audits->leftJoin('roles as r', 'r.id', '=', 'u.is_admin');
        $Audits->leftJoin('users as shead', 'shead.id', '=', 's.site_headofsafety');
        $Audits->leftJoin('audit_templates_master as atm', 'atm.atm_id', '=', 'adm.adm_atm_id');
        $Audits->leftJoin('audit_frequency as af', 'af.af_id', '=', 'adm.adm_af_id');
        $Audits->leftJoin('audit_keyfinding as akf', 'akf.ak_adm_id', '=', 'adm.adm_id');        
        $Audits->whereNull('adm.deleted_at') ;
        $Audits->whereIn('adm.adm_status',array(4,5));
        $Audits->where('adm.adm_id',$adm_id);        
        $Audits->orderby('adm.adm_start_from','asc') ;        
        $Audits= $Audits->first();  

        if(empty($Audits->adm_id)){return Redirect::route('audits')->with('error','Audits not found completed.');}
        $GetTimeline=DB::table('audit_timeline as atl');
        $GetTimeline->select('atl.*','u.name');
        $GetTimeline->leftJoin('users as u','u.id', '=', 'atl.atl_userid');
        $GetTimeline->where('atl_adm_id',$adm_id);        
        $GetTimeline=$GetTimeline->get();

        $atm_id=$Audits->adm_atm_id;
        $AuditSection = DB::table('audit_templates_parts')->where('atp_atm_id',$atm_id)->where('atp_status',1)->orderby('atp_id','ASC')->get();
        $AuditQuestions=AuditQuestions::whereNull('atpq_parent_id')->where('atpq_atm_id',$atm_id)->get()->groupBy('atpq_atp_id');
        $AuditSubQuestionsArr=AuditQuestions::whereNotNull('atpq_parent_id')->where('atpq_atm_id',$atm_id)->get()->groupBy('atpq_option_id');


        $GridViewOptionVal=DB::table('audit_gridview_option')->where('ago_atm_id',$atm_id)->get();
        $GridViewOption=array();
        if($GridViewOptionVal){
            foreach ($GridViewOptionVal as $key => $value) {
                $GridViewOption[$value->ago_keyword]=$value->ago_value;
            }
        }
        $CheckBoxQuestionOption = DB::table('audit_checkbox_question_option')->where('acqo_atm_id',$atm_id)->get()->groupBy('acqo_atpq_id')->toArray(); 
        $KeyFinding=DB::table('audit_keyfinding')->where('ak_adm_id',$adm_id)->get()->groupBy('ak_atpq_id');
        $ActionsAdded= DB::table('actions_master as am');
        $ActionsAdded->select('am.*', 'u.name','cm.cm_name');
        $ActionsAdded->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $ActionsAdded->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $ActionsAdded->whereNull('am.deleted_at') ;        
        $ActionsAdded->where('am.am_adm_id',$adm_id) ;        
        $Actions= $ActionsAdded->get()->groupBy('am_atpq_id');

        $site_id= $Audits->adm_site_id;
        $sites=Sites::where('id',$site_id)->withTrashed()->first();
        if($sites->site_parent==''){
            $site_id=$sites->id;
        }else{
            $site_id=$sites->site_parent;
        }
        

        $AuditAnswerMaster=DB::table('audit_answer_master')->where('aam_adm_id',$adm_id)->get()->groupBy('aam_atpq_id');                
        return view('audits.reports',compact('page_title','cuser','Audits','GetTimeline','AuditSection','AuditQuestions','GridViewOption','CheckBoxQuestionOption','KeyFinding','Actions','AuditAnswerMaster','AuditSubQuestionsArr'));

    }
}