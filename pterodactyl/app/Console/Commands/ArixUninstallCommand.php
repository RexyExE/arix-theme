<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ArixUninstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'arix:uninstall {--force : Force the operation to run without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall Arix theme settings and database configurations.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('Are you sure you want to remove all Arix theme database settings?')) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $this->info('Purging Arix database settings...');
        $deleted = DB::table('settings')->where('key', 'LIKE', 'settings::arix:%')->delete();
        $this->info("Successfully purged {$deleted} Arix database records.");

        $this->info('Clearing application cache...');
        $this->call('optimize:clear');

        $this->info('Arix theme database uninstallation complete!');
        return 0;
    }
}
