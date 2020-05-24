<?php


namespace Modules\Admin\Http\Controllers\Api;

use App\Services\InvokeService;
use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\AdminAppController;
use Modules\Admin\Services\PostAdminService;
use Modules\Post\Models\Classify;
use Modules\Post\Models\PostComment;
use Modules\Post\Models\PostTowerComment;
use Modules\Post\Post;
use Modules\User\Models\User;

class PostController extends AdminAppController
{
    private $adminFacade;

    public function __construct()
    {
        $this->adminFacade = app(InvokeService::class)->getAdminFacade();
    }

    /**
     * 冻结用户
     * @api               {post} /api/admin/blocked/account 冻结用户
     * @apiSampleRequest         /api/admin/blocked/account
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostBlockedAccount
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} blocked_user_id    需要冻结的用户ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * ｛｝
     */
    public function blockedAccount(Request $request)
    {
        $user = $request->user();
        $blockedUserId = $request->input('blocked_user_id');

        $this->adminFacade->blockedAccount($blockedUserId,$user);

        return response()->json([],204);

    }

    /**
     * 后台删除帖子
     * @api               {delete} /api/admin/post/｛postId｝ 后台删除帖子
     * @apiSampleRequest          /api/admin/post/2
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostDeletePost
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $postId    需要删除的帖子ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * ｛｝
     */
    public function deletePost(int $postId)
    {
        Post::where('id',$postId)->delete();
        return response()->json([],204);
    }


    /**
     * 后台添加推荐帖子
     * @api               {put} post/recommend/{id} 后台添加推荐帖子
     * @apiSampleRequest          post/recommend/1
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostPutRecommendPost
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $postId    需要推荐的帖子ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * ｛｝
     */
    public function putRecommendPost(int $postId)
    {
        Post::where('id',$postId)->update(['recommend'=>'1']);
    }

    /**
     * 用户列表（关键字匹配）
     * @api               {get} /api/admin/index/user 用户列表（关键字匹配）
     * @apiSampleRequest          /api/admin/index/user
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexUser
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} keyword   关键字
     *
     * @apiSuccessExample  {json} 200 成功请求
     * [
     * {
     * "id": 1,
     * "account": "1",
     * "user_name": "1",
     * "phone_number": "1",
     * "email": "1",
     * "password": "1",
     * "occupation_id": 1,
     * "profile": "1",
     * "avatar": "1",
     * "address": "1",
     * "province_id": 1,
     * "city_id": 1,
     * "zone_id": 1,
     * "sex": true,
     * "status": false,
     * "class": 1,
     * "authority_class": 1,
     * "authority_start": "2020-02-05 15:02:12",
     * "authority_finish": null,
     * "created_at": null,
     * "updated_at": "2020-02-05 07:06:33",
     * "deleted_at": null
     * }
     * ]
     */
    public function indexUser(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = app(PostAdminService::class)->indexUser($keyword);

        return $users;

    }

    /**
     * 帖子列表
     * @api               {get} /api/admin/index/post 帖子列表
     * @apiSampleRequest          /api/admin/index/post
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexUser
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} keyword   关键字
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     * "current_page": 1,
     * "data": [
     * {
     * "id": 1,
     * "user_id": 1,
     * "title": "1",
     * "content": "1",
     * "view": 0,
     * "hot": 0,
     * "perfect": 0,
     * "top": 0,
     * "recommend": 1,
     * "shield": 0,
     * "is_vip": 0,
     * "is_video": 0,
     * "created_at": "2020-02-05 16:01:11",
     * "updated_at": "2020-02-05 08:05:05",
     * "deleted_at": null,
     * "publish_user": {
     * "id": 1,
     * "account": "1",
     * "user_name": "1"
     * }
     * }
     * ],
     * "first_page_url": "http://luntan.com/api/admin/index/post?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://luntan.com/api/admin/index/post?page=1",
     * "next_page_url": null,
     * "path": "http://luntan.com/api/admin/index/post",
     * "per_page": 10,
     * "prev_page_url": null,
     * "to": 1,
     * "total": 1
     * }
     */
    public function indexPost()
    {
        return app(PostAdminService::class)->indexPost();
    }

    /**
     * 用户详情
     * @api               {get} /api/admin/show/user 用户详情
     * @apiSampleRequest          /api/admin/show/user
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowUser
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $userId   用户ID
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     * "id": 1,
     * "account": "1",
     * "user_name": "1",
     * "phone_number": "1",
     * "email": "1",
     * "password": "1",
     * "occupation_id": 1,
     * "profile": "1",
     * "avatar": "1",
     * "address": "1",
     * "province_id": 1,
     * "city_id": 1,
     * "zone_id": 1,
     * "sex": true,
     * "status": false,
     * "class": 1,
     * "authority_class": 1,
     * "authority_start": "2020-02-05 15:02:12",
     * "authority_finish": null,
     * "created_at": null,
     * "updated_at": "2020-02-05 07:06:33",
     * "deleted_at": null
     * }
     */
    public function showUser(int $userId)
    {
        return User::where('id',$userId)->first();
    }

    /**
     * 用户详情
     * @api               {get} /api/admin/index/user 用户详情
     * @apiSampleRequest          /api/admin/index/user
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowUser
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} keyword   关键字
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     * "id": 1,
     * "user_id": 1,
     * "title": "1",
     * "content": "1",
     * "view": 0,
     * "hot": 0,
     * "perfect": 0,
     * "top": 0,
     * "recommend": 1,
     * "shield": 0,
     * "is_vip": 0,
     * "is_video": 0,
     * "created_at": "2020-02-05 16:01:11",
     * "updated_at": "2020-02-05 08:05:05",
     * "deleted_at": null,
     * "publish_user": {
     * "id": 1,
     * "account": "1",
     * "user_name": "1",
     * "phone_number": "1",
     * "email": "1",
     * "password": "1",
     * "occupation_id": 1,
     * "profile": "1",
     * "avatar": "1",
     * "address": "1",
     * "province_id": 1,
     * "city_id": 1,
     * "zone_id": 1,
     * "sex": true,
     * "status": false,
     * "class": 1,
     * "authority_class": 1,
     * "authority_start": "2020-02-05 15:02:12",
     * "authority_finish": null,
     * "created_at": null,
     * "updated_at": "2020-02-05 07:06:33",
     * "deleted_at": null
     * }
     * }
     * */
    public function showPost(int $postId)
    {
        return Post::where('id',$postId)->with('publishUser')->first();
    }

    /**
     * 删除评论
     * @api               {delete} /api/admin/comment/{id} 删除评论
     * @apiSampleRequest         /api/admin/comment/2
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostDeleteComment
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $commentId   评论ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {
     * }
     */
    public function deleteComment($commentId)
    {
        PostComment::where('id',$commentId)->delete();
        return response([],204);
    }

    /**
     * 删除楼内评论
     * @api               {delete} /api/admin/tower/comment/{id} 删除楼内评论
     * @apiSampleRequest         /api/admin/tower/comment/2
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostDeleteTowerComment
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $towerCommentId   楼内评论ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {
     * }
     */
    public function deleteTowerComment($towerCommentId)
    {
        PostTowerComment::where('id',$towerCommentId)->delete();
        return response([],204);
    }

    /**
     * 板块列表
     * @api               {get} /api/admin/index/classify 板块列表
     * @apiSampleRequest         /api/admin/index/classify
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexClassify
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} $towerCommentId   楼内评论ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {
     *    "data": [
     *              {
     *              "id": 1,
     *              "name": "征婚",
     *              "created_at": null,
     *              "updated_at": null,
     *              "deleted_at": null
     *              },
     *              {
     *              "id": 2,
     *              "name": "新闻",
     *              "created_at": null,
     *              "updated_at": null,
     *              "deleted_at": null
     *              },
     *              {
     *              "id": 3,
     *              "name": "驴友",
     *              "created_at": null,
     *              "updated_at": null,
     *              "deleted_at": null
     *              }
     *    ]
     * }
     */
    //后台版块列表
    public function indexClassify()
    {
        return ['data' => Classify::all()];
    }
    //设置热门
    /**
     * 热门
     */
    public function setHot($postId)
    {
        Post::where('id',$postId)->update(['hot'=>1]);
        return response([],204);
    }
    /**
     * 精华
     */
    public function setPerfect($postId)
    {
        Post::where('id',$postId)->update(['perfect'=>1]);
        return response([],204);
    }


    /**
     * 统计版块内的帖子数
     * @api               {get} /api/admin/statistics/classify/post/{id} 统计版块内的帖子数
     * @apiSampleRequest         /api/admin/statistics/classify/post/6
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostStatisticsPost
     *
     * @apiUse            AuthJSONHeader
     *
     * @param int $classifyId 版块ID，传0统计所有版块
     * @return array
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *  "data": [
     *          {
     *          "id": 1,
     *          "name": "征婚",  // 版块名字
     *          "post_count": 2,  // 版块帖子总数
     *          "user_count": 1,  // 关注帖子用户总数
     *          }
     *     ]
     * }
     */
    public function statisticsPost(int $classifyId)
    {
        return ['data'=>app(PostAdminService::class)->statisticsClassifyPost($classifyId)];
    }


}
