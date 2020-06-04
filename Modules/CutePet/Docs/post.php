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