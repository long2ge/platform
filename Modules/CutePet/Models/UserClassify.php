<?php


namespace Modules\Post\Models;


use Modules\Core\Models\BaseModel;

class UserClassify  extends BaseModel
{
    public $timestamps = false;
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
    protected $table = 'user_classify';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'classify_id',
    ];

}
