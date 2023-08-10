<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('setlocale/{locale}',function($lang){
       \Session::put('locale',$lang);
       return redirect()->back();
});

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/linkstorage', function () {
   Artisan::call('storage:link');
});
Route::get('/', 'GeneralController@home');
Auth::routes(['verify' => true]);
Route::get('admin/login', 'GeneralController@AdminLogin')->name('adminlogin');
Route::post('admin/login', 'GeneralController@AdminLoginPost')->name('adminloginpost')->middleware('FrontUsersLogin');;

Route::post('company/login', 'GeneralController@CompanyLoginPost')->name('companyloginpost');//->middleware('FrontUsersLogin');
Route::get('cleardata', 'GeneralController@ClearData')->name('cleardata');
Route::get('testurl', 'HomeController@TestFunction')->name('testurl');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::group(array('prefix' => 'near-miss'), function () {
	Route::get('/', 'ObservationsControllers@index')->name('observations');
	Route::post('create', 'ObservationsControllers@create')->name('observationscreate');
	Route::post('store', 'ObservationsControllers@store')->name('observationsstore');
	Route::post('{id}/edit', 'ObservationsControllers@edit')->name('observationedit');
	Route::post('update', 'ObservationsControllers@update')->name('observationupdate');
	Route::post('{id}/delete', 'ObservationsControllers@delete')->name('observationdelete');
	Route::post('{id}/restore', 'ObservationsControllers@restore')->name('observationrestore');
	Route::post('{id}/deletefile', 'ObservationsControllers@DeleteFile')->name('deletefile');
	Route::post('{ora_id}/deletefileora', 'ObservationsControllers@DeleteFileOra')->name('deletefileora');
	Route::get('addaction', 'ObservationsControllers@AddAction')->name('addaction');
	Route::post('{id}/details', 'ObservationsControllers@Details')->name('observationdetails');
	Route::post('observationsstoreaction', 'ObservationsControllers@StoreAction')->name('observationsstoreaction');
});

Route::group(array('prefix' => 'vaccinations'), function () {
    Route::get('/', 'VaccinationController@index')->name('vaccinations');
    Route::post('store', 'VaccinationController@store')->name('vaccinationsstore');
    Route::post('{id}/edit', 'VaccinationController@edit')->name('vaccinationedit');
	Route::post('update', 'VaccinationController@update')->name('vaccinationupdate');
	Route::post('{id}/delete', 'VaccinationController@delete')->name('vaccinationdelete');
});

Route::group(array('prefix' => 'incidents'), function () {
	Route::get('/', 'IncidentsControllers@index')->name('incidents');
	Route::post('create', 'IncidentsControllers@create')->name('incidentscreate');
	Route::post('store', 'IncidentsControllers@store')->name('incidentsstore');
	Route::post('{id}/edit', 'IncidentsControllers@edit')->name('incidentsedit');
	Route::post('update', 'IncidentsControllers@update')->name('incidentsupdate');
	Route::post('updaterating', 'IncidentsControllers@UpdateRating')->name('updaterating');
	Route::post('{id}/delete', 'IncidentsControllers@delete')->name('incidentsdelete');
	Route::post('{id}/deletefile', 'IncidentsControllers@DeleteFile')->name('incidentsdeletefile');
	Route::get('{id}/steps/{step}', 'IncidentsControllers@Details')->name('incidentsdetails');
	Route::get('addvictim', 'IncidentsControllers@AddVictim')->name('addvictim');
	Route::get('addaction', 'IncidentsControllers@AddAction')->name('addaction');
	Route::post('step1', 'IncidentsControllers@StepOne')->name('step1');
	Route::post('step2', 'IncidentsControllers@StepTwo')->name('step2');
	Route::post('step3', 'IncidentsControllers@StepThree')->name('step3');
	Route::post('step4', 'IncidentsControllers@StepFour')->name('step4');
	Route::post('approvedstep4', 'IncidentsControllers@StepFourApproval')->name('approvedstep4');
	Route::post('step5', 'IncidentsControllers@StepFive')->name('step5');
	Route::post('stepnoninvistigation', 'IncidentsControllers@StepNonInvistiGation')->name('stepnoninvistigation');

});

Route::group(array('prefix' => 'actions'), function () {
	Route::get('/', 'ActionsControllers@index')->name('actions');
	Route::get('create', 'ActionsControllers@create')->name('actionscreate');
	Route::post('store', 'ActionsControllers@store')->name('actionsstore');
	Route::post('{id}/edit', 'ActionsControllers@edit')->name('actionsedit');
	Route::post('update', 'ActionsControllers@update')->name('actionsupdate');
	Route::post('{id}/delete', 'ActionsControllers@delete')->name('actionsdelete');
	Route::post('{id}/deletefile', 'ActionsControllers@DeleteFile')->name('actionsdeletefile');
	Route::post('{id}/details', 'ActionsControllers@Details')->name('actiondetails');
	Route::post('detailsupdate', 'ActionsControllers@DetailsUpdate')->name('detailsupdate');
});

Route::group(array('prefix' => 'permits'), function () {
	Route::get('/', 'PermitsControllers@index')->name('permits');
	Route::get('create', 'PermitsControllers@create')->name('permitscreate');
});

Route::group(array('prefix' => 'sites'), function () {
	Route::get('/', 'SitesControllers@index')->name('sites');
	Route::get('create', 'SitesControllers@create')->name('sitescreate');
	Route::post('store', 'SitesControllers@store')->name('sitesstore');
	Route::get('{id}/edit', 'SitesControllers@edit')->name('sitesedit');
	Route::post('update', 'SitesControllers@update')->name('sitesupdate');
	Route::get('{id}/delete', 'SitesControllers@delete')->name('sitesdelete');
	Route::get('{id}/divisions', 'SitesControllers@GetDivisions')->name('getdivisions');
	Route::get('{site_id}/adddivisions', 'SitesControllers@AddSubArea')->name('adddivisions');
	Route::get('{site_id}/{divi_id}/adddepartment', 'SitesControllers@AddSubArea')->name('adddepartment');
	Route::get('{site_id}/{dep_id}/addunit', 'SitesControllers@AddSubArea')->name('addaddunit');
	Route::post('postsubarea', 'SitesControllers@PostSubArea')->name('postsubarea');
	Route::post('postsubareaupdate', 'SitesControllers@PostSubAreaUpdate')->name('postsubareaupdate');
	Route::get('{id}/deletearea', 'SitesControllers@deleteArea')->name('deletearea');
});

Route::group(array('prefix' => 'roles'), function () {
	Route::get('/', 'RolesControllers@index')->name('roles');
	Route::get('create', 'RolesControllers@create')->name('rolescreate');
	Route::post('store', 'RolesControllers@store')->name('rolesstore');
	Route::get('{id}/edit', 'RolesControllers@edit')->name('rolesedit');
	Route::post('update', 'RolesControllers@update')->name('rolesupdate');
	Route::get('{id}/delete', 'RolesControllers@delete')->name('rolesdelete');
});

Route::group(array('prefix' => 'users'), function () {
	Route::get('/', 'UsersControllers@index')->name('users');
	Route::get('create', 'UsersControllers@create')->name('userscreate');
	Route::post('store', 'UsersControllers@store')->name('userstore');
	Route::get('{id}/edit', 'UsersControllers@edit')->name('usersedit');
	Route::post('update', 'UsersControllers@update')->name('userupdate');
	Route::get('{id}/delete', 'UsersControllers@delete')->name('usersdelete');
	Route::get('deleted', 'UsersControllers@deleted')->name('usersdeleted');
	Route::get('{id}/restore', 'UsersControllers@restore')->name('usersrestore');
	Route::get('{id}/permission', 'UsersControllers@GetPermission')->name('getpermission');
	Route::post('postpermission', 'UsersControllers@PostPermission')->name('postpermission');
	Route::get('{id}/resendvarification', 'UsersControllers@ResendVarification')->name('resendvarification');
});

Route::group(array('prefix' => 'universal-login'), function () {
	Route::get('/', 'UniversalControllers@index')->name('universal-login');
	Route::get('create', 'UniversalControllers@create')->name('universaluserscreate');
	Route::post('store', 'UniversalControllers@store')->name('universaluserstore');
	Route::get('{id}/edit', 'UniversalControllers@edit')->name('universalusersedit');
	Route::post('update', 'UniversalControllers@update')->name('universaluserupdate');
	Route::get('{id}/delete', 'UniversalControllers@delete')->name('universalusersdelete');
	Route::get('deleted', 'UniversalControllers@deleted')->name('universalusersdeleted');
	Route::get('{id}/restore', 'UniversalControllers@restore')->name('universalusersrestore');
	Route::get('{id}/permission', 'UniversalControllers@GetPermission')->name('universalgetpermission');
	Route::post('postpermission', 'UniversalControllers@PostPermission')->name('universalpostpermission');
	Route::get('{id}/resendvarification', 'UniversalControllers@ResendVarification')->name('universalresendvarification');
});

Route::group(array('prefix' => 'categories'), function () {
	Route::get('/', 'CategoriesControllers@index')->name('categories');
	Route::get('create', 'CategoriesControllers@create')->name('categorycreate');
	Route::get('{parent_id}/create', 'CategoriesControllers@create')->name('subcategorycreate');
	Route::post('store', 'CategoriesControllers@store')->name('categorystore');
	Route::get('{id}/edit', 'CategoriesControllers@edit')->name('categoryedit');
	Route::post('update', 'CategoriesControllers@update')->name('categoryupdate');
	Route::get('{id}/delete', 'CategoriesControllers@delete')->name('categorydelete');
});

Route::group(array('prefix' => 'rootcause'), function () {
	Route::get('/', 'RootCauseControllers@index')->name('rootcause');
	Route::get('create', 'RootCauseControllers@create')->name('rootcausecreate');
	Route::post('store', 'RootCauseControllers@store')->name('rootcausestore');
	Route::get('{id}/edit', 'RootCauseControllers@edit')->name('rootcauseedit');
	Route::post('update', 'RootCauseControllers@update')->name('rootcauseupdate');
	Route::get('{id}/delete', 'RootCauseControllers@delete')->name('rootcausedelete');
	Route::get('{rc_id}/list', 'RootCauseControllers@GetList')->name('rootcauselist');
	Route::get('{rc_id}/list/create', 'RootCauseControllers@ListSubCreate')->name('rootcauselistcreate');
	Route::post('storesub', 'RootCauseControllers@StoreSub')->name('rootcausestoresub');
	Route::get('{rc_id}/{parent_id}/list/create', 'RootCauseControllers@ListSubCreate')->name('rootcauselistsubcreate');
	Route::get('{rci_id}/sub-edit', 'RootCauseControllers@Subedit')->name('rootcauseeditsub');
	Route::post('subupdate', 'RootCauseControllers@Subupdate')->name('rootcauseupdatesub');
	Route::get('{rc_id}/{rci_id}/sub-delete', 'RootCauseControllers@Subdelete')->name('rootcausedeletesub');
});

Route::group(array('prefix' => 'audit-templates'), function () {
	Route::get('/', 'AuditTemplatesControllers@index')->name('audittemplates');
	Route::post('create', 'AuditTemplatesControllers@create')->name('audittemplatescreate');
	Route::post('store', 'AuditTemplatesControllers@store')->name('audittemplatesstore');
	Route::post('{id}/edit', 'AuditTemplatesControllers@edit')->name('audittemplatesedit');
	Route::post('update', 'AuditTemplatesControllers@update')->name('audittemplatesupdate');
	Route::post('{id}/delete', 'AuditTemplatesControllers@delete')->name('audittemplatesdelete');
	Route::post('{id}/deleteicon', 'AuditTemplatesControllers@DeleteIcon')->name('audittemplatesdeleteicon');
	Route::get('{atm_id}/section', 'AuditTemplatesControllers@GetSetions')->name('getsetions');
	Route::get('{atm_id}/{atp_id}/section', 'AuditTemplatesControllers@GetSetions')->name('getsetionslist');
	Route::post('storesection', 'AuditTemplatesControllers@StoreSection')->name('storesection');
	Route::post('addnewquestion', 'AuditTemplatesControllers@AddNewQuestion')->name('addnewquestion');
	Route::post('addnewsubquetions', 'AuditTemplatesControllers@AddNewSubQuestion')->name('addnewsubquetions');
	Route::post('addnewquestionoption', 'AuditTemplatesControllers@AddNewQuestionOption')->name('addnewquestionoption');
	Route::post('addgridviewtable', 'AuditTemplatesControllers@AddGridViewTable')->name('addgridviewtable');
	Route::post('checkboxoptionchange', 'AuditTemplatesControllers@CheckBoxOptionChange')->name('checkboxoptionchange');
	Route::post('checkboxoptionsave', 'AuditTemplatesControllers@CheckBoxOptionSave')->name('checkboxoptionsave');
	Route::post('{atp_id}/delelteseaction', 'AuditTemplatesControllers@DelelteSeaction')->name('delelteseaction');
	Route::post('changesectionstatus', 'AuditTemplatesControllers@ChangeSectionStatus')->name('changesectionstatus');
	Route::post('changesectionname', 'AuditTemplatesControllers@ChangeSectionName')->name('changesectionname');
	Route::post('addupdatequstion', 'AuditTemplatesControllers@AddUpdateQustion')->name('addupdatequstion');
	Route::post('deletequstion', 'AuditTemplatesControllers@DeleteQustion')->name('deletequstion');
	Route::post('addvaluetogridoption', 'AuditTemplatesControllers@AddValueToGridOption')->name('addvaluetogridoption');
});

Route::group(array('prefix' => 'audits'), function () {
	Route::get('/', 'AuditsControllers@index')->name('audits');
	Route::post('auditwise', 'AuditsControllers@index')->name('postauditwise');
	Route::get('sitewise', 'AuditsControllers@GetSitewise')->name('sitewise');
	Route::post('sitewise', 'AuditsControllers@GetSitewise')->name('postsitewise');
	Route::post('getauditbymonth', 'AuditsControllers@GetAuditByMonth')->name('getauditbymonth');
	Route::post('getsiteusers', 'AuditsControllers@GetSiteUsers')->name('getsiteusers');
	Route::post('store', 'AuditsControllers@store')->name('auditsstore');
	Route::post('edit', 'AuditsControllers@Edit')->name('edit');
	Route::post('update', 'AuditsControllers@update')->name('auditsupdate');
	Route::post('delete', 'AuditsControllers@delete')->name('auditsndelete');
	Route::get('{adm_id}/audit', 'AuditsControllers@GetAuditSection')->name('getauditsection');
	Route::get('{adm_id}/audit/{atp_id}', 'AuditsControllers@GetAuditSection')->name('getauditsectionlist');
	Route::get('{adm_id}/keyfindings', 'AuditsControllers@GetKeyFindings')->name('keyfindings');
	Route::get('{adm_id}/actionitems', 'AuditsControllers@GetActionItems')->name('actionitems');
	Route::post('postkeyfindings', 'AuditsControllers@PostKeyFindings')->name('postkeyfindings');
	Route::post('postnotify', 'AuditsControllers@PostNotify')->name('postnotify');
	Route::post('getactionpopup', 'AuditsControllers@GetActionPopup')->name('getactionpopup');
	Route::post('addauditaction', 'AuditsControllers@AddAuditAction')->name('addauditaction');
	Route::post('geteditactionpopup', 'AuditsControllers@GetEditActionPopup')->name('geteditactionpopup');
	Route::post('posteditactionpopup', 'AuditsControllers@PostEditActionPopup')->name('posteditactionpopup');
	Route::post('deleteactionitem', 'AuditsControllers@DeleteActionItem')->name('deleteactionitem');
	Route::post('ansewertoaudit', 'AuditsControllers@PostAnsewerToAudit')->name('ansewertoaudit');
	Route::post('ansewertoauditfiles', 'AuditsControllers@PostAnsewerToAuditFiles')->name('ansewertoauditfiles');
	Route::post('deleteansattachment', 'AuditsControllers@DeleteAnsAttachment')->name('deleteansattachment');
	Route::post('postgridanswer', 'AuditsControllers@PostGridAnswer')->name('postgridanswer');
	Route::post('auditsectioncomplete', 'AuditsControllers@AuditSectionComplete')->name('auditsectioncomplete');
	Route::post('auditchangetocomplate', 'AuditsControllers@AuditChangeToComplate')->name('auditchangetocomplate');
	Route::post('auditchangetoreject', 'AuditsControllers@AuditChangeToReject')->name('auditchangetoreject');
	Route::post('auditchangetoapproved', 'AuditsControllers@AuditChangeToApproved')->name('auditchangetoapproved');
	Route::get('{adm_id}/report', 'AuditsControllers@GetAuditReport')->name('getreport');

});


Route::group(array('prefix' => 'admin', 'middleware' => 'Admin'), function () {
	Route::get('/', 'AdminController@index')->name('admin');
});


