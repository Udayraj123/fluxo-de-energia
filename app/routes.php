<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/',function(){return View::make('login');});
Route::get('/login',function(){return View::make('login');});
Route::get('/create',function(){return View::make('create');});
Route::group(array('before' => 'teacher'), function(){
	Route::get('/panel',['as'=>'panel_teacher',function(){return View::make('panel_teacher');}]);
	Route::post('/getStudList',['as'=>'getStudList','uses'=>'teacherController@getStudList']);
	Route::post('/approveStuds',['as'=>'approveStuds','uses'=>'teacherController@approveStuds']);
});

Route::group(array('before' => 'admin'), function(){
	Route::get('/panel_admin',['as'=>'panel_admin',function(){return View::make('panel_admin');}]);
	Route::post('/addRole',['as'=>'addRole','uses'=>'AdminController@addRole']);
});

Route::group(array('before' => 'student'), function()
{
	Route::get('/home',['as'=>'panel_student','uses'=>'studentController@panel_student']);
	Route::post('/getApprList',['as'=>'getApprList','uses'=>'studentController@getApprList']);
	
});


Route::post('/createUser',['as'=>'createUser','uses'=>'HomeController@createUser']);
Route::group(array('before' => 'csrf'), function()
{
	Route::post('/createTeacher',['as'=>'createTeacher','uses'=>'HomeController@createTeacher']);
	Route::post('/login',['as'=>'login','uses'=>'HomeController@login']);
});