<?php

namespace Modules\CutePet\Models;

use Modules\Core\Models\BaseModel;

class CommentFavor extends BaseModel
{
    /**
     * The connection name for the model
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
    protected $table = 'comment_favors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comment_id',
        'user_id'
    ];

    public $timestamps = false;
}
