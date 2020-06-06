<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/2
 * Time: 19:33
 */

/**
 * @OA\Post(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="评论（回复主帖）",
 *     description="评论（回复主帖）//（回复帖内的评论接口 /api/post/comment/reply）",
 *     security={
 *      {"api_token": {}}
 *    },
 *    @OA\RequestBody(@OA\JsonContent(
 *              required={"post_id", "comment_content"},
 *              @OA\Property(property="post_id", type="integer", description="帖子ID"),
 *              @OA\Property(property="comment_content", type="string", description="评论内容"),
 *              example={"post_id": "1","comment_content": "内容"}
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="FAILED/失败",
 *     ),
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
 *              @OA\Property(property="comment_id", type="integer", description="评论ID"),
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
 * @OA\Put(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="修改评论",
 *     description="修改评论数据发布者ID 与 登录用户ID一致",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(required=true, @OA\JsonContent(
 *          required={"post_comment_id", "up_comment_content"},
 *          @OA\Property(property="post_comment_id", type="integer", description="修改的评论ID"),
 *          @OA\Property(property="up_comment_content", type="string", description="修改的评论内容"),
 *          example={"post_comment_id": "1","up_comment_content": "修改评论内容"}
 *     )),
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *      @OA\Response(
 *          response=400,
 *          description="FALSE/失败,评论不存在",
 *     ),
 * )
 */

/**
 * @OA\delete(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="删除评论",
 *     description="删除评论数据发布者ID 与 登录用户ID一致",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"post_comment_id"},
 *              @OA\Property(property="post_comment_id", type="integer", description="删除的评论ID"),
 *              example={"post_comment_id": "1"}
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

/**
 * @OA\Get(
 *     path="/api/post/comment",
 *     tags={"帖子评论组"},
 *     summary="评论详情",
 *     description="",
 *     security={
 *      {"api_token": {}}
 *    },
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"comment_id"},
 *              @OA\Property(property="comment_id", type="integer", description="评论ID"),
 *              example={"post_comment_id": "16"}
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="id", type="integer", description="评论ID"),
 *                 @OA\Property(property="post_id", type="integer", description="所属帖子ID"),
 *                 @OA\Property(property="comment_user_id", type="integer", description="发表评论者ID"),
 *                 @OA\Property(property="comment_content", type="string", description="评论内容"),
 *                 @OA\Property(property="type", type="integer", description="评论类型 0回复主贴 1回复评论"),
 *                 @OA\Property(property="reply_comment_id", type="integer", description="上级评论ID"),
 *                 @OA\Property(property="reply_comment_user_id", type="integer", description="上级评论用户ID"),
 *                 @OA\Property(property="praise", type="integer", description="获得点赞数"),
 *                 @OA\Property(property="astrict", type="integer", description="限制情况 0不限制，1屏蔽，2已删除"),
 *                 @OA\Property(property="created_at", type="date", description="发表时间"),
 *                 @OA\Property(property="updated_at", type="date", description="修改时间"),
 *             ),
 *         ),
 *     ),
 *
 *      @OA\Response(
 *          response=400,
 *          description="FALSE/失败,评论不存在",
 *     ),
 * )
 */

/**
 * @OA\Get(
 *     path="/api/post/comment/index",
 *     tags={"帖子评论组"},
 *     summary="帖子评论列表",
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
 *              @OA\Property(property="data", type="array", description="帖子评论列表数据",
 *                  @OA\Items(
 *                              @OA\Property(property="id", type="integer", description="评论IDs"),
 *                              @OA\Property(property="post_id", type="integer", description="所属帖子ID"),
 *                              @OA\Property(property="comment_user_id", type="integer", description="发表评论者ID"),
 *                              @OA\Property(property="comment_content", type="string", description="评论内容"),
 *                              @OA\Property(property="type", type="integer", description="评论类型 0回复主贴 1回复评论"),
 *                              @OA\Property(property="reply_comment_id", type="integer", description="上级评论ID"),
 *                              @OA\Property(property="reply_comment_user_id", type="integer", description="上级评论用户ID"),
 *                              @OA\Property(property="praise", type="integer", description="获得点赞数"),
 *                              @OA\Property(property="astrict", type="integer", description="限制情况 0不限制，1屏蔽，2已删除"),
 *                              @OA\Property(property="created_at", type="date", description="发表时间"),
 *                              @OA\Property(property="updated_at", type="date", description="修改时间"),
 *                  ),
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
 *        )
 *     )
 *
 * )
 */
