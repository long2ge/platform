<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/9/7
 * Time: 3:01 AM
 */

namespace Modules\User\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * 登录异常类
 * Class LoginException
 * @package Modules\User\Exceptions
 */
class LoginException extends HttpException
{
    /**
     * 找不到该用户
     * User: long
     * Date: 2019/9/7 3:11 AM
     * Describe:
     * @return void
     */
    public static function notFindUserByPassword()
    {
        $errorMessage = 'not find user';

        throw new static(400, $errorMessage);
    }

    /**
     * 退出登录失败
     * User: long
     * Date: 2019/9/8 1:38 AM
     * Describe:
     * @param string | null $errorMessage 异常消息
     * @return void
     */
    public static function logoutError($errorMessage = null)
    {
        $errorMessage = $errorMessage ?? 'logout error';

        throw new static(400, $errorMessage);
    }
}
