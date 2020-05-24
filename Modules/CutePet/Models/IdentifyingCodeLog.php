<?php

namespace Modules\Core\Models;

use Carbon\Carbon;

/**
 * Class IdentifyingCodeLog
 * @package Modules\Core\Models
 */
class IdentifyingCodeLog extends BaseModel
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
    protected $table = 'identifying_code_logs';

    /**
     * 关闭updated_at字段
     */
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_number',
        'code',
        'content',
        'business_type',
        'source',
    ];

    /**
     * 查询某天的短信数量
     * User: long
     * Date: 2019/4/6 8:59 PM
     * Describe:
     * @param string $phoneNumber 手机号码
     * @return mixed
     */
    public function hasCodeCountByDate($phoneNumber)
    {
        return $this
            ->where('phone_number', $phoneNumber)
            ->whereDate('created_at', Carbon::now()->toDateString())
            ->count();
    }
}
