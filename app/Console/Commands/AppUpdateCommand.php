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
            'php artisan l5-swagger:generate',
            'php artisan ide-helper:generate',
            'php artisan ide-helper:meta',
        ];

        foreach ($commands as $command) {
            $this->info('~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
            $this->info('start exec ' . $command . "\r\n");
            $this->info(shell_exec($command));
            $this->info('end exec ' . $command . "\r\n");
            $this->info('~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~');
        }
    }

}
