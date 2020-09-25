<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/9/25
 * Time: 16:05
 */

namespace App\Models\IndexConfigurator;


use ScoutElastic\IndexConfigurator;

/**
 * 创建索引的配置
 * php artisan elastic:create-index 'App\Models\IndexConfigurator\TestIndexConfigurator'
 *
 * Class TestIndexConfigurator
 * @package App\Models\IndexConfigurator
 */
class TestIndexConfigurator extends IndexConfigurator
{
    // It's not obligatory to determine name. By default it'll be a snaked class name without `IndexConfigurator` part.
    protected $name = 'test_index';

    // settings主要和索引的设置有关
    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'index' => [
            'number_of_shards' => 3,
            'number_of_replicas' => 2,
        ],
        'analysis' => [
            'analyzer' => [
                'es_test' => [
                    'type' => 'standard',
                ]
            ]
        ],
    ];
}