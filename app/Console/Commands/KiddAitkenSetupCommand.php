<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class KiddAitkenSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ka:setup';

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
        $this->info('');
        $this->info("             <fg=white;options=bold>    -   K I D D   A I T K E N   -</>");
        $this->info('');
        $this->warn('                  ********************************                 ');
        $this->warn('                  *    ⚠  ENVIRONMENT SETUP  ⚠   *                 ');
        $this->warn('                  ********************************                ');
        $this->info('
        This command is meant to setup the database for the customer in
        production environment or test purposes. Be aware that the command
        will <fg=red;options=bold>delete</> the database and create it again, migrate and seed the
        basic catalogs');

        $this->call('ka:drop-db');
        $this->call('ka:create-db');
        $this->info('Initializing migrations, chill, this may take a while...');
        $processMigrate = new Process(['php','artisan','migrate','--force']);
        $processMigrate->run();
        echo $processMigrate->getOutput();
        $this->alert('<fg=cyan;options=bold>Migrations done!</> ');

        $this->info('Initializing seeding, hang up there...');
        $process = new Process(['php','artisan','db:seed','--force']);
        $process->run();
        echo $process->getOutput();
        $this->alert('<fg=cyan;options=bold>Seeding done!</> 🌱');

        $process = new Process(['php','artisan','ka:refresh']);
        $process->run();

        echo $process->getOutput();
        $this->alert('<fg=cyan;options=bold>Refresh done!</>');

        $this->info("<fg=white;options=bold> K I D D   A I T K E N </><fg=magenta;> Is all set. You're good to go.</>");
        $this->info("");
        $this->info("");
    }
}
