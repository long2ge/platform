<?php

namespace App\GraphQL\Query;

use Rebing\GraphQL\Support\Facades\GraphQL;
use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UserQuery extends Query
{
    protected $attributes = [
        'name' => 'user'
    ];

    public function type() : Type
    {
        return Type::listOf(GraphQL::type('user'));
    }

    /**
     * 接收参数的类型定义
     * @return array
     */
    public function args() : array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'email' => ['name' => 'email', 'type' => Type::string()],
            'limit' => ['name' => 'limit', 'type' => Type::int()],
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
        $user = new User;

        if(isset($args['limit']) ) {
            $user =  $user->limit($args['limit']);
        }

        if(isset($args['id']))
        {
            $user = $user->where('id' , $args['id']);
        }

        if(isset($args['email']))
        {
            $user = $user->where('email', $args['email']);
        }

        return $user->get();
    }
}