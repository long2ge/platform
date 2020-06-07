<?php


namespace Modules\CutePet\Models;


use App\Models\BaseModel;

class PostClassify extends BaseModel
{
    public $timestamps = false;
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
    protected $table = 'post_classify';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'classify_id',
    ];

}
