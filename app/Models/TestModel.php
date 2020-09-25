<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/25
 * Time: 15:23
 */

namespace App\Models;


use App\Models\IndexConfigurator\TestIndexConfigurator;
use ScoutElastic\Searchable;

// php artisan elastic:update-mapping "App\Models\TestModel"
class TestModel extends BaseSearchableModel
{
    protected $table = 'bag_help';

    // ES索引信息（库）
    protected $indexConfigurator = TestIndexConfigurator::class;

    // -- 搜索规则
    protected $searchRules = [
        //
    ];

    // 字段类型和字段配置 -- mappings是用来描述数据结构的文件
    // Here you can specify a mapping for model fields
    protected $mapping = [
        'properties' => [
            'content' => [
                'type' => 'text',
                'store' => false,
                'index' => false,
                // Also you can configure multi-fields, more details you can find here https://www.elastic.co/guide/en/elasticsearch/reference/current/multi-fields.html
            ],
        ]
    ];

    // 更新单条数据例子
    public static function updateOneDemo()
    {
        $myModel = TestModel::find(1);
        if (! $myModel) {
            $myModel = new TestModel();
        }
        $myModel->content = '234';

        $a = $myModel->save();
    }

    // 搜索例子
    public static function searchDemo()
    {
        return TestModel::search('2')->paginate()->toArray();
    }

    public function demo()
    {
        TestModel::search('phone')
            // specify columns to select
            ->select(['title', 'price'])
            // filter
            ->where('color', 'red')
            // sort
            ->orderBy('price', 'asc')
            // collapse by field
            ->collapse('brand')
            // set offset
            ->from(0)
            // set limit
            ->take(10)
            // get results
            ->get();

        TestModel::searchRaw([
            'query' => [
                'bool' => [
                    'must' => [
                        'match' => [
                            'request_method' => 'POST'
                        ]
                    ]
                ]
            ]
        ])
        ->get();
    }
}