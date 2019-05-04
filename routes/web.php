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
Route::get('/users', 'CustomerController@index')->name('users');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');
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
