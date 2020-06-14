<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/13
 * Time: 23:12
 */

/**
 * @OA\Post(
 *     path="/api/image/upload",
 *     tags={"图片视频组"},
 *     summary="图片上传",
 *     description="",
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"picture"},
 *              @OA\Property(property="picture", type="file", description="上传文件"),
 *              example={"picture": "file.png"}
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *                        mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="url", type="string", description="图片rul"),
 *             ),
 *      example={"url": "https://cute-pet-images.oss-cn-shenzhen.aliyuncs.com/test/file/iVqdNJx2gK5E9GjvGAsHSiYMAraGBXQ2qfHjDaEl.png"}
 *              ),
 *     ),
 *
 * )
 */