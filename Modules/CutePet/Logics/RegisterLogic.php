<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/11/17
 * Time: 2:06 AM
 */

namespace Modules\CutePet\Logics;

use Closure;
use DB;
use Illuminate\Support\Facades\Hash;
use Log;
use Modules\CutePet\Models\User;


/**
 * 注册逻辑
 * Class RegisterLogic
 * @package Modules\User\Logics
 */
class RegisterLogic
{



    /**
     * 获取随机密码
     * User: long
     * Date: 2019/9/13 2:57 AM
     * Describe:
     * @return string
     */
    public static function getRandomCipher($password = null) : string
    {
        if ($password = null){
            $password = mt_rand(100000, 999999);
        }
        return Hash::make($password);
    }

    /**
     * 获取用户模型
     * User: long
     * Date: 2019/11/15 11:48 PM
     * Describe:
     * @param string $phone 手机号码
     * @return User
     */
    public static function getUserModelByPhone(string $phone) : User
    {
        $user = new User();

        $content = self::registerBasicContent($phone);
        foreach ($content as $key => $val) {
            $user->$key = $val;
        }

        return $user;
    }

    /**
     * 获取注册基本内容
     * User: long
     * Date: 2019/11/17 2:12 AM
     * Describe:
     * @param string $phone 手机号码
     * @return array
     */
    public static function registerBasicContent(string $phone) : array
    {
        return [
            'phone' => $phone,
            'password' => self::getRandomCipher(),
            'name' => $phone,
        ];
    }

    /**
     * 事务注册
     * User: long
     * Date: 2019/11/15 10:15 PM
     * Describe: 执行事务的注册
     * @param Closure $closure
     * @return mixed|null
     */
    public static function transactionRegister(Closure $closure)
    {
        $dbConnection = config('database.connections.user.connection');

        try {
            DB::connection($dbConnection)->beginTransaction();

            $user = $closure();

            DB::connection($dbConnection)->commit(); // 提交事务
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            try {
                DB::connection($dbConnection)->rollBack();
            } catch (\Exception $e) {
                Log::info($e->getMessage());
            }

            $user = null;
        }

        return $user;
    }

    /**
     * 简单注册接口
     */
    public static function writeData($phone,$password)
    {

        $passwordHash = self::getRandomCipher($password);

        if (User::where('phone_number',$phone)->exists()){
            abort(404,'账号已经存在');
        }

        User::create([
            'phone_number'=>$phone,
            'password'=>$passwordHash,
            ]);

    }
}
