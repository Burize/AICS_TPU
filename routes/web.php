<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/',['as' => 'main', 'uses' => 'MainPage@index', 'middleware' => 'auth']);

route::get('/administrate',['as'=>'Admin', 'uses'=>'Profil@Admin', 'middleware' => 'admin']);
route::post('/administrate/add',['as'=>'ManagerAdd', 'uses'=>'Profil@AddManager', 'middleware' => 'admin']);
route::post('/administrate/remove',['as'=>'ManagerRemove', 'uses'=>'Profil@RemoveFromManagers', 'middleware' => 'admin']);
route::post('/administrate/add_user',['as'=>'UserAdd', 'uses'=>'Profil@AddUser', 'middleware' => 'admin']);
route::post('/administrate/delete_user',['as'=>'UserDelete', 'uses'=>'Profil@DeleteUser', 'middleware' => 'admin']);
route::post('/administrate/get_user',['as'=>'GetUser', 'uses'=>'Profil@GetUser', 'middleware' => 'admin']);
route::post('/administrate/update_user',['as'=>'UpdateUser', 'uses'=>'Profil@UpdateUser', 'middleware' => 'admin']);

Route::get('/add',['as'=>'addindex','uses'=>'DeviceManager@Add', 'middleware' => 'manager']);
Route::post('/add',['as'=>'add','uses'=>'DeviceManager@Add', 'middleware' => 'manager']);


Route::get('/login',['as'=>'getlogin','uses'=>'Profil@Login']);
Route::post('/login',['as' => "login",'uses'=>'Profil@Login']); 
route::get('/profil/logout',['as'=>'Logout','uses'=>'Profil@Logout']);
route::get('/profil',['as'=>'profil','uses'=>'Profil@Index']);

route::get('/item',['as'=>'Item','uses'=>'DeviceManager@ItemIndex',  'middleware' => 'auth']);
route::post('/item/delete',['as'=>'Delete','uses'=>'DeviceManager@Delete', 'middleware' => 'manager']);

route::get('/edit',['as'=>'Editindex','uses'=>'DeviceManager@Edit', 'middleware' => 'manager']);
route::post('/edit',['as'=>'Edit','uses'=>'DeviceManager@Edit', 'middleware' => 'manager']);

route::get('/lend',['as'=>'LendIndex', 'uses'=>'DeviceManager@Lend','middleware' => 'manager']);
route::post('/lend',['as'=>'Lend', 'uses'=>'DeviceManager@Lend','middleware' => 'manager']);

route::post('/getusers', ['as'=>'GetStudents', 'uses'=>'Profil@GetUsers', 'middleware' => 'manager']);
//route::post('/getmanagers', ['as'=>'GetManagers', 'uses'=>'Profil@GetManagers', 'middleware' => 'admin']);


route::get('/records',['as'=>'Lends', 'uses'=>'Record@Index', 'middleware' => 'manager']);
route::post('/records/mail',['as'=>'Mail', 'uses'=>'Record@Mail','middleware' => 'manager']);
route::post('/records/return',['as'=>'Return', 'uses'=>'Record@_Return','middleware' => 'manager']);
//route::get('/records/return',['as'=>'Return', 'uses'=>'Record@_Return','middleware' => 'manager']);