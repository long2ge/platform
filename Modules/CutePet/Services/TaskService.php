<?php


use Carbon\Carbon;

class TaskService
{

    /**
     * 普通升级条件 常量
     */
    const GENERAL_CLASS = [
        '1V'=>['post_sum'=>'1','comment_sum'=>'1'],//1V需要做的任务，完成后，在CLASS_RANK['1V'] 获得新等级
        '2V'=>['post_sum'=>'5','comment_sum'=>'5'],
        '3V'=>['post_sum'=>'10','comment_sum'=>'10'],
        '4V'=>['post_sum'=>'15','comment_sum'=>'15'],
        '5V'=>['post_sum'=>'20','comment_sum'=>'20'],
    ];


    /**
     * 等级名称升级顺序
     */
    const CLASS_RANK = [
        '1V'=>'2V',//获得新等级后，查看MAINTAIN_AUTHORITY['V2']是否存在保级任务，和时间限制
        '2V'=>'3V',
        '3V'=>'4V',
        '4V'=>'5V',
        '5V'=>'6V',
    ];

    /**
     * 是否存在保级任务,和保级时间
     */
    //maintain_authority_class保级任务是否存在写入用户资料/authority_finish保级时间 !=0 写入保级时间
    //存在保级状态1，则开始记录保级任务数据；
    const MAINTAIN_AUTHORITY = [
        '1V'=>['maintain_authority_class'=>'0','authority_finish'=>'0',],
        '2V'=>['maintain_authority_class'=>'0','authority_finish'=>'0',],
        '3V'=>['maintain_authority_class'=>'0','authority_finish'=>'0',],
        '4V'=>['maintain_authority_class'=>'0','authority_finish'=>'0',],
        '5V'=>['maintain_authority_class'=>'1','authority_finish'=>'90',],
        '6V'=>['maintain_authority_class'=>'1','authority_finish'=>'90',],
    ];
    /**
     * 保级任务列表
     */
    //完成保级任务，增加保级时长/刷新时长，
    const MAINTAIN_CLASS = [
        '1V'=>['post_sum'=>'1','comment_sum'=>'1','date'=>'90'],
        '2V'=>['post_sum'=>'5','comment_sum'=>'5','date'=>'90'],
        '3V'=>['post_sum'=>'10','comment_sum'=>'10','date'=>'90'],
        '4V'=>['post_sum'=>'15','comment_sum'=>'15','date'=>'90'],
        '5V'=>['post_sum'=>'20','comment_sum'=>'20','date'=>'90'],
    ];

    /**
     * 权益下降流程
     */
    //根据保级时间是否存在，查看是否已经过期,过期后更改对应流程
    const AUTHORITY_DECLINE = [
        'V1'=>'V1',
        'V2'=>'V2',
        'V3'=>'V3',
        'V4'=>'V4',
        'V5'=>'V4',
        'V6'=>'V4',
    ];



    /**
     * 等级权益项目
     */
    const AUTHORITY_ITEM = [
        'V1'=>['a'=>0,'b'=>0,'c'=>0,'d'=>0,'e'=>1,],
        'v2'=>['a'=>0,'b'=>0,'c'=>0,'d'=>1,'e'=>1,],
        'v3'=>['a'=>0,'b'=>0,'c'=>1,'d'=>1,'e'=>1,],
        'v4'=>['a'=>0,'b'=>1,'c'=>1,'d'=>1,'e'=>1,],
        'v5'=>['a'=>1,'b'=>1,'c'=>1,'d'=>1,'e'=>1,],
        'v6'=>['a'=>1,'b'=>1,'c'=>1,'d'=>1,'e'=>1,],
    ];


    /**
     * 普通升级接口
     */
    public static function generalClass($user)
    {
        if (isset(self::GENERAL_CLASS[$user->class])) return;
        if (
            self::GENERAL_CLASS[$user->class]['post_sum'] <= $user->post_sum
            && self::GENERAL_CLASS[$user->class]['comment_sum'] <= $user->comment_sum
        ){
            $user->class = self::CLASS_RANK[$user->class];//升级后等级
            $user->authority_class = self::CLASS_RANK[$user->class];//升级后权益
            $user->maintain_authority_class = self::MAINTAIN_AUTHORITY[$user->class]['maintain_authority_class'];
            $user->authority_finish = self::MAINTAIN_AUTHORITY[$user->class]['authority_finish'] == 0?
                null:Carbon::now()->toDateString()->addDays(self::MAINTAIN_AUTHORITY[$user->class]['authority_finish']);
            $user->maintain_post_sum = 0;
            $user->maintain_comment_sum = 0;
            $user->save();
        }
    }

    /**
     *保级任务接口
     */
    public static function maintainClass($user)
    {
        if ($user->maintain_authority_class == 0)return;
        if (self::MAINTAIN_CLASS[$user->class]['post_sum'] >= $user->maintain_post_sum
            && self::MAINTAIN_CLASS[$user->class]['comment_sum'] >= $user->maintain_comment_sum
        ){
            $user->authority_finish = Carbon::now()->toDateString()->addDays(self::MAINTAIN_CLASS[$user->class]['date']);
            $user->maintain_post_sum = 0;
            $user->maintain_comment_sum = 0;
            $user->save();
        }
    }

    /**
     * 权益到期时间
     */
    public static function authorityDecline($user)
    {
        if ($user->maintain_authority_class == 0)return;
        if ($user->authority_class != $user->class)return;
        if ($user->authority_finish < Carbon::now()->toDateString()){
            $user->authority_class = self::AUTHORITY_DECLINE[$user->class];
            $user->save();
        }

    }

    /**
     * 获取权益项
     */
    public static function authorityItem($user)
    {
        return self::AUTHORITY_ITEM[$user->authority_class];
    }

    /**
     * 权益任务记录
     */
    public static function maintainClassData($user,$name)
    {
        $user->maintain_comment_sum = $name == 'maintain_comment_sum'? $user->maintain_comment_sum + 1: $user->maintain_comment_sum;
        $user->maintain_post_sum = $name == 'maintain_post_sum'? $user->maintain_post_sum + 1: $user->maintain_post_sum;
        $user->save();
        self::maintainClass($user);
    }

}
