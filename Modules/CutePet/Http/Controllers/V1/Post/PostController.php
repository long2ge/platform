<?php


namespace Modules\CutePet\Http\Controllers\V1\Post;

use Illuminate\Http\Request;
use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\CutePet\Services\PostService;

class PostController extends CutePetController
{
    /**
     * 发布帖子
     *
     * @api               {POST} /api/post 发布帖子
     * @apiSampleRequest         /api/post
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by sen
     *
     * @apiGroup          Post
     * @apiName           PostAddPost
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {string} title    标题
     * @apiParam {string} content  内容
     * @apiParam {int}   is_video  是否有视频
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {}
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addPost(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|string',
            'content'=>'required|string',
            'is_video'=>'required|int',
        ]);

        $data = $request->only(['title','content','is_video']);

        $data['user_id'] = $request->user()->id;

        app(PostService::class)->addPost($data);

        return response()->json([], 204);
    }

    /**
     * 删除帖子
     *
     * @api               {delete} /api/post 删除帖子
     * @apiSampleRequest         /api/post
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostDeletePost
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {int} post_id    帖子ID
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {}
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deletePost(Request $request)
    {
        $userId = $request->user()->id;
        $postId = $request->input('post_id');

        app(PostService::class)->deletePost($userId,$postId);

        return response()->json([], 204);
    }

    /**
     * 自发帖子列表
     *
     * @api               {get} /api/post/own 自发帖子列表
     * @apiSampleRequest         /api/post/own
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowOwnPost
     *
     * @apiUse            AuthJSONHeader
     * @apiSuccessExample  {json} 200 成功请求
     *   {
     *   "current_page": 1,
     *   "data": [
     *       {
     *      "id": 13,       //帖子ID
     *      "user_id": 1,   //发帖用户ID
     *      "title": "标题1", //标题
     *      "content": "内容2",//内容
     *      "view": 0,      //浏览量
     *      "hot": 0,       //是否热贴 0不是；1是
     *      "perfect": 0,   //是否精品贴 0不是；1是
     *      "top": 0,       //是否设顶  0不是；1是
     *      "shield": 0,    //是否屏蔽信息 0不屏蔽 1屏蔽
     *      "is_video": 0,  //是否有视频 0没 1有
     *      "created_at": "2020-01-24 18:56:51",
     *      "updated_at": "2020-01-24 18:56:51",
     *      "deleted_at": null
     *      },
     *      ],
     *      "first_page_url": "http://luntan.com/api/post/own?page=1",
     *      "from": 1,
     *      "last_page": 1,
     *      "last_page_url": "http://luntan.com/api/post/own?page=1",
     *      "next_page_url": null,
     *      "path": "http://luntan.com/api/post/own",
     *      "per_page": 10,
     *      "prev_page_url": null,
     *      "to": 4,
     *      "total": 4
     *      }
     * }
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexOwn(Request $request)
    {

        $userId = $visitor = $request->user()->id;

        $posts = app(PostService::class)->showUserId($userId,$visitor);

        return response()->json($posts);
    }

    /**
     * 帖子列表
     *
     * @api               {get} /api/index 帖子列表
     * @apiSampleRequest         /api/index
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowPost
     *
     * @apiUse            AuthJSONHeader
     * @param Request $request
     *
     * @apiSuccessExample  {json} 200 成功请求
     *   {
     *  "current_page": 1,
     *  "data": [
     *  {
     *  "id": 13,           //帖子ID
     *  "user_id": 1,       //发帖用户ID
     *  "title": "标题1",     //标题
     *  "content": "内容2",   //内容
     *  "view": 0,          //浏览量
     *  "hot": 0,            //是否热贴 0不是；1是
     *  "perfect": 0,        //是否精品贴 0不是；1是
     *  "top": 0,           //是否设顶  0不是；1是
     *  "shield": 0,     //是否屏蔽信息 0不屏蔽 1屏蔽
     *  "is_video": 0,    //是否有视频 0没 1有
     *  "created_at": "2020-01-24 18:56:51",
     *  "updated_at": "2020-01-24 18:56:51",
     *  "deleted_at": null,
     *  "post_praise_count": 0,
     *  "visitorPraise": 0,
     *  "visitorEnshrine": 0,
     *  "publish_user" *    : {
     *      "id": 1,
     *      "user_name": "123456"
     *      }
     *  },
     *  "first_page_url": "http://luntan.com/api/post/index?page=1",
     *  "from": 1,
     *  "last_page": * 2,
     *  "last_page_url": "http://luntan.com/api/post/index?page=2",
     *  "next_page_url": "http://luntan.com/api/post/index?page=2",
     *  "path": "http://luntan.com/api/post/index",
     *  "per_page": 3,
     *  "prev_page_url": null,
     *  "to": 3,
     *  "total": 5 *
     *  }
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
//        $this->validate($request, [
//            'select' => 'nullable|string',
//            'rank' => 'nullable|string',
//            'paginate' => 'nullable|int',
//        ]);
        $userId = $request->user()->id;

        $select = 'created_at';
        $rank = 'desc';
        $paginate = $request->input('paginate') ?? 10;
        $posts = app(PostService::class)->index($select,$rank,$userId,$paginate);

        return response()->json($posts);
    }

    /**
     * 回复列表
     *
     * @api               {get} /api/reply 回复列表
     * @apiSampleRequest         /api/reply
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowPost
     *
     * @apiUse            AuthJSONHeader
     * @param Request $request
     *
     * @apiSuccessExample  {json} 200 成功请求
     *{
     *  "current_page": 1,
     *  "data": [
     *  {
     *  "id": 1,  //回复评论ID
     *  "user_id": 1, //用户ID
     *  "post_id": 1, // 帖子ID
     *  "post_user_id": 1, //发帖用户ID
     *  "tower": 1, //  楼层
     *  "content": "1", // 评论内容
     *  "shield": 0, // 是否屏蔽
     *  "created_at": null,
     *  "updated_at": null,
     *  "deleted_at": null
     *  }
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/reply?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/reply?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/reply",
     *  "per_page": 10,
     *  "prev_page_url": null,
     *  "to": 1,
     *  "total": 1
     *  }
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexReply(Request $request)
    {
        $userId = $request->user()->id;

        return response()->json(
            app(PostService::class)->indexReply($userId)
        );
    }

    /**
     * 帖子详情
     *
     * @api               {get} /api/post/{postId} 帖子详情
     * @apiSampleRequest         /api/post/1
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostShowPost
     *
     * @apiUse            AuthJSONHeader
     *
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     * "id": 1,  //回复评论ID
     * "user_id": 1,    //用户ID
     * "title": "标题",    //标题
     * "content": "内容",   //内容
     * "view": 0,   //浏览量
     * "hot": 0,   //是否热贴
     * "perfect": 0,   //是否加精
     * "top": 0,   //是否设顶
     * "shield": 0,   //是否屏蔽
     * "is_video": 1,   //是否有视频
     * "created_at": "2020-01-22 16:30:22",
     * "updated_at": "2020-01-22 16:30:22",
     * "deleted_at": null,
     * "post_praise_count": 0,//帖子被点赞的长度
     * "visitorPraise": 0,    //浏览用户是否已经点赞帖子
     * "visitorEnshrine": 0, //浏览用户是否已经收藏帖子
     * "publish_user": {    //帖子发帖人信息
     *     "id": 1,         //用户ID
     *     "user_name": "123456"   //用户名字
     *     }
     * }
     * @param Request $request
     * @param $postId
     * @return \Illuminate\Http\JsonResponse
     */
    public function showPostId(Request $request,$postId)
    {
        $userId = $request->user()->id??null;

        return response()->json(
            app(PostService::class)->showPostId($postId,$userId)
        );
    }

    /**
     * 收藏列表
     *
     * @api               {get} /api/post/recommend 收藏列表
     * @apiSampleRequest         /api/post/recommend
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexEnshrine
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *"current_page": 1,
     *  "data": [
     *   {
     *  "post_id": 1,    //帖子ID
     *  "user_id": 1,   //发帖用户ID
     *  "title": "标题",     //标题
     *  "content": "内容",   //内容
     *  "view": 0,     //浏览量
     *  "hot": 0,   //是否加热
     *  "perfect": 0,   //是否加精
     *  "top": 0,   //是否设顶
     *  "shield": 0,   //是否屏蔽
     *  "is_video": 1,   //是否有视频
     *  "created_at": "2020-01-22 16:30:22"
     *  }，
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/enshrine",
     *  "per_page": 5,
     *  "prev_page_url": null,
     *  "to": 2,
     *  "total": 2
     *  }
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexEnshrine(Request $request)
    {
        $userId = $request->user()->id;

        $posts = app(PostService::class)->indexEnshrine($userId);

        return response()->json($posts);
    }

    /**
     * 推荐列表
     *
     * @api               {get} /api/post/recommend 推荐列表
     * @apiSampleRequest         /api/post/recommend
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexRecommend
     *
     * @apiUse            AuthJSONHeader
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *"current_page": 1,
     *  "data": [
     *   {
     *  "post_id": 1,   //帖子ID
     *  "user_id": 1,    //用户ID
     *  "title": "标题",   //标题
     *  "content": "内容",   //内容
     *  "view": 0,     //
     *  "hot": 0,
     *  "perfect": 0,
     *  "recommend": 1,
     *  "top": 0,
     *  "shield": 0,
     *  "is_video": 1,
     *  "created_at": "2020-01-22 16:30:22"
     *  },
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/enshrine",
     *  "per_page": 5,
     *  "prev_page_url": null,
     *  "to": 2,
     *  "total": 2
     *  }
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexRecommend()
    {
        return response()->json(
            Post::where('recommend',1)
                ->orderBy('created_at', 'desc')
                ->paginate(5)
        );
    }

    /**
     * 热门帖子列表
     *
     * @api               {get} /api/post/hot 热门帖子列表
     * @apiSampleRequest         /api/post/hot
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexHot
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *"current_page": 1,
     *  "data": [
     *   {
     *  "post_id": 1,   //帖子ID
     *  "user_id": 1,   //帖子用户ID
     *  "title": "标题",   //标题
     *  "content": "内容",   //内容
     *  "view": 0,   //浏览量
     *  "hot": 0,   //是否加热
     *  "perfect": 0,   //是否加精
     *  "recommend": 1,   //是否推荐
     *  "top": 0,   //是否设顶
     *  "shield": 0,   //是否屏蔽
     *  "is_video": 1,   //是否有视频
     *  "created_at": "2020-01-22 16:30:22"
     *  },
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/enshrine",
     *  "per_page": 5,
     *  "prev_page_url": null,
     *  "to": 2,
     *  "total": 2
     *  }
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexHot()
    {
        return response()->json(
            Post::where('hot',1)
                ->orderBy('created_at', 'desc')
                ->paginate(5)
        );
    }

    /**
     * 精华帖子列表
     *
     * @api               {get} /api/post/perfect 精华帖子列表
     * @apiSampleRequest         /api/post/perfect
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexPerfect
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *"current_page": 1,
     *  "data": [
     *   {
     *  "post_id": 1,  //帖子ID
     *  "user_id": 1,  //发帖用户ID
     *  "title": "标题",  //标题
     *  "content": "内容",  //内容
     *  "view": 0,   //浏览量
     *  "hot": 0,  //是否加热
     *  "perfect": 0,   //是否加精
     *  "recommend": 1,  //是否推荐
     *  "top": 0,  //是否设顶
     *  "shield": 0,  //是否屏蔽
     *  "is_video": 1,  //是否有视频
     *  "created_at": "2020-01-22 16:30:22"
     *  },
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/enshrine",
     *  "per_page": 5,
     *  "prev_page_url": null,
     *  "to": 2,
     *  "total": 2
     *  }
     */
    public function indexPerfect()
    {
        return  response()->json(Post::where('perfect',1)
            ->orderBy('created_at', 'desc')
            ->paginate(5));
    }

    /**
     * 视频帖子列表
     *
     * @api               {get} /api/post/video 视频帖子列表
     * @apiSampleRequest         /api/post/video
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexVideo
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *"current_page": 1,
     *  "data": [
     *   {
     *  "post_id": 1,
     *  "user_id": 1,
     *  "title": "标题",
     *  "content": "内容",
     *  "view": 0,
     *  "hot": 0,
     *  "perfect": 0,
     *  "recommend": 1,
     *  "top": 0,
     *  "shield": 0,
     *  "is_video": 1,
     *  "created_at": "2020-01-22 16:30:22"
     *  },
     *  ],
     *  "first_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "from": 1,
     *  "last_page": 1,
     *  "last_page_url": "http://luntan.com/api/post/enshrine?page=1",
     *  "next_page_url": null,
     *  "path": "http://luntan.com/api/post/enshrine",
     *  "per_page": 5,
     *  "prev_page_url": null,
     *  "to": 2,
     *  "total": 2
     *  }
     */
    public function indexVideo()
    {
        return  response()->json(Post::where('is_video',1)
            ->orderBy('created_at', 'desc')
            ->paginate(5));
    }

    /**
     * 帖子评论列表
     *
     * @api               {get} /api/post/comments 帖子评论列表
     * @apiSampleRequest         /api/post/comments
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostIndexComment
     *
     * @apiUse            AuthJSONHeader
     * @apiParam {string} type    类型
     * @apiParam {string} post_id  帖子ID
     *
     * @apiSuccessExample  {json} 200 成功请求
     *{
     *"current_page": 1,
     *"data": [
     *    {
     *    "id": 1,  //评论ID
     *    "user_id": 1,    //发表评论用户ID
     *    "post_id": 1,    //帖子ID
     *    "post_user_id": 1,    //发帖用户ID
     *    "tower": 1,        //楼层
     *    "content": "1",    //内容
     *    "shield": 0,  //是否屏蔽
     *    "created_at": "2020-01-26 22:30:29",
     *    "updated_at": null,
     *    "deleted_at": null,
     *    "comment_praise_count": 2,    //评论点赞数
     *    "visitPraise": 1,         //浏览用户者是否已点赞评论
     *    "user": {    //发布评论用户信息
     *        "id": 1,
     *        "user_name": "123456",
     *        "sex": true
     *        }
     *    },
     * ],
     * "first_page_url": "http://luntan.com/api/post/comments?page=1",
     * "from": 1,
     * "last_page": 1,
     * "last_page_url": "http://luntan.com/api/post/comments?page=1",
     * "next_page_url": null,
     * "path": "http://luntan.com/api/post/comments",
     * "per_page": 5,
     * "prev_page_url": null,
     * "to": 2,
     * "total": 2
     * }
     **/

    public function indexComment(Request $request)
    {
        $this->validate($request, [
            'type' => 'in:created_at_asc,created_at_desc,praise_desc',
            'post_id'=>'int|required'
        ]);

        $type = $request->input('type');
        $postId = $request->input('post_id');
        $userId = $request->user()->id??null;

        $comments = app(PostService::class)->indexComment($postId,$userId,$type);

        return response()->json($comments);
    }

    /**
     * 分配帖子到板块
     *
     * @api               {post} /api/post/classify 分配帖子到板块
     * @apiSampleRequest         /api/post/classify
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostAddPostClassify
     *
     * @apiUse            AuthJSONHeader
     * @apiParam {int} post_id    帖子ID
     * @apiParam {int} classify_id  版块ID
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     *
     * @apiSuccessExample  {json} 204 成功请求
     * {}
     *
     */
    public function addPostClassify(Request $request)
    {
        $userId = $request->user()->id;
        $postId = $request->input('post_id');
        $classifyId = $request->input('classify_id');
        app(PostService::class)->addPostClassify($userId,$postId,$classifyId);
        return response()->json([],204);
    }
    /**
     * 板块列表
     *
     * @api               {get} /api/post/classify/all 板块列表
     * @apiSampleRequest         /api/post/classify/all
     * @apiVersion 1.0.0
     * @apiDescription
     * developed 660099
     *
     * @apiGroup          Post
     * @apiName           PostClassifyAll
     *
     * @apiUse            AuthJSONHeader
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     *
     * @apiSuccessExample  {json} 200 成功请求
     * [
     * {
     *   "id": 1,       //版块ID
     *   "name": "征婚"  //板块名字
     * },
     * {
     *   "id": 2,
     *   "name": "新闻"
     * },
     * {
     *   "id": 3,
     *   "name": "驴友"
     * }
     * ]
     *
     */
    public function ClassifyAll()
    {
        return response()->json(Classify::query()->select('id','name')->get());
    }

    /**用户关注板块
     * @param Request $request
     * @param $classifyId
     * @return mixed
     */
    public function userAddClassify(Request $request,$classifyId)
    {
        $userId = $request->user()->id;

        return app(PostService::class)->userAddClassify($userId,$classifyId);
    }

    /**
     * 用户最近浏览的帖子
     *
     * @api               {get} /api/post/recent/post 用户最近浏览的帖子
     * @apiSampleRequest         /api/post/recent/post
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          Post
     * @apiName           PostRecentPost
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * [
     *   {
     *   "user_id": 1,
     *   "post_id": 2,
     *   "created_at": null,
     *   "updated_at": null,
     *   "deleted_at": null,
     *   "post": {
     *   "id": 2,
     *   "user_id": 1,
     *   "title": "11",
     *   "content": "11",
     *   "view": 1,
     *   "hot": 1,
     *   "perfect": 1,
     *   "top": 0,
     *   "recommend": 0,
     *   "shield": 0,
     *   "is_vip": 0,
     *   "is_video": 0,
     *   "created_at": null,
     *   "updated_at": null,
     *   "deleted_at": null
     *   }
     *   }
     * ]
     */
    public function recentPost(Request $request)
    {
        $userId = $request->user()->id;
        return app(PostService::class)->recentPost($userId);
    }

    /**
     *板块统计
     */
    public function classifyStatistics()
    {
        $data = app(PostService::class)->classifyStatistics();
        return $data;
    }

    /**
     *
     */




}
