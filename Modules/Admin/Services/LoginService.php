<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/12/9
 * Time: 7:33 PM
 */

namespace Modules\Admin\Services;


use Illuminate\Http\Response;
use Laravel\Passport\Http\Controllers\HandlesOAuthErrors;
use Modules\Admin\Models\AdminUser;
use Modules\Admin\Models\Jurisdiction;
use Modules\Admin\Models\User;
use Modules\Core\Services\AuthorizationManageServer;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response as Psr7Response;

/**
 * 登录服务
 * Class LoginService
 * @package Modules\Admin\Services
 */
class LoginService
{
    use HandlesOAuthErrors;

    /**
     * 退出登录
     * User: long
     * Date: 2019/9/8 1:39 AM
     * Describe:
     * @param AdminUser $user 用户模型
     */
    public function logout(AdminUser $user)
    {
        try {
            $user->token()->delete();
        } catch (\Exception $e) {
            abort(400, '退出登录失败!');
        }
    }

    /**
     * 密码登录方法
     * User: long
     * Date: 2019/9/7 1:43 AM
     * Describe:
     * @param ServerRequestInterface $request PSR-7 请求接口
     * @return Response
     */
    public function password(ServerRequestInterface $request)
    {
        return $this->withErrorHandling(function () use ($request) {
            $authorizationServer = app(AuthorizationManageServer::class)->getAdminUserAuthorizationServer();

            return $this->convertResponse(
                $authorizationServer->respondToAccessTokenRequest($request, new Psr7Response)
            );
        });
    }

    /**
     * 创建权限
     * @param array $data
     */
    public function addJurisdictions(array $data)
    {

        if (! isset($data['up_class_id']) || $data['up_class_id'] == '')
        {
            $data['up_class_id'] = 0;
            $data['class'] = 1;
        }else{
            $data['class'] = 2;
        }

        if ($data['up_class_id'] != 0 && !Jurisdiction::where('id',$data['up_class_id'])->exists()){
            abort(404,'设置上级ID组群不存在');
        }

        if (Jurisdiction::where('name',$data['name'])->exists()){
            abort(404,'设置的权限名字重复');
        }

        $add = Jurisdiction::create($data);
        if (!$add){
            abort(404,'设置失败');
        }

    }

    /**
     * 删除权限/或整个权限组群包括权限下的子类权限
     * @param int $id
     */
    public function deleteJurisdictions(int $id)
    {
        if (! Jurisdiction::where('id',$id)->exists()){
            abort(404,'权限ID不存在');
        }

        $delete = Jurisdiction::where('id',$id)
            ->orwhere('up_class_id',$id)
            ->delete();
        if ($delete < 1){
            abort(404,'删除失败');
        }
    }

    /**
     * 修改权限
     * @param array $data
     */
    public function putJurisdictions(array $data)
    {
        foreach ($data as $key=>$v){
            if ($v == ''){
                unset($data[$key]);
            }
        }

        if (! Jurisdiction::where('id',$data['id'])->exists()){
            abort(404,'id不存在');
        }

        Jurisdiction::where('id',$data['id'])->update($data);
    }

    /**
     * 权限详情
     * @param $id
     * @return mixed
     */
    public function showJurisdictions($id)
    {
        $jurisdiction = Jurisdiction::where('id',$id)->first();
        if (!$jurisdiction){
            abort(404,'数据不存在');
        }
        return $jurisdiction;
    }


    /**
     * 权限列表（数组）
     * @return array
     *
     */
    public function indexJurisdictions()
    {
        $jurisdictions = Jurisdiction::query()->orderBy('class','desc')->get();

        $one = [];
        $two = [];
        foreach ($jurisdictions as &$v)
        {
            if ($v['class'] == 2){
                $two[$v['up_class_id']][] = $v;
            }

            if ($v['class'] == 1){
                $v['two'] = $two[$v['id']]??[];
                $one[] = $v;
            }
        }

        return $one;
    }

    /**
     * 设置用户权限
     * @param $userId
     * @param $json
     */
    public function setJurisdictions($userId,$json)
    {
        $data = json_decode($json, true);

        $jurisdictions = [];
        foreach ($data as $v){
            if (count($v['two']) == 0){
                continue;
            }
            $jurisdictions = array_merge($jurisdictions,$v['two']);
        }

        $ids = '';
        foreach ($jurisdictions as $jurisdiction){
            $ids = $ids.','.$jurisdiction['id'];
        }

        $ids = trim($ids,',');

        $user = User::where('id',$userId)
            ->update(['jurisdictions_ids'=>$ids]);

        if (!User::where('id',$userId)->exists()){
            abort(404,'用户不存在');
        }

        if (!$user){
            abort(404,'设置失败，请稍后重试');
        }

    }

    public function userJurisdictions($user,$id)
    {

        if ($id ==null){
            $id = $user->id;
        }

        $jurisdictionsIds = User::where('id',$id)->first()->jurisdictions_ids;
        $jurisdictionsIdsArray = explode(',',$jurisdictionsIds);
        $jurisdictions = Jurisdiction::whereIn('id',$jurisdictionsIdsArray)->orwhere('class',1)->orderBy('class','desc')->get();
        $two = [];
        $one = [];
        foreach ($jurisdictions as $jurisdiction){
            if ($jurisdiction->class ==2){
                $two[$jurisdiction->up_class_id][] = $jurisdiction;
            }

            if ($jurisdiction->class ==1 && isset($two[$jurisdiction->id])){
                $jurisdiction->tow = $two[$jurisdiction->id];
                $one[] = $jurisdiction;
            }
        }
        return $one;
    }


















}
