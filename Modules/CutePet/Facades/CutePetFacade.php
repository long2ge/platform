<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/22
 * Time: 17:09
 */

namespace Modules\CutePet\Facades;


use App\Repositories\CutePetUserRepository;
use App\Services\AuthorizationManageServer;
use App\Traits\InvokeTrait;
use Modules\CutePet\Logics\LoginLogic;
use Modules\CutePet\Services\LoginService;

class CutePetFacade
{
    use InvokeTrait;

    //发表评论
    public function CommentStore()
    {

    }

    //用户登录
    public function UserRegister($request,$username,$password)
    {
        $AuthorizationManageServer = new AuthorizationManageServer(new CutePetUserRepository());
        return $AuthorizationManageServer->login($request, $username,$password);
    }

    //用户注册
    public function UserLogin($request, $phone, $password)
    {
        $request = LoginLogic::requestWithParsedBodyByAdmin($request, $phone, $password);

        return app(LoginService::class)->password($request);
    }
}