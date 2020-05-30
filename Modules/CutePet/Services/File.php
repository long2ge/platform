<?php


namespace Modules\CutePet\Services;



class File
{
    //图片上传格式
    const PICTURE_FORMAT = [
        'jpg',
        'bmp',
        'pcx',
        'png',
        'jpeg',
        'gif',
        'tiff',
        'dxf',
        'cgm'
    ];

    const VIDEO_FORMAT = [
        'avi',
        'mov',
        'rmvb',
        'rm',
        'flv',
        'mp4',
        '3gp',
    ];

    /**验证图片格式
     * @param $pictureSuffix
     */
    public static function validatePictureFormat($pictureSuffix)
    {

        if (!in_array(strtolower($pictureSuffix),self::PICTURE_FORMAT)){
            $formats = '';
            foreach(self::PICTURE_FORMAT as $v){
                $formats = $formats.$v.',';
            }
            abort(400,'图片只支持'.$formats.'格式');
        }

    }

    /**验证视频格式
     * @param $pictureSuffix
     */
    public static function validateVideoFormat($pictureSuffix)
    {
        if (!in_array(strtolower($pictureSuffix),self::VIDEO_FORMAT)){
            $formats = '';
            foreach(self::VIDEO_FORMAT as $v){
                $formats = $formats.$v.',';
            }
            abort(400,'视频只支持'.$formats.'格式');
        }
    }

}
