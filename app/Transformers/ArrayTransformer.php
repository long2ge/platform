<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/2
 * Time: 12:15 PM
 */

namespace App\Transformers;

/**
 * 数组转化器
 * Class ArrayTransformer
 * @package App\Transformers
 */
class ArrayTransformer extends BaseTransformer
{
    /**
     * 转化方法
     * User: long
     * Date: 2020/5/2 12:12 PM
     * Describe:
     * @param mixed $data
     * @return array
     */
    function transform($data) : array
    {
        return is_array($data) ? $data : $data->toArray();
    }

}