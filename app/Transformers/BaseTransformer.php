<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/2
 * Time: 12:07 PM
 */

namespace App\Transformers;


use League\Fractal\TransformerAbstract;

/**
 * 基础转化器
 * Class BaseTransformer
 * @package App\Transformers
 */
abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * @var array 返回数据
     */
    protected $data;

    /**
     * @var array 参数
     */
    protected $params;

    public function __construct($params = [])
    {
        $this->params = $params;
    }

    /**
     * 转化方法
     * User: long
     * Date: 2020/5/2 12:12 PM
     * Describe:
     * @param mixed $data
     * @return array
     */
    abstract function transform($data) : array;

    /**
     * 设置参数
     * User: long
     * Date: 2020/5/2 12:17 PM
     * Describe:
     * @param array $params
     * @return static
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

}