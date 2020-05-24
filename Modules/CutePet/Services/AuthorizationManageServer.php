<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/8
 * Time: 7:56 PM
 */

namespace Modules\CutePet\Services;


use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Modules\Admin\Repositories\AdminUserRepository;
use Modules\User\Repositories\UserRepository;

/**
 * 认证管理服务
 * Class AuthorizationManageServer
 * @package Modules\User\Services
 */
class AuthorizationManageServer
{
    /**
     * 获取乘客认证服务
     * User: long
     * Date: 2019/12/8 8:52 PM
     * Describe:
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return \Illuminate\Contracts\Foundation\Application|AuthorizationServer
     */
    public function getUserAuthorizationServer()
    {
       return $this->getCommonAuthorizationServer($this->getUserRepository());
    }

    /**
     * 获取乘客认证服务
     * User: long
     * Date: 2019/12/8 8:52 PM
     * Describe:
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @return \Illuminate\Contracts\Foundation\Application|AuthorizationServer
     */
    public function getAdminUserAuthorizationServer()
    {
        return $this->getCommonAuthorizationServer($this->getAdminUserRepository());
    }

    /**
     * 获取公共认证服务
     * User: long
     * Date: 2019/12/9 7:32 PM
     * Describe:
     * @param UserRepositoryInterface $userRepository
     * @return \Illuminate\Contracts\Foundation\Application|AuthorizationServer|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getCommonAuthorizationServer(UserRepositoryInterface $userRepository)
    {
        $grant = new PasswordGrant(
            $userRepository,
            $this->getRefreshTokenRepository()
        );

        $grant->setRefreshTokenTTL($this->getRefreshTokensExpireIn());

        $authorizationServer = $this->getAuthorizationServer();

        $authorizationServer->enableGrantType($grant, $this->getAccessTokenTTL());

        return $authorizationServer;
    }

    /**
     * 获取AccessTokenTTL
     * User: long
     * Date: 2019/12/8 9:25 PM
     * Describe:
     * @return \DateInterval|Passport
     */
    protected function getAccessTokenTTL()
    {
        return Passport::tokensExpireIn();
    }

    /**
     * 获取认证服务
     * User: long
     * Date: 2019/12/8 9:28 PM
     * Describe:
     * @return \Illuminate\Contracts\Foundation\Application|AuthorizationServer|mixed
     */
    protected function getAuthorizationServer()
    {
        return app(AuthorizationServer::class);
    }

    /**
     * 获取后台服务数据仓库
     * User: long
     * Date: 2019/12/9 7:29 PM
     * Describe:
     * @return UserRepositoryInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getAdminUserRepository() : UserRepositoryInterface
    {
        return app()->make(AdminUserRepository::class);
    }

    /**
     * 获取乘客用户数据仓库
     * User: long
     * Date: 2019/12/8 8:51 PM
     * Describe:
     * @return UserRepositoryInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getUserRepository() : UserRepositoryInterface
    {
        return app()->make(UserRepository::class);
    }

    /**
     * 获取刷新token数据仓库
     * User: long
     * Date: 2019/12/8 8:51 PM
     * Describe:
     * @return RefreshTokenRepository|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getRefreshTokenRepository()
    {
        return app()->make(RefreshTokenRepository::class);
    }

    /**
     * 获取刷新token有效时间
     * User: long
     * Date: 2019/12/8 8:52 PM
     * Describe:
     * @return \DateInterval|Passport
     */
    protected function getRefreshTokensExpireIn()
    {
        return Passport::refreshTokensExpireIn();
    }

}