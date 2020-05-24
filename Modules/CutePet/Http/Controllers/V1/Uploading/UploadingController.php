<?php

namespace Modules\CutePet\Http\Controllers\V1\Uploading;


use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\BaseCoreController;
use Modules\Core\Services\OpenServices;

class UploadingController extends BaseCoreController
{
    public function cs()
    {
        dd(111111);
        dd('开始代码测试');
    }

    /**
     * 图片上传
     *
     * @api               {POST} /api/core/picture 图片上传
     * @apiSampleRequest         /api/core/picture
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          UploadingController
     * @apiName           UploadingControllerUploadingPictures
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {file} picture    图片文件
     * @apiParam {User} user   登录用户
     * @param Request $request
     * @return mixed
     * @apiSuccessExample  {json} 200 成功请求
     * {
     *      "path_name":"http:\/\/luntan.com\/picture\/userid1\/user_id_1.11579885055.9561.jpg"
     * }
     */
    public function uploadingPictures(Request $request)
    {
        $userId = 1;

        $picture = $request->file('picture');

        $path = app(OpenServices::class)->pictureManage($userId,$picture);

        return $path;
    }

    /**
     * 视频上传
     *
     * @api               {POST} /api/core/video 视频上传
     * @apiSampleRequest         /api/core/video
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 660099
     *
     * @apiGroup          UploadingController
     * @apiName           UploadingControllerUploadingVideo
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {file} video    视频文件
     * @apiParam {User} user   登录用户
     * @param Request $request
     * @return mixed
     * @apiSuccessExample  {json} 204 成功请求
     * {
     *      "path_name":"http:\/\/luntan.com\/picture\/userid1\/user_id_1.11579885055.9561.mp4"
     * }
     */
    public function uploadingVideo(Request $request)
    {
        $userId = 1;

        $video = $request->file('video');

        $path = app(OpenServices::class)->videoManage($userId,$video);

        return $path;
    }
}
