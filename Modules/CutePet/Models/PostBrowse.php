<?php


namespace Modules\CutePet\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\BaseModel;
use Modules\Post\Post;

class PostBrowse  extends BaseModel
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
    protected $table = 'post_browse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * 关联帖子
     */
    public function post()
    {
        return $this->hasOne(Post::class,'id','post_id');
    }

}
