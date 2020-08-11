<?php

namespace App\Console\Commands;

use App\MyModel;
use App\MySearchRule;
use App\TestModel;
use Illuminate\Console\Command;

/**
 * 测试命令
 * Class TestCommand
 * @package App\Console\Commands
 */
class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test start';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        // 生成索引,建立映射

        // update an Elasticsearch type mapping
        // php artisan elastic:update-mapping "App\MyModel"  gen

//        $order->save();

        // 插入数据

        $myModel = new TestModel();

        $myModel->name = '呵呵 123';
        $a = $myModel->save();
        dd($a);
        // 搜索数据


//        $a = MyModel::search('task-status')->raw();

//        $data = MyModel::search('POST')
//            ->rule(MySearchRule::class)
//            ->get()->toArray();
//        dd($data);
//        $data = MyModel::searchRaw([
//            'query' => [
//                'bool' => [
//                    'must' => [
//                        'match' => [
//                            'request_method' => 'POST'
//                        ]
//                    ]
//                ]
//            ]
//        ]);

//        \DB::enableQueryLog();
//
//        $a = MyModel::search('POST')
////            ->within('tv_shows_popularity_desc')
//            ->paginate()
//            ->toArray();
//
//        dd(\DB::getQueryLog());
//        $bb = $myModel->searchable();

// You may also update via relationships...
//        $user->orders()->searchable();
//
//// You may also update via collections...
//        $orders->searchable();


//        $result = MyModel::search('Star Trek')->get()->toArray();

        // 更新数据
    }

}
