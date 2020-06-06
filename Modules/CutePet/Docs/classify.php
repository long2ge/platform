<?php
/**
 * 板块
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/6
 * Time: 17:43
 */

/**
 * @OA\Get(
 *     path="/api/classify",
 *     tags={"板块组"},
 *     summary="板块列表",
 *     description="",
 *
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *          @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="data", type="array", description="板块列表数据",
 *              @OA\Items(
 *                  @OA\Property(property="id", type="integer", description="id"),
 *                  @OA\Property(property="name", type="string", description="名字"),
 *                    ),
 *              ),
 *          ),
 *      ),
 *   ),
 * )
 */