<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => 'admin',
    'namespace' => '\Modules\Admin\Http\Controllers\Api',
], function () {

    /*
    |--------------------------------------------------------------------------
    | Test route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Api/Test.php';

    /*
    |--------------------------------------------------------------------------
    | Test route
    |--------------------------------------------------------------------------
    */
    require __DIR__ . '/Api/Auth.php';

    // admin_api

    Route::group([
        'middleware' => 'auth:admin_api',
    ], function () {

        require __DIR__ . '/Api/User.php';

    });

});


