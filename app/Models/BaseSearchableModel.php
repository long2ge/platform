<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use ScoutElastic\Searchable;

class BaseSearchableModel extends Model
{

    use Searchable;
    // 强烈建议你配置一个 队列驱动，使用它运行一个队列来处理允许 Scout 将模型信息同步到搜索索引的所有操作，
    // 为你的应用的 web 接口提供更快的响应。一旦你配置了队列驱动程序，你的 config/scout.php 配置文件中 queue 选项的值要设置为 true





    public static function run()
    {

        // 增删改查
        $model = new static();

        // 更新 或者 创建
        $model->save();

        // 删除
        $model->delete();

        // 查询


        // 通过查询添加

        // 通过 Eloquent 查询构造器添加...
        // App\Order::where('price', '>', 100)->searchable();

        // 你也可以通过模型关系增加记录...
        // $user->orders()->searchable();

        // You may also update via collections...
        // 你也可以通过集合增加记录...
        // $orders->searchable();



        // 分页
        // $orders = App\Order::search('Star Trek')->paginate();
        // $orders = App\Order::search('Star Trek')->paginate(15);


        // 通过 Eloquent 查询删除...
        // App\Order::where('price', '>', 100)->unsearchable();

        // 你可以通过数据间的关系进行删除...
        // $user->orders()->unsearchable();

        // 你可以通过数据集合进行删除...
        // $orders->unsearchable();

    }


}
