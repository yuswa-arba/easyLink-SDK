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

use Illuminate\Support\Facades\Route;

// ROUTE UNTUK SETTING
Route::get('/setting', 'FingerSpot\SettingController@setting');

Route::get('/proses_setting', 'FingerSpot\SettingController@prosesSetting');


// ROUTE UNTUK USER
Route::get('/user', 'FingerSpot\UserController@user');

Route::get('/user_proses', 'FingerSpot\UserController@userProses');


// ROUTE UNTUK SCAN LOG
Route::get('/scanlog', 'FingerSpot\ScanLogController@scanLog');

Route::get('/proses_scan', 'FingerSpot\ScanLogController@prosesScan');


// ROUTE UNTUK INFO
Route::get('/info', 'FingerSpot\InfoController@info');

Route::get('/proses_info', 'FingerSpot\InfoController@prosesInfo');
