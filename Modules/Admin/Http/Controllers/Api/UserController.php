<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/10
 * Time: 4:33 PM
 */

namespace Modules\Admin\Http\Controllers\Api;


use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\AdminAppController;

class UserController extends AdminAppController
{
    public function show(Request $request, int $id)
    {
        return $request->user();
    }

    /**
     * 退出登陆
     * User: long
     * Date: 2020/5/10 3:17 PM
     * Describe:
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        $request->user()->logout();

        return response()->noContent();
    }
}