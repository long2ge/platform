<?php


namespace Modules\User\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;
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
    protected $table = 'visit';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'visit_user_id',
        'user_id',
    ];

    /**
     * 关联用户
     */
    public function visitUser()
    {
        return $this->hasOne(User::class,'id','visit_user_id');
    }
}
