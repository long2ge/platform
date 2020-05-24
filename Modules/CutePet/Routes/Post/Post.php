<?php

// 测试路由    luntan.com/api/post/test  get

/**
 * 代码测试
 */
$api->get('/cs', [
    'middleware' => 'check.level',
    'uses' => 'PostController@cs',
]);

/**
 * 发布帖子
 */
$api->post('/', ['uses' => 'PostController@addPost']);

/**
 * 删除帖子
 */
$api->delete('/', ['uses' => 'PostController@deletePost']);

/**
 * 自发帖子列表
 */
$api->get('/own', ['uses' => 'PostController@showOwnPost']);

/**
 * 贴子列表
 */
$api->get('/index', ['uses' => 'PostController@index']);

/**
 *回复列表
 */
$api->get('/reply', ['uses' => 'PostController@indexReply']);


/**
 * 关注帖子列表
 */
$api->get('/enshrine', ['uses' => 'PostController@indexEnshrine']);

/**
 * 推荐帖子
 */
$api->get('/recommend', ['uses' => 'PostController@indexRecommend']);

/**
 * 热门帖子
 */
$api->get('/hot', ['uses' => 'PostController@indexHot']);

/**
 * 精华帖子
 */
$api->get('/perfect', ['uses' => 'PostController@indexPerfect']);

/**
 * 视频帖子列表
 */
$api->get('/video', ['uses' => 'PostController@indexVideo']);
/**
 * 分配帖子到板块
 */
$api->post('/classify', ['uses' => 'PostController@addPostClassify']);
/**
 * 板块列表
 */
$api->get('/classify/all', ['uses' => 'PostController@ClassifyAll']);
$api->get('/classify', ['uses' => 'PostController@ClassifyAll']);
// /classify
/**
 * 板块统计
 */
$api->get('/classify/statistics', ['uses' => 'PostController@classifyStatistics']);



//带参路由
/**
 *近期浏览的帖子
 */
$api->get('/recent/post', ['uses' => 'PostController@recentPost']);

/**
 * 用户关注板块
 */
$api->post('/user/classify/{classify_id}', ['uses' => 'PostController@userAddClassify']);
/**
 * 帖子评论列表
 */
$api->get('/comments', ['uses' => 'PostController@indexComment']);
/**
 * 帖子详情
 */
$api->get('/{id}', ['uses' => 'PostController@showPostId']);

