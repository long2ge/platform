<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/9/7
 * Time: 1:48 AM
 */

namespace Modules\User\Services;
//use Illuminate\Http\Response;
//use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
//use Modules\Core\Services\AuthorizationManageServer;
//use Modules\User\Logics\RegisterLogic;
//use Modules\User\Models\User;
//use Modules\User\Repositories\UserRepository;
//use Psr\Http\Message\ServerRequestInterface;
use App\Exceptions\LoginException;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Zend\Diactoros\Response as Psr7Response;

/**
 * 登录服务
 * Class LoginService
 * @package Modules\User\Services
 */
class LoginService
{
    use HandlesOAuthErrors;

    /**
     * 退出登录
     * User: long
     * Date: 2019/9/8 1:39 AM
     * Describe:
     * @param User $user 用户模型
     */
    public function logout(User $user)
    {
        try {
            $user->token()->delete();
        } catch (\Exception $e) {
            LoginException::logoutError($e);
        }




    }

    /**
     * 密码登录方法
     * User: long
     * Date: 2019/9/7 1:43 AM
     * Describe:
     * @param ServerRequestInterface $request PSR-7 请求接口
     * @return Response
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    public function password(ServerRequestInterface $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $authorizationServer = app(AuthorizationManageServer::class)->getUserAuthorizationServer();

            return $this->convertResponse(
                $authorizationServer->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }
}