<?php


namespace Modules\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jurisdiction extends Model
{
    use SoftDeletes;
    /**
     * The connection name for the model.
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'cloud_admin';

    /**
     * Table Name
     * 表名
     *
     * @var string
     */
    protected $table = 'jurisdictions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'class',
        'up_class_id',
    ];

}
