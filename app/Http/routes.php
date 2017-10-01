<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    //return view('welcome');
    if(Auth::check()){
		if(Auth::user()->getRolesId() == 1){                // If roles id == 1, redirect to /admin            
	      return redirect('admin');
	    }
	    if(Auth::user()->getRolesId() == 2){                // If roles id == 2, redirect to /user            
	      return redirect('user');
	    }
	}
	else{
		return redirect('/login');
	}
});

Route::auth();

//Public
Route::post('register', [
   'as' => 'register', 'uses' => 'Auth\AuthController@postRegister'
]);

Route::get('homepage', ['uses'=>'UserController@homepage'])->name('homepage');

Route::get('check-availability', ['uses'=>'UserController@checkAvailability'])->name('check-availability');
Route::post('check', ['uses'=>'UserController@check'])->name('check');

Route::get('/home', 'HomeController@index');
Route::get('loginTemplate', ['uses'=>'AdminController@loginTemplate'])->name('admin.loginTemplate');

Route::get('test', [
   'as' => 'test', 'uses' => 'UserController@test'
]);

//Admin
Route::group(['middleware'=>['auth', 'checkRole:1']], function(){
	Route::get('admin/', ['uses'=>'AdminController@index'])->name('admin.index');

	Route::get('admin/manage-user', ['uses'=>'AdminController@manageUser'])->name('admin.manage-user');
	Route::post('admin/create-user', ['uses'=>'AdminController@createUser'])->name('admin.create-user');
	Route::delete('admin/delete-user', ['uses'=>'AdminController@deleteUser'])->name('admin.delete-user');
	Route::patch('admin/edit-user', ['uses'=>'AdminController@editUser'])->name('admin.edit-user');

	Route::get('admin/manage-vehicle', ['uses'=>'AdminController@manageVehicle'])->name('admin.manage-vehicle');
	Route::post('admin/create-vehicle', ['uses'=>'AdminController@createVehicle'])->name('admin.create-vehicle');
	Route::delete('admin/delete-vehicle', ['uses'=>'AdminController@deleteVehicle'])->name('admin.delete-vehicle');
	Route::patch('admin/edit-vehicle', ['uses'=>'AdminController@editVehicle'])->name('admin.edit-vehicle');
	Route::get('admin/view-vehicle-histories/{id}', ['uses'=>'AdminController@viewVehicleHistories'])->name('admin.view-vehicle-histories');

	Route::get('admin/manage-booking', ['uses'=>'AdminController@manageBooking'])->name('admin.manage-booking');
	Route::get('admin/approve-reject-confirmation/{booking_id}', ['uses'=>'AdminController@approveRejectConfirmation'])->name('admin.approve-reject-confirmation');
	Route::post('admin/approve-reject', ['uses'=>'AdminController@approveReject'])->name('admin.approve-reject');
});

//User
Route::group(['middleware'=>['auth', 'checkRole:2']], function(){

	Route::get('user', ['uses'=>'UserController@index'])->name('user.index');
	Route::post('user/booking', ['uses'=>'UserController@booking'])->name('user.booking');
	Route::post('user/view-available-booking', ['uses'=>'UserController@showAvailableBooking'])->name('user.view-available-booking');

});