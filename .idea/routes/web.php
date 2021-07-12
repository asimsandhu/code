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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');
         /*---------------userlogin-----------*/
Route::post('/login_user','App\Http\Controllers\userController@login_user')->middleware('guest');
Route::get('/login','App\Http\Controllers\userController@show_login_form')->name('login')->middleware('guest');
Route::get('/dashboard','App\Http\Controllers\userController@show_dashboard')->name('dashboard')->middleware('auth');

/*gdhdgfdgf*/
        /*---------------userlogout-----------*/
Route::get('/logout','App\Http\Controllers\userController@logout')->middleware('auth');

       /*---------------Login detail-----------*/
Route::get('/login_details','App\Http\Controllers\userController@login_details')->middleware('auth');





        //--------AGENT MANAGMENT-------
Route::get('/agent_CRUD','App\Http\Controllers\userController@show_agent_crud')->middleware('auth');
Route::post('/create_agent','App\Http\Controllers\userController@create_agent')->middleware('auth');
Route::post('/assign_role','App\Http\Controllers\userController@assign_role')->middleware('auth');



       /*------------------SUBSCRIBER -----------*/
Route::get('/subscriber','App\Http\Controllers\SubscriberController@show_subscriber_crud')->middleware('auth');
Route::post('create_subscriber','App\Http\Controllers\SubscriberController@create_subscriber')->middleware('auth');
