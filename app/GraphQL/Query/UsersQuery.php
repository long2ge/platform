<?php

namespace App\GraphQL\Query;

use Rebing\GraphQL\Support\Facades\GraphQL;
use App\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class UsersQuery extends Query
{
    protected $attributes = [
        'name' => 'users'
    ];

    public function type() : Type
    {
        return GraphQL::paginate('user');
    }

    /**
     * 接收参数的类型定义
     * @return array
     */
    public function args() : array
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::int()],
            'page' => ['name' => 'page', 'type' => Type::int()],
            'limit' => ['name' => 'limit', 'type' => Type::int()],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $info, Closure $getSelectFields)
    {
        $fields = $getSelectFields();

        return User::with($fields->getRelations())
            ->select($fields->getSelect())
            ->paginate($args['limit'], ['*'], 'page', $args['page']);
    }

}