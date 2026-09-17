<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Pterodactyl\Models\Setting;

class ArixAutoFixCommand extends Command
{
    protected $signature = 'arix:fix {--force : Force resolution without prompting}';
    protected $description = 'Automatically diagnoses and resolves common 500 errors, cache corruption, and missing settings for Arix theme.';

    public function handle()
    {
        $this->info("=================================================");
        $this->info("   Arix Theme Self-Healing & Diagnostic Tool    ");
        $this->info("=================================================");

        // 1. Clear application caches
        $this->task("Clearing compiled Blade views & caches", function () {
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('cache:clear');
            return true;
        });

        // 2. Ensure basic Arix settings exist in database
        $this->task("Verifying Arix Database Settings", function () {
            $defaultSettings = [
                'settings::arix:theme' => 'arix',
                'settings::arix:mode' => 'dark',
                'settings::arix:color' => 'blue',
                'settings::arix:sidebar' => 'expanded',
            ];

            foreach ($defaultSettings as $key => $value) {
                if (!Setting::where('key', $key)->exists()) {
                    Setting::create(['key' => $key, 'value' => $value]);
                }
            }
            return true;
        });

        // 3. Compile translations if needed
        $this->task("Compiling language files", function () {
            try {
                Artisan::call('language:compile');
            } catch (\Exception $e) {
                // Ignore if command not present
            }
            return true;
        });

        // 4. Check & Fix file permissions
        $this->task("Verifying storage & cache permissions", function () {
            $storagePath = storage_path();
            $cachePath = base_path('bootstrap/cache');

            if (File::exists($storagePath)) {
                @chmod($storagePath, 0775);
            }
            if (File::exists($cachePath)) {
                @chmod($cachePath, 0775);
            }
            return true;
        });

        $this->info("\n[SUCCESS] Self-healing complete. Panel caches and settings restored.");
        return Command::SUCCESS;
    }
}
