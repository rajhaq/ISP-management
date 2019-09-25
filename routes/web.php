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
//resource
Route::resource('/app/area', 'AreaController');
Route::resource('/app/bill', 'BillController');
Route::resource('/app/customer', 'CustomerController');
Route::resource('/app/package', 'PackageController');
Route::resource('/app/invoice', 'InvoiceController');
Route::resource('/app/setting', 'SettingController');
Route::get('app/billgenerate', 'BillController@generate');
Route::get('app/customerbill/{id}', 'BillController@customerBill');

Route::get('/users', 'CustomerController@index')->name('users');
Route::post('/app/updateUser', 'UserController@updateUser');

Route::get('app/auth', 'UserController@auth');
Route::get('app/customerwitharea/{id}', 'CustomerController@customerwitharea');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
Route::get('/collector', 'HomeController@collector');
Route::get('/logout', function () {
	Auth::logout();
    Session::flush();
	Session::forget('url.intented');
	return redirect("/login");
    
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/dashboard/{slug}', [
    'uses' => 'HomeController@dashboard',
 ])->where('slug', '([A-z\d-\/_.]+)?')->middleware('auth');
