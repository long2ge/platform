<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/11/15
 * Time: 11:03 PM
 */

namespace Modules\Core\Logics;

use Illuminate\Support\Facades\Hash;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 登录逻辑
 * Class LoginLogic
 * @package Modules\User\Logics
 */
class LoginLogic
{
    /**
     * 获取passport解析参数Body
     * User: long
     * Date: 2019/9/13 12:54 AM
     * Describe:
     * @param string $identification 用户标识 （手机号码|微信平台id|小程序唯一id)
     * @param string $password 密码
     * @return array
     */
    public static function getPassportParsedBody(string $identification, string $password)
    {
        return [
            'username' => $identification,
            'password' => $password,
            'grant_type' => 'password',
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
            'scope' => '*',
        ];
    }

    /**
     * 解析request body
     * User: long
     * Date: 2019/11/17 1:58 AM
     * Describe:
     * @param ServerRequestInterface $request 请求对象
     * @param string $identification 用户标识 （手机号码|微信平台id|小程序唯一id)
     * @param string $password 密码
     * @return ServerRequestInterface
     */
    public static function requestWithParsedBody(
        ServerRequestInterface $request,
        string $identification,
        string $password
    ) : ServerRequestInterface {
        return $request->withParsedBody(
            LoginLogic::getPassportParsedBody($identification, $password)
        );
    }

    /**
     * 解析request body
     * User: long
     * Date: 2019/12/09 20:00 AM
     * Describe:
     * @param ServerRequestInterface $request 请求对象
     * @param string $identification 用户标识 （手机号码|微信平台id|小程序唯一id)
     * @param string $password 密码
     * @return ServerRequestInterface
     */
    public static function requestWithParsedBodyByAdmin(
        ServerRequestInterface $request,
        string $identification,
        string $password
    ) : ServerRequestInterface {
        return $request->withParsedBody(
            LoginLogic::getPassportParsedBody($identification, $password)
        );
    }

    /**
     * 加密密码
     * User: long
     * Date: 2019/12/28 9:22 PM
     * Describe:
     * @param string $password
     * @return string
     */
    public static function encryptPassword(string $password)
    {
        return Hash::make($password);
    }
}
