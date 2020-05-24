<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/9/7
 * Time: 1:03 AM
 */

namespace Modules\Admin\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\BaseAdminController;
use Modules\Admin\Services\LoginService;
use Modules\Core\Logics\LoginLogic;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 登录控制器
 * Class LoginController
 * @package App\Http\Controllers\User\Auth
 */
class LoginController extends BaseAdminController
{
    /**
     * 密码登录
     *
     * @api               {POST} /api/admin/user/login 密码登录
     * @apiSampleRequest  /api/admin/user/login
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginPhone
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {String} username 账号
     * @apiParam {String} password 密码
     *
     * @apiSuccessExample  {json} 200 成功请求
     *  {
     *      "token_type": "Bearer", token的类型
     *      "expires_in": 1295999, 有效时间（秒)）
     *      "access_token": "123456", 请求token
     *      "refresh_token": "123456" 刷新token
     *  }
     *
     * @apiUse            RestfulError
     * @param ServerRequestInterface $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(ServerRequestInterface $request)
    {
        $attributes = (array) $request->getParsedBody();
        $attributes = [
            'username' => $attributes['username'] ?? null,
            'password' => $attributes['password'] ?? null,
        ];

        $this->validateArray($attributes, [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $request = LoginLogic::requestWithParsedBodyByAdmin($request, $attributes['username'], $attributes['password']);

        return app(LoginService::class)->password($request);
    }

    /**
     * 注册
     *
     * @api               {POST} /api/admin/user/register 注册
     * @apiSampleRequest  /api/admin/user/register
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginRegister
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiParam {String} phone 手机号码
     * @apiParam {String} password 密码
     *
     * @apiSuccessExample  {json} 200 成功请求
     *  {
     *      "token_type": "Bearer", token的类型
     *      "expires_in": 1295999, 有效时间（秒)）
     *      "access_token": "123456", 请求token
     *      "refresh_token": "123456" 刷新token
     *  }
     *
     * @apiUse            RestfulError
     * @param ServerRequestInterface $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(ServerRequestInterface $request)
    {
        $attributes = (array) $request->getParsedBody();
        $attributes = [
            'phone' => $attributes['phone'] ?? null,
            'password' => $attributes['password'] ?? null,
        ];

        $this->validateArray($attributes, [
            'phone' => 'required|string',
            'password' => 'required|string'
        ]);

        $request = LoginLogic::requestWithParsedBodyByAdmin($request, $attributes['phone'], $attributes['password']);

        //app(AdminUserService::class)->register($attributes);

        return app(LoginService::class)->password($request);
    }

    /**
     * 退出登录
     *
     * @api               {DELETE} /api/admin/user/logout 退出登录
     * @apiSampleRequest  /api/admin/user/logout
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginLogout
     *
     * @apiUse            AuthJSONHeader
     *
     * @apiSuccessExample  {json} 204 成功请求
     *  {
     *  }
     *
     * @apiUse            RestfulError
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        app(LoginService::class)->logout($request->user());

        return response()->noContent();
    }

    /**
     * 创建权限
     *
     * @api               {POST} /api/admin/jurisdictions 创建权限
     * @apiSampleRequest  /api/admin/jurisdictions
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginAddJurisdictions
     * @apiUse            AuthJSONHeader
     * @apiParam {string} name  名字             必填
     * @apiParam {Integer} class 等级            选填 默认为 1级 只可选1或者2
     * @apiParam {Integer} up_class_id  上级ID   选填 新建组群传 默认为0级
     *
     * @apiSuccessExample  {json} 200 成功请求
     *  {
     *  }
     *
     * @apiUse            RestfulError
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addJurisdictions(Request $request)
    {
        $this->validate($request,[
            'name'=>'required||string',
            'class'=>'nullable||int',
            'up_class_id'=>'nullable||int',
        ]);

        $data = $request->only([
            'name',
            'class',
            'up_class_id',
        ]);

        app(LoginService::class)->addJurisdictions($data);

        return response()->noContent();

    }

    /**
     * 删除权限/或整个权限组群包括权限下的子类权限
     *
     * @api               {delete} /api/admin/jurisdictions/{id} 删除权限
     * @apiSampleRequest  /api/admin/jurisdictions/1
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginDeleteJurisdictions
     * @apiUse            AuthJSONHeader
     * @apiParam {int} id       必填
     * @apiSuccessExample  {json} 204 成功请求
     *  {
     *  }
     *
     * @apiUse            RestfulError
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function deleteJurisdictions(int $id)
    {
        app(LoginService::class)->deleteJurisdictions($id);

        return response()->noContent();
    }

    /**
     * 修改权限
     * @api               {put} /api/admin/jurisdictions 删除权限
     * @apiSampleRequest  /api/admin/jurisdictions
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginPutJurisdictions
     * @apiUse            AuthJSONHeader
     * @apiParam {int} id       必填
     * @apiParam {string} name  名字             选填
     * @apiParam {Integer} class 等级            选填
     * @apiParam {Integer} up_class_id  上级ID   选填
     * @apiSuccessExample  {json} 204 成功请求
     *  {
     *  }
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function putJurisdictions(Request $request)
    {

        $this->validate($request,[
            'id'=>'required||int',
            'name'=>'nullable||string',
            'class'=>'nullable||int',
            'up_class_id'=>'nullable||int',
        ]);

        $data = $request->only([
            'id',
            'name',
            'class',
            'up_class_id',
        ]);

        app(LoginService::class)->putJurisdictions($data);

        return response()->noContent();
    }

    /**
     * 权限详情
     * @api               {get} /api/admin/jurisdictions/{id} 权限详情
     * @apiSampleRequest  /api/admin/jurisdictions/15
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginShowJurisdictions
     * @apiUse            AuthJSONHeader
     * @apiParam {int} id       必填
     *
     * @apiSuccessExample  {json} 204 成功请求
     *  {
     *  "id": 15,
     *  "name": "12313",
     *  "class": 1,
     *  "up_class_id": 0,
     *  "created_at": "2020-03-01 06:19:27",
     *  "updated_at": "2020-03-01 06:31:31",
     *  "deleted_at": null
     *  }
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function showJurisdictions($id)
    {
        $data = app(LoginService::class)->showJurisdictions($id);
        return $data;
    }

    /**
     * 权限列表
     * @api               {get} /api/admin/jurisdictions 权限列表
     * @apiSampleRequest  /api/admin/jurisdictions
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginIndexJurisdictions
     * @apiUse            AuthJSONHeader
     *
     * @apiSuccessExample  {json} 204 成功请求
     *[
     *{
     *"id": 15,
     * "name": "12313",
     * "class": 1,
     * "up_class_id": 0,
     * "created_at": "2020-03-01 06:19:27",
     * "updated_at": "2020-03-01 06:31:31",
     * "deleted_at": null,
     * "two": [
     *    {
     *    "id": 11,
     *    "name": "123",
     *    "class": 2,
     *    "up_class_id": 15,
     *    "created_at": null,
     *    "updated_at": null,
     *    "deleted_at": null
     *    },
     *    {
     *    "id": 18,
     *    "name": "1组下的第一个元素",
     *    "class": 2,
     *    "up_class_id": 15,
     *    "created_at": "2020-03-01 06:19:58",
     *    "updated_at": "2020-03-01 06:19:58",
     *    "deleted_at": null
     *    }
     *    ]
     * },
     * {
     * "id": 16,
     * "name": "2组",
     * "class": 1,
     * "up_class_id": 0,
     * "created_at": "2020-03-01 06:19:30",
     * "updated_at": "2020-03-01 06:19:30",
     * "deleted_at": null,
     * "two": []
     * },
     * {
     * "id": 17,
     * "name": "3组",
     * "class": 1,
     * "up_class_id": 0,
     * "created_at": "2020-03-01 06:19:33",
     * "updated_at": "2020-03-01 06:19:33",
     * "deleted_at": null,
     * "two": []
     * }
     * ]
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function indexJurisdictions()
    {
        return app(LoginService::class)->indexJurisdictions();
    }

    /**
     * 设置用户权限
     * @api               {post} /api/admin/jurisdictions/user 设置用户权限
     * @apiSampleRequest  /api/admin/jurisdictions/user
     * @apiVersion 1.0.0
     * @apiDescription
     * developed by long2ge
     *
     * @apiGroup          Login
     * @apiName           LoginSetJurisdictions
     * @apiUse            AuthJSONHeader
     *
     * @apiSuccessExample  {json} 204 成功请求
     * @param Request $request
     * {
     * }
     */
    public function setJurisdictions(Request $request)
    {
        $js_array = $request->input('js_array');
        $userId = $request->input('user_id');

        app(LoginService::class)->setJurisdictions($userId,$js_array);
    }

    /**
     * @param Request $request
     * @param $id
     * @return array[
    {
    "id": 15,
    "name": "12313",
    "class": 1,
    "up_class_id": 0,
    "created_at": "2020-03-01 06:19:27",
    "updated_at": "2020-03-01 06:31:31",
    "deleted_at": null,
    "tow": [
    {
    "id": 11,
    "name": "123",
    "class": 2,
    "up_class_id": 15,
    "created_at": null,
    "updated_at": null,
    "deleted_at": null
    },
    {
    "id": 18,
    "name": "1组下的第一个元素",
    "class": 2,
    "up_class_id": 15,
    "created_at": "2020-03-01 06:19:58",
    "updated_at": "2020-03-01 06:19:58",
    "deleted_at": null
    }
    ]
    }
    ]
     */
    public function userJurisdictions(Request $request ,$id)
    {
        $user = $request->user();
        $data = app(LoginService::class)->userJurisdictions($user,$id);
        return $data;
    }
}
