<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/31
 * Time: 10:04 PM
 */

/**
 * ==============
 *  用户信息
 * ==============
 */
$api->get('/info/show', ['uses' => 'Info\UserController@show']);

/**
 * 查看最近访客
 */
$api->get('/info/visit', ['uses' => 'Info\UserController@recentVisitUser']);
/**
 * 发送私信
 */
$api->post('/letter', ['uses' => 'Info\UserController@letter']);



/**
 * 关注。取消关注用户
 */
$api->post('/info/fans/{gz_id}', ['uses' => 'Info\UserController@fans']);
/**
 * 访问用户
 */
$api->get('/info/visit/{gz_id}', ['uses' => 'Info\UserController@visitUser']);

