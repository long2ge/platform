<?php


namespace Modules\Post;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\BaseModel;
use Modules\Post\Models\PostEnshrine;
use Modules\Post\Models\PostPraise;
use Modules\User\Models\User;

/**
 * 帖子模型
 * Class Post
 * @package Modules\Post
 */
class Post extends BaseModel
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'cloud_post';

    /**
     * Table Name
     * 表名
     *
     * @var string
     */
    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'view',
        'hot',
        'perfect',
        'top',
        'shield',
        'recommend',
    ];

    /**
     * 关联用户
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function publishUser() : HasOne
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    /**
     * 关联点赞表
     */
    public function postPraise()
    {
        return $this->hasMany(PostPraise::class,'post_id','id');
    }

    public function postEnshrines()
    {
        return $this->hasMany(PostEnshrine::class, 'post', 'id');
    }

}
//<?php
//
//namespace Modules\Post\Models;
//
//use Illuminate\Database\Eloquent\SoftDeletes;
//use Modules\Core\Models\BaseModel;
//use Modules\User\Models\User;
//
//class Post extends BaseModel
//{
//    use SoftDeletes;
//    /**
//     * The connection name for the model
//     * 库链接的配置名
//     *
//     * @var string
//     */
//    protected $connection = 'cloud_post';
//
//    /**
//     * Table Name
//     * 表名
//     *
//     * @var string
//     */
//    protected $table = 'posts';
//
//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = [
//        'id',
//        'user_id',
//        'title',
//        'content',
//        'view',
//        'stick',
//        'source',
//        'last_updated_at',
//        'created_at',
//        'updated_at',
//        'deleted_at'
//    ];
//
//    protected $casts = ['stick' => 'boolean'];
//
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }
//
//    public function comments()
//    {
//        return $this->hasMany(Comment::class);
//    }
//
//    public function postFavors()
//    {
//        return $this->hasMany(PostFavor::class);
//    }
//
//    public function speechRecords()
//    {
//        return $this->hasMany(SpeechRecord::class);
//    }
//}
