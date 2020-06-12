<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/6
 * Time: 17:37
 */

namespace Modules\CutePet\Http\Controllers\V1\Post;


use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\CutePet\Services\ClassufyService;

class ClassifyController extends CutePetController
{
    /**
     * 板块列表
     */
    public function indexClassify()
    {
        return response()->json(['data'=>app(ClassufyService::class)->indexClassify()]);
    }


}