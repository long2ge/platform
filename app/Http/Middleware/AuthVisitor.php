<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/31
 * Time: 2:24 PM
 */

namespace App\Http\Middleware;


use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthVisitor extends Middleware
{

    protected function unauthenticated($request, array $guards)
    {
        // 游客不抛错
    }

//    public function handle($request, Closure $next)
//    {
//        // 如果头部传了令牌, 就检测登录
//        if ($request->hasHeader('authorization') === true) {
//            // 先检测是否已经登录
//            if (! Auth::check()) {
//                return route('login');
//            }
//        }
//
//        return $next($request);
//    }
}