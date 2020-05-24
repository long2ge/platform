<?php


namespace Modules\Post\Models;


use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\BaseModel;

class PostTowerComment extends BaseModel
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'cute_pet';

    /**
     * Table Name
     * 表名
     *
     * @var string
     */
    protected $table = 'post_tower_comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'up_user_id',
        'post_id',
        'post_comment_id',
        'up_user_comment_id',
        'user_id',
        'content',
        'shield',
    ];
}
