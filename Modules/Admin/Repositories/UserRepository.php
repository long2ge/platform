<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/9
 * Time: 7:22 PM
 */

namespace Modules\Admin\Repositories;

use App\Repositories\AbstractUserRepository;

class UserRepository extends AbstractUserRepository
{
    /**
     * 获取提供者类
     * User: long
     * Date: 2020/5/3 6:38 PM
     * Describe:
     * @return string
     */
    public function getProviderClass(): string
    {
        $provider = config('auth.guards.admin_api.provider');

        return config('auth.providers.'.$provider.'.model');
    }
}