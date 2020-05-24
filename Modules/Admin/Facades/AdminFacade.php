<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/2
 * Time: 4:10 PM
 */

namespace Modules\Admin\Facades;

use App\Traits\InvokeTrait;
use Modules\Admin\Services\PostAdminService;

/**
 * 后台系统门面
 * Class AdminFacade
 * @package Modules\Admin\Facades
 */
class AdminFacade
{
    use InvokeTrait;

    /**
     * 测试方法
     * User: long
     * Date: 2020/5/2 5:39 PM
     * Describe:
     * @return string
     */
    public function test()
    {
        return ' AdminFacade test ';
    }

    /**
     * 冻结用户
     * @param $blockedUserId
     * @param $user
     */
    public function blockedAccount($blockedUserId,$user)
    {
        app(PostAdminService::class)->blockedAccount($blockedUserId,$user);
    }

}