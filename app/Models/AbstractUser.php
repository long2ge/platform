<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/3
 * Time: 5:30 PM
 */

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * 抽象用户
 * Class AbstractUser
 * @package App\Models
 */
abstract class AbstractUser extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens, Notifiable;

    /**
     * 根据用户名字获取密码
     * User: long
     * Date: 2019/4/7 6:22 PM
     * Describe:
     * @param $username
     * @return mixed
     */
    abstract public function findForPassport($username);

    /**
     * passport 密码验证方法
     * User: long
     * Date: 2019/9/7 2:26 AM
     * Describe:
     * @param string $password 验证密码方法
     * @return bool
     */
//    public function validateForPassportPasswordGrant($password)
//    {
//        return $password == $this->password;
//    }

    /**
     * 退出登陆
     * User: long
     * Date: 2020/5/3 5:33 PM
     * Describe:
     * @throws \Exception
     */
    public function logout()
    {
        $this->token()->delete();
    }

}