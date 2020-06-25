<?php

namespace Modules\CutePet\Services;

use Carbon\Carbon;
use Modules\CutePet\Models\User;
use Modules\CutePet\Models\UserEverydayTaskGoal;
use Modules\CutePet\Models\UserEverydayTaskIntegral;

class TaskService
{

    /**
     * @param \Illuminate\Database\Eloquent\Collection|static[] $task_integration
     */
    private $userEverydayTaskGoal;

    public function __construct()
    {
        //加分标准
        $this->userEverydayTaskGoal = UserEverydayTaskGoal::query();
        //操作记录表
        $this->userEverydayTaskIntegral = UserEverydayTaskIntegral::query();
    }

    /**
     * 用户任务记录
     * @return \Illuminate\Database\Eloquent\Collection|UserEverydayTaskGoal[]
     */
    public function userTaskRecord($user,$taskId)
    {
        $taskGoal = $this->userEverydayTaskGoal->where('id',$taskId)->first()->toArray();

        $userIntegral = $this->userEverydayTaskIntegral
            ->where('handle_task_id',$taskId)
            ->where('user_id',$user->id)
            ->where('created_at','like',  Carbon::now()->toDateString(). '%')
            ->first();


        if (null == $userIntegral){
        $userIntegral =  $this->userEverydayTaskIntegral->create([
                'user_id'=>$user->id,
                'handle_task_id'=>$taskId,
                'handle_task_sum'=>1,
            ]);
        }else{
            $userIntegral->handle_task_sum += 1;
            $userIntegral->save();
        }

        if (! $userIntegral->handle_task_sum > $taskGoal->upper_limit){
    //
        }


        dd($userIntegral);

    }


}
