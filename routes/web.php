<?php

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

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('privacy_policy','FrontendController@Privacy');
=======
Route::get('privacy_policy','FrontendController@PrivacyPolicy');
>>>>>>> d7773d31828416c18e795d6918cea69281a291d8
