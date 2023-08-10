<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/', array('uses' => 'ApiController@index'));
Route::get('getlogin', array('uses' => 'ApiController@getlogin'))->middleware('ApiUserCheck'); //FrontUsersLogin
Route::get('forgotpass',array('uses'=>'ApiController@forgotpass'))->middleware('ApiUserCheck');

//Route::get('getlogin', array('uses' => 'ApiController@getlogin'))->middleware('FrontUsersLogin');
Route::get('getobservations', array('uses' => 'ApiController@getobservations'))->middleware('APIMiddleware');
Route::get('getobdetail', array('uses' => 'ApiController@getobdetail'))->middleware('APIMiddleware');
Route::get('getobcreatedata', array('uses' => 'ApiController@getobcreatedata'))->middleware('APIMiddleware');
Route::post('addob',array('uses'=>'ApiController@addob'))->middleware('APIMiddleware');
Route::post('updateob',array('uses'=>'ApiController@updateob'))->middleware('APIMiddleware');
Route::get('deleteob',array('uses'=>'ApiController@deleteob'))->middleware('APIMiddleware');
Route::post('addobfiles',array('uses'=>'ApiController@addobfiles'))->middleware('APIMiddleware');
Route::get('getactiondata', array('uses' => 'ApiController@getactiondata'))->middleware('APIMiddleware');
Route::get('editob',array('uses'=>'ApiController@editob'))->middleware('APIMiddleware');
Route::get('deleteaction',array('uses'=>'ApiController@deleteaction'))->middleware('APIMiddleware');
//insi
Route::get('getincidents', array('uses' => 'ApiController@getincidents'))->middleware('APIMiddleware');
Route::get('deleteinc',array('uses'=>'ApiController@deleteinc'))->middleware('APIMiddleware');
Route::get('getincidentdata', array('uses' => 'ApiController@getincidentdata'))->middleware('APIMiddleware');
Route::post('addinc',array('uses'=>'ApiController@addinc'))->middleware('APIMiddleware');
Route::get('editinc',array('uses'=>'ApiController@editinc'))->middleware('APIMiddleware');
Route::post('updateinc',array('uses'=>'ApiController@updateinc'))->middleware('APIMiddleware');
Route::get('getincidentvictim', array('uses' => 'ApiController@getincidentvictim'))->middleware('APIMiddleware');
Route::get('getincidentrootcauseanalysis', array('uses' => 'ApiController@getIncidentRootCauseAnalysis'))->middleware('APIMiddleware');
Route::get('getincidentrootactions', array('uses' => 'ApiController@getIncidentActions'))->middleware('APIMiddleware');
Route::get('getincidentinvestigationteam', array('uses' => 'ApiController@getIncidentInvestigationTeam'))->middleware('APIMiddleware');
Route::post('storestepone',array('uses'=>'ApiController@storestepone'))->middleware('APIMiddleware');
Route::post('storesteptwo',array('uses'=>'ApiController@storesteptwo'))->middleware('APIMiddleware');
Route::post('storestepthree',array('uses'=>'ApiController@storestepthree'))->middleware('APIMiddleware');
Route::post('storestepfour',array('uses'=>'ApiController@storestepfour'))->middleware('APIMiddleware');
Route::post('storestepfive',array('uses'=>'ApiController@storestepfive'))->middleware('APIMiddleware');
Route::get('incidentapprover',array('uses'=>'ApiController@incidentapprover'))->middleware('APIMiddleware');
Route::get('incidentratings',array('uses'=>'ApiController@incidentratings'))->middleware('APIMiddleware');
Route::get('deletefilecommon', array('uses' => 'ApiController@deletefilecommon'))->middleware('APIMiddleware');
Route::get('getdashboard', array('uses' => 'ApiController@getdashboard'))->middleware('APIMiddleware');
Route::get('getactions', array('uses' => 'ApiController@getactions'))->middleware('APIMiddleware');
Route::get('geteditactdata',array('uses'=>'ApiController@geteditactdata'))->middleware('APIMiddleware');

Route::post('updateact',array('uses'=>'ApiController@updateact'))->middleware('APIMiddleware');
Route::get('getactionfilterdata', array('uses' => 'ApiController@getactionfilterdata'))->middleware('APIMiddleware');
Route::get('getinstructions', array('uses' => 'ApiController@getinstructions'));







