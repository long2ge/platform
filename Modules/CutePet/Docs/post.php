<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/30
 * Time: 20:50
 */

/**
 * @OA\Post(
 *     path="/api/post/add",
 *     tags={"帖子组"},
 *     summary="发布帖子",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"title", "content","is_video","classify_id"},
 *              @OA\Property(property="title", type="string", description="帖子标题"),
 *              @OA\Property(property="content", type="string", description="帖子内容"),
 *              @OA\Property(property="is_video", type="integer", description="帖子是否有视频 0没有 1有"),
 *              @OA\Property(property="classify_id", type="integer", description="板块ID"),
 *              example={"title": "标题","content": "内容","is_video":"0","classify_id":"1"}
 *     )),
 *          @OA\Response(
 *              response=204,
 *              description="SUCCESS/成功",
 *        )
 *     )
 * )
 */


/**
 * @OA\Delete(
 *     path="/api/post",
 *     tags={"帖子组"},
 *     summary="删除帖子",
 *     description="删除用户名下帖子",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"post_id"},
 *              @OA\Property(property="post_id", type="integer", description="用户名下帖子ID"),
 *              example={"post_id": 12}
 *     )),
 *          @OA\Response(
 *              response=204,
 *              description="SUCCESS/成功",
 *        ),
 *          @OA\Response(
 *              response=400,
 *              description="FALSE/失败",
 *        )
 *     )
 * )
 */



/**
 * @OA\Get(
 *     path="/api/post/own",
 *     tags={"帖子组"},
 *     summary="用户自发帖子列表",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                 @OA\Items(
 *                      @OA\Property(property="id", type="integer", description="帖子id"),
 *                      @OA\Property(property="post", type="object", description="帖子数据",
 *                                  @OA\Property(property="user_id", type="integer", description="用户id"),
 *                                  @OA\Property(property="title", type="string", description="标题"),
 *                                  @OA\Property(property="content", type="string", description="内容"),
 *                                  @OA\Property(property="view", type="integer", description="浏览量"),
 *                                  @OA\Property(property="post_praise_count", type="integer", description="点赞数"),
 *                                  @OA\Property(property="visitor_user_id", type="integer", description="浏览者ID 没登录者为0"),
 *                                  @OA\Property(property="visitor_is_enshrine", type="integer", description="浏览者是否已收藏0/1"),
 *                                  @OA\Property(property="visitor_is_praise", type="integer", description="浏览者是否已点赞0/1"),
 *                                  @OA\Property(property="is_hot", type="integer", description="是否热帖 0否 1是"),
 *                                  @OA\Property(property="is_perfect", type="integer", description="是否加精 0否 1是"),
 *                                  @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                                  @OA\Property(property="is_recommend", type="integer", description="是否推荐 0否 1是"),
 *                                  @OA\Property(property="is_shield", type="integer", description="是否屏蔽 0否 1是"),
 *                                  @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                                  @OA\Property(property="created_at", type="date", description="创建时间",),
 *                                  @OA\Property(property="publish_user", type="object", description="发帖者数据",
 *                                              @OA\Property(property="id", type="integer", description="发帖者id"),
 *                                              @OA\Property(property="user_name", type="string", description="发帖者名字"),
 *
 *                                 ),
 *                                 @OA\Property(property="post_classify", type="array", description="帖子所属板块",
 *                                        @OA\Items(
 *                                              @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                                              @OA\Property(property="classify_name", type="string", description="板块名字"),
 *                                        ),
 *
 *                                 ),
 *
 *                      ),
 *                 ),
 *              ),
 *              @OA\Property(property="first_page_url",type="string",description=""),
 *              @OA\Property(property="from",type="integer",description=""),
 *              @OA\Property(property="last_page",type="integer",description=""),
 *              @OA\Property(property="last_page_url",type="string",description=""),
 *              @OA\Property(property="next_page_url",type="string",description=""),
 *              @OA\Property(property="path",type="string",description=""),
 *              @OA\Property(property="per_page",type="integer",description=""),
 *              @OA\Property(property="prev_page_url",type="integer",description=""),
 *              @OA\Property(property="to",type="integer",description=""),
 *              @OA\Property(property="total",type="integer",description=""),
 *             ),
 *       example={    "current_page": 1,    "data": {        {            "id": 18,            "post": {                "id": 18,                "user_id": 10000009,                "title": "帖子内容存在违规行为已屏蔽内容",                "content": "帖子内容存在违规行为已屏蔽内容",                "view": 0,                "created_at": null,                "updated_at": null,                "deleted_at": null,                "post_praise_count": 0,                "visitor_user_id": 10000009,                "visitor_is_enshrine": 0,                "visitor_is_praise": 1,                "is_perfect": 0,                "is_hot": 0,                "is_recommend": 0,                "is_shield": 1,                "is_video": 0,                "post_classify": {                    {                        "classify_id": 1,                        "post_id": 18,                        "name": "1号板块"                    },                    {                        "classify_id": 2,                        "post_id": 18,                        "name": "2号版块"                    }                },                "publish_user": {                    "id": 10000009,                    "user_name": "用户1012623458"                }            }        }    },    "first_page_url": "http://platform.com/api/post/own?page=1",    "from": 1,    "last_page": 1,    "last_page_url": "http://platform.com/api/post/own?page=1",    "next_page_url": null,    "path": "http://platform.com/api/post/own",    "per_page": 10,    "prev_page_url": null,    "to": 2,    "total": 2}
 *
 *              ),
 *     )
 * )
 */


/**
 * @OA\Post(
 *     path="/api/post/praise/{post_id}",
 *     @OA\Parameter(
 *       name="post_id",
 *       in="path",
 *       required=true,
 *       description="10",
 *       @OA\Schema(type="integer")
 *     ),
 *     tags={"帖子组"},
 *     summary="帖子点赞",
 *     description="点赞取消点赞",
 *     security={
 *      {"api_token": {}}
 *    },
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *
 * )
 */

/**
 * @OA\Post(
 *     path="/api/post/enshrine/{post_id}",
 *     @OA\Parameter(
 *       name="post_id",
 *       in="path",
 *       required=true,
 *       description="10",
 *       @OA\Schema(type="integer")
 *     ),
 *     tags={"帖子组"},
 *     summary="帖子收藏",
 *     description="收藏取消收藏",
 *     security={
 *      {"api_token": {}}
 *    },
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="FALSE/失败",
 *     ),
 *
 * )
 */

/**
 * @OA\Get(
 *     path="/api/post/enshrine",
 *     tags={"帖子组"},
 *     summary="帖子收藏列表",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                 @OA\Items(
 *                      @OA\Property(property="user_id", type="integer", description="用户id"),
 *                      @OA\Property(property="post_id", type="integer", description="帖子id"),
 *                      @OA\Property(property="created_at", type="string", description="收藏时间"),
 *                      @OA\Property(property="post", type="object", description="帖子数据",
 *                                  @OA\Property(property="user_id", type="integer", description="用户id"),
 *                                  @OA\Property(property="title", type="string", description="标题"),
 *                                  @OA\Property(property="content", type="string", description="内容"),
 *                                  @OA\Property(property="view", type="integer", description="浏览量"),
 *                                  @OA\Property(property="post_praise_count", type="integer", description="点赞数"),
 *                                  @OA\Property(property="visitor_user_id", type="integer", description="浏览者ID 没登录者为0"),
 *                                  @OA\Property(property="visitor_is_enshrine", type="integer", description="浏览者是否已收藏0/1"),
 *                                  @OA\Property(property="visitor_is_praise", type="integer", description="浏览者是否已点赞0/1"),
 *                                  @OA\Property(property="is_hot", type="integer", description="是否热帖 0否 1是"),
 *                                  @OA\Property(property="is_perfect", type="integer", description="是否加精 0否 1是"),
 *                                  @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                                  @OA\Property(property="is_recommend", type="integer", description="是否推荐 0否 1是"),
 *                                  @OA\Property(property="is_shield", type="integer", description="是否屏蔽 0否 1是"),
 *                                  @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                                  @OA\Property(property="created_at", type="date", description="创建时间",),
 *                                  @OA\Property(property="publish_user", type="object", description="发帖者数据",
 *                                              @OA\Property(property="id", type="integer", description="发帖者id"),
 *                                              @OA\Property(property="user_name", type="string", description="发帖者名字"),
 *
 *                                 ),
 *                                 @OA\Property(property="post_classify", type="array", description="帖子所属板块",
 *                                        @OA\Items(
 *                                              @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                                              @OA\Property(property="classify_name", type="string", description="板块名字"),
 *                                        ),
 *
 *                                 ),
 *
 *                      ),
 *                 ),
 *              ),
 *              @OA\Property(property="first_page_url",type="string",description=""),
 *              @OA\Property(property="from",type="integer",description=""),
 *              @OA\Property(property="last_page",type="integer",description=""),
 *              @OA\Property(property="last_page_url",type="string",description=""),
 *              @OA\Property(property="next_page_url",type="string",description=""),
 *              @OA\Property(property="path",type="string",description=""),
 *              @OA\Property(property="per_page",type="integer",description=""),
 *              @OA\Property(property="prev_page_url",type="integer",description=""),
 *              @OA\Property(property="to",type="integer",description=""),
 *              @OA\Property(property="total",type="integer",description=""),
 *             ),
 *       example={    "current_page": 1,    "data": {        {            "user_id": 10000009,            "post_id": 18,            "created_at": "2020-06-11T05:50:43.000000Z",            "updated_at": null,            "post": {                "id": 18,                "user_id": 10000009,                "title": "帖子内容存在违规行为已屏蔽内容",                "content": "帖子内容存在违规行为已屏蔽内容",                "view": 0,                "created_at": null,                "updated_at": null,                "deleted_at": null,                "post_praise_count": 0,                "visitor_user_id": 10000009,                "visitor_is_enshrine": 0,                "visitor_is_praise": 1,                "is_perfect": 0,                "is_hot": 0,                "is_recommend": 0,                "is_shield": 1,                "is_video": 0,                "post_classify": {                    {                        "classify_id": 1,                        "post_id": 18,                        "name": "1号板块"                    },                    {                        "classify_id": 2,                        "post_id": 18,                        "name": "2号版块"                    }                },                "publish_user": {                    "id": 10000009,                    "user_name": "用户1012623458"                }            }        }    },    "first_page_url": "http://platform.com/api/post/enshrine?page=1",    "from": 1,    "last_page": 1,    "last_page_url": "http://platform.com/api/post/enshrine?page=1",    "next_page_url": null,    "path": "http://platform.com/api/post/enshrine",    "per_page": 10,    "prev_page_url": null,    "to": 4,    "total": 4}
 *
 *              ),
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/post/index",
 *     tags={"帖子组"},
 *     summary="帖子列表(根据板块)",
 *     description="设顶帖子优先",
 *     security={
 *      {"api_token": {}}
 *    },
 *    @OA\RequestBody(@OA\JsonContent(
 *              required={"classify_id",},
 *              @OA\Property(property="classify_id", type="integer", description="板块ID"),
 *              @OA\Property(property="paginate", type="integer", description="每页条数"),
 *              example={"classify_id": "1","paginate": "10"}
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                 @OA\Items(
 *                      @OA\Property(property="post_id", type="integer", description="帖子id"),
 *                      @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                      @OA\Property(property="is_top", type="integer", description="是否设顶"),
 *                      @OA\Property(property="post", type="object", description="帖子数据",
 *                                  @OA\Property(property="user_id", type="integer", description="用户id"),
 *                                  @OA\Property(property="title", type="string", description="标题"),
 *                                  @OA\Property(property="content", type="string", description="内容"),
 *                                  @OA\Property(property="view", type="integer", description="浏览量"),
 *                                  @OA\Property(property="post_praise_count", type="integer", description="点赞数"),
 *                                  @OA\Property(property="visitor_user_id", type="integer", description="浏览者ID 没登录者为0"),
 *                                  @OA\Property(property="visitor_is_enshrine", type="integer", description="浏览者是否已收藏0/1"),
 *                                  @OA\Property(property="visitor_is_praise", type="integer", description="浏览者是否已点赞0/1"),
 *                                  @OA\Property(property="is_hot", type="integer", description="是否热帖 0否 1是"),
 *                                  @OA\Property(property="is_perfect", type="integer", description="是否加精 0否 1是"),
 *                                  @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                                  @OA\Property(property="is_recommend", type="integer", description="是否推荐 0否 1是"),
 *                                  @OA\Property(property="is_shield", type="integer", description="是否屏蔽 0否 1是"),
 *                                  @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                                  @OA\Property(property="created_at", type="date", description="创建时间",),
 *                                  @OA\Property(property="publish_user", type="object", description="发帖者数据",
 *                                              @OA\Property(property="id", type="integer", description="发帖者id"),
 *                                              @OA\Property(property="user_name", type="string", description="发帖者名字"),
 *
 *                                 ),
 *                                 @OA\Property(property="post_classify", type="array", description="帖子所属板块",
 *                                        @OA\Items(
 *                                              @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                                              @OA\Property(property="classify_name", type="string", description="板块名字"),
 *                                        ),
 *
 *                                 ),
 *
 *                      ),
 *                 ),
 *              ),
 *              @OA\Property(property="first_page_url",type="string",description=""),
 *              @OA\Property(property="from",type="integer",description=""),
 *              @OA\Property(property="last_page",type="integer",description=""),
 *              @OA\Property(property="last_page_url",type="string",description=""),
 *              @OA\Property(property="next_page_url",type="string",description=""),
 *              @OA\Property(property="path",type="string",description=""),
 *              @OA\Property(property="per_page",type="integer",description=""),
 *              @OA\Property(property="prev_page_url",type="integer",description=""),
 *              @OA\Property(property="to",type="integer",description=""),
 *              @OA\Property(property="total",type="integer",description=""),
 *             ),
 *       example={    "current_page": 1,    "data": {        {            "post_id": 18,            "classify_id": 1,            "is_top": 0,            "created_at": null,            "updated_at": null,            "deleted_at": null,            "post": {                "id": 18,                "user_id": 10000009,                "title": "帖子内容存在违规行为已屏蔽内容",                "content": "帖子内容存在违规行为已屏蔽内容",                "view": 0,                "created_at": null,                "updated_at": null,                "deleted_at": null,                "post_praise_count": 0,                "visitor_user_id": 10000009,                "visitor_is_enshrine": 0,                "visitor_is_praise": 1,                "is_perfect": 0,                "is_hot": 0,                "is_recommend": 0,                "is_shield": 1,                "is_video": 0,                "post_classify": {                    {                        "classify_id": 1,                        "post_id": 18,                        "name": "1号板块"                    },                    {                        "classify_id": 2,                        "post_id": 18,                        "name": "2号版块"                    }                },                "publish_user": {                    "id": 10000009,                    "user_name": "用户1012623458"                }            }        }    },    "first_page_url": "http://platform.com/api/post/index?page=1",    "from": 1,    "last_page": 1,    "last_page_url": "http://platform.com/api/post/index?page=1",    "next_page_url": null,    "path": "http://platform.com/api/post/index",    "per_page": 10,    "prev_page_url": null,    "to": 2,    "total": 2}
 *
 *              ),
 *     )
 *
 * )
 */

/**
 * @OA\Get(
 *     path="/api/post/index/recommend",
 *     tags={"帖子组"},
 *     summary="推荐帖子列表",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                 @OA\Items(
 *                      @OA\Property(property="post_id", type="integer", description="帖子id"),
 *                      @OA\Property(property="post", type="object", description="帖子数据",
 *                                  @OA\Property(property="user_id", type="integer", description="用户id"),
 *                                  @OA\Property(property="title", type="string", description="标题"),
 *                                  @OA\Property(property="content", type="string", description="内容"),
 *                                  @OA\Property(property="view", type="integer", description="浏览量"),
 *                                  @OA\Property(property="post_praise_count", type="integer", description="点赞数"),
 *                                  @OA\Property(property="visitor_user_id", type="integer", description="浏览者ID 没登录者为0"),
 *                                  @OA\Property(property="visitor_is_enshrine", type="integer", description="浏览者是否已收藏0/1"),
 *                                  @OA\Property(property="visitor_is_praise", type="integer", description="浏览者是否已点赞0/1"),
 *                                  @OA\Property(property="is_hot", type="integer", description="是否热帖 0否 1是"),
 *                                  @OA\Property(property="is_perfect", type="integer", description="是否加精 0否 1是"),
 *                                  @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                                  @OA\Property(property="is_recommend", type="integer", description="是否推荐 0否 1是"),
 *                                  @OA\Property(property="is_shield", type="integer", description="是否屏蔽 0否 1是"),
 *                                  @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                                  @OA\Property(property="created_at", type="date", description="创建时间",),
 *                                  @OA\Property(property="publish_user", type="object", description="发帖者数据",
 *                                              @OA\Property(property="id", type="integer", description="发帖者id"),
 *                                              @OA\Property(property="user_name", type="string", description="发帖者名字"),
 *
 *                                 ),
 *                                 @OA\Property(property="post_classify", type="array", description="帖子所属板块",
 *                                        @OA\Items(
 *                                              @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                                              @OA\Property(property="classify_name", type="string", description="板块名字"),
 *                                        ),
 *
 *                                 ),
 *
 *                      ),
 *                 ),
 *              ),
 *              @OA\Property(property="first_page_url",type="string",description=""),
 *              @OA\Property(property="from",type="integer",description=""),
 *              @OA\Property(property="last_page",type="integer",description=""),
 *              @OA\Property(property="last_page_url",type="string",description=""),
 *              @OA\Property(property="next_page_url",type="string",description=""),
 *              @OA\Property(property="path",type="string",description=""),
 *              @OA\Property(property="per_page",type="integer",description=""),
 *              @OA\Property(property="prev_page_url",type="integer",description=""),
 *              @OA\Property(property="to",type="integer",description=""),
 *              @OA\Property(property="total",type="integer",description=""),
 *             ),
 *       example={    "current_page": 1,    "data": {        {            "post_id": 18,            "classify_id": 1,            "is_top": 0,            "created_at": null,            "updated_at": null,            "deleted_at": null,            "post": {                "id": 18,                "user_id": 10000009,                "title": "帖子内容存在违规行为已屏蔽内容",                "content": "帖子内容存在违规行为已屏蔽内容",                "view": 0,                "created_at": null,                "updated_at": null,                "deleted_at": null,                "post_praise_count": 0,                "visitor_user_id": 10000009,                "visitor_is_enshrine": 0,                "visitor_is_praise": 1,                "is_perfect": 0,                "is_hot": 0,                "is_recommend": 0,                "is_shield": 1,                "is_video": 0,                "post_classify": {                    {                        "classify_id": 1,                        "post_id": 18,                        "name": "1号板块"                    },                    {                        "classify_id": 2,                        "post_id": 18,                        "name": "2号版块"                    }                },                "publish_user": {                    "id": 10000009,                    "user_name": "用户1012623458"                }            }        }    },    "first_page_url": "http://platform.com/api/post/index?page=1",    "from": 1,    "last_page": 1,    "last_page_url": "http://platform.com/api/post/index?page=1",    "next_page_url": null,    "path": "http://platform.com/api/post/index",    "per_page": 10,    "prev_page_url": null,    "to": 2,    "total": 2}
 *
 *              ),
 *     )
 *
 * )
 */

/**
 * @OA\Put(
 *     path="/api/post",
 *    @OA\RequestBody(@OA\JsonContent(
 *              required={"post_id",},
 *              @OA\Property(property="post_id", type="integer", description="帖子ID"),
 *              @OA\Property(property="title", type="string", description="修改的标题"),
 *              @OA\Property(property="content", type="string", description="修改的内容"),
 *              example={"post_id": "18","title": "新标题","content": "新内容"}
 *     )),
 *     tags={"帖子组"},
 *     summary="修改帖子",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="FALSE/失败",
 *     ),
 *
 * )
 */

/**
 * @OA\Get(
 *     path="/api/post",
 *     tags={"帖子组"},
 *     summary="帖子详情",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(
 *          @OA\JsonContent(
 *              required={"post_id",},
 *              @OA\Property(property="post_id", type="integer", description="帖子ID"),
 *              example={"post_id": "18"},
 *     )),
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="data", type="array", description="帖子数据",
 *                         @OA\Items(
 *                                  @OA\Property(property="user_id", type="integer", description="用户id"),
 *                                  @OA\Property(property="title", type="string", description="标题"),
 *                                  @OA\Property(property="content", type="string", description="内容"),
 *                                  @OA\Property(property="view", type="integer", description="浏览量"),
 *                                  @OA\Property(property="post_praise_count", type="integer", description="点赞数"),
 *                                  @OA\Property(property="visitor_user_id", type="integer", description="浏览者ID 没登录者为0"),
 *                                  @OA\Property(property="visitor_is_enshrine", type="integer", description="浏览者是否已收藏0/1"),
 *                                  @OA\Property(property="visitor_is_praise", type="integer", description="浏览者是否已点赞0/1"),
 *                                  @OA\Property(property="is_hot", type="integer", description="是否热帖 0否 1是"),
 *                                  @OA\Property(property="is_perfect", type="integer", description="是否加精 0否 1是"),
 *                                  @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                                  @OA\Property(property="is_recommend", type="integer", description="是否推荐 0否 1是"),
 *                                  @OA\Property(property="is_shield", type="integer", description="是否屏蔽 0否 1是"),
 *                                  @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                                  @OA\Property(property="created_at", type="date", description="创建时间"),
 *                                  @OA\Property(property="publish_user", type="object", description="发帖者数据",
 *                                              @OA\Property(property="id", type="integer", description="发帖者id"),
 *                                              @OA\Property(property="user_name", type="string", description="发帖者名字"),
 *
 *                                 ),
 *                                 @OA\Property(property="post_classify", type="array", description="帖子所属板块",
 *                                        @OA\Items(
 *                                              @OA\Property(property="classify_id", type="integer", description="板块id"),
 *                                              @OA\Property(property="classify_name", type="string", description="板块名字"),
 *                                        ),
 *
 *                                 ),
 *                          )
 *		            ),
 *
 *              ),
 *          ),
 *     ),
 *
 * )
 */