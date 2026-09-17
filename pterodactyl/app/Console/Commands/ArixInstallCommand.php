<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArixInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'arix:install {--force : Force the operation to run without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize and setup Arix theme database configurations and caches.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing Arix theme setup & running auto-fix checks...');

        $this->info('Running database migrations...');
        $this->call('migrate', ['--force' => true]);

        $this->info('Executing auto-heal & self-repair checks...');
        $this->call('arix:fix', ['--force' => true]);

        $this->info('Arix theme installation & auto-heal completed successfully!');
        return 0;
    }
}
