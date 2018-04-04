<?php

use Illuminate\Routing\Router;

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


//本地登录跳转
Route::get('/index', 'IndexController@index')->name('login'); //本地首页
Route::get('/logout', 'IndexController@logout')->middleware('auth:web')->name('logout');//本地退出登录

//SSO登录系统
Route::get('/sso/oauth', 'Login\OAuthServerController@oauthLoginPage')->name('sso.login');
Route::post('/sso/oauth/login', 'Login\OAuthServerController@oauthLogin')->name('sso.send_login');
Route::get('/sso/logout', 'Login\OAuthServerController@oauthLogout')->name('sso.logout');

////默认跳转
Route::get('/', 'IndexController@feIndex')->middleware('auth:web');
