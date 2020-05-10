<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Repositories\UserRepository;
use App\Services\AuthorizationManageServer;
use Psr\Http\Message\ServerRequestInterface;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| login demo
|--------------------------------------------------------------------------
*/
$router->get('/login/demo', function (ServerRequestInterface $request) {
    $AuthorizationManageServer = new AuthorizationManageServer(new UserRepository());
    return $AuthorizationManageServer->login(
        $request, UserRepository::DEMO_NAME, UserRepository::DEMO_PASSWORD);
    }
);