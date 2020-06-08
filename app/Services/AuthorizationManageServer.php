<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/8
 * Time: 7:56 PM
 */

namespace App\Services;


use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Laravel\Passport\Passport;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\PasswordGrant;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Laminas\Diactoros\Response as Psr7Response;

/**
 * 认证管理服务
 * Class AuthorizationManageServer
 * @package Modules\User\Services
 */
class AuthorizationManageServer
{
    use HandlesOAuthErrors;

    /**
     * @var UserRepositoryInterface 用户仓库
     */
    private $userRepository;

    /**
     * AuthorizationManageServer constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * 登陆
     * User: long
     * Date: 2020/5/3 5:16 PM
     * Describe:
     * @param ServerRequestInterface $request 请求对象
     * @param string $username 账号
     * @param string $password 密码
     * @param string $grantType 授予方式
     * @return mixed
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    public function login(ServerRequestInterface $request, $username, $password, string $grantType = 'password')
    {
        $request = $this->requestWithParsedBody($request, $username, $password, $grantType);

        return $this->respondToAccessTokenRequest($request);
    }

    /**
     * 解析request body
     * User: long
     * Date: 2020/5/3 4:28 PM
     * Describe:
     * @param ServerRequestInterface $request 请求对象
     * @param string $username 账号
     * @param string $password 密码
     * @param string $grantType 授予方式
     * @return ServerRequestInterface
     */
    protected function requestWithParsedBody(
        ServerRequestInterface $request, string $username, string $password, string $grantType
    ) : ServerRequestInterface {
        return $request->withParsedBody(
            [
                'username' => $username,
                'password' => $password,
                'grant_type' => $grantType,
                'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
                'scope' => '*',
            ]
        );
    }

    /**
     * 响应 access token
     * User: long
     * Date: 2020/5/3 4:28 PM
     * Describe:
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    protected function respondToAccessTokenRequest(ServerRequestInterface $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            return $this->convertResponse(
                $this->getAuthorizationServer()->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }

    /**
     * 获取认证服务
     * User: long
     * Date: 2020/5/3 5:12 PM
     * Describe:
     * @return \Laravel\Lumen\Application|AuthorizationServer|mixed
     */
    protected function getAuthorizationServer()
    {
        $grant = new PasswordGrant($this->userRepository, $this->getRefreshTokenRepository());

        $grant->setRefreshTokenTTL($this->getRefreshTokensExpireIn());

        $authorizationServer = app(AuthorizationServer::class);

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
     * 获取刷新token数据仓库
     * User: long
     * Date: 2019/12/8 8:51 PM
     * Describe:
     * @return RefreshTokenRepository|mixed
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