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