<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//前台用户登录
$router->post('/user/password', 'V1\Auth\LoginController@password');
//前台用户注册
$router->post('/user/login', 'V1\Auth\LoginController@register');
/**
 *
 * 帖子组
 */

/**
 * 发布帖子
 */
$router->middleware('auth:cute_pet_api')->post('/post/add', 'V1\Post\PostController@addPost');

/**
 * 删除帖子
 */
$router->middleware('auth:cute_pet_api')->delete('/post', ['uses' => 'V1\Post\PostController@deletePost']);

/**
 * 自发帖子列表
 */
$router->middleware('auth:cute_pet_api')->get('/post/own', ['uses' => 'V1\Post\PostController@indexOwn']);

/**
 * 贴子列表
 */
$router->middleware('auth:cute_pet_api')->get('/post/index', ['uses' => 'V1\Post\PostController@index']);

/****************************************************评论**************************************************/


 /**
 * 发布主帖评论
 */
$router->middleware('auth:cute_pet_api')->post('/post/comment', ['uses' => 'V1\Post\PostCommentController@store']);

/**
 * 回复评论
 */
$router->middleware('auth:cute_pet_api')->post('/post/comment/reply   ', ['uses' => 'V1\Post\PostCommentController@commentReply']);

/**
 * 修改评论
 */
$router->middleware('auth:cute_pet_api')->put('/post/comment', ['uses' => 'V1\Post\PostCommentController@upPostComment']);

/**
 * 删除评论
 */
$router->middleware('auth:cute_pet_api')->delete('/post/comment', ['uses' => 'V1\Post\PostCommentController@deleteComment']);

/**
 * 评论详情
 */
$router->middleware('auth:cute_pet_api')->get('/post/comment', ['uses' => 'V1\Post\PostCommentController@show']);


/****************************************************板块**************************************************/

/**
 * 板块列表（待移后台操作）
 */
$router->get('/classify', ['uses' => 'V1\Post\ClassifyController@indexClassify']);


/**
 * 增加板块(后台操作)（待做，增删改,分配）
 */
$router->middleware('auth:cute_pet_api')->post('/classify', ['uses' => 'V1\Post\ClassifyController@indexClassify']);

/****************************************************点赞**************************************************/

/**
 * 帖子点赞
 */
$router->middleware('auth:cute_pet_api')->post('/post/praise/{post_id}', ['uses' => 'V1\Post\PostController@praise']);

/**
 * （帖子内的）评论点赞
 */
$router->middleware('auth:cute_pet_api')->post('/post/comment/praise/{post_id}', ['uses' => 'V1\Post\PostCommentController@praise']);




$router->middleware('auth:cute_pet_api')
    ->post('/aaa/test', function (Request $request) {
    return $request->user();
});

//Route::post('user/passwordd','Modules\CutePet\Http\Controllers\V1\Auth@password');
//Route::middleware('auth:api')->get('/cutepet', function (Request $request) {
//    return $request->user();
//});