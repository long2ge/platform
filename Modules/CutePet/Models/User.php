<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use SoftDeletes, Authenticatable, Authorizable, HasApiTokens;

    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'cloud_user';

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
        'account',
        'user_name',
        'phone_number',
        'email',
        'password',
        'profile',
        'avatar',
        'address',
        'province_id',
        'city_id',
        'zone_id',
        'occupation_id',
        'sex',
        'status',
        'class',
        'authority_class',
        'authority_start',
        'authority_finish',
        'class',
        'authority_class',
        'post_sum',
        'comment_sum',
        'maintain_post_sum',
        'maintain_comment_sum',
        'maintain_authority_class',
        'authority_finish',
    ];

    protected $casts = [
        'sex' => 'boolean',
        'status' => 'boolean'
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
        return (new static())->where('user_name', $username)->first();
    }

    /**
     * 设置用来认证的密码字段
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * 用户关联粉丝关联关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userFans()
    {
        return $this->hasMany(UserFans::class);
    }

    /**
     * 用户关联偶像关联关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userConcerns()
    {
        return $this->hasMany(UserFans::class, 'fan_id');
    }

}
