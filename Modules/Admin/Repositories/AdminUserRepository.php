<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/9
 * Time: 7:22 PM
 */

namespace Modules\Admin\Repositories;

use Illuminate\Support\Facades\Hash;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Laravel\Passport\Bridge\User as UserEntity;
use RuntimeException;

class AdminUserRepository implements UserRepositoryInterface
{
    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
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
        $provider = config('auth.guards.admin_api.provider');

        if (is_null($model = config('auth.providers.'.$provider.'.model'))) {
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
}
