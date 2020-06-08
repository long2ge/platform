<?php


namespace Modules\CutePet\Models;



use App\Models\BaseModel;

class PostEnshrine extends BaseModel
{
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
    protected $table = 'post_enshrines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    public function post()
    {
        return $this->hasOne(Post::class,'id','post_id');
    }

}
