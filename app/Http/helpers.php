<?php
use App\Sites;
use App\Category;
use App\AuditTemplates;
function GetbaseUrl(){
    $baseurll=URL::to('storage');
    return str_replace('public', '', $baseurll);
}

function GetNMPrefix(){
    return 'NM';
}

function GetCurrentUser(){
    if (Auth::check()) {
        $user = Auth::user();
        return $user->name;
    }
    return;
}
function GetUserNameWithRole($userid=0,$onelyname=''){
    $Users= DB::table('users')
        ->select('users.*', 'roles.r_name')
        ->leftJoin('roles', 'roles.id', '=', 'users.is_admin')
        ->whereNull('users.deleted_at')->where('users.id',$userid)
        ->first();
    if($Users){
        if($onelyname==1){
            return $Users->name;
        }else{
            return $Users->name.' - '.$Users->r_name;
        }
    }
    return;
}

function GetCompanyList(){
    $Users= DB::table('users')->whereNull('is_admin')->get();
    $html='';
    if($Users){
        foreach ($Users as $key => $value) {
            $html.='<option value="'.$value->companyname.'">'.$value->companyname.'</option>';
        }
    }
    return $html;
}

function GetLoginSiteList(){
    $sites= DB::table('sites')->whereNull('sub_parent')->whereNull('deleted_at')->where('status',1)->get();
    $html='';
    if($sites){
        foreach ($sites as $key => $value) {
            $html.='<option value="'.$value->id.'">'.$value->site_name.'</option>';
        }
    }
    return $html;
}

function GetHeadofSafety($siteid=0,$field='email'){
    $Users= DB::table('site_headofsafety as sh')
        ->select('sh.*', 'users.'.$field)
        ->leftJoin('users', 'users.id', '=', 'sh.sh_user_id')
        ->where('sh_site_id',$siteid)
        ->get();
    $fields=array();
    if($Users){
        foreach ($Users as $key => $value) {
           $fields[]= $value->$field;
        }
    }
    return $fields;
}

function GetHeadofSafetyEmailName($siteid=0){
    $Users= DB::table('site_headofsafety as sh')
        ->select('sh.*', 'users.name', 'users.email','users.planguage')
        ->leftJoin('users', 'users.id', '=', 'sh.sh_user_id')
        ->where('sh_site_id',$siteid)
        ->get();
    $fields=array();
    if($Users){
        foreach ($Users as $key => $value) {
            $single=array();
            $single['name']=$value->name;
            $single['email']=$value->email;
            $single['planguage']=$value->planguage;
            $fields[]= $single;
        }
    }
    return $fields;
}

function GetHeadofSafetyEmailNameArray($siteid=array()){
    $Users= DB::table('site_headofsafety as sh')
        ->select('sh.*', 'users.name', 'users.email','users.planguage')
        ->leftJoin('users', 'users.id', '=', 'sh.sh_user_id')
        ->whereIn('sh_site_id',$siteid)
        ->groupBy('users.id')
        ->get();
    $fields=array();
    if($Users){
        foreach ($Users as $key => $value) {
            $single=array();
            $single['name']=$value->name;
            $single['email']=$value->email;
            $single['planguage']=$value->planguage;
            $fields[]= $single;
        }
    }
    return $fields;
}

function GetGender($id){
    $GetGenderArr=array(0=>'',1=>__('Male'),2=>__('Female'),3=>__('Other'));
    if(array_key_exists($id, $GetGenderArr)){return $GetGenderArr[$id];}
    return;
}

function GetActionStatus($status){
    $statusArr=array(0=>'',1=>__('Open'),2=>__('Overdue'),3=>__('In Progress'),4=>__('Completed'),5=>__('Closed'));
    if(array_key_exists($status, $statusArr)){return $statusArr[$status];}
    return;
}

function GetActionStatusEmail($status){
    $statusArr=array(0=>'',1=>'Open',2=>'Overdue',3=>'In Progress',4=>'Completed',5=>'Closed');
    if(array_key_exists($status, $statusArr)){return $statusArr[$status];}
    return;
}

function GetRiskLevel($status){
    $statusArr=array(0=>'',1=>__('Minor'),2=>__('Serious'),3=>__('Fatal'));
    if(array_key_exists($status, $statusArr)){return $statusArr[$status];}
    return $status;
}

function GetActionResponsibilityUserID($am_id){
    $Responsibility= DB::table('actions_responsible')->where('am_id',$am_id)->get();
    $usernames=array('none');
    if(!empty($Responsibility)){
        $usernames=array();
        foreach ($Responsibility as $key => $value) {
            $usernames[]=$value->user_id;
        }
    }
    return $usernames;
}

function GetActionResponsibility($am_id,$total=''){
    if($total==''){$total=1;}

    $Responsibility= DB::table('actions_responsible as ar')
        ->select('ar.*', 'u.name')
        ->leftJoin('users as u', 'u.id', '=', 'ar.user_id')
        ->where('ar.am_id',$am_id)
        ->orderby('ar.ar_id','asc')
        ->get();
    if(!empty($Responsibility)){
        $usernames=array();
        foreach ($Responsibility as $key => $value) {
            $usernames[]=$value->name;
        }
        return implode(', ', $usernames);
    }
    return ;
}

function GetActionAttachement($am_id){
    $ActionAttachement= DB::table('actions_attachement_rel')->where('am_id',$am_id)->orderby('aa_id','asc')->get();
    return $ActionAttachement;
}

function CheckPermission($userid,$roleid='',$pm_id){
    $Responsibility= DB::table('users_permissions')->where('permission_pm_id',$pm_id)->where('user_by_tennat_id',$userid)->get();
    if(count($Responsibility)){ return '<i class="fa fa-check" aria-hidden="true"></i>';}
    /*$Responsibility= DB::table('role_permissions_master')->where('permission_pm_id',$pm_id)->where('roles_id',$roleid)->get();
    if(count($Responsibility)){ return '<i class="fa fa-check" aria-hidden="true"></i>';}*/
    return __('Assign');
}
function CheckPermissionCount($pm_id){
    $CheckPermissionCount= DB::table('users_permissions')->where('permission_pm_id',$pm_id)->count();
    return $CheckPermissionCount;
}
function GetSiteArea($site_id,$site_type){
    $GetSiteArea= DB::table('sites')->where('site_parent',$site_id)->where('site_type',$site_type)->whereNull('deleted_at')->count();
    return $GetSiteArea;
}

function GetSiteAreaName($site_id){
    $GetSiteAreaName= DB::table('sites')->where('id',$site_id)->whereNull('deleted_at')->first();
    if($GetSiteAreaName){
        return $GetSiteAreaName->site_name;
    }
    return;
}

 function GetSiteDropDown($site_id='',$addedsite='')
    {
        $usersites=array('none');
        if (Auth::check()) {
            $user = Auth::user();
            $user_site = DB::table('user_site_relation')->where('user_id',$user->id)->get();
            if($user_site){ foreach ($user_site as $key => $value) { $usersites[]=$value->site_id; }   }
        }
        if($site_id){
            $Sites=Sites::where('id',$site_id)->where('status',1)->get();
        }else{
            $Sites=Sites::where('status',1)->whereIn('id',$usersites)->where('site_type',1)->get();
        }
        $html='';$leafclass=''; $selected='';
        $html.='<option value="" >'.__('Select Site').'</option>';
        foreach ($Sites as $key => $sitevalue) {
        $Sites0=Sites::where('site_parent',$sitevalue->id)->where('sub_parent',$sitevalue->id)->where('status',1)->orderby('id','asc')->get();
        if(count($Sites0)){$leafclass='non-leaf';}else{$leafclass='';}
        if($addedsite==$sitevalue->id){$selected='selected="selected"';}else{$selected='';}
        $html.='<option '.$selected.' value="'.$sitevalue->id.'" class="l1 '.$leafclass.'">'.$sitevalue->site_name.' ('.count($Sites0).')</option>';
        foreach ($Sites0 as $key => $divivalue) {
           $Sites1=Sites::where('site_parent',$sitevalue->id)->where('sub_parent',$divivalue->id)->where('status',1)->orderby('id','asc')->get();
           if(count($Sites1)){$leafclass='non-leaf';}else{$leafclass='';}
           if($addedsite==$divivalue->id){$selected='selected="selected"';}else{$selected='';}
           $html.='<option '.$selected.' value="'.$divivalue->id.'" data-pup="'.$sitevalue->id.'" class="l2 '.$leafclass.'">'.$divivalue->site_name.' ('.count($Sites1).')</option>';
            foreach ($Sites1 as $key => $departvalue) {
                    $Sites2=Sites::where('site_parent',$sitevalue->id)->where('sub_parent',$departvalue->id)->where('status',1)->orderby('id','asc')->get();
                    if(count($Sites2)){$leafclass='non-leaf';}else{$leafclass='';}
                    if($addedsite==$departvalue->id){$selected='selected="selected"';}else{$selected='';}
                    $html.='<option '.$selected.' value="'.$departvalue->id.'" data-pup="'.$divivalue->id.'" class="l3 '.$leafclass.'">'.$departvalue->site_name.' ('.count($Sites2).')</option>';
                    foreach ($Sites2 as $key => $unitvalue) {
                        if($addedsite==$unitvalue->id){$selected='selected="selected"';}else{$selected='';}
                        $html.='<option '.$selected.' value="'.$unitvalue->id.'" data-pup="'.$departvalue->id.'" class="l4 ">'.$unitvalue->site_name.'</option>';
                    }
            }
        }
        }
        return $html;
    }

function GetCatDropDown($Type='',$addedcat='')
    {
        if($Type==''){
            $Category=Category::orderby('parent_id','asc')->get()->toArray();
        }else{
            $Category=Category::where('type_id',$Type)->orderby('parent_id','asc')->get()->toArray();
        }

        $html='';$leafclass=''; $selected='';
        if($Type==4){
            $html.='<option value="" >'.__("Select Audit Type").'</option>';
        }else{
            $html.='<option value="" >'.__("Select Category").'</option>';
        }

        foreach ($Category as $key => $category_value) {
        $html.='<option ';
        if($category_value['parent_id']!=$category_value['id']){
            $html.=' data-pup="'.$category_value['parent_id'].'" ';
        }
        if($category_value['parent_id']==$category_value['id']){
            if(array_key_exists($key+1, $Category)){
                if($Category[$key+1]['parent_id']==$category_value['id']){
                    $html.=' class="l1 non-leaf" ';
                }
            }
        }
        if($addedcat==$category_value['id']){
            $html.=' selected="selected" ';
        }
        $html.=' value="'.$category_value['id'].'">'.$category_value['category_name'].'</option>';
        }
        return $html;
    }

function GetVaccinetypeDropDown($filter=false,$second_vaccination=false,$value='',$other_val='')
{
    if($filter){
        $html='<select class="vaccine_type vaccinationslist" name="filtervaccinetype">';
    }else if($second_vaccination){
        $html='<select class="vaccine_type" name="second_vaccine_type" >';
    }else{
        $html='<select class="vaccine_type" name="vaccine_type" >';
    }

    if($value == ''){
        $html.='<option selected disabled >Select vaccine type</option>';
    }else{
        $html.='<option disabled>Select vaccine type</option>';
    }
    if($value == 'Pfizer'){
        $html.='<option selected value="Pfizer">Pfizer</option>';
    }else{
        $html.='<option value="Pfizer">Pfizer</option>';
    }
    if($value == 'AstraZeneca'){
        $html.='<option selected value="AstraZeneca">AstraZeneca</option>';
    }else{
        $html.='<option value="AstraZeneca">AstraZeneca</option>';
    }
    if($value == 'Moderna'){
        $html.='<option selected value="Moderna">Moderna</option>';
    }else{
        $html.='<option value="Moderna">Moderna</option>';
    }

    if($value== 'Other'){
        $html.='<option selected value="Other">Other</option>';
    }else{
        $html.='<option value="Other">Other</option>';
    }

    $html.='</select>';
    if($value== 'Other' && $second_vaccination){
        $html.='<input type="text" required placeholder="Vaccine Manufacturer" name="second_other_vaccine_type" class="form-control classsecond_other_vaccine_type" value="'.$other_val.'" >';
    }elseif($value == 'Other'){
        $html.='<input type="text" required placeholder="Vaccine Manufacturer" name="other_vaccine_type" class="form-control classother_vaccine_type" value="'.$other_val.'" >';
    }
    return $html;
    }
function GetAuditTemplateDropDown($addedvalue='')
{
    $AuditTemplates=AuditTemplates::all();
    $html='';
    $html.='<option value="" >Select name</option>';
    if($AuditTemplates){
        foreach ($AuditTemplates as $key => $AuditTemplatesItem) {
            $selected='';
            if($addedvalue==$AuditTemplatesItem->atm_id){
                $selected=' selected="selected" ';
            }
            $html.='<option '.$selected.' value="'.$AuditTemplatesItem->atm_id.'" >'.$AuditTemplatesItem->atm_audit_name.'</option>';
        }
    }
    return $html;
}

function GetVaccinetype($addedvalue='')
{
    $vaccine_type= DB::table('vaccine_type')->where('vt_status',1)->get();
    $html='';
    $html.='<option value="" >'.__("Select").'</option>';
    if($vaccine_type){
        foreach ($vaccine_type as $key => $value) {
            $selected='';
            if($addedvalue==$value->vt_id){
                $selected=' selected="selected" ';
            }

            $html.='<option '.$selected.' value="'.$value->vt_id.'" >'.$value->vt_name.'</option>';
        }
    }
    if($addedvalue=='other'){
                $selected=' selected="selected" ';
            }
    $html.='<option '.$selected.' value="other" >'.__("Other").'</option>';
    return $html;
}

function GetAuditFrequencyDropDown($addedvalue='')
{
    $AuditFrequency=DB::table('audit_frequency')->get();
    $html='';
    $html.='<option value="" >'.__('Select').' '.__('Frequency').'</option>';
    if($AuditFrequency){
        foreach ($AuditFrequency as $key => $AuditFrequencyItem) {
            $selected='';
            if($addedvalue==$AuditFrequencyItem->af_id){
                $selected=' selected="selected" ';
            }
            $html.='<option '.$selected.' value="'.$AuditFrequencyItem->af_id.'" >'.$AuditFrequencyItem->af_name.'</option>';
        }
    }
    return $html;
}
function GetInspectionScore($adm_id='',$adm_atm_id,$type='')
{
    $audit_template_parts_questions= DB::table('audit_template_parts_questions')->select('atpq_id')->whereNull('atpq_parent_id')->where('atpq_atm_id',$adm_atm_id)->whereNull('deleted_at')->get();
    if(count($audit_template_parts_questions)){
        $atpq_id=array();
        foreach ($audit_template_parts_questions as $key => $value) {
            $atpq_id[]= $value->atpq_id;
        }
        $audit_answer_master= DB::table('audit_answer_master')->where('aam_adm_id',$adm_id)->whereIn('aam_atpq_id',$atpq_id)->whereNull('deleted_at')->groupBy('aam_atpq_id')->get();
        if($type==1){return count($audit_answer_master).' out of '.count($atpq_id);}
        return  round((count($audit_answer_master)*100)/count($atpq_id)).'%';
    }
    return '0%';
}

function GetsiteIdsTree($filtersiteID)
{   $filtersite=array();
    if($filtersiteID){
        $Sites = Sites::where('status',1)->where('id',$filtersiteID)->first();
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
    return $filtersite;
}

//********* 13-01-2021
function randString($length) {
    $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $char = str_shuffle($char);
    for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
        $rand .= $char[mt_rand(0, $l)];
    }
    return $rand;
}
function get_site_name(){
    return 'Workplace Dash';
}
function get_role_field($id, $field){
    $role = DB::table('roles')->select($field)->where('id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_category_field($id, $field){
    $role = DB::table('category')->select($field)->where('id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_site_field($id, $field){
    $role = DB::table('sites')->select($field)->where('id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_control_field($id, $field){
    $role = DB::table('control_master')->select($field)->where('cm_id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_user_field($id, $field){
    $role = DB::table('users')->select($field)->where('id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_user_all_field($id){
    $users = DB::table('users')->where('id', $id)->first();
    return ($users)?$users:'';
}
function get_rating_field($id, $field){
    $role = DB::table('incidents_rating')->select($field)->where('ir_id', $id)->first();
    return ($role)?$role->{$field}:'';
}
function get_shifts_field($id, $field){
    if($id){
        $role = DB::table('shift_master')->select($field)->where('sm_id', $id)->first();
        return ($role)?$role->{$field}:'';
    }
}
function check_user_permissions($userid, $menu){
    $check = DB::table('permissions_master as pm')
        ->select('*')
        ->leftJoin('users_permissions as up', 'up.permission_pm_id', '=', 'pm.pm_id')
        ->where('up.permission_pm_id',$userid)
        ->where('pm.pm_name',$menu)
        ->first();

    return $check;
}
?>
