<?php

namespace App\GraphQL\Query;

use App\Job;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class JobQuery extends Query
{
    protected $attributes = [
        'name' => 'job'
    ];

    public function type() : Type
    {
        return Type::listOf(GraphQL::type('job'));
    }

    /**
     * 接收参数的类型定义
     * @return array
     */
    public function args() : array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'name' => ['name' => 'name', 'type' => Type::string()],
        ];
    }

    /**
     * @param $root
     * @param $args 传入参数
     *
     * 处理请求的逻辑
     * @return mixed
     */
    public function resolve($root, $args)
    {
        $job = new Job();

        if(isset($args['id']))
        {
            $job = $job->where('id' , $args['id']);
        }

        return $job->get();
    }
}