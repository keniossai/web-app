<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class KiddAitkenRefreshCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ka:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('🍻 Refreshing the environment 🍻');

        $refreshProcess = new Process(['php','artisan','route:cache']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $refreshProcess = new Process(['php','artisan','route:clear']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $refreshProcess = new Process(['php','artisan','config:cache']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $refreshProcess = new Process(['php','artisan','cache:clear']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $refreshProcess = new Process(['php','artisan','view:clear']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $refreshProcess = new Process(['composer','dump-autoload']);
        $refreshProcess->run();
        echo $refreshProcess->getOutput();

        $this->info('Aaaah~ 🍻 refreshed!');
    }
}
