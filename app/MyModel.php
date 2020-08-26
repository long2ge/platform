<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ScoutElastic\Searchable;

class MyModel extends Model
{
    use Searchable;

    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'server_name',
        'time_local',
        'remote_user',
        'http_referer',
        'upstream_addr',
        'uri',
        'http_user_agent',
        'request_method',
        'request_uri',
        'route',
        'request_uuid',
        'server_protocol',
        'test_id',
    ];

    /**
     * @var string
     */
    protected $indexConfigurator = MyIndexConfigurator::class;

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
//    public function getScoutKey()
//    {
//        return $this->email;
//    }

    /**
     * Get the key name used to index the model.
     *
     * @return mixed
     */
    public function getScoutKeyName()
    {
        return 'test_id';
    }

    /**
     * @var array
     */
    protected $searchRules = [
        //
    ];

    /**
     * @var array
     */
    protected $mapping = [
        'properties' => [
//            'title' => [
//                'type' => 'text',
//                // Also you can configure multi-fields, more details you can find here https://www.elastic.co/guide/en/elasticsearch/reference/current/multi-fields.html
//                'fields' => [
//                    'raw' => [
//                        'type' => 'keyword',
//                    ]
//                ]
//            ],
        ]
    ];

    // 定义es的库的字段
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'route'=> $this->route,
            'request_method' => $this->request_method,
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }

    public function testUpdateEs()
    {
        // 方式 1  只要更新成功，都会调用es,的更新操作。
//        $myModel = MyModel::where('id', 1)->first();
//        $myModel->server_name = 'bbb';
//        $myModel->save();

        // 方式2 删除
//        $myModel = MyModel::where('id', 1)->first();
//        $myModel->delete();

        // 方式3 删除es中id是2，3，4的文档，mysql没有影响 mysql没有的话，es有也不处理。
        // MyModel::whereIn('id', [2,3,4])->unsearchable();

        // 方式4 增加es中id是2，3，4的文档，mysql没有影响, mysql没有的话，es有也不处理。
//        MyModel::whereIn('id', [2,3,4])->searchable();

        // MyModel->where()->update() 和 MyModel->where()->delete() 不会更新
    }


    public function testQuery()
    {
        // 1  搜索（ES）文档里面的内容
        MyModel::search('task-status')->raw();

        // Pausing Indexing    暂时索引
        MyModel::withoutSyncingToSearch(function () {
            // 这里面的操作，不会同步到es
        });

        // 2 根据（ES的数据）搜索出（MYSQL）文档 里面的内容
        MyModel::search('POST')->get();

        // 详细情况
        MyModel::search('POST')
            // specify columns to select
            ->select(['*'])
            // filter
            ->where('route', '1')
            // sort
            ->orderBy('request_method', 'asc')
            // collapse by field
            ->collapse('request_method')
            // set offset
            ->from(0)
            // set limit
            ->take(10)
            // get results
            ->get();


        // 执行原生语句
        MyModel::searchRaw([
            'query' => [
                'bool' => [
                    'must' => [
                        'match' => [
                            'request_method' => 'POST'
                        ]
                    ]
                ]
            ]
        ]);

        //

        MyModel::search('POST')
            ->rule(MySearchRule::class)
            ->get()->toArray();

        MyModel::onlyTrashed();

    }

     // php artisan scout:import "App\MyModel"

}
