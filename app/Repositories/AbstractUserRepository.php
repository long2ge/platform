<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/9
 * Time: 7:22 PM
 */

namespace App\Repositories;

use Illuminate\Support\Facades\Hash;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Laravel\Passport\Bridge\User as UserEntity;
use RuntimeException;

/**
 * 抽象用户仓库
 * Class AbstractUserRepository
 * @package Modules\Admin\Repositories
 */
abstract class AbstractUserRepository implements UserRepositoryInterface
{

    /**
     * 获取提供者类
     * User: long
     * Date: 2020/5/3 6:38 PM
     * Describe:
     * @return string
     */
    abstract public function getProviderClass() : string;

    /**
     * Get a user entity.
     *
     * @param string $username 账号
     * @param string $password 密码
     * @param string $grantType 授权类型 password
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntity
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $model = $this->getProviderClass();

        if (is_null($model)) {
            throw new RuntimeException('Unable to determine authentication model from configuration.');
        }

        if (method_exists($model, 'findForPassport')) {
            $user = (new $model)->findForPassport($username);
        } else {
            $user = (new $model)->where('email', $username)->first();
        }

        if (! $user) {
            return;
        } elseif (method_exists($user, 'validateForPassportPasswordGrant')) {
            if (! $user->validateForPassportPasswordGrant($password)) {
                return;
            }

        } elseif (! Hash::check($password, $user->getAuthPassword())) {
            return;
        }

        return new UserEntity($user->getAuthIdentifier());
    }

    /**
     * 加密密码
     * User: long
     * Date: 2020/5/3 5:09 PM
     * Describe:
     * @param string $password
     * @return string
     */
    protected function encryptPassword(string $password)
    {
        return Hash::make($password);
    }

}