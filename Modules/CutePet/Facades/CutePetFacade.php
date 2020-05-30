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

}