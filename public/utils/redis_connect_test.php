<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/6/9
 * Time: 3:46 PM
 */


require '../../bootstrap/app.php';

$redis = new Redis();
//连接
$redis->connect('redis-php:6379', 6379);
dvar_dumpd('redis-php:6379 ping : ' . $redis->ping());
//$redis->auth("gdjztw-86yqy"); //密码验证
/*
$redis->set("Redis_hrsas_wx_access_token",null); die();
$ticket = $redis->get("Redis_hrsas_wx_access_token");
var_dump($ticket);die();
*/


//检测是否连接成功

$redis = new Redis();
//连接
$redis->connect('redis-php', 6379);
dvar_dumpd('redis-php ping : ' . $redis->ping());


