<?php


namespace Modules\CutePet\Services;


class OpenServices
{
    /**图片储存处理
     * @param $userId  //用户ID
     * @param $picture //图片
     * @return array
     */
    public function pictureManage($userId,$picture)
    {
        $filename = $picture->getClientOriginalExtension();

        File::validatePictureFormat($filename);

        $path  = 'picture'.'/'.'userid'.$userId;

        $name = 'user_id_'.$userId.'.'.$userId.microtime(true).'.'.$filename;

        $picture->move(public_path($path),$name);

        $pathName  = ['path_name' => env('APP_URL') . '/picture'.'/'.'userid'.$userId.'/'.$name];

        return $pathName;
    }

    /**视频储存处理
     * @param $userId  //用户ID
     * @param $video //视频
     * @return array
     */
    public function videoManage($userId,$video)
    {
        $filename = $video->getClientOriginalExtension();

        File::validateVideoFormat($filename);

        $path  ='video'.'/'.'userid'.$userId;

        $name = 'user_id_'.$userId.'.'.$userId.microtime(true).'.'.$filename;

        $video->move(public_path($path),$name);

        $pathName  = ['path_name' => env('APP_URL') .$path.'/'.$name];

        return $pathName;
    }
}
