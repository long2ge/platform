<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * app更新命令
 * Class AppUpdateCommand
 * @package App\Console\Commands
 */
class AppUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'app update';

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
        $commands = [
            'php artisan l5-swagger:generate' => 1,
            'php artisan ide-helper:generate' => 0,
            'php artisan ide-helper:meta' => 0,
        ];

        foreach ($commands as $command => $result) {

            if (! $result &&
                app()->isProduction()) {
                continue;
            }

            $this->info('~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
            $this->info('start exec ' . $command . "\r\n");
            $this->info(shell_exec($command));
            $this->info('end exec ' . $command . "\r\n");
            $this->info('~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
        }
    }

}
