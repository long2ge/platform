<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/6/13
 * Time: 20:56
 */

namespace Modules\CutePet\Http\Controllers\V1\imageUpload;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\CutePet\Http\Controllers\CutePetController;

class imageUploadController extends CutePetController
{
    /**
     * 图片上传
     * @param Request $request
     */
        public function imageUpload(Request $request)
        {
            //$userId = $request->user()->id;
            $picture = $request->file('picture');
            //$path = 'test/file/user/'.$userId;
            $path = 'test/file';

            //上传图片,获取图片相对路径
            $putFile = Storage::putFile($path,$picture);
            //给相对路径增加域名
            $url = Storage::url($putFile);

            return response()->json(['url'=>$url]);
        }
}