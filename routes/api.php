<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('profile_for','Api\UserController@ProfileFor');
Route::get('profile_created_by','Api\UserController@ProfileCreated');
Route::get('blood_group','Api\UserController@BloodGroup');
Route::get('religion','Api\UserController@Religion');
Route::get('community','Api\UserController@Community');
Route::get('mother_tongue','Api\UserController@MotherTongue');
Route::get('face_fair','Api\UserController@FaceFair');
Route::post('register','Api\UserController@Register');
Route::post('login','Api\UserController@Login');

//Route::middleware('auth:api')->group(function () {
	Route::post('sub_community','Api\UserController@SubCommunity');
	Route::post('religion_background','Api\UserController@ReligionBackground');
	Route::post('profile_screen','Api\UserController@ProfileScreen');
	Route::post('education_details','Api\UserController@EducationDetails');
	Route::post('family_details','Api\UserController@FamilyDetails');
	Route::post('get_status','Api\UserController@GetStatus');
	Route::post('profile_pic','Api\UserController@ProfilePic');
	Route::post('profile_info','Api\UserController@ProfileInfo');
	Route::post('previous_data','Api\UserController@PreviousData');
	
//});


