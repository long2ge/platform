<?php

namespace App\Console\Commands;

use App\Models\TestModel;

use Illuminate\Console\Command;
use Phpml\Association\Apriori;

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

    /**
     * 机器学习 - 预测方法
     */
    public static function testPredict()
    {
        // https://php-ml.readthedocs.io/en/latest/machine-learning/association/apriori/
        $associator = new Apriori($support = 0.5, $confidence = 0.5);
        $samples = [
            ['alpha', 'beta', 'epsilon'], 
            ['alpha', 'beta', 'theta'], 
            ['alpha', 'beta', 'epsilon'], 
            ['alpha', 'beta', 'theta'],
        ];
        $labels  = [];
        $associator->train($samples, $labels);

        return $associator->predict(['alpha','theta']);;

    }


    public function handle()
    {
        // ES  demo
        // $a = TestModel::searchDemo();
        // dd($a);

        $data = self::testPredict();

        dd($data);
    }

}
