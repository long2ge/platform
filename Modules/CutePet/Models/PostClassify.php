<?php


namespace Modules\CutePet\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostClassify extends BaseModel
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
    protected $table = 'post_classify';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'classify_id',
        'is_top',
    ];

}
