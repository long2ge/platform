<?php
/**
 * Created by PhpStorm.
 * User: LONG
 * Date: 2019/4/11
 * Time: 0:43
 */

namespace Modules\CutePet\Services;

use Modules\User\Exceptions\UserException;


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




}
