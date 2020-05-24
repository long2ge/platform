<?php
/**
 * Created by PhpStorm.
 * User: LONG
 * Date: 2019/4/11
 * Time: 0:43
 */

namespace Modules\User\Services;

use Modules\User\Exceptions\UserException;
use Modules\User\Models\ClassNeed;
use Modules\User\Models\Letter;
use Modules\User\Models\User;
use Modules\User\Models\UserContribute;
use Modules\User\Models\UserFans;
use Modules\User\Models\Visit;
use Modules\User\Repositories\UserRepository;

class UserService
{
    private function findUserById($userId)
    {
        $user = User::find($userId);

        return $user;
    }

    public function update($id, $parameters)
    {

//        'province_id' => 'int',
//            'city_id' => 'int',
//            'zone_id' => 'int',

        // 验证省市区，是否符合规范
        if (isset($parameters['province_id'])) {

        }

        $user = app(UserRepository::class)->find($id);

        $result = app(UserRepository::class)->update($id, $parameters);
        if (false === $result) {
            UserException::updateFault();
        }
    }

    //增加关注用户
    public function fans($fansUserId,$attentionUserId)
    {
        if (UserFans::where('fans_user_id',$fansUserId)
            ->where('attention_user_id',$attentionUserId)
            ->exists())
        {
            UserFans::where('fans_user_id',$fansUserId)
                ->where('attention_user_id',$attentionUserId)
                ->delete();
            return [0];
        }else{
            UserFans::create(['fans_user_id'=>$fansUserId,'attention_user_id'=>$attentionUserId]);
            return [1];
        }
    }
    /**
     * 访客
     */
    public function visitUser($visitId,$userId)
    {

        $this->visitRecord($visitId,$userId);

        return $this->findUserById($userId);
    }

    /**访客记录
     * @param $visitId
     * @param $userId
     */
    public function visitRecord($visitId,$userId)
    {

        Visit::create(['visit_user_id'=>$visitId,'user_id'=>$userId]);
    }

    /**
     * 查看近期访客
     */
    public function recentVisitUser($userId)
    {
        return Visit::where('user_id',$userId)
            ->with(['visitUser'=>function($query){
                $query->select('id','user_name');
            }])
            ->orderBy('created_at', 'desc')
            ->select('visit_user_id','user_id','created_at')
            ->limit(10)
            ->get()
            ->map(function($value) {
                $value->user_name = $value->visitUser->user_name;
                unset($value->visitUser,$value->user_id);
                return $value;
            });
    }
    /**
     * 发生私信
     */
    public function letter($letterData)
    {
        $Letter =Letter::create($letterData);
        if (!$Letter){
            abort(400,'发生失败，请检查网络');
        }
    }

    /**升级系统
     * @param $userId //用户Id
     */
    public function classNeed($userId)
    {
        $classNeeds = ClassNeed::query()->orderBy('class', 'desc')->get();

        $userContribute = UserContribute::where('user_id',$userId)->first();

        foreach ($classNeeds as $classNeed){
            if ($classNeed->post_sum <= $userContribute->post_sum
                && $classNeed->comment_sum <= $userContribute->comment_sum
                && $classNeed->enshrine_sum <= $userContribute->enshrine_sum
                && $classNeed->fans_sum <= $userContribute->fans_sum
                && $classNeed->idol_sum <= $userContribute->idol_sum) {
                if ($classNeed->class != $userContribute->class
                    && $classNeed->class >$userContribute->class){
                    $userContribute->class = $classNeed->class;
                    $userContribute->save();
                }
                    break;
            }
        }

    }
    /**
     * 用户增加贡献
     */
    public function userContribute($userId,$type,$sum)
    {
        if (UserContribute::where('user_id',$userId)->exists()){
            UserContribute::where('user_id',$userId)->increment($type,$sum);
        }else{
            UserContribute::create(['user_id'=>$userId]);
        }
        if ($sum >0 ){
            $this->classNeed($userId);
        }

    }
}
