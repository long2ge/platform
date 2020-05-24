<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/31
 * Time: 10:09 PM
 */

/**
 * ==============
 *  密码登录
 * ==============
 */
$api->post('/login/password', ['uses' => 'Auth\LoginController@password']);