<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/9/7
 * Time: 1:03 AM
 */

namespace Modules\CutePet\Http\Controllers\V1\Auth;

use App\Repositories\CutePetUserRepository;
use App\Services\AuthorizationManageServer;
use Illuminate\Http\Request;
use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\CutePet\Services\LoginService;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 登录控制器(前台)
 * Class LoginController
 * @package App\Http\Controllers\User\Auth
 */
class LoginController extends CutePetController
{
    /**
     * 密码登录
     *
     * @api               {POST} /api/user/login/password 密码登录
     * @apiSampleRequest  /api/user/login/password
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginPhone
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {String} username 账号
     * @apiParam {String} password 密码
     *
     * @apiSuccessExample  {json} 200 成功请求
     *  {
     *      "token_type": "Bearer", token的类型
     *      "expires_in": 1295999, 有效时间（秒)）
     *      "access_token": "123456", 请求token
     *      "refresh_token": "123456" 刷新token
     *  }
     *
     * @apiUse            RestfulError
     * @param ServerRequestInterface $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    public function password(ServerRequestInterface $request)
    {

        $attributes = (array) $request->getParsedBody();
        $attributes = [
            'username' => $attributes['username'] ?? 0,
            'password' => $attributes['password'] ?? null,
        ];

        $this->validateWithArray($attributes, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $AuthorizationManageServer = new AuthorizationManageServer(new CutePetUserRepository());

        return $AuthorizationManageServer->loginByPassword($request,$attributes['username'], $attributes['password']);

    }

//    /**
//     * 注册
//     *
//     * @api               {POST} /api/admin/user/register 注册
//     * @apiSampleRequest  /api/admin/user/register
//     * @apiVersion 1.0.0
//     * @apiDescription
//     * developed by long2ge
//     *
//     * @apiGroup          Login
//     * @apiName           LoginRegister
//     *
//     * @apiUse            AuthJSONHeader
//     *
//     * @apiParam {String} phone 手机号码
//     * @apiParam {String} password 密码
//     *
//     * @apiSuccessExample  {json} 200 成功请求
//     *  {
//     *      "token_type": "Bearer", token的类型
//     *      "expires_in": 1295999, 有效时间（秒)）
//     *      "access_token": "123456", 请求token
//     *      "refresh_token": "123456" 刷新token
//     *  }
//     *
//     * @apiUse            RestfulError
//     * @param ServerRequestInterface $request
//     * @return \Illuminate\Http\Response
//     * @throws \Illuminate\Validation\ValidationException
//     * @throws \Laravel\Passport\Exceptions\OAuthServerException
//     */
//    public function register(ServerRequestInterface $request)
//    {
//        $attributes = (array) $request->getParsedBody();
//        $attributes = [
//            'phone' => $attributes['phone'] ?? null,
//            'password' => $attributes['password'] ?? null,
//        ];
//
//        $this->validateWithArray($attributes, [
//            'phone' => 'required|string',
//            'password' => 'required|string'
//        ]);
//
//
//        //注册
//        RegisterLogic::passwordRegister($attributes['phone'],$attributes['password']);
//
//
////        $request = LoginLogic::requestWithParsedBodyByAdmin($request, $attributes['phone'], $attributes['password']);
////
////        return app(LoginService::class)->password($request);
//
//
//    }

    /**
     * 退出登录
     *
     * @api               {DELETE} /api/admin/user/logout 退出登录
     * @apiSampleRequest  /api/admin/user/logout
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginLogout
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiSuccessExample  {json} 204 成功请求
     *  {
     *  }
     *
     * @apiUse            RestfulError
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        app(LoginService::class)->logout($request->user());

        return response()->json([], 204);
    }

}
