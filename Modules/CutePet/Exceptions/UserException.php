<?php


namespace Modules\User\Exceptions;


use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * 用户异常处理
 * Class UserException
 * @package Modules\User\Exceptions
 */
class UserException extends HttpException
{

    /**
     * 更新错误
     */
    public static function updateFault()
    {
        $message = 'update user fault';

        throw new static(400, $message);
    }

}