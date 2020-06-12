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
 *              @OA\Property(property="is_video", type="int", description="帖子是否有视频 0没有 1有"),
 *              @OA\Property(property="classify_id", type="int", description="板块ID"),
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
 *              @OA\Property(property="post_id", type="int", description="用户名下帖子ID"),
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
 *              @OA\Property(property="current_page", type="int", description="页数"),
 *              @OA\Property(property="data", type="object", description="帖子列表数据",
 *                  @OA\Property(property="id", type="int", description="id"),
 *                  @OA\Property(property="user_id", type="int", description="用户id"),
 *                  @OA\Property(property="title", type="string", description="标题"),
 *                  @OA\Property(property="content", type="string", description="内容"),
 *                  @OA\Property(property="view", type="int", description="浏览量"),
 *                  @OA\Property(property="hot", type="int", description="是否热帖 0否 1是"),
 *                  @OA\Property(property="perfect", type="int", description="是否加精 0否 1是"),
 *                  @OA\Property(property="top", type="int", description="是否设顶 0否 1是"),
 *                  @OA\Property(property="recommend", type="int", description="是否推荐 0否 1是"),
 *                  @OA\Property(property="shield", type="int", description="是否屏蔽 0否 1是"),
 *                  @OA\Property(property="is_video", type="int", description="是否视频帖子 0否 1是"),
 *                  @OA\Property(property="created_at", type="date", description="创建时间",),
 *              ),
 *              @OA\Property(property="first_page_url",type="string",description=""),
 *              @OA\Property(property="from",type="int",description=""),
 *              @OA\Property(property="last_page",type="int",description=""),
 *              @OA\Property(property="last_page_url",type="string",description=""),
 *              @OA\Property(property="next_page_url",type="string",description=""),
 *              @OA\Property(property="path",type="string",description=""),
 *              @OA\Property(property="per_page",type="int",description=""),
 *              @OA\Property(property="prev_page_url",type="int",description=""),
 *              @OA\Property(property="to",type="int",description=""),
 *              @OA\Property(property="total",type="int",description=""),
 *             ),
 *        ),
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
 *                        mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                     @OA\Items(
 *                      @OA\Property(property="user_id",type="integer",description="用户ID" ),
 *                      @OA\Property(property="post_id",type="integer",description="收藏的帖子ID" ),
 *                      @OA\Property(property="created_at",type="string",description="收藏时间" ),
 *                      @OA\Property(property="post",type="object",description="帖子数据",
 *                              @OA\Property(property="id", type="integer", description="id"),
 *                              @OA\Property(property="user_id", type="integer", description="用户id"),
 *                              @OA\Property(property="title", type="string", description="标题"),
 *                              @OA\Property(property="content", type="string", description="内容"),
 *                              @OA\Property(property="view", type="integer", description="浏览量"),
 *                              @OA\Property(property="hot", type="integer", description="是否热帖 0否 1是"),
 *                              @OA\Property(property="perfect", type="integer", description="是否加精 0否 1是"),
 *                              @OA\Property(property="top", type="integer", description="是否设顶 0否 1是"),
 *                              @OA\Property(property="recommend", type="integer", description="是否推荐 0否 1是"),
 *                              @OA\Property(property="shield", type="integer", description="是否屏蔽 0否 1是"),
 *                              @OA\Property(property="is_video", type="integer", description="是否视频帖子 0否 1是"),
 *                              @OA\Property(property="created_at", type="string", description="创建时间",),
 *                              @OA\Property(property="post_praise_count", type="integer", description="帖子点赞数",),
 *                              @OA\Property(property="publish_user",type="object",description="帖子发帖用户数据",
 *                                     @OA\Property(property="user_name", type="string", description="发帖用户名字",),
 *                                     @OA\Property(property="id", type="integer", description="发帖用户Id",),
 *                                          )
 *                                  )
 *                              )
 *                          ),
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
 *      example={"current_page":1,"data":{{"user_id":10000009,"post_id":21,"created_at":"2020-06-11T05:51:50.000000Z","updated_at":null,"post":{"id":21,"user_id":10000009,"title":"123","content":"1231","view":0,"hot":0,"perfect":0,"top":0,"recommend":0,"shield":0,"is_vip":0,"is_video":0,"created_at":"2020-06-07T13:29:47.000000Z","updated_at":"2020-06-07T13:29:47.000000Z","deleted_at":null,"post_praise_count":0,"publish_user":{"id":10000009,"account":"15207590099","user_name":"用户1012623458","phone_number":"15207590099","email":null,"password":"$2y$10$28RtknU23ZjPKJkYQfjb2eX8J/6/NIOBuXxGu4nz.55cUK0Dq4Iji","occupation_id":null,"profile":"","avatar":"","address":"","province_id":0,"city_id":0,"zone_id":0,"sex":true,"status":true,"class":0,"authority_class":0,"post_sum":0,"comment_sum":0,"maintain_post_sum":0,"maintain_comment_sum":0,"maintain_authority_class":0,"authority_finish":null,"created_at":"2020-05-30T12:13:20.000000Z","updated_at":"2020-05-30T12:13:20.000000Z","deleted_at":null}}}},"first_page_url":"http://platform.com/api/post/enshrine?page=1","from":1,"last_page":4,"last_page_url":"http://platform.com/api/post/enshrine?page=4","next_page_url":"http://platform.com/api/post/enshrine?page=2","path":"http://platform.com/api/post/enshrine","per_page":1,"prev_page_url":null,"to":1,"total":4}
 *        ),
 *     ),
 *
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
 *                        mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="current_page", type="integer", description="页数"),
 *              @OA\Property(property="data", type="array", description="帖子列表数据",
 *                     @OA\Items(
 *                      @OA\Property(property="id",type="integer",description="帖子ID" ),
 *                      @OA\Property(property="user_id",type="integer",description="楼主ID" ),
 *                      @OA\Property(property="title",type="string",description="标题" ),
 *                      @OA\Property(property="content",type="string",description="内容" ),
 *                      @OA\Property(property="view",type="string",description="浏览量" ),
 *                      @OA\Property(property="hot",type="string",description="是否热帖" ),
 *                      @OA\Property(property="perfect",type="string",description="是否精帖" ),
 *                      @OA\Property(property="top",type="string",description="是否设定" ),
 *                      @OA\Property(property="recommend",type="string",description="是否推荐" ),
 *                      @OA\Property(property="shield",type="string",description="是否屏蔽" ),
 *                      @OA\Property(property="is_vip",type="string",description="" ),
 *                      @OA\Property(property="is_video",type="string",description="是否有视频" ),
 *                      @OA\Property(property="created_at",type="string",description="创建时间" ),
 *                      @OA\Property(property="updated_at",type="string",description="" ),
 *                      @OA\Property(property="deleted_at",type="string",description="" ),
 *                      @OA\Property(property="post_praise_count",type="string",description="点赞总数" ),
 *                      @OA\Property(property="post_comment_count",type="string",description="评论总数" ),
 *                      @OA\Property(property="visitorPraise",type="string",description="浏览者是否已点赞" ),
 *                      @OA\Property(property="visitorEnshrine",type="string",description="浏览者是否已收藏" ),
 *                      @OA\Property(property="visitorUserId",type="string",description="浏览者用户ID 0为没登录用户" ),
 *                      @OA\Property(property="publish_user",type="object",description="楼主信息",
 *                                  @OA\Property(property="id",type="integer",description="楼主ID"),
 *                                  @OA\Property(property="user_name",type="integer",description="楼主名字"),
 *                                  ),
 *                              ),
 *                          ),
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
 *      example={"current_page":1,"data":{{"id":23,"user_id":10000009,"title":"123","content":"1231","view":0,"hot":0,"perfect":0,"top":0,"recommend":0,"shield":0,"is_vip":0,"is_video":0,"created_at":"2020-06-07T13:32:59.000000Z","updated_at":"2020-06-07T13:32:59.000000Z","deleted_at":null,"post_praise_count":0,"post_comment_count":0,"visitorPraise":0,"visitorEnshrine":0,"visitorUserId":10000009,"publish_user":{"id":10000009,"user_name":"用户1012623458"}}},"first_page_url":"http://platform.com/api/post/index?page=1","from":1,"last_page":1,"last_page_url":"http://platform.com/api/post/index?page=1","next_page_url":null,"path":"http://platform.com/api/post/index","per_page":10,"prev_page_url":null,"to":4,"total":4}
 *        ),
 *     ),
 *
 * )
 */