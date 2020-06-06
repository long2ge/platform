<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
        $path = 'test/file';

        $bbb = Storage::putFile($path, public_path('111.png'));

        //Storage::put()
        /**
         *
         *
         * https://cute-pet-images.oss-cn-shenzhen.aliyuncs.com
         * https://oss-cn-shenzhen.aliyuncs.com/test/file/file.png/gchDsEVawVtFKByBBs38luvbtUiPqXCzfGZZgGMp.png
         * https://cute-pet-images.oss-cn-shenzhen.aliyuncs.com/test/file/file.png/gchDsEVawVtFKByBBs38luvbtUiPqXCzfGZZgGMp.png
         * https://oss-cn-shenzhen.aliyuncs.com/test/file/file.png/gchDsEVawVtFKByBBs38luvbtUiPqXCzfGZZgGMp.png?Expires=1591414968&OSSAccessKeyId=TMP.3Kfv2jURMz6DpWNZg9K4q3UhDuM6FFmDYgUZRM1qFcqjQNgrByxGHPHzD6TyvyZAKsX13uYVaioZTGpBu8LfzzyzvQU9k9&Signature=szjOpI9KKto9IE4UNhre6MiwoZk%3D
         * https://cute-pet-images.oss-cn-shenzhen.aliyuncs.com/test/file/file.png/gchDsEVawVtFKByBBs38luvbtUiPqXCzfGZZgGMp.png?Expires=1591414968&OSSAccessKeyId=TMP.3Kfv2jURMz6DpWNZg9K4q3UhDuM6FFmDYgUZRM1qFcqjQNgrByxGHPHzD6TyvyZAKsX13uYVaioZTGpBu8LfzzyzvQU9k9&Signature=szjOpI9KKto9IE4UNhre6MiwoZk%3D
         */
        $aaa = Storage::url($bbb);
//
        dd($path, $aaa, $bbb);
    }

}
