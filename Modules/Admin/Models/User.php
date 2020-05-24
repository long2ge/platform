<?php

namespace Modules\Admin\Models;

use App\Models\AbstractUser;

/**
 * 后台用户
 * Class User
 * @package Modules\Admin\Models
 */
class User extends AbstractUser
{
    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'admin';

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
        'avatar',
        'role_id',
        'status',
        'jurisdictions_ids',//权限IDs
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
        return (new static())->where('username', $username)->first();
    }

}
