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
 *              required={"title", "content","is_video"},
 *              @OA\Property(property="title", type="string", description="帖子标题"),
 *              @OA\Property(property="content", type="string", description="帖子内容"),
 *              @OA\Property(property="is_video", type="int", description="帖子是否有视频 0没有 1有"),
 *              example={"title": "标题","content": "内容","is_video":"0"}
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
 * @OA\get(
 *     path="/api/post/own",
 *     tags={"帖子组"},
 *     summary="用户自发帖子列表",
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
 *        )
 *     )
 *
 * )
 */



/**
 * @OA\post(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="评论（回复主帖）",
 *     description="评论（回复主帖）//（回复帖内的评论接口 /api/post/comment/reply）",
 *     security={
 *      {"api_token": {}}
 *    },
 *    @OA\RequestBody(@OA\JsonContent(
 *              required={"post_id", "comment_content"},
 *              @OA\Property(property="post_id", type="int", description="帖子ID"),
 *              @OA\Property(property="comment_content", type="string", description="评论内容"),
 *              example={"post_id": "1","comment_content": "内容"}
 *     )),
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="FAILED/失败",
 *     ),
 *
 * )
 */


/**
 * @OA\post(
 *     path="/api/post/comment/reply",
 *     tags={"帖子评论组"},
 *     summary="回复评论",
 *     description="回复评论",
 *     security={
 *      {"api_token": {}}
 *    },
 *    @OA\RequestBody(@OA\JsonContent(
 *              required={"comment_id", "reply_content"},
 *              @OA\Property(property="comment_id", type="int", description="评论ID"),
 *              @OA\Property(property="reply_content", type="string", description="回复评论内容"),
 *              example={"comment_id": "15","reply_content": "回复内容"}
 *     )),
 *
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="FAILED/失败",
 *     ),
 *
 * )
 */

/**
 * @OA\put(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="修改评论",
 *     description="修改评论数据发布者ID 与 登录用户ID一致",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"post_comment_id", "up_comment_content"},
 *              @OA\Property(property="post_comment_id", type="int", description="修改的评论ID"),
 *              @OA\Property(property="up_comment_content", type="string", description="修改的评论内容"),
 *              example={"post_comment_id": "1","up_comment_content": "修改评论内容",}
 *     )),
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="FALSE/失败,评论不存在",
 *     ),
 * )
 */

