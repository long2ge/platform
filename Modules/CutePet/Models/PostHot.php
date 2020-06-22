<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/22
 * Time: 19:41
 */

namespace Modules\CutePet\Models;


use App\Models\BaseModel;

class PostHot extends BaseModel
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
    protected $table = 'post_hot';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
    ];
}