<?php

namespace App;

use App\Models\AbstractUser;

class User extends AbstractUser
{
    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'user';

    /**
     * Table Name
     * 表名
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'email_verified_at',
        'remember_token',
        'phone',
        'real_name',
        'birthday',
        'sex', // 1代表男, 0代表女
        'union_id',
        'mini_openid',
        'avatar',
    ];

    /**
     * 根据用户名字获取密码
     * User: long
     * Date: 2019/4/7 6:22 PM
     * Describe:
     * @param $username
     * @return mixed
     */
    public function findForPassport($username)
    {
        return (new static())->where('name', $username)->first();
    }
}
