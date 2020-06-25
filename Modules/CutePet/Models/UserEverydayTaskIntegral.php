<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/23
 * Time: 4:25
 */

namespace Modules\CutePet\Models;


use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEverydayTaskIntegral extends BaseModel
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
    protected $table = 'user_everyday_task_integral';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'handle_task_id',
        'handle_task_sum',
    ];


}