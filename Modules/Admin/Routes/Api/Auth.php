<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/10
 * Time: 3:46 PM
 */

Route::post('/login', 'AuthController@login')->name('admin.login');

Route::delete('/logout', 'AuthController@logout')->name('admin.logout');