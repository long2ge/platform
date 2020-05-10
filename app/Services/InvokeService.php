<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/2
 * Time: 4:09 PM
 */

namespace App\Services;


use App\Traits\InvokeTrait;

/**
 * 调用服务
 * Class InvokeService
 * @package App\Services
 */
class InvokeService
{
    use InvokeTrait;

    /**
     * 获取后台门面
     * User: long
     * Date: 2020/5/2 5:38 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\Admin\Facades\AdminFacade
     */
    public function getAdminFacade()
    {
        return app('app.admin');
    }

    /**
     * 获取资讯门面
     * User: long
     * Date: 2020/5/3 10:36 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\News\Facades\NewsFacade
     */
    public function getNewsFacade()
    {
        return app('app.news');
    }

    /**
     * 获取车辆门面
     * User: long
     * Date: 2020/5/3 10:36 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\Car\Facades\CarFacade
     */
    public function getCarFacade()
    {
        return app('app.car');
    }

    /**
     * 获取消息中心门面
     * User: long
     * Date: 2020/5/3 10:37 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\MessageCenter\Facades\MessageCenterFacade
     */
    public function getMessageCenterFacade()
    {
        return app('app.messageCenter');
    }

    /**
     * 获取小程序门面
     * User: long
     * Date: 2020/5/3 10:37 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\MiniProgram\Facades\MiniProgramFacade
     */
    public function getMiniProgramFacade()
    {
        return app('app.miniProgram');
    }

    /**
     * 获取第三方门面
     * User: long
     * Date: 2020/5/3 10:37 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\OpenApi\Facades\OpenApiFacade
     */
    public function getOpenApiFacade()
    {
        return app('app.openApi');
    }

    /**
     * 获取订单门面
     * User: long
     * Date: 2020/5/3 10:37 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\Order\Facades\OrderFacade
     */
    public function getOrderFacade()
    {
        return app('app.order');
    }

    /**
     * 获取用户门面
     * User: long
     * Date: 2020/5/3 10:38 PM
     * Describe:
     * @return \Laravel\Lumen\Application|mixed|\Modules\User\Facades\UserFacade
     */
    public function getUserFacade()
    {
        return app('app.user');
    }

}