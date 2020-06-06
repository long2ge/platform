<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/5/5
 * Time: 10:11 PM
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * 初始化命令
 * Class AppInitCommand
 * @package App\Console\Commands
 */
class AppInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'app init';

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
       $this->initAppDir();
    }

    /**
     * 初始化目录
     * User: long
     * Date: 2020/5/6 11:31 AM
     * Describe:
     */
    public function initAppDir()
    {
        // 生成系统目录
        foreach ([
            '/app/Docs',
        ] as $dir) {
            $this->createdDir(base_path($dir));
        }

        // 生成系统软链
        foreach ([
            // "/storage/public/" => "/public/storage",
         ] as $source => $target) {
            $this->createdSoftLink($source, $target);
        }

        // 生成Modules目录
        $moduleJsonPath = base_path('modules_statuses.json');
        if (file_exists($moduleJsonPath)) {
            $modules = json_decode(file_get_contents($moduleJsonPath), true) ?? [];

            foreach ($modules as $module => $status) {
                if (! $status) continue;

                $source = "/Modules/{$module}/Docs";
                $target = "/app/Docs/{$module}";
                $this->createdSoftLink($source, $target);
            }
        }

    }

    /**
     * 创建软链
     * User: long
     * Date: 2020/5/6 11:30 AM
     * Describe:
     * @param $source
     * @param $target
     */
    public function createdSoftLink($source, $target)
    {
        $base = base_path();
        $source = $base . $source;
        $target = $base . $target;

        $this->createdDir($source);

        // ln -s /home/vagrant/code/yq-dd/platform/Modules/Admin/Docs /home/vagrant/code/yq-dd/platform/app/Docs/Admin

        // 清理旧文件
        $command = "rm -rf $target";
        $this->info('command : ' . $command);
        $this->info(shell_exec($command));

        $command = "ln -s {$source} {$target}";
        // $command = "[ -d {$source} ] || ln -s {$source} {$target}";

        $this->info('command : ' . $command);
        $this->info(shell_exec($command));
    }

    /**
     * 创建目录
     * User: long
     * Date: 2020/5/6 11:30 AM
     * Describe:
     * @param $dirPath
     */
    public function createdDir($dirPath)
    {
        if (is_dir($dirPath)) return;

        $command = "[ -d {$dirPath} ] || mkdir -p {$dirPath}";
        $this->info(shell_exec($command));
    }

}