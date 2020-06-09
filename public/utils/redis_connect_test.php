<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/6/9
 * Time: 3:46 PM
 */

//检测是否连接成功

try {
    $redis = new Redis();
//连接
    $redis->connect('redis-php', 6379);
    var_dump('redis-php ping : ' . $redis->ping());
} catch (\Exception $e) {
    var_dump($e);
}



