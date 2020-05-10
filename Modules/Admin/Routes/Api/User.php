<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/10
 * Time: 4:36 PM
 */

Route::get('/user/show/{id}', 'UserController@show')->name('admin.user.show');

Route::delete('/logout', 'UserController@logout')->name('admin.user.logout');