<?php
/**
 * Created by PhpStorm.
 * User: LONG
 * Date: 2019/4/11
 * Time: 0:38
 */

namespace Modules\User\Http\Controllers\V1\Info;

use Illuminate\Http\Request;
use Modules\User\Http\Controllers\BaseUserController;
use Modules\User\Services\UserService;

class UserController extends BaseUserController
{

    /**
     * @var UserService
     */
    private $userService;

    /**
     * 构造函数
     * UserService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 获取用户基本信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        return response()->json($request->user());
    }

    public function update(Request $request, $id)
    {
        $this->requestValidator($request, [
            'user_name' => 'string',
            'phone_number' => 'string',
            'email' => 'string',
            'password' => 'string',
            'profile' => 'string',
            'avatar' => 'string',
            'address' => 'string',
            'province_id' => 'int',
            'city_id' => 'int',
            'zone_id' => 'int',
            'sex' => 'int',
        ]);

        $parameters = $request->only([
            'user_name',
            'phone_number',
            'email',
            'password',
            'profile',
            'avatar',
            'address',
            'province_id',
            'city_id',
            'zone_id',
            'sex',
        ]);

        app(UserService::class)->update($id, $parameters);
    }

    /**关注用户
     * @param Request $request
     * @param $attentionUserId
     * @return array
     */
    public function fans(Request $request ,$attentionUserId)
    {
        $fansUserId = $request->user()->id;
        return app(UserService::class)->fans($fansUserId,$attentionUserId);
    }

    /**
     * 访问用户
     * @param Request $request
     * @param $userId
     * @return
     */
    public function visitUser(Request $request,$userId)
    {
        $visitId = $request->user()->id??null;

        return app(UserService::class)->visitUser($visitId,$userId);
    }

    /**
     * 查看最近访客
     *
     * @api               {get} /api/user/info/visit 查看最近访客
     * @apiSampleRequest         /api/user/info/visit
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by 609
     *
     * @apiGroup          User
     * @apiName           UserRecentVisitUser
     *
     * @apiUse            AuthJSONHeader
     *
     *
     * @apiSuccessExample  {json} 200 成功请求
     * [
     *     {
     *     "visit_user_id": 2,
     *     "created_at": "2020-01-27 09:46:55",
     *     "user_name": "2"
     *     }
     * ]
     * @param Request $request
     * @return
     */
    public function recentVisitUser(Request $request)
    {
        $userId = $request->user()->id;

        return app(UserService::class)->recentVisitUser($userId);
    }


    /**
     * 发生私信
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function letter(Request $request)
    {
        $this->validate($request,[
            'content'=>'required|string',
            'addressee_user_id'=>'required|numeric',
        ]);

        $letterData = $request->only(['content','addressee_user_id']);
        $letterData['sender_user_id'] = $request->user()->id;

        app(UserService::class)->letter($letterData);

        return response()->json([], 204);
    }
}
