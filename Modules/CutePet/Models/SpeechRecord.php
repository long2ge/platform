<?php

namespace Modules\Post\Models;

use Modules\Core\Models\BaseModel;

class SpeechRecord extends BaseModel
{
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
    protected $table = 'speech_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'comment_id',
        'response_id'
    ];

    public $timestamps = false;
}
