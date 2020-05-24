<?php

namespace Modules\Core\Models;

class region extends BaseModel
{
    /**
     * The connection name for the model
     * 库链接的配置名
     *
     * @var string
     */
    protected $connection = 'cloud_core';

    /**
     * Table Name
     * 表名
     *
     * @var string
     */
    protected $table = 'regions';

    /**
     * 关闭创建和更新字段
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'pid',
        'capital',
        'pinyin',
        'level',
        'enable',
    ];

    protected $casts = ['enable' => 'boolean'];
}
