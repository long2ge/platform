<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/12
 * Time: 17:01
 */

namespace Modules\CutePet\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonalityPostRecommend  extends BaseModel
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
    protected $table = 'commonality_post_recommend';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
    ];
}