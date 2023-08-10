<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\UserPermission;
use Config;
use Artisan;
use Auth;
use DB;
use App\UserByTennat;
use App\Actions;
use App\Sites;
use App\Category;
use App\Control;
use App\RootCause;
use App\RootCauseItem;
use App\BodyPart;
use App\VictimType;
use Image;
use File;
use Illuminate\Support\Facades\Storage;
use Mail;
use Illuminate\Support\Facades\Password;

class ApiController extends Controller{

    public $cats_subdata = array();

    public function getinstructions(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid authentication key.');

        $insfor = (isset($request->insfor))?$request->insfor:'reg';
        if($insfor == 'reg'){
            $data='
                <h2>How to create an account on ISM Group</h2>
                <p>To create an account on ISM Group, access your desktop browser and follow these instructions.</p>
                <p>1. Visit http://ism.gujjucoders.com/ and click on the "Register" Button on top.</p>
                <p>2. Verrify your email and create your organization account by filling out the form fields.</p>
                <p>3. Once the setup is complete, return to the mobile app and login with your username and password.</p>
                <p>Have a question? <br><br>Email us at info@ism.gujjucoders.com</p>
                <p></p>
            ';
            $responce = array('error'=>0,'responce'=>$data,'msg'=>'Successfully.');
        }else{

        }
        echo json_encode($responce);              
        die;                        
    }
    
    public function getlogin(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Email-Address And Password Are Wrong');
        $input = $request->all(); 
        $companyname = (isset($request->companyname))?$request->companyname:'';
        if($companyname == ''){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid company name.');
            echo json_encode($responce);              
            die;             
        }        
        $user = UserByTennat::where('email',$input['email'])->first();
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))){
            /*if($user->can('Actions Add')){
                //$user->actionaaaaa = 1;
            }*/

            $user->action = (check_user_permissions($user->id, 'Actions Add'))?1:0;
            $user->observationclose = (check_user_permissions($user->id, 'Observations Close'))?1:0;

            $responce = array('error'=>0,'responce'=>$user,'msg'=>'Login Successfully.');
        }       
        echo json_encode($responce);              
        die;                        
    }

    public function forgotpass(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid authentication key.');
        $companyname = (isset($request->companyname))?$request->companyname:'';
        $email = (isset($request->email))?$request->email:'';
        if($companyname == ''){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid company name.');
            echo json_encode($responce);              
            die;             
        }
        $user = UserByTennat::where('email',$email)->first();
        if(empty($user)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Email Address not found.');
            echo json_encode($responce);              
            die;            
        }
        $credentials = request()->validate(['email' => 'required|email']);
        Password::sendResetLink($credentials);
        echo json_encode($responce);              
        die;        
    }

    public function index(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Invalid authentication key.');
        echo json_encode($responce);              
        die;                        
    }

    public function getsitedataMulti($allsite=false){

        $sites_data = array();
        $data = array();
        $siteparents_ids = array('none');
        $Sites=Sites::where('status',1)->whereNull('deleted_at')->get();
        if(!empty($Sites)){
            foreach($Sites as $site){
              if($site->site_parent == $site->id){
                 $data[] = array('id'=>$site->id,'name'=> $site->site_name); 
              }else{
                 $parentId = (!empty($site->sub_parent))?$site->sub_parent:$site->site_parent; 
                 $data[] = array('id'=>$site->id,'name'=> $site->site_name,'parentId'=>$parentId);              
              }  

            }
            $datacnt = 0;
         }   
        //$data[] = array('id'=>0,'name'=> 'Unsure / do not know');       
        return $data;

    }

    
    public function getdashboard(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Dashboard Data Not Found.');
        $uid=(isset($request->uid))?$request->uid:0;
        $range = (isset($request->range))?$request->range:'month';
        //$fsite = (isset($request->fsite))?$request->fsite:'';
        $sdate = (isset($request->sdate))?$request->sdate:'';
        $edate = (isset($request->edate))?$request->edate:'';

        $fsite = (isset($request->fmltisite))?$request->fmltisite:'';
        if(!empty($fsite)){
            $fsite=explode(",",$fsite);
        }

        if(!empty($sdate) && !empty($edate)){
            //$sdate = date('Y-m-d', strtotime($sdate . ' -1 day'));
            //$edate = date('Y-m-d', strtotime($edate . ' +1 day')); 
            $sdate  = date('Y-m-d 00:00:00', strtotime($sdate));
            $edate  = date('Y-m-d 23:59:59', strtotime($edate));            
        }        

        if($range == 'month'){
            $sdate  = date('Y-m-01'); 
            $edate  = date('Y-m-t'); 

            $sdate  = date('Y-m-d 00:00:00', strtotime($sdate));
            $edate  = date('Y-m-d 23:59:59', strtotime($edate));

            //$sdate = date('Y-m-d', strtotime($sdate . ' -1 day'));
            //$edate = date('Y-m-d', strtotime($edate . ' +1 day'));                      
        }
        if($range == 'week'){
            $date   = date('Y-m-d');
            $ts     = strtotime($date);
            
            $start  = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
            
            $sdate  = date('Y-m-d 00:00:00', $start);
            $edate  = date('Y-m-d 23:59:59', strtotime('next saturday', $start));

            //$sdate = date('Y-m-d', strtotime($sdate . ' -1 day'));
            //$edate = date('Y-m-d', strtotime($edate . ' +1 day'));
        }
        if($range == 'today'){
            $date   = date('Y-m-d');

            $sdate  = date('Y-m-d 00:00:00', strtotime($date));
            $edate  = date('Y-m-d 23:59:59', strtotime($date));            
            
            //$sdate  = date('Y-m-d', strtotime($date . ' -1 day'));
            //$edate  = date('Y-m-d', strtotime($date . ' +1 day'));            
        }

        //def incident
        $inclabel = array();
        $inclabel['type1'] = array('name'=>'Minor','value'=>0);
        $inclabel['type2'] = array('name'=>'Serious','value'=>0);
        $inclabel['type3'] = array('name'=>'Fatal','value'=>0);
        $totalinc = 0;

        //def over

        $IncidentsbyRatingQuery= DB::table('incidents_rating');
        $IncidentsbyRatingQuery->select('incidents_rating.rating_text','incidents_rating.rating_type', DB::raw('COUNT(incidents_master.im_ratinganincident) AS rate_count'));
        $IncidentsbyRatingQuery->RightJoin('incidents_master', 'incidents_master.im_ratinganincident', '=', 'incidents_rating.ir_id');
        $IncidentsbyRatingQuery->whereNull('incidents_rating.deleted_at');
        $IncidentsbyRatingQuery->whereNotNull('incidents_master.im_ratinganincident');

        if($sdate!=''){$IncidentsbyRatingQuery->whereBetween('incidents_master.created_at',[$sdate,$edate]);}
        if(!empty($fsite)){   $IncidentsbyRatingQuery->whereIn('incidents_master.im_site_id',$fsite);   } 

        $IncidentsbyRatingQuery->groupBy('incidents_rating.rating_type');
        $IncidentsbyRatingQuery->orderby('incidents_rating.ir_id','ASC');
        $IncidentsbyRating=$IncidentsbyRatingQuery->get(); 
        if(!empty($IncidentsbyRating)){
            foreach($IncidentsbyRating as $incd){
               $inclabel['type'.$incd->rating_type] = array('name'=>$incd->rating_text,'value'=>$incd->rate_count); 
            }
        }
        foreach($inclabel as $val){
            $totalinc = $totalinc+$val['value'];
        }
        $inclabel = array_values($inclabel);
        $incdata = array('total'=>$totalinc,'labels'=>$inclabel);

        //def ob
        $obabel = array();
        $obabel['type0'] = array('name'=>'No Level','value'=>0);
        $obabel['type1'] = array('name'=>'Minor','value'=>0);
        $obabel['type2'] = array('name'=>'Serious','value'=>0);
        $obabel['type3'] = array('name'=>'Fatal','value'=>0);
        $totalob = 0;

        //def over

        $observations= DB::table('observations_master as om');
        $observations->select('om.riskpotentiallevel', DB::raw('COUNT(om.riskpotentiallevel) AS rate_count')); 
        
        if($sdate!=''){  $observations->whereBetween('om.created_at',[$sdate,$edate]);  }
        if(!empty($fsite)){  $observations->whereIn('om.site_id',$fsite);  }

        $observations->whereNull('om.deleted_at');
        $observations->groupBy('om.riskpotentiallevel');
        $observations->orderby('om.riskpotentiallevel','ASC'); 
        $observationsbyRating = $observations->get(); 
        

        if(!empty($observationsbyRating)){
            foreach($observationsbyRating as $obcd){
              if(isset($obabel['type'.$obcd->riskpotentiallevel])){ 
               $obabel['type'.$obcd->riskpotentiallevel]['value'] = $obcd->rate_count; 
              }
            }
        }
        foreach($obabel as $val){
            $totalob = $totalob+$val['value'];
        }
        $obabel = array_values($obabel);
        $obdata = array('total'=>$totalob,'labels'=>$obabel);

         //def ac
        $aclabel = array();
        $aclabel['type1'] = array('name'=>'Open','value'=>0);
        $aclabel['type2'] = array('name'=>'Overdue','value'=>0);
        $aclabel['type3'] = array('name'=>'In Progress','value'=>0);
        $aclabel['type4'] = array('name'=>'Completed','value'=>0);
        $aclabel['type5'] = array('name'=>'Closed','value'=>0);
        $totalac = 0;
        //def over       
        $ActionsByStatusQuery= DB::table('actions_master');
        $ActionsByStatusQuery->select( 'am_status',DB::raw('COUNT(am_status) AS status_count'));        
        $ActionsByStatusQuery->whereNull('deleted_at');
        $ActionsByStatusQuery->whereIn('am_status',array(1,2,3,4,5));
        if($sdate!=''){
            $ActionsByStatusQuery->whereBetween('actions_master.created_at',[$sdate,$edate]);
        }
        if(!empty($fsite)){  
            $ActionsByStatusQuery->whereIn('actions_master.am_site_id',$fsite);   
        }                
        $ActionsByStatusQuery->groupBy('am_status');
        $ActionsByStatusQuery->orderby('am_status','asc');
        $ActionsByStatus=$ActionsByStatusQuery->get();     
        $ActionsByStatusArrFinal=array();   
        if(count($ActionsByStatus)){
            foreach ($ActionsByStatus as $key => $value) {                
                if(isset($aclabel['type'.$value->am_status])){
                    $aclabel['type'.$value->am_status]['value']=$value->status_count;
                }
            }            
        }
        foreach($aclabel as $val){
            $totalac = $totalac+$val['value'];
        }  
        $aclabel = array_values($aclabel);     
        $acdata = array('total'=>$totalac,'labels'=>$aclabel);

        //def ac
        $prlabel = array();
        $prlabel['type1'] = array('name'=>'Closed','value'=>0);
        $prlabel['type2'] = array('name'=>'Extended','value'=>0);
        $prlabel['type3'] = array('name'=>'Revoked','value'=>0);
        $prlabel['type4'] = array('name'=>'Rejected','value'=>0);
        $totalpr = 0;
        //def over
        foreach($prlabel as $val){
            $totalpr = $totalpr+$val['value'];
        }  
        $prlabel = array_values($prlabel);     
        $prdata = array('total'=>$totalpr,'labels'=>$prlabel);


        //def aud
        $audlabel = array();
        $audlabel['type1'] = array('name'=>'Scheduled','value'=>0);
        $audlabel['type2'] = array('name'=>'In Progress','value'=>0);
        $audlabel['type3'] = array('name'=>'Overdue','value'=>0);
        $audlabel['type4'] = array('name'=>'Completed','value'=>0);
        $audlabel['type5'] = array('name'=>'Approved','value'=>0);
        $totalaud = 0;
        //def over 

        $AuditsItems= DB::table('audit_master as adm');
        $AuditsItems->select('adm.adm_status',DB::raw('COUNT(adm.adm_status) AS status_count'));
        if($sdate!=''){
            $AuditsItems->whereBetween('adm.created_at',[$sdate,$edate]);
        }
        if(!empty($fsite)){  
            $AuditsItems->whereIn('adm.adm_site_id',$fsite);   
        } 
        $AuditsItems->whereNull('adm.deleted_at');
        $AuditsItems->groupBy('adm.adm_status');
        $AuditsItems->orderby('adm.adm_status','asc');
        $AuditByStatus=$AuditsItems->get(); 
        if(count($AuditByStatus)){
            foreach ($AuditByStatus as $key => $value) {                
                if(isset($audlabel['type'.$value->adm_status])){
                    $audlabel['type'.$value->adm_status]['value']=$value->status_count;
                }
            }            
        }
        foreach($audlabel as $val){
            $totalaud = $totalaud+$val['value'];
        }  
        $audlabel = array_values($audlabel);     
        $auddata = array('total'=>$totalaud,'labels'=>$audlabel);

        //$sites  = $this->getsitedata(true);
        $sites  = $this->getsitedataMulti();

        $responce = array('error'=>0,'responce'=>array('sites'=>$sites,'incdata'=>$incdata,'obdata'=>$obdata,'acdata'=>$acdata,'prdata'=>$prdata,'auddata'=>$auddata),'msg'=>'Success');
        echo json_encode($responce);              
        die;
    }



    public function getuserroleinfo($uid=0){
        $Users = DB::table('users')
        ->select('users.*', 'roles.r_name','roles.id as role_id')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->where('users.id',$uid)
        ->whereNull('users.deleted_at')    
        ->first();
        $r_name = (isset($Users->r_name))?$Users->r_name:'';
        $role_id = (isset($Users->role_id))?$Users->role_id:'';
        return array('r_name'=>$r_name,'role_id'=>$role_id);
    }

    public function getChildCats($Category,$parents_ids,$id,$fnldata=array()){    
        $data = array();
        foreach($Category as $cat){
           if($id == $cat->parent_id && $cat->id != $id){ 
                $data[] = array('id'=>$cat->id,'name'=>$cat->category_name,'sortNo'=>$cat->id,'parentId'=>$cat->parent_id);
           }
        }
        $fnldata = $data;
        return $fnldata;   
    }

    public function getsitedata($allsite=false){

        $sites_data = array();
        $data = array();
        $siteparents_ids = array('none');
        $Sites=Sites::where('status',1)->where('site_type',1)->whereNull('deleted_at')->get()->toArray();
        if(!empty($Sites)){
            foreach($Sites as $site){
                $siteparents_ids[]=$site['site_parent'];
            }
            $datacnt = 0;
            foreach($Sites as $site){
                if($site['id'] == $site['site_parent']){
                   $data[$datacnt] = array('id'=>$site['id'],'name'=>$site['site_name'],'sortNo'=>$site['id'],'parentId'=>0);
                   $Sites0=Sites::where('site_parent',$site['id'])->where('sub_parent',$site['id'])->where('status',1)->whereNull('deleted_at')->orderby('id','asc')->get();
                   if(count($Sites0)){
                        $data_sub = array();
                        $data_subcnt = 0;
                        foreach($Sites0 as $ssst){
                            $data_sub[$data_subcnt]=array('id'=>$ssst->id,'name'=>$ssst->site_name);
                            $data[$datacnt]['children'][$data_subcnt]=array('id'=>$ssst->id,'name'=>$ssst->site_name,'sortNo'=>$ssst->id,'parentId'=>$site['id']);
                            $Sites1=Sites::where('site_parent',$site['id'])->where('sub_parent',$ssst->id)->where('status',1)->whereNull('deleted_at')->orderby('id','asc')->get();
                            $data_sub1 = array();
                            $data_sub1cnt = 0;
                            foreach($Sites1 as $ssst1){
                                $data[$datacnt]['children'][$data_subcnt]['children'][$data_sub1cnt]=
                                array('id'=>$ssst1->id,'name'=>$ssst1->site_name,'sortNo'=>$ssst1->id,'parentId'=>$ssst->id);
                                $Sites2=Sites::where('site_parent',$site['id'])->where('sub_parent',$ssst1->id)->where('status',1)->whereNull('deleted_at')->orderby('id','asc')->get();
                                $data_sub2 = array();
                                $data_sub2cnt = 0;
                                foreach($Sites2 as $ssst2){
                                    $data[$datacnt]['children'][$data_subcnt]['children'][$data_sub1cnt]['children'][$data_sub2cnt]=
                                    array('id'=>$ssst2->id,'name'=>$ssst2->site_name,'sortNo'=>$ssst2->id,'parentId'=>$ssst1->id);
                                    $data_sub2cnt++;
                                }
                                $data_sub1cnt++;
                            }
                         $data_subcnt++;   
                        }
                        $datacnt++;
                   }
                }
            }
        }
        $data[] = array('id'=>0,'name'=> 'Unsure / do not know','sortNo'=> 0,'parentId'=>0);
        if($allsite){
            $allstdata = array();
            $allstdata[] = array('id'=>'','name'=> 'All Sites','sortNo'=> 0,'parentId'=>0);
            $data = array_merge($allstdata,$data);
        }        
        return $data;

    }

    public function getcatsdata($type=''){
        $cats_data = array();
        $parents_ids = array('none');
        $Category=Category::where('type_id',$type)->orderby('parent_id','asc')->get();
        if(!empty($Category)){
            foreach($Category as $cat){
                $parents_ids[]=$cat->parent_id;
            }
            foreach($Category as $cat){
                if($cat->id == $cat->parent_id){
                     $data = array('id'=>$cat->id,'name'=>$cat->category_name,'sortNo'=>$cat->id,'parentId'=>0);
                     if(in_array($cat->id,$parents_ids)){
                        $data['children']=$this->getChildCats($Category,$parents_ids,$cat->id);
                     }
                     $cats_data[]=$data;
                }
            }
        }
        return $cats_data;
    }    

    public function user_has_access($uid,$perid){
        $has_access   = '';
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$perid,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        }
        return $has_access;
    }

    public function getactionfilterdata(Request $request){
        $uid=(isset($request->uid))?$request->uid:0;
        $type = array();
        //$type[] = array('id'=>1,'name'=>'');
        $type[] = array('key'=>'','label'=>'All','customKey'=>'k0');
        $type[] = array('key'=>1,'label'=>'Observations','customKey'=>'k1');
        $type[] = array('key'=>2,'label'=>'Incidents','customKey'=>'k2');
        $type[] = array('key'=>4,'label'=>'Audits','customKey'=>'k4');
        $sites  = $this->getsitedata();
        $responce = array('error'=>0,'responce'=>array(
            'sites'=>$sites,
            'obtype'=>$type,
        ),'msg'=>'');
        echo json_encode($responce);
    }

    public function getobcreatedata(Request $request){
        $uid=(isset($request->uid))?$request->uid:0;
        $obtype = $this->getcatsdata(1);
        $sites  = $this->getsitedata();

        $riskpotentialaccess = $this->user_has_access($uid,64);
        $actionaccess = $this->user_has_access($uid,54);
        $statusaccess = $this->user_has_access($uid,61);

        $responce = array('error'=>0,'responce'=>array(
            'sites'=>$sites,
            'obtype'=>$obtype,
            'riskpotentialaccess'=>$riskpotentialaccess,
            'actionaccess'=>$actionaccess,
            'statusaccess'=>$statusaccess,
        ),'msg'=>'');
        echo json_encode($responce);
    }

    public function namebyid($type='cat',$id){
        if($type == 'cat'){
            $category = Category::where('id',$id)->first();
            return (isset($category->category_name))?$category->category_name:'';
        }
        if($type == 'site'){
            $Sites=Sites::where('id',$id)->first();
            return (isset($Sites->site_name))?$Sites->site_name:'';
        }
        if($type == 'control'){
            $Control=Control::where('cm_id',$id)->first();
            return (isset($Control->cm_name))?$Control->cm_name:'';
        }
        return '';
    }


    public function getactions(Request $request){

        $permission = array('edit'=>0,'delete'=>0);
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $acs_data=array();
        $r_limit = 5;
        $status=1;
        $start = (isset($request->start))?$request->start:0;
        $uid=(isset($request->uid))?$request->uid:0;        
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        if(empty($r_name)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'User Not Valid. Please logout & login again.');
            echo json_encode($responce);  
            die;
        }
        $has_access = '';
        $action_id  = 53;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$action_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec) || $r_name == 'Super Admin'){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $has_edit   = $this->user_has_access($uid,55);
        $has_delete = $this->user_has_access($uid,56);
        if($r_name == 'Super Admin'){
            $has_edit   = 'Yes';
            $has_delete = 'Yes';
        }
        $filtercat=(isset($request->filtercat))?$request->filtercat:'';
        $status=(isset($request->status))?$request->status:1;
        $riskpotentiallevel=(isset($request->filterrlevel))?$request->filterrlevel:'';
        $sdate = (isset($request->sdate))?$request->sdate:'';
        $edate = (isset($request->edate))?$request->edate:'';

        if(!empty($sdate) && !empty($edate)){
            $sdate = date('Y-m-d 00:00:00',strtotime($sdate));
            $edate = date('Y-m-d 23:59:59',strtotime($edate));
        }

        $filtersite = (isset($request->filtersite))?$request->filtersite:array();
        
        $searchtxt = (isset($request->searchtxt))?$request->searchtxt:'';

        if($request->filtersite && $request->filtersite!=0 && !empty($filtersite)){
            $filtersite=array();
            $Sites = Sites::where('status',1)->where('id',$request->filtersite)->whereNull('deleted_at')->first(); 
            $filtersite[]=$Sites->id;
            if($Sites->site_type==1){
                $SitesOne = Sites::where('status',1)->where('site_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesOne as $key => $value) {
                    $filtersite[]=$value->id;                    
                }
            }
            if($Sites->site_type==2){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->whereNull('deleted_at')->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                }
            }
            if($Sites->site_type==3){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->whereNull('deleted_at')->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                }
            }
        }
        

        $ActionsOpen= DB::table('actions_master as am');
        $ActionsOpen->select('am.*', 'u.name', 'u.empid','.ims.site_name as im_site_name','s.site_name','adms.site_name as auditsitename','imc.category_name as im_category_name','admc.category_name as audit_category_name','c.category_name','om.ob_srno','om.oc_id','om.ob_id','om.site_id','om.description as ob_description','om.obdatetime','om.riskpotentiallevel','im.im_id','im.im_srno','im.im_site_id','im.im_ic_id','im.im_description','im.im_datetime','im.created_at as im_created_at','sm.sm_name','ir.rating','ir.severity','ir.likelihood','ir.rating_text','ir.rating_type','adm.adm_id','adm.adm_srno','adm.adm_ac_id','adm_site_id','adm.adm_start_from','adm.adm_start_from','adm.adm_status');
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
        $ActionsOpen->whereNull('am.deleted_at');
        $ActionsOpen->where('am.am_status',$status);

        if($r_name != 'Super Admin'){  
            $ActionsOpen->where('am.am_created_by',$uid); 
        }

        if(!empty($filtersite)){  $ActionsOpen->whereIn('am.am_site_id',$filtersite);  }
        if(!empty($sdate) && !empty($edate)){
            $ActionsOpen->whereBetween('am_due_date', [$sdate,$edate]);       
        }
        if(!empty($filtercat)){  $ActionsOpen->where('am.am_module_type',$filtercat);  }

        $total = $ActionsOpen->count();
        $ActionsList = $ActionsOpen->skip($start)->take($r_limit)->get();
        if(!empty($ActionsList)){
            foreach($ActionsList as $ActionsOpen_item){
                  $adddata = (array)$ActionsOpen_item;
                  $mt=$ActionsOpen_item->am_module_type;
                  $description=$srno=$category_name=$category_typnm=$site_name=$GetActionResponsibility=$Whendatetime=$GetRiskLevel=$shifts=$colorborder='';
                  if($mt==1){
                      $description=$ActionsOpen_item->ob_description;
                      $srno=$ActionsOpen_item->ob_srno;
                      $category_name=$ActionsOpen_item->category_name;
                      $category_typnm='Observation Type';
                      $site_name=$ActionsOpen_item->site_name;
                      $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                      $Whendatetime=$ActionsOpen_item->obdatetime;
                      $GetRiskLevel=$ActionsOpen_item->riskpotentiallevel;
                      $popuptitle="Observation Details";
                      $colorborder=$ActionsOpen_item->riskpotentiallevel;
                  }
                  if($mt==2){
                      $description=$ActionsOpen_item->im_description;
                      $srno=$ActionsOpen_item->im_srno;                  
                      $category_name=$ActionsOpen_item->im_category_name;
                      $category_typnm='Incident Type';
                      $site_name=$ActionsOpen_item->im_site_name;
                      $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);  
                      $Whendatetime=$ActionsOpen_item->im_datetime;
                      $shifts=$ActionsOpen_item->sm_name;
                      $popuptitle="Incident Details";
                      $GetRiskLevel=$ActionsOpen_item->rating_text;
                      $colorborder=$ActionsOpen_item->rating_type;
                  }
                  if($mt==4){
                      $description=$ActionsOpen_item->im_description;
                      $srno=$ActionsOpen_item->adm_srno;                  
                      $category_name=$ActionsOpen_item->audit_category_name;
                      $category_typnm='Audit Type';
                      $site_name=$ActionsOpen_item->auditsitename;    
                      $GetActionResponsibility=GetActionResponsibility($ActionsOpen_item->am_id);                
                      $Whendatetime=$ActionsOpen_item->adm_start_from;                  
                      $popuptitle="Audit Details";                  
                      $colorborder=$ActionsOpen_item->adm_status;
                  }                
                  $adddata['description']=$description;
                  $adddata['srno']=$srno;
                  $adddata['category_name']=$category_name;
                  $adddata['category_typnm']=$category_typnm;
                  $adddata['site_name']=$site_name;
                  $adddata['GetActionResponsibility']=$GetActionResponsibility;
                  $adddata['Whendatetime'] = date('d M, Y D h:ia',strtotime($Whendatetime));
                  $adddata['GetRiskLevel']=$GetRiskLevel;
                  $adddata['popuptitle']=$popuptitle;
                  $adddata['riskpotentiallevel']=$colorborder; 
                  $adddata['short_desc']=substr($ActionsOpen_item->am_description,0,57); 
                  $adddata['formate_due_date']=date('d M, Y',strtotime($ActionsOpen_item->am_due_date));
                  $adddata['formate_created_at']=date('d M, Y D h: ia',strtotime($ActionsOpen_item->created_at));
                  $adddata['st_name']=GetActionStatus($ActionsOpen_item->am_status);              
                  $acs_data[] = $adddata;
            }
        }
        $start = $start+$r_limit;
        $responce = array('error'=>0,'responce'=>$acs_data,'has_edit'=>$has_edit,'has_delete'=>$has_delete,'total'=>$total,'start'=>$start,'msg'=>'');
        echo json_encode($responce);              
        die;
    }


    public function getactiondata(){
        $Users=UserByTennat::where('status',1)->get();  
        $Control=Control::where('cm_status',1)->get(); 
        $controldata = array();
        $controlkey = array();
        $respdata = array();
        $respkey = array();
        if(!empty($Control)){
            foreach($Control as $key => $Control_value){
                $controldata[]=array('key'=>$Control_value->cm_id,'label'=>$Control_value->cm_name,'customKey'=>'k'.$Control_value->cm_id);
                $controlkey['k'.$Control_value->cm_id]=$Control_value->cm_name;
            }
        }
        if(!empty($Users)){
            foreach ($Users as $key => $Users_value) {
                $respdata[]=array('id'=>$Users_value->id,'name'=>$Users_value->name);
                $respkey['k'.$Users_value->id]=$Users_value->name;
            }
        }
        $responce = array('error'=>0,'responce'=>array('controldata'=>$controldata,'respdata'=>$respdata,'controlkey'=>$controlkey,'respkey'=>$respkey),'msg'=>'');
        echo json_encode($responce);      
    }

    public function addobfiles(Request $request){
        $attachedimgname=$request->file_attachment;
        $input = $request->all();
        $responce = array('error'=>0,'responce'=>$input,'msg'=>'Yes Call API Finally Done.');
        echo json_encode($responce);
    }

    public function editob(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not found.');
        $uid=(isset($request->uid))?$request->uid:0;
        $ob_id=(isset($request->ob_id))?$request->ob_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        $Observation = DB::table('observations_master')->where('ob_id',$ob_id)->first();
        if(empty($Observation)){
            echo json_encode($responce);
            die;
        }
        if($r_name != 'Super Admin' && $Observation->created_by != $uid){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);
            die;            
        }
        $obtype = $this->getcatsdata(1);
        $sites  = $this->getsitedata();
        $data = (array)$Observation;

        //$data['oc_id']=$Observation->oc_id;
        //$data['site_id']=$Observation->site_id;
        $data['typename']=$this->namebyid('cat',$Observation->oc_id);
        $data['sitename']=$this->namebyid('site',$Observation->site_id);
        $data['observationtypelist']=$obtype;
        $data['sitelist']=$sites;
        //$data['obdatetime']=date('d M, Y D h:i a',strtotime($Observation->obdatetime));
        $data['obdatetime']=date('m/d/Y h:i a',strtotime($Observation->obdatetime));
        $data['created_at']=date('d M, Y D h:i a',strtotime($Observation->created_at));        
 
        $replayattached=array();
        $observations_reply_attachement=DB::table('observations_reply_attachement')->where('ora_ob_id',$ob_id)->get();
        if(!empty($observations_reply_attachement)){
                foreach ($observations_reply_attachement as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->ora_attachament);
                    $path_info = pathinfo($attachamentsrc); 
                    $is_img = 1;                   
                    if($path_info['extension']=='pdf'){
                        $attachamentsrc=asset('images/pdf.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='docx' || $path_info['extension']=='doc'){
                        $attachamentsrc=asset('images/doc.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='xlsx' || $path_info['extension']=='xls'){
                        $attachamentsrc=asset('images/excel.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='bin'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='pptx' || $path_info['extension']=='ppt'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    } 
                    $url = url('storage/'.$value->ora_attachament);
                    $replayattached[] = array(
                        'ora_id'    => $value->ora_id,
                        'ob_id'    => $value->ora_ob_id,
                        'image'    => $attachamentsrc,
                        'name'     => $value->ora_attachement_name,
                        'url'      => $url,
                        'ext'      => $path_info['extension'],
                        'is_img'   => $is_img,
                    );

                }            
        }       
        $data['replayattached'] = $replayattached;

        $attached=array();
        $observations_attachement_rel=DB::table('observations_attachement_rel')->where('ob_id',$ob_id)->get();
        if(!empty($observations_attachement_rel)){
                foreach ($observations_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc); 
                    $is_img = 1;                   
                    if($path_info['extension']=='pdf'){
                        $attachamentsrc=asset('images/pdf.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='docx' || $path_info['extension']=='doc'){
                        $attachamentsrc=asset('images/doc.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='xlsx' || $path_info['extension']=='xls'){
                        $attachamentsrc=asset('images/excel.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='bin'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='pptx' || $path_info['extension']=='ppt'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    } 
                    $url = url('storage/'.$value->attachament);
                    $attached[] = array(
                        'oar_id'    => $value->oar_id,
                        'ob_id'    => $value->ob_id,
                        'image'    => $attachamentsrc,
                        'name'     => $value->attachement_name,
                        'url'      => $url,
                        'ext'      => $path_info['extension'],
                        'is_img'   => $is_img,
                    );

                }            
        }
        $data['attached'] = $attached;

        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'u.name','cm.cm_name','s.site_name','c.category_name','om.*');
        $Actions->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $Actions->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $Actions->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $Actions->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_parent_id',$ob_id);        
        $Actions->where('am.am_module_type',1);        
        $Actions = $Actions->get();

        $action_data = array();
        if(!empty($Actions)){
            foreach($Actions as $actval){
                $innerdata=array(
                  'actind'=>'',
                  'am_id'=>$actval->am_id,
                  'action'=>$actval->am_description,
                  'controlid'=>$actval->am_control,
                  'duedate'=>date('m/d/Y h:i a',strtotime($actval->am_due_date)),
                  'remark'=>$actval->am_remark,
                  'status'=>$actval->am_status,
                  'control'=>$this->namebyid('control',$actval->am_control),
                );
                $actions_responsible =  DB::table('actions_responsible')->where('am_id',$actval->am_id)->get();
                $respid = array();
                $respname=array();
                if(!empty($actions_responsible)){
                    foreach($actions_responsible as $act_resp){
                        $Users=UserByTennat::where('id',$act_resp->user_id)->first();
                        if(!empty($Users)){
                            $respid[]=$act_resp->user_id; 
                            $respname[]= $Users->name;  
                        }
                    }
                }
                $innerdata['respid']=$respid;
                if(!empty($respname)){
                    $innerdata['resp']=implode(",",$respname);
                }else{
                    $innerdata['resp']='';
                }
                $action_data[] = $innerdata;
            }
        }
        $data['actions']=$action_data;

        $riskpotentialaccess = $this->user_has_access($uid,64);
        $actionaccess = $this->user_has_access($uid,54);
        $statusaccess = $this->user_has_access($uid,61);

        $actionedit   = $this->user_has_access($uid,55);
        $actiondelete = $this->user_has_access($uid,56);

        $data['riskpotentialaccess'] = $riskpotentialaccess;
        $data['actionaccess'] = $actionaccess;
        $data['statusaccess'] = $statusaccess;
        $data['actionedit']   = $actionedit;
        $data['actiondelete'] = $actiondelete;        

        $responce = array('error'=>0,'responce'=>$data,'msg'=>'Success');
        echo json_encode($responce);
        die;
    }

    public function geteditactdata(Request $request){

        $responce = array('error'=>1,'responce'=>'failed','msg'=>'No Action Found.');
        $uid=(isset($request->uid))?$request->uid:0;
        $am_id=(isset($request->am_id))?$request->am_id:0;
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $attached=array();
        $actions_attachement_rel=DB::table('actions_attachement_rel')->where('am_id',$am_id)->get();
        if(!empty($actions_attachement_rel)){
                foreach ($actions_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc); 
                    $is_img = 1;                   
                    if($path_info['extension']=='pdf'){
                        $attachamentsrc=asset('images/pdf.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='docx' || $path_info['extension']=='doc'){
                        $attachamentsrc=asset('images/doc.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='xlsx' || $path_info['extension']=='xls'){
                        $attachamentsrc=asset('images/excel.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='bin'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='pptx' || $path_info['extension']=='ppt'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    } 
                    $url = url('storage/'.$value->attachament);
                    $attached[] = array(
                        'aa_id'    => $value->aa_id,
                        'am_id'    => $value->am_id,
                        'image'    => $attachamentsrc,
                        'name'     => $value->attachement_name,
                        'url'      => $url,
                        'ext'      => $path_info['extension'],
                        'is_img'   => $is_img,
                    );
                }            
        }
        $data['attached'] = $attached;
        $Actions= DB::table('actions_master as am');
        $Actions->select('am.*', 'u.name','cm.cm_name','s.site_name','c.category_name','om.*');
        $Actions->leftJoin('users as u', 'u.id', '=', 'am.am_created_by');        
        $Actions->leftJoin('observations_master as om', 'om.ob_id', '=', 'am.am_parent_id');
        $Actions->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $Actions->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $Actions->leftJoin('control_master as cm', 'cm.cm_id', '=', 'am.am_control');
        $Actions->whereNull('am.deleted_at') ;
        $Actions->where('am.am_id',$am_id);      
        $Actions = $Actions->get();
        $action_data = array();
        if(!empty($Actions)){
            foreach($Actions as $actval){
                $innerdata=array(
                  'actind'=>'',
                  'am_id'=>$actval->am_id,
                  'action'=>$actval->am_description,
                  'controlid'=>$actval->am_control,
                  'duedate'=>date('m/d/Y h:i a',strtotime($actval->am_due_date)),
                  'remark'=>(!is_null($actval->am_remark))?$actval->am_remark:'',
                  'status'=>$actval->am_status,
                  'control'=>$this->namebyid('control',$actval->am_control),
                  'attached'=>$attached,
                  'am_module_type'=>$actval->am_module_type
                );
                $actions_responsible =  DB::table('actions_responsible')->where('am_id',$actval->am_id)->get();
                $respid = array();
                $respname=array();
                if(!empty($actions_responsible)){
                    foreach($actions_responsible as $act_resp){
                        $Users=UserByTennat::where('id',$act_resp->user_id)->first();
                        if(!empty($Users)){
                            $respid[]=$act_resp->user_id; 
                            $respname[]= $Users->name;  
                        }
                    }
                }
                $innerdata['respid']=$respid;
                if(!empty($respname)){
                    $innerdata['resp'] = implode(",",$respname);
                }else{
                    $innerdata['resp'] = '';
                }
                $action_data[] = $innerdata;
            }
        }        
        if(!empty($action_data)){
            $responce = array('error'=>0,'responce'=>$action_data,'msg'=>'');
        }
        echo json_encode($responce);
        die;

    }

    public function deleteaction(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $uid=(isset($request->uid))?$request->uid:0;
        $am_id=(isset($request->am_id))?$request->am_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        $Action =DB::table('actions_master')->where('am_id',$am_id)->first();
        if(empty($Action)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Action not found.');
            echo json_encode($responce);
            die;
        }
        DB::table('actions_master')->where('am_id',$am_id)->delete();
        DB::table('actions_responsible')->where('am_id',$am_id)->delete();
        $responce = array('error'=>0,'responce'=>'','msg'=>'Action Succesfully Deleted.');
        echo json_encode($responce);
        die;
    }    


    public function updateact(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not added.');
        $uid=(isset($request->uid))?$request->uid:0;
        $am_id=(isset($request->am_id))?$request->am_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        $usernames = array();
        $Action = DB::table('actions_master')->where('am_id',$am_id)->first();
        if(empty($Action)){
            $responce = array('error'=>1,'responce'=>'failed','msg'=>'Action not found.');
            echo json_encode($responce);
            die;
        }
        $action=(isset($request->action))?$request->action:'';
        $duedate=(isset($request->duedate))?date('Y-m-d H:i:s ',strtotime($request->duedate)):'';
        $controlid=(isset($request->controlid))?$request->controlid:'';
        $remark=(isset($request->remark))?$request->remark:'';
        $status=(isset($request->status))?$request->status:'';
        $remark=(isset($request->remark))?$request->remark:'';
        $respid=(isset($request->respid))?$request->respid:'';

        $Actions = \App\Actions::find($am_id);
        $Actions->am_description = $action;
        $Actions->am_due_date = $duedate;
        $Actions->am_control = $controlid;
        $Actions->am_remark = $remark;
        $Actions->am_status = $status;
        $Actions->save(); 
        
        $am_id=$Actions->am_id;
        if(!empty($respid)){
            $respid=explode(",",$respid);
            $ararr=array();
            foreach ($respid as $user_id_value) {
                $single=array();    
                $single['am_id']= $am_id;
                $single['user_id']=$user_id_value;
                $ararr[]=$single;
                $usernames[]=$user_id_value;
            }
            DB::table('actions_responsible')->where('am_id',$am_id)->delete();
            DB::table('actions_responsible')->insert($ararr);    
        }
        $companyname = $request->companyname;
        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        if(!empty($photosadd)){
            $attached=array();
            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'am'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['am_id']=$am_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
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
        $ActionsOpen->where('am.am_id',$request->am_id) ;
        $ActionsOpen= $ActionsOpen->first(); 

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
        $subject = $mlstatus.': An action has been updated';
        if(!empty($respid)){                   
            foreach ($respid as $user_id_value) {
                $useremail = get_user_field($user_id_value, 'email');
                $useremail = 'kishanu.gc@gmail.com';
                $username = get_user_field($user_id_value, 'name');
                
                $hasmail = Mail::send('email.action_update', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });

            }                    
        }




        $responce = array('error'=>0,'responce'=>'failed','msg'=>'Action Succesfully Updated.');
        echo json_encode($responce);
        die;       
    }



    public function updateob(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not added.');
        $uid=(isset($request->uid))?$request->uid:0;
        $ob_id=(isset($request->ob_id))?$request->ob_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);

        $parentuser = $user;
        $mlactions = array();

        $Observation = DB::table('observations_master')->where('ob_id',$ob_id)->first();
        if(empty($Observation)){
            $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not found.');
            echo json_encode($responce);
            die;
        }

        $Observation =  \App\Observation::find($ob_id);
        $Observation->site_id = $request->site_id;
        $Observation->oc_id = $request->oc_id;
        $Observation->description = $request->description;
        $Observation->obdatetime = date('Y-m-d H:i:s ',strtotime($request->obdatetime));
        $Observation->riskpotentiallevel = $request->riskpotentiallevel;
        $Observation->action_required = $request->action_required;
        $Observation->Comments = $request->comments;
        $Observation->status = $request->status;
        if($request->ob_closing_comments && $request->status!=1){
            $Observation->ob_closing_comments = $request->ob_closing_comments;     
        }else{
            $Observation->ob_closing_comments = '';     
        }


        $reqmoreemail = 0;
        if(isset($request->ob_more_information_required)){
            if($Observation->ob_more_information_required != 1){
                $reqmoreemail = 1;
            }
            $Observation->ob_more_information_required = 1;
            $Observation->ob_information_required = $request->ob_information_required;
            $Observation->ob_reply_information_requested = $request->ob_reply_information_requested; 
        }else{
            $Observation->ob_more_information_required = 0;
        }


        //$Observation->created_by = $request->uid;
        $Observation->save();
        
        $ob_describethelocation = (isset($request->ob_describethelocation))?$request->ob_describethelocation:'';
        $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$ob_describethelocation;

        
        if($request->action_required == 1 && !empty($request->actions)){
            $actions = json_decode($request->actions);
            foreach($actions as $act){

                if(!empty($act->am_id)){
                    $Actions = \App\Actions::find($act->am_id);
                }else{
                    $Actions = new \App\Actions;    
                }
                $Actions->am_parent_id = $ob_id;
                $Actions->am_module_type = 1;
                $Actions->am_site_id = $request->site_id;
                $Actions->am_description = $act->action;
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($act->duedate));
                $Actions->am_control = $act->controlid;
                $Actions->am_remark = $act->remark;
                $Actions->am_status = $act->status;
                $Actions->am_created_by = $request->uid;
                $Actions->save(); 
                $am_id=$Actions->am_id; 
                $usernames = array(); 
                if(!empty($act->respid)){
                    $ararr=array();
                    foreach ($act->respid as $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                        //for e
                        $usernames[] = get_user_field($user_id_value, 'name');
                    }
                    DB::table('actions_responsible')->where('am_id',$am_id)->delete();
                    DB::table('actions_responsible')->insert($ararr);    
                }  


                //For Mail
                
                

                $mlaction = array();
                $mlaction['description'] = $act->action;
                $mlaction['control'] = get_control_field($act->controlid, 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($act->duedate)); 

                $mlstatus = GetActionStatus($act->status);

                $mlaction['status'] = $mlstatus;
                $mlaction['remarks'] = $act->remark;
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                
                $subject = $mlstatus.': An action assigned to you';
                //Act Resp Email
                
                if(!empty($act->respid) && empty($act->am_id)){                 
                    foreach ($act->respid as $user_id_value){
                        $useremail = get_user_field($user_id_value, 'email');
                        $username = get_user_field($user_id_value, 'name');
                        Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                            $m->to($useremail, $username)->subject($subject);
                        });  
                    }                    
                }
                $mlactions[] = $mlaction;
               


            }
            DB::table('actions_master')->where('am_parent_id', $ob_id)->where('am_module_type',1)->update(['am_site_id' => $request->site_id]);
        }
        $companyname = $request->companyname;
        if(isset($request->ob_more_information_required)){
            
            $rtotal_images = $request->rtotal_images;
            $rphotosadd = array();
            $rphotosname = array();
            $rphotosext = array();
            for ($i=0; $i < $rtotal_images; $i++) { 
              $rphotosadd[] = $request->{'rphotosaddhidden'.$i};
              $rphotosname[] = $request->{'rphotosname'.$i};
              $rphotosext[] = $request->{'rphotosext'.$i};
            }

             if(!empty($rphotosadd)){
                $attached=array();
                foreach ($rphotosadd as $key => $img) {
                      $image = base64_decode($img);
                      $image_name = 'ob'.$key.time();
                      $picture = $image_name.'.'.$rphotosext[$key];
                      $storefullpath = 'public/'.$companyname.'/'.$picture;
                      Storage::put($storefullpath, $image);
                      $single=array();    
                      $single['ora_ob_id']=$ob_id;
                      $single['ora_attachament']=str_replace('public/', '', $storefullpath);
                      $single['ora_attachement_name']=$rphotosname[$key];
                      $attached[]=$single;                    
                } 
                DB::table('observations_reply_attachement')->insert($attached);           
            }            


        }

        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        
        if(!empty($photosadd)){
            $attached=array();
            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'ob'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['ob_id']=$ob_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
            } 
            DB::table('observations_attachement_rel')->insert($attached);           
        } 


        //Send Mail to admin
        //For Mail
        
        
        $observations = array();
        $observations['ob_srno'] = $Observation->ob_srno;
        $observations['ob_information_required'] = '';
        $observations['observationtype'] = get_category_field($request->oc_id, 'category_name');
        $observations['description'] = $request->description;
        $observations['sites'] = $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$Observation->ob_describethelocation;
        $observations['datetime'] = $request->obdatetime;
        $risklevel = '';
        if($request->riskpotentiallevel == 1){ $risklevel = 'MINOR'; }
        if($request->riskpotentiallevel == 2){ $risklevel = 'SERIOUS'; }
        if($request->riskpotentiallevel == 3){ $risklevel = 'FATAL'; }
        $observations['risklevel'] = $risklevel;
        $observations['comments'] = $request->comments;
        $observations['actions'] = $mlactions;

        //OB Update E-mail Start
        $subject = 'Observation report updated';
        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                

                $username = $ademl->name;

                Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }
        //isset($request->ob_more_information_required) && $uid != $Observation->created_by && $reqmoreemail
        
        //&& $uid != $Observation->created_by
        if(isset($request->ob_more_information_required) && $uid != $Observation->created_by && $reqmoreemail){

            $observations['ob_information_required'] = $Observation->ob_information_required;
            $created_by = DB::table('users')->where('id', $Observation->created_by)->where('status', 1)->first();    

            $useremail = $created_by->email;
            $username = $created_by->name;

            $subjectforcreatror = 'Observation report '.$Observation->ob_srno.' required more information.';
            Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
                $m->to($useremail, $username)->subject($subjectforcreatror);
            });
        }

        //Send to creator
        $created_by = DB::table('users')->where('id', $Observation->created_by)->where('status', 1)->first();                
        $useremail =$created_by->email;
        $username = $created_by->name;
        
        

        $subjectforcreatror = 'Observation report successfully updated.';
        Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
            $m->to($useremail, $username)->subject($subjectforcreatror);
        });               

 
         //Send Mail to Site head of safety        
        $headid = GetHeadofSafetyEmailName($request->site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value) {
                $useremail = $value['email'];
                $username =  $value['name'];  
                  
                Mail::send('email.observations_edit', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });   
            }            
        }


        $responce = array('error'=>0,'responce'=>'failed','msg'=>'Observation succesfully edit.');
        echo json_encode($responce);
        die;
               
    }

    public function addob(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not added.');
        
        $mlactions = array();

        $input = $request->all();
        $user = User::find($request->uid);

        $parentuser = $user;

        $companyid = $user->companyid;

        $Observation = new \App\Observation;
        $Observation->ob_srno = '';
        $Observation->site_id = $request->site_id;
        $Observation->ob_describethelocation = $request->ob_describethelocation;
        $Observation->oc_id = $request->oc_id;
        $Observation->description = $request->description;
        $Observation->obdatetime = date('Y-m-d H:i:s ',strtotime($request->obdatetime));
        $Observation->riskpotentiallevel = $request->riskpotentiallevel;
        $Observation->action_required = $request->action_required;
        $Observation->Comments = $request->comments;
        $Observation->listing_type = $request->listing_type;
        $Observation->status = 1;
        $Observation->created_by = $request->uid;
        $Observation->save();

        $ob_id=$Observation->ob_id;
        $ob_srno='OBS'.str_pad($companyid, 2, '0', STR_PAD_LEFT).str_pad( $ob_id, 4, '0', STR_PAD_LEFT); 
        DB::table('observations_master')->where('ob_id', $ob_id)->update(['ob_srno' => $ob_srno]);

        $sitesname = get_site_field($request->site_id, 'site_name');

        if($request->action_required == 1 && !empty($request->actions)){
            $actions = json_decode($request->actions);
            foreach($actions as $act){
                $Actions = new \App\Actions;
                $Actions->am_parent_id = $ob_id;
                $Actions->am_module_type = 1;
                $Actions->am_site_id = $request->site_id;
                $Actions->am_description = $act->action;
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($act->duedate));
                $Actions->am_control = $act->controlid;
                $Actions->am_remark = $act->remark;
                $Actions->am_status = $act->status;
                $Actions->am_created_by = $request->uid;
                $Actions->save(); 
                $am_id=$Actions->am_id; 
                $usernames = array();

                if(!empty($act->respid)){
                    $ararr=array();
                    foreach ($act->respid as $user_id_value) {
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
                $mlaction['description'] = $act->action;
                $mlaction['control'] = get_control_field($act->controlid, 'cm_name');
                $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($act->duedate)); 

                $mlstatus = GetActionStatus($act->status);

                $mlaction['status'] = $mlstatus;
                $mlaction['remarks'] = $act->remark;
                $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):'';                
                $subject = $mlstatus.': An action assigned to you';
                //Act Resp Email
                if(!empty($act->respid)){                  
                    foreach ($act->respid as $user_id_value){
                        $useremail = get_user_field($user_id_value, 'email');
                        $username = get_user_field($user_id_value, 'name');
                        Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                            $m->to($useremail, $username)->subject($subject);
                        });  
                    }                    
                }
                $mlactions[] = $mlaction;



            }
            DB::table('actions_master')->where('am_parent_id', $ob_id)->where('am_module_type',1)->update(['am_site_id' => $request->site_id]);
        }

        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        $companyname = $request->companyname;
        if(!empty($photosadd)){
            $attached=array();
            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'ob'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['ob_id']=$ob_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
            } 
            DB::table('observations_attachement_rel')->insert($attached);           
        }      

        //Send Mail to admin
        $observations = array();
        $observations['ob_srno'] = $ob_srno;
        $observations['observationtype'] = get_category_field($request->oc_id, 'category_name');
        $observations['description'] = $request->description;
        $observations['sites'] = $sitesname= ($request->site_id!=0)?get_site_field($request->site_id, 'site_name'):$request->ob_describethelocation;
        $observations['datetime'] = date('Y-m-d H:i:s ',strtotime($request->obdatetime));
        $risklevel = '';
        if($request->riskpotentiallevel == 1){ $risklevel = 'MINOR'; }
        if($request->riskpotentiallevel == 2){ $risklevel = 'SERIOUS'; }
        if($request->riskpotentiallevel == 3){ $risklevel = 'FATAL'; }
        $observations['risklevel'] = $risklevel;
        $observations['comments'] = $request->comments;
        $observations['actions'] = $mlactions;
        
        $subject = 'New Observation report created';

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }
        }

       //Send to creator 
        $useremail =$parentuser->email;
        $username = $parentuser->name;
        $subjectforcreatror = 'New Observation report successfully created.';
        Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subjectforcreatror) {            
            $m->to($useremail, $username)->subject($subjectforcreatror);
        });
 
        //Send Mail to Site head of safety        
        $headid = GetHeadofSafetyEmailName($request->site_id);
        if(!empty($headid)){
            foreach ($headid as $key => $value){
                $useremail = $value['email'];
                $username =  $value['name'];    
                Mail::send('email.observations', ['username' => $username, 'useremail' => $useremail, 'observations' => $observations], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });   
            }            
        } 


        $responce = array('error'=>0,'responce'=>'Success','msg'=>'Observation succesfully added.');
        echo json_encode($responce);

    }

    public function getobdetail(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $uid=(isset($request->uid))?$request->uid:0;
        $ob_id=(isset($request->ob_id))?$request->ob_id:'';
        if(empty($ob_id)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Observations Not Found.');
            echo json_encode($responce);  
            die;           
        }
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        if(empty($r_name)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'User Not Valid. Please logout & login again.');
            echo json_encode($responce);  
            die;
        }
        $obsingledata = array();
        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name','u.empid','c.category_name','s.site_name');
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        $observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');
        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
        $observations1->whereNull('om.deleted_at') ;
        $observations1->where('om.ob_id',$ob_id) ;        
        $Observation= $observations1->first();
        if(empty($Observation)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Observations Not Found.');
            echo json_encode($responce);  
            die;             
        }else{
            $obsingledata=(array)$Observation;
            $formate_ob_date=date('d M, Y D h:ia',strtotime($obsingledata['obdatetime']));
            $formate_created_at=date('d M, Y D h:ia',strtotime($obsingledata['created_at']));

            $riskpotentiallevelname = GetRiskLevel($Observation->riskpotentiallevel);

            $obsingledata['formate_ob_date']=$formate_ob_date;
            $obsingledata['formate_created_at']=$formate_created_at;
            $obsingledata['riskpotentiallevelname']=$riskpotentiallevelname;


            $obsingledata['edit']=0;
            $obsingledata['delete']=0;
            if($r_name == 'Super Admin' || $obsingledata['created_by'] == $uid){
                $obsingledata['delete'] = 1;
                $obsingledata['edit']=1;
            }           

            $observations_attachement_rel=DB::table('observations_attachement_rel')->where('ob_id',$ob_id)->get();

            $ob_attachment = array();
            if($observations_attachement_rel){
                foreach ($observations_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $type='image';
                    $path_info = pathinfo($attachamentsrc);                    
                    if($path_info['extension']=='pdf'){ $type='pdf'; $attachamentsrc=asset('images/pdf.png');}
                    if($path_info['extension']=='docx'){$type='docx'; $attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='doc'){$type='doc'; $attachamentsrc=asset('images/doc.png');}
                    if($path_info['extension']=='xlsx'){$type='xlsx'; $attachamentsrc=asset('images/excel.png');}
                    if($path_info['extension']=='bin'){$type='bin'; $attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='pptx'){$type='pptx'; $attachamentsrc=asset('images/ppt.png');}
                    if($path_info['extension']=='ppt'){$type='ppt'; $attachamentsrc=asset('images/ppt.png');}
                    $url=url('storage/'.$value->attachament);

                    $athdata=(array)$value;
                    $athdata['extension'] = $path_info['extension'];
                    $athdata['image'] = $attachamentsrc;
                    $athdata['url']   = $url;
                    $athdata['type']  = $type;
                    $ob_attachment[]  = $athdata;
                }

            }
            $obsingledata['ob_attachment']=$ob_attachment;

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
            $Actions->where('am.am_parent_id',$ob_id) ;        
            $Actions->where('am.am_module_type',1) ;        
            $Actions = $Actions->get(); 

            $all_actions=array();
            if(!empty($Actions)){
                foreach($Actions as $ActionsOpen_item){
                    $am_desc_short  = substr($ActionsOpen_item->am_description,0,70);
                    $responsibility = GetActionResponsibility($ActionsOpen_item->am_id);
                    $due_by     = date('d M, Y',strtotime($ActionsOpen_item->am_due_date));
                    $act_status = GetActionStatus($ActionsOpen_item->am_status);
                    
                    $acndata    = array();
                    $acndata['am_id']          = $ActionsOpen_item->am_id;
                    $acndata['am_desc_short']  = $am_desc_short;
                    $acndata['responsibility'] = $responsibility;
                    $acndata['due_by']         = $due_by;
                    $acndata['act_status']     = $act_status;
                    $acndata['cm_name']        = $ActionsOpen_item->cm_name;
                    $all_actions[] = $acndata;
                }
            }
            $obsingledata['all_actions']=$all_actions;
        }
        $responce = array('error'=>0,'responce'=>$obsingledata,'msg'=>'');
        echo json_encode($responce);  
        die;                        
    }

    public function deleteob(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $uid=(isset($request->uid))?$request->uid:0;
        $ob_id=(isset($request->ob_id))?$request->ob_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        $Observation = DB::table('observations_master')->where('ob_id',$ob_id)->first();
        if(empty($Observation)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Observation not found.');
            echo json_encode($responce);
            die;
        }
        if($r_name != 'Super Admin' && $Observation->created_by != $uid){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);
            die;            
        }
        DB::table('observations_master')->where('ob_id',$ob_id)->delete();
        $responce = array('error'=>0,'responce'=>'','msg'=>'Observation succesfully deleted.');
        echo json_encode($responce);
        die;
    }

    public function getobservations(Request $request){
        
        $permission = array('edit'=>0,'delete'=>0);
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $obs_data=array();
        $r_limit = 5;
        $status=1;
        $start = (isset($request->start))?$request->start:0;

        $uid=(isset($request->uid))?$request->uid:0;        
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        if(empty($r_name)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'User Not Valid. Please logout & login again.');
            echo json_encode($responce);  
            die;
        }


        $filtercat=(isset($request->filtercat))?$request->filtercat:'';
        
        $status=(isset($request->status))?$request->status:1;

        $riskpotentiallevel=(isset($request->filterrlevel))?$request->filterrlevel:'';

        $sdate = (isset($request->sdate))?$request->sdate:'';
        $edate = (isset($request->edate))?$request->edate:'';

        if(!empty($sdate) && !empty($edate)){
            $sdate = date('Y-m-d 00:00:00',strtotime($sdate));
            $edate = date('Y-m-d 23:59:59',strtotime($edate));
        }

        $filtersite = (isset($request->filtersite))?$request->filtersite:array();

        $searchtxt = (isset($request->searchtxt))?$request->searchtxt:'';

        if($request->filtersite && $request->filtersite!=0){
            $filtersite=array();
            $Sites = Sites::where('status',1)->where('id',$request->filtersite)->whereNull('deleted_at')->first(); 
            $filtersite[]=$Sites->id;
            if($Sites->site_type==1){
                $SitesOne = Sites::where('status',1)->where('site_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesOne as $key => $value) {
                    $filtersite[]=$value->id;                    
                }
            }
            if($Sites->site_type==2){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->whereNull('deleted_at')->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                }
            }
            if($Sites->site_type==3){
                $SitesTwo = Sites::where('status',1)->where('sub_parent',$Sites->id)->whereNull('deleted_at')->get(); 
                foreach ($SitesTwo as $key => $value) {
                    $filtersite[]=$value->id;
                        $SitesThree = Sites::where('status',1)->where('sub_parent',$value->id)->whereNull('deleted_at')->get(); 
                        if($SitesThree){
                            foreach ($SitesThree as $key => $value) {
                                $filtersite[]=$value->id;                    
                            }    
                        }
                }
            }
        }



       /*
        $has_site = false;
        if(!empty($searchtxt)){
            $searchdd = Sites::where('status',1)->where('site_name','LIKE','%'.$searchtxt.'%')->whereNull('deleted_at')->get(); 
            if(!empty($searchdd)){
                foreach($searchdd as $sdf){
                    $has_site = true;
                    $filtersite[]=$sdf->id; 
                }
            }
        }
        */
        
        //print_r($filtersite);

        $observations1= DB::table('observations_master as om');
        $observations1->select('om.*', 'u.name', 'u.empid','c.category_name','s.site_name');
        
        $observations1->leftJoin('users as u', 'u.id', '=', 'om.created_by');
        
        //$observations1->leftJoin('sites as s', 's.id', '=', 'om.site_id');

        $observations1->leftJoin('sites as s', function ($join) {
           $join->on('s.id', '=', 'om.site_id')->whereNull('om.deleted_at');
        });

        $observations1->leftJoin('category as c', 'c.id', '=', 'om.oc_id');

        $observations1->whereNull('om.deleted_at');
        $observations1->where('om.status',$status);        

        if(!empty($filtersite)){  
            $observations1->whereIn('om.site_id',$filtersite);   
        }
        if(!empty($sdate) && !empty($edate)){  
            $observations1->whereBetween('om.created_at', [$sdate,$edate]); 
        }
        if($filtercat!=''){   
            $observations1->where('om.oc_id',$filtercat);    
        }
        if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   
            $observations1->where('om.riskpotentiallevel',$riskpotentiallevel);  
        }
        if(!empty($searchtxt)){
          $observations1->where('om.description','LIKE','%'.$searchtxt.'%');
          
          $observations1->orWhere('c.category_name','LIKE','%'.$searchtxt.'%')->whereNull('om.deleted_at')->where('om.status',$status);  
              if(!empty($filtersite)){  
                    $observations1->whereIn('om.site_id',$filtersite);   
              }
              if(!empty($sdate) && !empty($edate)){  
                    $observations1->whereBetween('om.created_at', [$sdate,$edate]); 
              }
              if($filtercat!=''){   
                    $observations1->where('om.oc_id',$filtercat);    
              }
              if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   
                    $observations1->where('om.riskpotentiallevel',$riskpotentiallevel);  
              }

          
          $observations1->orWhere('s.site_name','LIKE','%'.$searchtxt.'%')->whereNull('om.deleted_at')->where('om.status',$status);
              if(!empty($filtersite)){  
                    $observations1->whereIn('om.site_id',$filtersite);   
              }
              if(!empty($sdate) && !empty($edate)){  
                    $observations1->whereBetween('om.created_at', [$sdate,$edate]); 
              }
              if($filtercat!=''){   
                    $observations1->where('om.oc_id',$filtercat);    
              }
              if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   
                    $observations1->where('om.riskpotentiallevel',$riskpotentiallevel);  
              }          

        }

        $observations1->orderBy('om.ob_id','DESC');

        $total = $observations1->count();
        $ObservationList = $observations1->skip($start)->take($r_limit)->get();
        if(!empty($ObservationList)){
            foreach($ObservationList as $oblist){
                $adddata = (array)$oblist;
                $formate_ob_date=date('d M, Y D h:ia',strtotime($oblist->obdatetime));
                $short_desc=substr($oblist->description,0,57);
                $formate_created_at=date('d M, Y D h:ia',strtotime($oblist->created_at));
                $adddata['formate_ob_date']=$formate_ob_date;
                $adddata['formate_created_at']=$formate_created_at;
                $adddata['short_desc']=$short_desc;
                $adddata['edit']=0;
                $adddata['delete']=0;
                $adddata['overdue']=0;
                $ob_date=date('Y-m-d',strtotime($oblist->obdatetime));
                $curdate = date('Y-m-d');
                if($ob_date<$curdate){
                    $adddata['overdue']=1;
                }
                if($r_name == 'Super Admin' || $oblist->created_by == $uid){
                    $adddata['delete'] = 1;
                    $adddata['edit']=1;
                }
                $obs_data[]=$adddata;
            }
        }
        $start = $start+$r_limit;
        $responce = array('error'=>0,'responce'=>$obs_data,'total'=>$total,'start'=>$start,'msg'=>'');
        echo json_encode($responce);              
        die;

    }

    //incidents

    public function getincidents(Request $request){
        $permission = array('edit'=>0,'delete'=>0,'view'=>0);
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $inc_data=array();
        $r_limit = 5;
        $status=(isset($request->status))?$request->status:1;
        $start = (isset($request->start))?$request->start:0; 
        $uid=(isset($request->uid))?$request->uid:0;        
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($uid);
        if(empty($r_name)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'User Not Valid. Please logout & login again.');
            echo json_encode($responce);  
            die;
        }
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec) || $r_name == 'Super Admin'){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $has_edit   = '';
        $has_delete = '';
        $incedent_delete_id = 8;
        $incedent_edit_id = 7;
        $has_edit_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_edit_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_edit_rec)){
            $has_edit   = 'Yes';
        }
        $has_delete_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_delete_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_delete_rec)){
            $has_delete   = 'Yes';
        }
        $filterdate = (isset($request->filterdate))?$request->filterdate:'';
        
        $filtersite=(isset($request->filtersite))?$request->filtersite:'';
        $filtercat=(isset($request->filtercat))?$request->filtercat:'';
        $riskpotentiallevel=(isset($request->filterrlevel))?$request->filterrlevel:'';        
        $sdate = (isset($request->sdate))?$request->sdate:'';
        $edate = (isset($request->edate))?$request->edate:'';

        if(!empty($sdate) && !empty($edate)){
            $sdate = date('Y-m-d 00:00:00',strtotime($sdate));
            $edate = date('Y-m-d 23:59:59',strtotime($edate));
        }

        $searchtxt = (isset($request->searchtxt))?$request->searchtxt:'';
        

        if($request->filtersite){
            $filtersite=array();
            $Sites = Sites::where('status',1)->where('id',$request->filtersite)->first(); 
            $filtersite[]=$Sites->id;
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

        $incidents1= DB::table('incidents_master as im');
        $incidents1->select('im.*', 'u.name','c.category_name','s.site_name','ir.rating','ir.rating_type','ir.rating_text');
        $incidents1->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
        $incidents1->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
        $incidents1->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
        $incidents1->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
        $incidents1->whereNull('im.deleted_at') ;
        $incidents1->where('im.im_status',$status);
        if($riskpotentiallevel!='' && $riskpotentiallevel!=0){   
            $incidents1->where('ir.rating_type',$riskpotentiallevel);    
        }
        if(!empty($filtersite)){  $incidents1->whereIn('im.im_site_id',$filtersite);  }
        if(!empty($sdate) && !empty($edate)){ $incidents1->whereBetween('im.created_at', [$sdate,$edate]); }
        if($filtercat!=''){   $incidents1->where('im.im_ic_id',$filtercat); }

        if(!empty($searchtxt)){
            $incidents1->where('im.im_description','LIKE','%'.$searchtxt.'%');

            $incidents1->orWhere('c.category_name','LIKE','%'.$searchtxt.'%')->whereNull('im.deleted_at')->where('im.im_status',$status);
            if(!empty($filtersite)){  $incidents1->whereIn('im.im_site_id',$filtersite);  }
            if(!empty($sdate) && !empty($edate)){ $incidents1->whereBetween('im.created_at', [$sdate,$edate]); }
            if($filtercat!=''){   $incidents1->where('im.im_ic_id',$filtercat); }

            $incidents1->orWhere('s.site_name','LIKE','%'.$searchtxt.'%')->whereNull('im.deleted_at')->where('im.im_status',$status);
            if(!empty($filtersite)){  $incidents1->whereIn('im.im_site_id',$filtersite);  }
            if(!empty($sdate) && !empty($edate)){ $incidents1->whereBetween('im.created_at', [$sdate,$edate]); }
            if($filtercat!=''){   $incidents1->where('im.im_ic_id',$filtercat); }

        }        

        
        $incidents1->orderBy('im.im_id','DESC');
        $total = $incidents1->count();
        $IncidentsList = $incidents1->skip($start)->take($r_limit)->get();  
        
        //print_r($IncidentsList);

        if(!empty($IncidentsList)){
            foreach($IncidentsList as $inclist){
                $adddata = (array)$inclist;
                $adddata['short_desc']=substr($inclist->im_description,0,57);
                $adddata['formate_created_at']=date('d M, Y D h:ia',strtotime($inclist->created_at));
                $adddata['formate_im_datetime']=date('d M, Y D h:ia',strtotime($inclist->im_datetime));
                $adddata['view']=0;
                $adddata['edit']=0;
                $adddata['delete']=0;
                $userrole = get_user_field($inclist->im_investigateteamlead, 'is_admin');
                $adddata['leadteamuser'] = get_user_field($inclist->im_investigateteamlead, 'name').' - '.get_role_field($userrole, 'r_name');
                $adddata['rating_likelihood']=get_rating_field($inclist->im_ratinganincident, 'likelihood');
                if($inclist->im_ratinganincident){
                    $adddata['view']=1;
                }
                if(!empty($has_edit) && ($r_name == 'Super Admin' || $inclist->created_by == $uid)){
                    $adddata['edit'] = 1;
                }
                if(!empty($has_delete) && ($r_name == 'Super Admin' || $inclist->created_by == $uid)){
                    $adddata['delete'] = 1;
                }                
                $inc_data[]=$adddata;
            }
        }
        $start = $start+$r_limit;

        //$obtype = $this->getcatsdata(2);
        //$sites  = $this->getsitedata();
        //$filterdata = array('allsites'=>$sites,'inctype'=>$obtype);
        
        $responce = array('error'=>0,'responce'=>$inc_data,'total'=>$total,'start'=>$start,'msg'=>'');
        echo json_encode($responce);              
        die;
    }    
    

    public function deleteinc(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $uid=(isset($request->uid))?$request->uid:0; 
        $im_id=(isset($request->im_id))?$request->im_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($uid);
        $has_delete = '';
        $incedent_delete_id = 8;
        $has_delete_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_delete_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_delete_rec)){
            $has_delete   = 'Yes';
        }        
        $Incidents = DB::table('incidents_master')->where('im_id',$im_id)->first();
        if(empty($Incidents)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'Incident not found.');
            echo json_encode($responce);
            die;
        }
        if(empty($has_delete) && ($r_name != 'Super Admin' && $Incidents->created_by != $uid)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);
            die;            
        }
        DB::table('incidents_master')->where('im_id',$im_id)->delete();
        $responce = array('error'=>0,'responce'=>'','msg'=>'Incident succesfully deleted.');
        echo json_encode($responce);
        die;
    }

    public function getshiftdata(){
        $shifts_data = array();
        $Shifts = DB::table('shift_master')->where('sm_status',1)->get();
        if(!empty($Shifts)){
            foreach($Shifts as $shft){
                $shifts_data[] = array(
                    'key'=>$shft->sm_id,
                    'label'=>$shft->sm_name,
                    'customKey'=>$shft->sm_id,
                );
            }
        }
        return $shifts_data;
    }

    public function getincidentdata(Request $request){
        $obtype = $this->getcatsdata(2);
        $sites  = $this->getsitedata();
        $Shifts = $this->getshiftdata();
        $responce = array('error'=>0,'responce'=>array('shifts'=>$Shifts,'sites'=>$sites,'obtype'=>$obtype),'msg'=>'');
        echo json_encode($responce);
        die;
    }

    public function addinc(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not added.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;

        $parentuser = $user;

        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $companyid = $user->companyid;
        $Incident = new \App\Incident;        
        $Incident->im_site_id = $request->im_site_id;
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;        
        $Incident->im_created_by = $request->uid;
        $Incident->im_status = 1;
        $Incident->save(); 
        $im_id=$Incident->im_id;

        $im_srno='INC'.str_pad($companyid, 2, '0', STR_PAD_LEFT).str_pad( $im_id, 4, '0', STR_PAD_LEFT);
        DB::table('incidents_master')->where('im_id', $im_id)->update(['im_srno' => $im_srno]);
        $companyid = $user->companyid;
        
        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        $companyname = $request->companyname;
        if(!empty($photosadd)){
            $attached=array();

            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'inci'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['im_id']=$im_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
            } 
            DB::table('incidents_attachement_rel')->insert($attached);           
        }

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
        $incidents['description'] = $request->im_description;
        $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');
        
        $subject = 'New incidents report created';

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if($adminemails){
            foreach ($adminemails as $ademl) {
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
                Mail::send('email.incidents', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                    $m->to($useremail, $username)->subject($subject);
                });
            }    
        } 


        $responce = array('error'=>0,'responce'=>'failed','msg'=>'Incident succesfully added.');
        echo json_encode($responce);
        die;
    }

    public function deletefilecommon(Request $request){        
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'File not deleted.');
        $uid=(isset($request->uid))?$request->uid:0;
        $table_name=(isset($request->table_name))?$request->table_name:'';
        $id_name=(isset($request->id_name))?$request->id_name:'';
        $id=(isset($request->id))?$request->id:'';
        if(!empty($table_name) && !empty($id_name) && !empty($id)){
            $attachement_rel=DB::table($table_name)->where($id_name,$id)->first();
            if($table_name == 'observations_reply_attachement'){
                Storage::delete('public/'.$attachement_rel->ora_attachament);
                DB::table($table_name)->where($id_name,$id)->delete();  
            }else{
                Storage::delete('public/'.$attachement_rel->attachament);
                DB::table($table_name)->where($id_name,$id)->delete();               
            }
            $responce = array('error'=>0,'responce'=>'Success','msg'=>'Success'); 
        }
        echo json_encode($responce);
        die;
    }

    public function editinc(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident not found.');
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=(isset($request->im_id))?$request->im_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($request->id);
        $incedent_edit_id = 7;
        $has_edit_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_edit_id,'user_by_tennat_id'=>$uid])->first();
        if(empty($has_edit_rec)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);
            die;  
        }        
        $Incident = DB::table('incidents_master')->where('im_id',$request->im_id)->first();
        if(empty($Incident)){
            $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident not found.');
            echo json_encode($responce);
            die;
        }

        $attached=array();
        $incidents_attachement_rel=DB::table('incidents_attachement_rel')->where('im_id',$im_id)->get();
        if(!empty($incidents_attachement_rel)){
                foreach ($incidents_attachement_rel as $key => $value) {                    
                    $attachamentsrc=url('storage/'.$value->attachament);
                    $path_info = pathinfo($attachamentsrc); 
                    $is_img = 1;                   
                    if($path_info['extension']=='pdf'){
                        $attachamentsrc=asset('images/pdf.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='docx' || $path_info['extension']=='doc'){
                        $attachamentsrc=asset('images/doc.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='xlsx' || $path_info['extension']=='xls'){
                        $attachamentsrc=asset('images/excel.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='bin'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    }
                    if($path_info['extension']=='pptx' || $path_info['extension']=='ppt'){
                        $attachamentsrc=asset('images/ppt.png');
                        $is_img = '';
                    } 
                    $url = url('storage/'.$value->attachament);
                    $attached[] = array(
                        'ia_id'    => $value->ia_id,
                        'image'    => $attachamentsrc,
                        'name'     => $value->attachement_name,
                        'url'      => $url,
                        'ext'      => $path_info['extension'],
                        'is_img'   => $is_img,
                    );

                }            
        }

        $data = (array)$Incident;
        $data['attached'] = $attached;

        $obtype = $this->getcatsdata(2);
        $sites  = $this->getsitedata();
        $Shifts = $this->getshiftdata();
        
        $data['obtype']=$obtype;
        $data['sites']=$sites;
        $data['Shifts']=$Shifts;
        $data['typename']=$this->namebyid('cat',$Incident->im_ic_id);
        $data['sitename']=$this->namebyid('site',$Incident->im_site_id);
        $responce = array('error'=>0,'responce'=>$data,'msg'=>'Success');
        echo json_encode($responce);
        die; 
    }


    public function updateinc(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Observation not added.');
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=(isset($request->im_id))?$request->im_id:'';
        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $user = User::find($uid);
        $parentuser = $user;

        $incedent_edit_id = 7;
        $has_edit_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_edit_id,'user_by_tennat_id'=>$uid])->first();
        if(empty($has_edit_rec)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);
            die;  
        } 
        $Incident = DB::table('incidents_master')->where('im_id',$request->im_id)->first();
        if(empty($Incident)){
            $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident not found.');
            echo json_encode($responce);
            die;
        }
        $Incident =  \App\Incident::find($im_id);   
        $Incident->im_site_id = $request->im_site_id;
        $Incident->im_ic_id = $request->im_ic_id;
        $Incident->im_description = $request->im_description;
        $Incident->im_datetime = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $Incident->im_shift = $request->im_shift;                        
        $Incident->save();
        DB::table('actions_master')->where('am_parent_id', $im_id)->where('am_module_type',2)->update(['am_site_id' => $request->im_site_id]);

        $companyid = $user->companyid;

        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        $companyname = $request->companyname;
        if(!empty($photosadd)){
            $attached=array();

            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'inci'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['im_id']=$im_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
            } 
            DB::table('incidents_attachement_rel')->insert($attached);           
        }

        //Send Mail to admin
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
        $incidents['description'] = $request->im_description;
        $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');

        $subject = 'Incidents report updated.';

        $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
        if(!empty($adminemails)){
            foreach ($adminemails as $ademl) {
                $useremail = $ademl->email;
                $username = $ademl->name;
                try {             
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }
                catch (exception $e){  
                    //$responce = array('error'=>1,'responce'=>'Success','msg'=>'Incident succesfully updated.');
                    //echo json_encode($responce);
                    //die;                   
                }                
            }
        }
        
        //Send Mail to Site head & Supervisor
        try {      
                $headid = GetHeadofSafetyEmailName($request->im_site_id);
                if(!empty($headid)){
                        foreach ($headid as $key => $value) {
                            $useremail = $value['email'];
                            $username =  $value['name'];    
                            Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                                $m->to($useremail, $username)->subject($subject);
                            });
                        }    
                }
        }
        catch (exception $e){  
            
        }                                    

        $responce = array('error'=>0,'responce'=>'Success','msg'=>'Incident succesfully updated.');
        echo json_encode($responce);
        die;
               
    }

    public function getincidentvictim(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $im_id=(isset($request->im_id))?$request->im_id:'';
        $responce['responce'] = array('victims' => '','bodypart' => '','victimtype' => '','bodypartkey' => '','victimtypekey' => '' );
        if($im_id){
            $responce['error'] = 0;
            $responce['msg'] = 'Record not found.';
            $victims= DB::table('incidents_victim as iv')
                                ->select('iv.*', 'vt.vtm_name',DB::raw('COUNT(ivbp.ivbp_iv_id) AS bodypart_count'))
                                ->leftJoin('victimtype_master as vt', 'vt.vtm_id', '=', 'iv.iv_vtm_id')
                                ->leftJoin('incidents_victim_bodypart as ivbp', 'ivbp.ivbp_iv_id', '=', 'iv.iv_id')
                                ->where('iv.iv_im_id',$im_id) 
                                ->groupBy('iv.iv_id')   
                                ->get(); 
            $victimdata = array();
            if($victims){
                foreach ($victims as $vct) {
                    $victimdata[] = array('iv_id' => $vct->iv_id, 'iv_name' => $vct->iv_name, 'iv_age_range' => $vct->iv_age_range, 'iv_gender' => GetGender($vct->iv_gender), 'bodypart_count' => isset($vct->bodypart_count)?$vct->bodypart_count:0, 'vtm_name' => $vct->vtm_name);
                }
                $responce['responce']['victims'] = $victimdata;
                $responce['msg'] = '';
            }
        }

        $victimdata = $victimdatakey = array();
        $BodyPart = BodyPart::where('bpm_status',1)->get();
        if($BodyPart){
            foreach ($BodyPart as $vct) {
                $victimdata[] = array('id' => $vct->bpm_id, 'name' => $vct->bpm_name);
                $victimdatakey[] = array('k'.$vct->bpm_id => $vct->bpm_name);
            }
            $responce['responce']['bodypart'] = $victimdata;
            $responce['responce']['bodypartkey'] = $victimdatakey;
            $responce['msg'] = '';
            $responce['error'] = 0;
        }

        $victimdata = $victimdatakey = array();
        $VictimType=VictimType::where('vtm_status',1)->get(); 
        if($VictimType){
            foreach ($VictimType as $vct) {
                $victimdata[] = array('key' => $vct->vtm_id, 'label' => $vct->vtm_name, 'customKey' => 'k'.$vct->vtm_id);
                $victimdatakey[] = array('k'.$vct->vtm_id => $vct->vtm_name);
            }
            $responce['responce']['victimtype'] = $victimdata;
            $responce['responce']['victimtypekey'] = $victimdatakey;
            $responce['msg'] = '';
            $responce['error'] = 0;
        }

        echo json_encode($responce);
        die;
    }

    public function getIncidentRootCauseAnalysis(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.', 'selroots' => '', 'selsubroots' => '');
        $im_id=(isset($request->im_id))?$request->im_id:'';
        if($im_id){
            $responce['error'] = 0;
            $responce['msg'] = 'Record not found.';
            $RootCause=array(); $RootCauseItem=array(); $AddedRootCauseItem=array(); $AddedRootCauseDesciption = array('undefined'); $selsubroots = array();
            $RootCause=RootCause::where('rc_status',1)->get();
            foreach ($RootCause as $key => $RootCause_value) {
                $RootCauseItem[$RootCause_value->rc_id]= RootCauseItem::where('rci_rc_id',$RootCause_value->rc_id)->orderby('rci_parent_id','asc')->get()->toArray();
                $AddedRootCauseDesciption[$RootCause_value->rc_id]='';
            }
            $AddedRootCauseDescArr=DB::table('incidents_root_cause_description')->where('ircd_im_id',$im_id)->get()->toArray();            
            if($AddedRootCauseDescArr){                
                foreach ($AddedRootCauseDescArr as $key => $AddedRootCauseDescArr_value) {
                    $AddedRootCauseDesciption[$AddedRootCauseDescArr_value->ircd_rcid]=$AddedRootCauseDescArr_value->ircd_text;
                }   
            }

            $finalroots = array();
            if($RootCause){
                foreach($RootCause as $key => $RootCauseValue){
                    $arrayfst = array();
                    $AddedRootCauseItemArr=DB::table('incidents_root_cause')->where('irc_rcid',$RootCauseValue['rc_id'])->where('irc_im_id',$im_id)->first();
                    if($AddedRootCauseItemArr) {
                        $AddedRootCauseItem[]=$RootCauseValue['rc_id'];
                    }

                    foreach($RootCauseItem[$RootCauseValue->rc_id] as $subkey=> $RootCauseItemValue){

                        $subitems = RootCauseItem::where('rci_parent_id',$RootCauseItemValue['rci_id'])->where('rci_id','!=',$RootCauseItemValue['rci_id'])->get()->toArray();

                        if($RootCauseItemValue['rci_id'] == $RootCauseItemValue['rci_parent_id']){
                            $RootCauseItemValue['subitems'] = $subitems;
                            $arrayfst[] = $RootCauseItemValue;
                        }else{
                            $AddedRootCauseItemSub=DB::table('incidents_root_cause')->where('irc_rcid',$RootCauseItemValue['rci_id'])->where('irc_im_id',$im_id)->first();
                            if($AddedRootCauseItemSub) {
                                if(!in_array($RootCauseItemValue['rci_parent_id'], $AddedRootCauseItem)){
                                    $AddedRootCauseItem[]=$RootCauseItemValue['rci_parent_id'];
                                }
                                $selsubroots['indicator_'.$RootCauseItemValue['rci_parent_id']][]=$RootCauseItemValue['rci_id'];
                            }
                        }
                    }
                    $RootCauseValue->items = $arrayfst;
                    $finalroots[] = $RootCauseValue;
                }
            }
            $responce['responce'] = $finalroots;
            $responce['selroots'] = $AddedRootCauseItem;
            $responce['selsubroots'] = $selsubroots;
            $responce['rootsdesc'] = $AddedRootCauseDesciption;
            $responce['msg'] = '';
        }

        //print_r($AddedRootCauseItem);

        echo json_encode($responce);
        die;
    }

    public function getIncidentActions(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $im_id=(isset($request->im_id))?$request->im_id:'';
        if($im_id){
            $responce['error'] = 0;
            $responce['msg'] = 'Record not found.';
            $Actions = Actions::where('am_parent_id',$im_id)->where('am_module_type',2)->get(); 
            $victimdata = array();
            if($Actions){
                foreach ($Actions as $vct) {
                    $res = DB::table('actions_responsible')->where('am_id',$vct->am_id)->get();
                    $resusers = $resuserids = array();
                    if($res){
                        foreach ($res as $re) {
                            $resusers[] = get_user_field($re->user_id, 'name');
                            $resuserids[] = $re->user_id;
                        }
                    }

                    $victimdata[] = array('am_id' => $vct->am_id, 'action' => $vct->am_description, 'duedate' => ($vct->am_due_date)?date('d M Y, h:i a', strtotime($vct->am_due_date)):'', 'control' => get_control_field($vct->am_control, 'cm_name'), 'resp' => ($resusers)?implode(', ', $resusers):'', 'respid' => $resuserids, 'actind' => '', 'controlid' => $vct->am_control, 'status' => $vct->am_status);
                }
                $responce['responce'] = $victimdata;
                $responce['msg'] = '';
            }
        }

        echo json_encode($responce);
        die;
    }

    public function getIncidentInvestigationTeam(Request $request){
        $responce = array('error'=>1,'responce'=>array('members' => '', 'leadoptions' => '', 'memberoptions' => '', 'admins' => ''),'msg'=>'Something Wrong.');
        $im_id=(isset($request->im_id))?$request->im_id:'';
        if($im_id){
            $members = $leadoptions = $memberoptions = $admins = array();
            $res = DB::table('incidents_investigation_team')->where('iit_im_id',$im_id)->get();
            if($res){
                foreach ($res as $tm) {
                    $ms = array();
                    $ms[] = $tm->iit_user_id;
                    $members[] = $tm->iit_user_id;
                }
                $responce['responce']['members'] = $members;
            }

            $res = DB::table('users')->where('status',1)->get();
            if($res){
                foreach ($res as $tm) {
                    $lop = $mop = $ad = array();
                    $lop['id'] = $tm->id;
                    $lop['name'] = $tm->name.' - '.get_role_field($tm->id, 'r_name');

                    $mop['key'] = $tm->id;
                    $mop['label'] = $tm->name.' - '.get_role_field($tm->id, 'r_name');
                    $mop['customKey'] = 'k'.$tm->id;

                    if($tm->is_admin == 1){
                        $ad['id'] = $tm->id;
                        $ad['name'] = $tm->name;
                        $ad['role'] = get_role_field($tm->id, 'r_name');
                        $admins[] = $ad;
                    }

                    $leadoptions[] = $lop; $memberoptions[] = $mop;
                }
                $responce['responce']['leadoptions'] = $leadoptions;
                $responce['responce']['memberoptions'] = $memberoptions;
                $responce['responce']['admins'] = $admins;
            }
        }

        echo json_encode($responce);
        die;
    }

    public function storestepone(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident Report not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;

        $parentuser = $user;

        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $companyid = $user->companyid;

        $data = array();
        $data['im_ic_id'] = $request->im_ic_id;
        $data['im_datetime'] = date('Y-m-d H:i:s ',strtotime($request->im_datetime));
        $data['im_site_id'] = $request->im_site_id;
        $data['im_shift'] = $request->im_shift;
        $data['im_machineno_extralocation'] = $request->im_machineno_extralocation;
        $data['im_description'] = $request->im_description;
        $data['im_extendofdamange'] = $request->im_extendofdamange;
        $data['im_immediateactiontaken'] = $request->im_immediateactiontaken;
        $data['im_anyvictim'] = $request->victim_required;
        $data['im_lastsubmitedstep'] = 1;

        if(!empty($request->victimsnew)){
            $victims = json_decode($request->victimsnew);
            foreach($victims as $vct){
                $vdata = array();
                $vdata['iv_im_id'] = $im_id;
                $vdata['iv_vtm_id'] = $vct->controlid;
                $vdata['iv_name'] = $vct->action;
                $vdata['iv_gender'] = $vct->gender + 1;
                $vdata['iv_age_range'] = $vct->agerengesel;
                $vdata['iv_details_injury'] = $vct->injury;
                $vdata['iv_when_returntowork'] = $vct->returntowork;
                $vdata['iv_details_treatment'] = $vct->treatment;

                $vctid = DB::table('incidents_victim')->insertGetId($vdata);
                if($vctid){
                    if(!empty($vct->respid)){
                        $vararr=array();
                        foreach ($vct->respid as $user_id_value) {
                            $vsingle=array();    
                            $vsingle['ivbp_im_id']= $im_id;
                            $vsingle['ivbp_iv_id']=$vctid;
                            $vsingle['ivbp_bpm_id']=$user_id_value;
                            $vararr[]=$vsingle;
                        }
                        DB::table('incidents_victim_bodypart')->insert($vararr);    
                    }
                }
            }
        }

        $actions = $request->actions;
        if(!empty($request->actions)){
            $actions = json_decode($request->actions);
            foreach($actions as $act){
                $Actions = new \App\Actions;
                $Actions->am_parent_id = $im_id;
                $Actions->am_module_type = 1;
                $Actions->am_site_id = $request->site_id;
                $Actions->am_description = $act->action;
                $Actions->am_due_date = date('Y-m-d H:i:s ',strtotime($act->duedate));
                $Actions->am_control = $act->controlid;
                $Actions->am_status = 1;
                $Actions->am_created_by = $request->uid;
                $Actions->save(); 
                $am_id=$Actions->am_id; 
                if(!empty($act->respid)){
                    $ararr=array();
                    foreach ($act->respid as $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                    }
                    DB::table('actions_responsible')->insert($ararr);    
                }                
            }
            DB::table('actions_master')->where('am_parent_id', $im_id)->where('am_module_type',1)->update(['am_site_id' => $request->site_id]);
        }

        $total = $request->total_images;
        $photosadd = array();
        $photosname = array();
        $photosext = array();
        for ($i=0; $i < $total; $i++) { 
          $photosadd[] = $request->{'photosaddhidden'.$i};
          $photosname[] = $request->{'photosname'.$i};
          $photosext[] = $request->{'photosext'.$i};
        }
        $companyname = $request->companyname;
        if(!empty($photosadd)){
            $attached=array();
            $photos=array();
            foreach ($photosadd as $key => $img) {
                  $image = base64_decode($img);
                  $image_name = 'inci'.$key.time();
                  $picture = $image_name.'.'.$photosext[$key];
                  $storefullpath = 'public/'.$companyname.'/'.$picture;
                  Storage::put($storefullpath, $image);
                  $single=array();    
                  $single['im_id']=$im_id;
                  $single['attachament']=str_replace('public/', '', $storefullpath);
                  $single['attachement_name']=$photosname[$key];
                  $attached[]=$single;                        
            } 
            DB::table('incidents_attachement_rel')->insert($attached);           
        }
        if($data){
            DB::table('incidents_master')->where('im_id', $im_id)->update($data);
            $responce = array('error'=>0,'responce'=>'','msg'=>'Incident succesfully updated.');

            //Send Mail to admin
            $incidents = array();
            $incidents['incidentsype'] = get_category_field($request->im_ic_id, 'category_name');
            $incidents['reportedby'] = get_user_field($parentuser->id, 'name');
            $incidents['description'] = $request->im_description;
            $incidents['sites'] = $sitesname= get_site_field($request->im_site_id, 'site_name');
            $incidents['datetime'] = date('d M, Y D h:ia',strtotime($request->im_datetime));                        
            $incidents['shift'] =  get_shifts_field($request->im_shift,'sm_name');                        
            $incidents['victims'] =  DB::table('incidents_victim')->where('iv_im_id', $im_id)->get();

            $subject = 'Incidents report updated.';
            $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
            if($adminemails){
                foreach ($adminemails as $ademl) {
                    $useremail = $ademl->email;
                    $username = $ademl->name;
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
                    Mail::send('email.incidentsedit_step1', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }
             



        }
        echo json_encode($responce);
        die;
    }

    public function storesteptwo(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident Report not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;

        $parentuser = $user;

        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $companyid = $user->companyid;

        $data = array();
        $data['im_investigateteamlead'] = $request->teamlead;
        $data['im_dateofcomplete'] = ($request->duedate)?date('Y-m-d H:i:s',strtotime($request->duedate)):'';
        $data['im_lastsubmitedstep'] = 2;

        $teammenbers   = array();
        $teammenbers[] = $request->teamlead;
        if($data){
            $attached = array();
            DB::table('incidents_investigation_team')->where('iit_im_id',$im_id)->delete();
            $members = json_decode($request->members);
            foreach ($members as $key => $iit_user_id_value) {                                
                $single=array();    
                $single['iit_im_id']= $im_id;
                $single['iit_user_id']=$iit_user_id_value;
                $attached[]=$single;
                $teammenbers[]=$iit_user_id_value;
            }
            DB::table('incidents_investigation_team')->insert($attached);

            DB::table('incidents_master')->where('im_id', $im_id)->update($data);
            $responce = array('error'=>0,'responce'=>$members,'msg'=>'Investigation Team succesfully updated.');

            //Start Email Here.....

            $TeamUsers= DB::table('users')
            ->select('users.*', 'roles.r_name')
            ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
            ->whereNull('users.deleted_at')->whereIn('users.id',$teammenbers)
            ->get();  

            $Incident  =  \App\Incident::find($im_id);
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

            $subject = 'Investigation Team Created: '.$incidents['incidentsype'].' Incident Report '.$incidents['severity'].' & '.$incidents['likelihood'].' ( '.$incidents['rating'].' - '.$incidents['rating_text'].' ) at '.$incidents['sites'].' on '.date('d-M-Y').': '. $incidents['im_srno']; 


            try {
                $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
                if($adminemails){
                    foreach ($adminemails as $ademl) {
                        $useremail = $ademl->email;
                        $username = $ademl->name;
                        Mail::send('email.investigation_team', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents,'TeamUsers'=>$TeamUsers], function ($m) use ($username, $useremail, $subject) {            
                            $m->to($useremail, $username)->subject($subject);
                        });
                    }
                }
                if($TeamUsers){
                    foreach ($TeamUsers as $ademl) {
                        $useremail = $ademl->email;
                        $username = $ademl->name;
                        Mail::send('email.investigation_team', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents,'TeamUsers'=>$TeamUsers], function ($m) use ($username, $useremail, $subject) {            
                            $m->to($useremail, $username)->subject($subject);
                        });
                    }
                }
            }
            catch (Exception $e) {
                
            }


        }
        echo json_encode($responce);
        die;
    }

    public function storestepfour(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident Report not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;



        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }
        $companyid = $user->companyid;
        
        
        $Incident =  \App\Incident::find($im_id); 
        $sitesname= get_site_field($Incident->im_site_id, 'site_name');

        if(!empty($request->actions)){
            $actions = json_decode($request->actions);
            foreach($actions as $act){
                $mlstatus=1;
                $data = array();
                $data['am_site_id'] = $request->site_id;
                $data['am_parent_id'] = $request->im_id;
                $data['am_module_type'] = 2;
                $data['am_description'] = $act->action;
                $data['am_due_date'] = date('Y-m-d H:i:s ',strtotime($act->duedate));
                $data['am_control'] = $act->controlid;
                $data['am_created_by'] = $request->uid;

                $am_id = $act->am_id;
                if($act->am_id){
                    //$Actions  =  \App\Actions::find($act->am_id);
                    //if(isset($Actions->am_status)){
                        //$mlstatus = $Actions->am_status;                     
                    //}
                    DB::table('actions_master')->where('am_id', $am_id)->update($data);
                }else{
                    $data['am_status'] = $mlstatus;
                    $am_id = DB::table('actions_master')->insertGetId($data);
                }
                
                $usernames=array();

                DB::table('actions_responsible')->where('am_id',$am_id)->delete();
                if(!empty($act->respid)){
                    $ararr=array();
                    foreach ($act->respid as $user_id_value) {
                        $single=array();    
                        $single['am_id']= $am_id;
                        $single['user_id']=$user_id_value;
                        $ararr[]=$single;
                        $usernames[] = get_user_field($user_id_value, 'name');
                    }
                    DB::table('actions_responsible')->insert($ararr);    
                }


                
                
            try {    
                if(!empty($act->respid)){                    
                        
                        //$Actions  =  \App\Actions::find($act->am_id);

                        $mlaction = array();                
                        $mlaction['description'] = $act->action;
                        $mlaction['control'] = get_control_field($act->controlid, 'cm_name');
                        $mlaction['due_date'] = date('d M, Y D h:ia',strtotime($act->duedate));                     
                        if($mlstatus){
                          //$mlstatus = GetActionStatus($mlstatus);  
                        }
                        $mlaction['status'] = '';                
                        $mlaction['responsibility'] = ($usernames)?implode(',', $usernames):''; 

                        if(!empty($mlstatus)){
                            $subject = $mlstatus.': An action assigned to you';
                        }else{
                            $subject = 'An action assigned to you';
                        }
                  
                        foreach ($act->respid as $user_id_value) {
                            $useremail = get_user_field($user_id_value, 'email');
                            $useremail = 'kishanu.gc@gmail.com';
                            $username = get_user_field($user_id_value, 'name');
                            if(!empty($username)){
                              // Email Create a problem HERE....  
                                
                               
                                /*
                                Mail::send('email.action', ['username' => $username, 'useremail' => $useremail,  'action' => $mlaction,'sitesname'=>$sitesname], function ($m) use ($username, $useremail, $subject) {            
                                    $m->to(trim($useremail), $username)->subject($subject);
                                });
                                */
                               

                              // Email Create a problem HERE....   
                            }
                            //break;
                        } 
                                      
                }
            }
            catch (Exception $e) {
                //echo $e->getMessage();
            }
                

            }
            DB::table('incidents_master')->where('im_id', $im_id)->update(['im_lastsubmitedstep' => 5]);
            $responce = array('error'=>0,'responce'=>'','msg'=>'Recommended Actions succesfully updated.');
        }

       //Send Mail to admin
        $Incident =  \App\Incident::find($im_id);
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        

        $subject = 'Incidents report updated.';
        try {
            $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
            if($adminemails){
                foreach ($adminemails as $ademl) {
                    $useremail = $ademl->email;
                    $username = $ademl->name;
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
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }

        }
        catch (Exception $e) {
            
        }

        echo json_encode($responce);
        die;
    }

    public function storestepfive(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident Report not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;

        $parentuser = $user;

        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }

        $data = array();
        $data['im_status'] = $request->im_status;

        $Incident  =  \App\Incident::find($im_id);                         
        $oldstatus = $Incident->im_status;  
        $newstatus = $request->im_status;
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
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            } 
        }
        DB::table('incidents_master')->where('im_id', $im_id)->update(['im_status' => $request->im_status, 'im_lastsubmitedstep' => 5]);
        $responce = array('error'=>0,'responce'=>'','msg'=>'Incident succesfully updated.');
        echo json_encode($responce);
        die;
    }

    public function incidentapprover(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Incident Report not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;
        $status=$request->status;
        $statustxt=($request->status)?'approved':'rejected';

        $parentuser = $user;

        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }

        DB::table('incidents_master')->where('im_id', $im_id)->update(['im_actionapproved' => $status, 'im_approved_by' => $request->uid, 'im_approved_at' => date('Y-m-d H:i:s')]);


        //Send Mail to admin
        $Incident =  \App\Incident::find($im_id);
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');                        
        if($request->status==1){
            $subject = 'Incidents report approved.';
        }else{
            $subject = 'Incidents report rejected.';
        }
        try{
            $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
            if($adminemails){
                foreach ($adminemails as $ademl) {
                    $useremail = $ademl->email;
                    $username = $ademl->name;
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
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }
        }
        catch (Exception $e) {
            
        }

        $responce = array('error'=>0,'responce'=>'','msg'=>'Incident succesfully '.$statustxt.'.');

        echo json_encode($responce);
        die;
    }

    public function storestepthree(Request $request){
        $responce = array('error'=>1,'responce'=>'failed','msg'=>'Root Cause Analysis not update.');

        $input = $request->all();
        $user = User::find($request->uid);
        $uid=(isset($request->uid))?$request->uid:0;
        $im_id=$request->im_id;

        $parentuser = $user;

        $role_info=$this->getuserroleinfo($uid);
        $r_name=$role_info['r_name'];
        $has_access = '';
        $incedent_id = 5;
        $has_access_rec = DB::table('users_permissions')->where(['permission_pm_id'=>$incedent_id,'user_by_tennat_id'=>$uid])->first();
        if(!empty($has_access_rec)){
            $has_access   = 'Yes';
        } 
        if(empty($has_access)){
            $responce = array('error'=>1,'responce'=>'','msg'=>'You can not access this section.');
            echo json_encode($responce);  
            die;
        }

        if($request->roots){
            $irc_rcid=array();
            DB::table('incidents_root_cause')->where('irc_im_id',$im_id)->delete();
            $roots = json_decode($request->roots);
            foreach ($roots as $key => $irc_rcid_value) {                                
                $single=array();    
                $single['irc_im_id']= $im_id;
                $single['irc_rcid']=$irc_rcid_value;
                $irc_rcid[]=$single;

                if(isset($request->{'indicator_'.$irc_rcid_value})){
                    $rtsbs = json_decode($request->{'indicator_'.$irc_rcid_value});
                    if($rtsbs){
                        foreach ($rtsbs as $key => $val) {
                            DB::table('incidents_root_cause')->insert(array('irc_im_id' => $im_id, 'irc_rcid' => $val));
                        }
                    }
                }
            }
            DB::table('incidents_root_cause')->insert($irc_rcid);

            $responce['responce'] = '';
            $responce['msg'] = '';
            $responce['error'] = '';
        }

        if($request->rootsubs){
            $irc_rcid=array();
            foreach ($request->rootsubs as $data) {
                foreach ($data as $key => $irc_rcid_value) {
                    $single=array();    
                    $single['irc_im_id']= $im_id;
                    $single['irc_rcid']=$irc_rcid_value;
                    $irc_rcid[]=$single;
                }
            }
            DB::table('incidents_root_cause')->insert($irc_rcid);

            $responce['responce'] = $request->rootsubs;
            $responce['msg'] = '';
            $responce['error'] = '';
        }

        if($request->desc){
            $descs = json_decode($request->desc);
            DB::table('incidents_root_cause_description')->where('ircd_im_id',$im_id)->delete();

            $RootCause=RootCause::where('rc_status',1)->get(); $i = 1;
            foreach ($RootCause as $key => $RootCause_value) {
                $single=array();  
                $single['ircd_im_id']= $im_id;
                $single['ircd_rcid']= $RootCause_value->rc_id;
                $single['ircd_text']=$descs[$i];
                if($descs[$i]){
                    DB::table('incidents_root_cause_description')->insert($single);   
                }   
                $i++;
            }           
        }

        //Send Email Start Here..
        $Incident =  \App\Incident::find($im_id); 
        $incidents = array();
        $incidents['incidentsype'] = get_category_field($Incident->im_ic_id, 'category_name');
        $incidents['reportedby'] = get_user_field($Incident->im_created_by, 'name');
        $incidents['description'] = $Incident->im_description;
        $incidents['sites'] = $sitesname= get_site_field($Incident->im_site_id, 'site_name');
        $incidents['datetime'] = date('d M, Y D h:ia',strtotime($Incident->im_datetime));                        
        $incidents['shift'] =  get_shifts_field($Incident->im_shift,'sm_name');              
        $subject = 'Incidents report updated.';  
        //Send Mail to admin

        try {
            $adminemails = DB::table('users')->where('is_admin', 1)->where('status', 1)->get();
            if($adminemails){
                foreach ($adminemails as $ademl) {
                    $useremail = $ademl->email;
                    $username = $ademl->name;
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
                    Mail::send('email.incidentsedit', ['username' => $username, 'useremail' => $useremail, 'incidents' => $incidents], function ($m) use ($username, $useremail, $subject) {            
                        $m->to($useremail, $username)->subject($subject);
                    });
                }    
            }  
        }
        catch (Exception $e) {
            
        }

        echo json_encode($responce);
        die;
    }

    public function incidentratings(Request $request){
        $responce = array('error'=>1,'responce'=>'','msg'=>'Something Wrong.');
        $im_id=(isset($request->im_id))?$request->im_id:'';
        $rating=(isset($request->rating))?$request->rating:'';
        $investigation=(isset($request->investigation))?$request->investigation:'';

        if($rating){
            DB::table('incidents_master')->where('im_id', $im_id)->update(['im_ratinganincident' => $rating, 'im_investigationisrequired' => $investigation]);
            $responce['error'] = 0;
            $responce['msg'] = 'Incident Classification Matrix succesfully updated.';
        }else{
            $responce['msg'] = 'Select Incident Classification Matrix is Required.';
        }

        echo json_encode($responce);
        die;
    }
}
