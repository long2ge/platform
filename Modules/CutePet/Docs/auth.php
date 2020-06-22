<?php

/**
 * @OA\Post(
 *     path="/api/user/password",
 *     tags={"用户组"},
 *     summary="用户登录",
 *     description="返回浏览器秘钥",
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"username", "password"},
 *              @OA\Property(property="username", type="string", description="user 账户"),
 *              @OA\Property(property="password", type="string", description="user 密码"),
 *     example={"username": "测试1234","password": "123456"}
 *     )),
 *     @OA\Response(
 *         response=200,
 *         description="SUCCESS/成功",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *              @OA\Property(property="token_type", type="string", description="秘钥类型"),
 *              @OA\Property(property="expires_in", type="int", description="有效秒数"),
 *              @OA\Property(property="access_token",type="string",description="访问秘钥码"),
 *              @OA\Property(property="refresh_token",type="string",description="刷新秘钥码"),
 *             ),
 *         example={"api_key_security_example": {
 *              "token_type": "Bearer",
 *              "expires_in": 31536000,
 *              "access_token": "22.33.aLcl6kE-44-55-ojITv9hzsJd-66-77-wTn7hNZxZdQ7C0CIH4dNcxLepP6-bazu-7-7",
 *              "refresh_token": "1111"
 *          }
 *          }
 *        )
 *     )
 * )
 */



/**
 * @OA\Post(
 *     path="/api/user/login",
 *     tags={"用户组"},
 *     summary="用户注册",
 *     description="",
 *     @OA\RequestBody(@OA\JsonContent(
 *              required={"phone", "password"},
 *              @OA\Property(property="phone", type="string", description="注册账户"),
 *              @OA\Property(property="password", type="string", description="注册密码"),
 *     example={"username": "测试1234","password": "123456"}
 *     )),
 *     @OA\Response(
 *         response=204,
 *         description="SUCCESS/成功",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="账号已存在",
 *     ),
 * )
 */
