<?php

namespace Modules\Post\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\BaseModel;
use Modules\User\Models\User;

class Response extends BaseModel
{
    use SoftDeletes;
    /**
     * The connection name for the model
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
    protected $table = 'responses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'comment_id',
        'post_id',
        'respondent_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function responseFavors()
    {
        return $this->hasMany(ResponseFavor::class);
    }
}
