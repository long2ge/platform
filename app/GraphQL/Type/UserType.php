<?php

namespace App\GraphQL\Type;

use App\User;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name' => 'user',
        'description' => '用户',
        'model' => User::class
    ];

    /**
     * 定义返回的字段接口
     * @return array
     */
    public function fields() : array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => '用户id'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => '用户名'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => '用户的email'
            ],
            'job' => [
                'type' => Type::listOf(GraphQL::type('job')),
                'description' => '用户的工作字段'
            ]
        ];
    }

}