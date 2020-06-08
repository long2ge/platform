<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/9/7
 * Time: 1:03 AM
 */

namespace Modules\Admin\Http\Controllers\Api;

use App\Services\AuthorizationManageServer;
use Modules\Admin\Http\Controllers\AdminAppController;
use Modules\Admin\Repositories\UserRepository;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 登录控制器
 * Class LoginController
 * @package App\Http\Controllers\User\Auth
 */
class AuthController extends AdminAppController
{
    /**
     * 登陆
     * User: long
     * Date: 2020/5/10 3:16 PM
     * Describe:
     * @param ServerRequestInterface $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Laravel\Passport\Exceptions\OAuthServerException
     */
    public function login(ServerRequestInterface $request)
    {
        $attributes = (array) $request->getParsedBody();
        $attributes = [
            'username' => $attributes['username'] ?? null,
            'password' => $attributes['password'] ?? null,
        ];

        $this->validateWithArray($attributes, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $AuthorizationManageServer = new AuthorizationManageServer(new UserRepository());

        return $AuthorizationManageServer->login($request, $attributes['username'], $attributes['password']);
    }

}
