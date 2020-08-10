<?php

namespace App\Console\Commands;

use App\MyModel;
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

//        $myModel = new MyModel();
//        $myModel->title = '哈哈哈，呵呵';
//        $myModel->name = '呵呵 123';
//        $myModel->save();
        // 搜索数据


        $result = MyModel::search('Star Trek')->get();
dd($result);
        // 更新数据
    }

}
