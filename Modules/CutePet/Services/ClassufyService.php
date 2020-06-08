<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/6
 * Time: 17:39
 */

namespace Modules\CutePet\Services;


use Modules\CutePet\Models\Classify;
use Modules\CutePet\Models\User;

class ClassufyService
{
    /**
     * 板块列表
     */
    public function indexClassify()
    {
        return Classify::all();
    }

    /**
     * 分配帖子板块关联
     */
    public function allocationPost(User $user,$postId,$classifyId)
    {

    }


}