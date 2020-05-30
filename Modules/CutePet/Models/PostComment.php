<?php


namespace Modules\CutePet\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\BaseModel;
use Modules\User\Models\User;

class PostComment extends BaseModel
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
    protected $table = 'post_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'post_user_id',
        'tower',
        'content',
        'shield',
    ];

    /**
     * 关联评论点赞表
     */
    public function commentPraise()
    {
        return $this->hasMany(PostCommentsPraise::class,'comment_id','id');
    }

    /**关联用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    /**
     * 关联评论
     */
    public function comment()
    {
        return $this->hasMany(PostComment::class,'post_id','id');
    }

    /**
     * 关联收藏
     */
    public function enshrine()
    {
        return $this->hasMany(PostEnshrine::class,'post_id','id');
    }
}
