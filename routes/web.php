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
Route::match(['put', 'patch'], '/users/restore/{user}', 'UserController@restore')->name('users.restore')->middleware('auth');
Route::resource('users', 'UserController')->middleware('auth');

// Roles
Route::match(['put', 'patch'], '/roles/restore/{role}', 'RoleController@restore')->name('roles.restore')->middleware('auth');
Route::resource('roles', 'RoleController')->middleware('auth');

// Logs
Route::resource('logs', 'LogController')->only(['index'])->middleware('auth');

// Images
Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*')->name('images.show');

// Locale
Route::get('locales/{locale}', 'LocaleController@index')->name('locales.index')->middleware('auth');

// Dashboard
Route::get('/', function () {
    return redirect()->route('dashboards.index');
})->middleware('auth');
Route::resource('dashboards', 'DashboardController')->only(['index'])->middleware('auth');

// Platforms
Route::get('/platforms/export', 'PlatformController@export')->name('platforms.export')->middleware('auth');
Route::match(['put', 'patch'], '/platforms/restore/{platform}', 'PlatformController@restore')->name('platforms.restore')->middleware('auth');
Route::resource('platforms', 'PlatformController')->middleware('auth');

// Domains
Route::get('/domains/export', 'DomainController@export')->name('domains.export')->middleware('auth');
Route::delete('/domains/massDestroy', 'DomainController@massDestroy')->name('domains.massDestroy')->middleware('auth'); 
Route::match(['put', 'patch'], '/domains/restore/{domain}', 'DomainController@restore')->name('domains.restore')->middleware('auth');
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
