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

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Users
Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// Dashboard
Route::get('/', function () {
    return redirect()->route('dashboards.index');
})->middleware('auth');
Route::resource('dashboards', 'DashboardController')->middleware('auth');

// Platforms
Route::get('/platforms/export', 'PlatformController@export')->name('platforms.export')->middleware('auth');
Route::resource('platforms', 'PlatformController')->middleware('auth');

// Domains
Route::get('/domains/export', 'DomainController@export')->name('domains.export')->middleware('auth');
Route::resource('domains', 'DomainController')->middleware('auth');

// Pings
Route::resource('pings', 'PingController')->middleware('auth')->only(['create', 'store']);

// Nslookup
Route::resource('nslookups', 'NslookupController')->middleware('auth')->only(['create', 'store']);

// Whois
Route::resource('whois', 'WhoisController')->middleware('auth')->only(['create', 'store']);

// Trace
Route::resource('traces', 'TraceController')->middleware('auth')->only(['create', 'store']);

// Netcat
Route::resource('netcats', 'NetcatController')->middleware('auth')->only(['create', 'store']);

// 500 error
Route::get('500', function () {
    // Force debug mode for this endpoint in the demo environment
    if (App::environment('demo')) {
        Config::set('app.debug', true);
    }

    echo $fail;
});
