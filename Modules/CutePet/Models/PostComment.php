<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/31
 * Time: 16:43
 */

namespace Modules\CutePet\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'post_id',//所属帖子ID
        'comment_user_id',//评论用户ID
        'comment_content',//评论内容
        //'praise',//点赞数
        'astrict',//0不限制，1屏蔽，2已删除
        'type',//类型 0回复主帖，1回复评论
        'reply_comment_id',//回复的评论ID  （type为1的数据）
        'reply_comment_user_id',//回复的评论用户ID  （type为1的数据）
    ];

    public function postCommentsPraise()
    {
        return $this->hasMany(PostCommentsPraise::class,'praise_comment_id','id');
    }

}