<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/1
 * Time: 7:59 PM
 */

namespace App\Http\Controllers;

use App\Transformers\ArrayTransformer;
use Illuminate\Http\Request;

/**
 * Class TestController
 * Describe: https://laravel-apidoc-generator.readthedocs.io/en/latest/documenting.html#indicating-authentication-status
 * @package Modules\Admin\Http\Controllers\Api
 */
class TestController extends AppController
{
    public function test(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'nullable|string',
            'business_status' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'page_size' => 'int',
            'in_city' => 'integer',
            'parking_fee' => 'numeric|min:0',
            'service_items' => 'json|nullable',
        ]);

        $a = ['get test' => 2221];

        return $this->responseItem($a, new ArrayTransformer());
    }

    public function postTest(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'nullable|string',
            'business_status' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'page_size' => 'int',
            'longitude_and_latitude' => 'required|string',
            'in_city' => 'integer',
            'parking_fee' => 'numeric|min:0',
            'service_items' => 'json|nullable',
        ]);

        $attributes = $request->only([
            'keyword',
        ]);

        // 逻辑处理

        return $this->noContent();
    }
}