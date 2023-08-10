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
use App\CheckBoxOption;
use Config;
use Artisan;
use Auth;
use DB;
use Mail;
use Redirect;

class HomeController extends Controller
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
        $cuser = Auth::user();                   
        if($cuser->is_admin==6){
            return Redirect::route('observations');
        }
        $category=User::all();
        $page_title=__('Dashboard');
        $filterdate=$request->filterdate;
        $filtersite=$request->site_id;
        $moduletype=array(1,2,3,4);
        if($request->moduletype){
           $moduletype=$request->moduletype; 
        }
        if($filterdate!=''){
            $filterdaterange=explode(' - ', $filterdate);
            $filterdatestart=date('Y-m-d 00:00:00',strtotime($filterdaterange[0]));
            $filterdateend=date('Y-m-d 23:59:59',strtotime($filterdaterange[1]));
        } 

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

        $ObservationsbyCategoriesArr=array();$IncidentsbyCategoriesArr=array();$ActionsByStatusArr=array();$IncidentsbyRatingArr=array();

        $ObservationsbyCategoriesQuery= DB::table('category');
        $ObservationsbyCategoriesQuery->select('category.category_name', DB::raw('COUNT(observations_master.oc_id) AS cat_count'));
        $ObservationsbyCategoriesQuery->RightJoin('observations_master', 'observations_master.oc_id', '=', 'category.id');
        $ObservationsbyCategoriesQuery->whereNull('category.deleted_at');
        $ObservationsbyCategoriesQuery->whereNull('observations_master.deleted_at');
        if($filterdate!=''){$ObservationsbyCategoriesQuery->whereBetween('observations_master.created_at',[$filterdatestart,$filterdateend]);}
        if($filtersite!=''){  $ObservationsbyCategoriesQuery->whereIn('observations_master.site_id',$filtersite) ;   }  
        if(!$cuser->hasRole('Super Admin')){$ObservationsbyCategoriesQuery->where('observations_master.created_by',$cuser->id) ;}      
        $ObservationsbyCategoriesQuery->groupBy('category.id');
        $ObservationsbyCategoriesQuery->orderby('category.id','desc');
        $ObservationsbyCategories=$ObservationsbyCategoriesQuery->get();
        if($ObservationsbyCategories){
            foreach ($ObservationsbyCategories as $key => $value) {
                $single=array();
                $single['name']= $value->category_name;
                $single['y']= $value->cat_count;
                $single['color']= '#C647EB';
               $ObservationsbyCategoriesArr[]=$single;
            }
        }

        $IncidentsbyCategoriesQuery= DB::table('category');
        $IncidentsbyCategoriesQuery->select('category.category_name', DB::raw('COUNT(incidents_master.im_ic_id) AS cat_count'));
        $IncidentsbyCategoriesQuery->RightJoin('incidents_master', 'incidents_master.im_ic_id', '=', 'category.id');
        $IncidentsbyCategoriesQuery->whereNull('category.deleted_at');
        $IncidentsbyCategoriesQuery->whereNull('incidents_master.deleted_at');
        if($filterdate!=''){$IncidentsbyCategoriesQuery->whereBetween('incidents_master.created_at',[$filterdatestart,$filterdateend]);}
        if($filtersite!=''){  $IncidentsbyCategoriesQuery->whereIn('incidents_master.im_site_id',$filtersite) ;   } 
        if(!$cuser->hasRole('Super Admin')){$IncidentsbyCategoriesQuery->where('incidents_master.im_created_by',$cuser->id) ;}             
        $IncidentsbyCategoriesQuery->groupBy('category.id');
        $IncidentsbyCategoriesQuery->orderby('category.id','desc');
        $IncidentsbyCategories=$IncidentsbyCategoriesQuery->get();
        if($IncidentsbyCategories){
            foreach ($IncidentsbyCategories as $key => $value) {
                $single=array();
                $single['name']= $value->category_name;
                $single['y']= $value->cat_count;
                $single['color']= '#3460a0';
               $IncidentsbyCategoriesArr[]=$single;
            }
        }
        $ActionsByStatusArrFinal=array();   
        if($cuser->hasRole('Super Admin') || $cuser->can('Observations')){
            $ActionsByStatusQuery= DB::table('actions_master');
            $ActionsByStatusQuery->select( 'am_status',DB::raw('COUNT(am_status) AS status_count'));        
            $ActionsByStatusQuery->whereNull('deleted_at');
            $ActionsByStatusQuery->where('am_module_type',1);
            $ActionsByStatusQuery->whereIn('am_status',array(1,5));
            if($filterdate!=''){$ActionsByStatusQuery->whereBetween('actions_master.created_at',[$filterdatestart,$filterdateend]);}
            if($filtersite!=''){  $ActionsByStatusQuery->whereIn('actions_master.am_site_id',$filtersite) ;   }   
            $ActionsByStatusQuery->whereNull('actions_master.deleted_at');     
            if(!$cuser->hasRole('Super Admin') ){
                $ActionsByStatusQuery->whereIN('actions_master.am_id',$actionsids) ;
            }        
            $ActionsByStatusQuery->groupBy('am_status');
            $ActionsByStatusQuery->orderby('am_status','asc');
            $ActionsByStatus=$ActionsByStatusQuery->get();     
            if(count($ActionsByStatus)){
                $ActionsByStatusArr[1]=array('name'=>'Near Miss Open', 'y'=> 0, 'color'=>"#1ED1FF");
               // $ActionsByStatusArr[3]=array('name'=>'In Progress', 'y'=> 0, 'color'=>"#FFE019");
               // $ActionsByStatusArr[4]=array('name'=>'Completed', 'y'=> 0, 'color'=>"#669933");
                $ActionsByStatusArr[2]=array('name'=>'Near Miss Closed', 'y'=> 0, 'color'=>"#19E519");
               // $ActionsByStatusArr[2]=array('name'=>'Overdue', 'y'=> 0, 'color'=>"#E84530");
                foreach ($ActionsByStatus as $key => $value) { 
                    if($value->am_status==5){
                        $ActionsByStatusArr[2]['y']=$value->status_count;
                    }else{
                        $ActionsByStatusArr[1]['y']=$value->status_count;
                    }               
                    
                }            
                foreach ($ActionsByStatusArr as $key => $value) {                
                    $ActionsByStatusArrFinal[]=$value;
                }
            }
        }

        if($cuser->hasRole('Super Admin') || $cuser->can('Incident')){
            $ActionsByStatusQuery= DB::table('actions_master');
            $ActionsByStatusQuery->select( 'am_status',DB::raw('COUNT(am_status) AS status_count'));        
            $ActionsByStatusQuery->whereNull('deleted_at');
            $ActionsByStatusQuery->where('am_module_type',2);
            if($filterdate!=''){$ActionsByStatusQuery->whereBetween('actions_master.created_at',[$filterdatestart,$filterdateend]);}
            if($filtersite!=''){  $ActionsByStatusQuery->whereIn('actions_master.am_site_id',$filtersite) ;   }   
            $ActionsByStatusQuery->whereNull('actions_master.deleted_at');     
            if(!$cuser->hasRole('Super Admin') ){
                $ActionsByStatusQuery->whereIN('actions_master.am_id',$actionsids) ;
            }        
            $ActionsByStatusQuery->groupBy('am_status');
            $ActionsByStatusQuery->orderby('am_status','asc');
            $ActionsByStatus=$ActionsByStatusQuery->get();     
            
            if(count($ActionsByStatus)){
                $ActionsByStatusArr[3]=array('name'=>'Incident Open', 'y'=> 0, 'color'=>"#1ED1FF");
               // $ActionsByStatusArr[3]=array('name'=>'In Progress', 'y'=> 0, 'color'=>"#FFE019");
               // $ActionsByStatusArr[4]=array('name'=>'Completed', 'y'=> 0, 'color'=>"#669933");
                $ActionsByStatusArr[4]=array('name'=>'Incident Closed', 'y'=> 0, 'color'=>"#19E519");
               // $ActionsByStatusArr[2]=array('name'=>'Overdue', 'y'=> 0, 'color'=>"#E84530");
                foreach ($ActionsByStatus as $key => $value) { 
                    if($value->am_status==5){
                        $ActionsByStatusArr[4]['y']=$value->status_count;
                    }else{
                        $ActionsByStatusArr[3]['y']=$value->status_count;
                    }               
                    
                }            
                foreach ($ActionsByStatusArr as $key => $value) {                
                    $ActionsByStatusArrFinal[]=$value;
                }
            }
        }

        
        $AllEvent=array();
        if(in_array(1, $moduletype)){
            $observations= DB::table('observations_master as om');
            $observations->select('om.ob_srno as srno','om.created_at','om.riskpotentiallevel', 'u.name','c.category_name','s.site_name');
            $observations->leftJoin('users as u', 'u.id', '=', 'om.created_by');
            $observations->leftJoin('sites as s', 's.id', '=', 'om.site_id');
            $observations->leftJoin('category as c', 'c.id', '=', 'om.oc_id');
            $observations->whereNull('om.deleted_at') ;

            if($filterdate!=''){$observations->whereBetween('om.created_at',[$filterdatestart,$filterdateend]);} 
            if($filtersite!=''){  $observations->whereIn('om.site_id',$filtersite) ;   }   
            if(!$cuser->hasRole('Super Admin')){$observations->where('om.created_by',$cuser->id) ;}                
            $Observation= $observations->get();
            if($Observation){
                foreach ($Observation as $key => $value) {
                    if($cuser->hasRole('Super Admin') || $cuser->can('Observations')){
                        $AllEvent[date('dmY',strtotime($value->created_at))][]=$value;
                    }
                }
            }
        }

        if(in_array(2, $moduletype)){
            $incidents= DB::table('incidents_master as im');
            $incidents->select('im.im_srno as srno','im.created_at','u.name','c.category_name','s.site_name','ir.rating_type as riskpotentiallevel');
            $incidents->leftJoin('users as u', 'u.id', '=', 'im.im_created_by');
            $incidents->leftJoin('sites as s', 's.id', '=', 'im.im_site_id');
            $incidents->leftJoin('category as c', 'c.id', '=', 'im.im_ic_id');
            $incidents->leftJoin('incidents_rating as ir', 'ir.ir_id', '=', 'im.im_ratinganincident');
            $incidents->whereNull('im.deleted_at') ;
            if($filterdate!=''){$incidents->whereBetween('im.created_at',[$filterdatestart,$filterdateend]);}      
            if($filtersite!=''){  $incidents->whereIn('im.im_site_id',$filtersite) ;   }  
            if(!$cuser->hasRole('Super Admin')){$incidents->where('im.im_created_by',$cuser->id) ;}                           
            $Incidents= $incidents->get();
            if($Incidents){
                foreach ($Incidents as $key => $value) {
                    if($cuser->hasRole('Super Admin') || $cuser->can('Incident')){
                        $AllEvent[date('dmY',strtotime($value->created_at))][]=$value;
                    }
                }
            }
        }

        $IncidentsbyRatingQuery= DB::table('incidents_rating');
        $IncidentsbyRatingQuery->select('incidents_rating.rating_text','incidents_rating.rating_type', DB::raw('COUNT(incidents_master.im_ratinganincident) AS rate_count,incidents_master.im_created_by'));
        $IncidentsbyRatingQuery->RightJoin('incidents_master', 'incidents_master.im_ratinganincident', '=', 'incidents_rating.ir_id');
        $IncidentsbyRatingQuery->whereNull('incidents_master.deleted_at');
        $IncidentsbyRatingQuery->whereNotNull('incidents_master.im_ratinganincident');
        if($filterdate!=''){$IncidentsbyRatingQuery->whereBetween('incidents_master.created_at',[$filterdatestart,$filterdateend]);}
        if($filtersite!=''){  $IncidentsbyRatingQuery->whereIn('incidents_master.im_site_id',$filtersite) ;   }    
        if(!$cuser->hasRole('Super Admin')){$incidents->where('incidents_master.im_created_by',$cuser->id) ;}      
        $IncidentsbyRatingQuery->groupBy('incidents_rating.rating_type');
        $IncidentsbyRatingQuery->orderby('incidents_rating.ir_id','ASC');
        $IncidentsbyRating=$IncidentsbyRatingQuery->get(); 
        
        $IncidentsbyRatingArrFinal=array();   
        if(count($IncidentsbyRating)){
            $IncidentsbyRatingArr[1]=array('name'=>'Minor', 'y'=> 0, 'color'=>"#ffc700");
            $IncidentsbyRatingArr[2]=array('name'=>'Serious', 'y'=> 0, 'color'=>"#f77c21");
            $IncidentsbyRatingArr[3]=array('name'=>'Fatal', 'y'=> 0, 'color'=>"#e62108");            
            foreach ($IncidentsbyRating as $key => $value) {
                if(!$cuser->hasRole('Super Admin')){ 
                    if($cuser->id==$value->im_created_by){               
                        $IncidentsbyRatingArr[$value->rating_type]['y']=$value->rate_count;
                    }
                }else{
                    $IncidentsbyRatingArr[$value->rating_type]['y']=$value->rate_count;   
                }
            }            
            foreach ($IncidentsbyRatingArr as $key => $value) {                
                $IncidentsbyRatingArrFinal[]=$value;
            }
        }

        $ObservationByRating= DB::table('observations_master');
        $ObservationByRating->select( 'ob_id','created_by','riskpotentiallevel',DB::raw('COUNT(ob_id) AS status_count'));        
        $ObservationByRating->whereNull('deleted_at');
        $ObservationByRating->where('riskpotentiallevel','!=',0);  
        if($filterdate!=''){$ObservationByRating->whereBetween('observations_master.created_at',[$filterdatestart,$filterdateend]);}
        if($filtersite!=''){  $ObservationByRating->whereIn('observations_master.site_id',$filtersite) ;   }  
        if(!$cuser->hasRole('Super Admin')){$ObservationByRating->where('observations_master.created_by',$cuser->id) ;}   
        $ObservationByRating->groupBy('riskpotentiallevel');
        $ObservationByRating->orderby('riskpotentiallevel','asc');
        $ObservationByRating=$ObservationByRating->get();
        
        $ObservationbyRatingArrFinal=array();   
        if(count($ObservationByRating)){
            $ObservationbyRatingArr[1]=array('name'=>'Minor', 'y'=> 0, 'color'=>"#ffc700");
            $ObservationbyRatingArr[2]=array('name'=>'Serious', 'y'=> 0, 'color'=>"#f77c21");
            $ObservationbyRatingArr[3]=array('name'=>'Fatal', 'y'=> 0, 'color'=>"#e62108");            
            foreach ($ObservationByRating as $key => $value) {
                if(!$cuser->hasRole('Super Admin')){ 
                    if($cuser->id==$value->created_by){               
                        $ObservationbyRatingArr[$value->riskpotentiallevel]['y']=$value->status_count;
                    }
                }else{
                    $ObservationbyRatingArr[$value->riskpotentiallevel]['y']=$value->status_count;   
                }
            }            
            foreach ($ObservationbyRatingArr as $key => $value) {                
                $ObservationbyRatingArrFinal[]=$value;
            }
        }   



        $AllDayEvent=array();
        $FinalDayEvent=array();
        if($AllEvent){
            foreach ($AllEvent as $key => $value) {
                $html='';
                $html.='<ul>';
                 foreach ($value as $subkey => $Subvalue) {

                    if (strpos($Subvalue->srno, 'OBS') !== false) {
                        $html.='<li class="statusli'.$Subvalue->riskpotentiallevel.'">
                            <a href="javascript:void(0);">
                                <div>
                                    <h4>Observation <span>- '.$Subvalue->srno.'</span></h4><span class="sitename">'.$Subvalue->site_name.'</span><p>'.$Subvalue->category_name.' Observation reported by '.$Subvalue->name.' on '.date('d M, Y D h:i a',strtotime($Subvalue->created_at)).'</p>
                                </div>
                            </a>
                        </li>';
                    }    
                    if (strpos($Subvalue->srno, 'INC') !== false) {
                        $html.='<li class="statusli'.$Subvalue->riskpotentiallevel.'">
                            <a href="javascript:void(0);" class="">
                                <div>
                                    <h4>Incident <span>- '.$Subvalue->srno.'</span></h4><span class="sitename">'.$Subvalue->site_name.'</span>
                                    <p><span>'.$Subvalue->category_name.'  </span> Incident reported by '.$Subvalue->name.' on '.date('d M, Y D h:i a',strtotime($Subvalue->created_at)).'</p>
                                </div>
                            </a>
                        </li>';
                    }

                }
                $html.='</ul>';
                $AllDayEvent[$key]=$html;
            }
            
             foreach ($AllEvent as $key => $value) {
                    foreach ($value as $subkey => $Subvalue) {
                        $single=array();
                        $objclaname='fc-bg-none';
                        $single['title']= date('F d',strtotime($Subvalue->created_at));
                        $single['description']= $AllDayEvent[$key];
                        $single['start']= date('Y-m-d',strtotime($Subvalue->created_at));
                        $single['end']= date('Y-m-d',strtotime($Subvalue->created_at));
                        if($Subvalue->riskpotentiallevel==1){$objclaname='fc-bg-minor';}
                        if($Subvalue->riskpotentiallevel==2){$objclaname='fc-bg-serious';}
                        if($Subvalue->riskpotentiallevel==3){$objclaname='fc-bg-fatal';}
                        $single['className']= $objclaname;
                        $FinalDayEvent[]=$single;
                    }
             }

        } 
        if ($request->ajax()) {
            $data=array();
            $data['ObservationsbyCategoriesArr']=$ObservationsbyCategoriesArr;
            $data['IncidentsbyCategoriesArr']=$IncidentsbyCategoriesArr;
            $data['ActionsByStatusArrFinal']=$ActionsByStatusArrFinal;
            $data['IncidentsbyRatingArrFinal']=$IncidentsbyRatingArrFinal;
            $data['FinalDayEvent']=$FinalDayEvent;
            $data['ObservationbyRatingArrFinal']=$ObservationbyRatingArrFinal;
            return json_encode($data);
        }         
        return view('dashboard',compact('category','page_title','cuser','ObservationsbyCategoriesArr','IncidentsbyCategoriesArr','ActionsByStatusArrFinal','FinalDayEvent','IncidentsbyRatingArrFinal','ObservationbyRatingArrFinal'));
    }

    public function TestFunction()
    {
        /*//
        Artisan::call('userdb:migrate asarco_udb_3');
        $Category=CheckBoxOption::all();
        foreach ($Category as $key => $value) {
            echo "\App\CheckBoxOption::create([
            'aco_id' => '".$value->aco_id."',
            'aco_grpid_id' => '".$value->aco_grpid_id."',            
            'aco_name' => '".$value->aco_name."',            
            ]);\n";
        }
        exit;*/        
    }
}
