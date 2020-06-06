<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/6
 * Time: 17:39
 */

namespace Modules\CutePet\Services;


use Modules\CutePet\Models\Classify;

class ClassufyService
{
        /**
         * 板块列表
         */
        public function indexClassify()
    {
        return Classify::all();
    }

}