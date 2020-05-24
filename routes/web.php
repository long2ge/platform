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
    return view('welcome');
});

//// 登录
//Route::get('/set', function () {
//
//    $user = [
//        'name' => '用户',
//        'age' => 18,
//        'sex' => '男',
//    ];
//    session()->put('aaa', 'bbb');
//
//    return view('welcome');
//});
//
//
//// 获取用户信息
//Route::get('/get', function () {
//
//
//    return session()->get('aaa');
//});
//// 删除登录信息
//Route::get('/del', function () {
//     session()->forget('aaa');
//});