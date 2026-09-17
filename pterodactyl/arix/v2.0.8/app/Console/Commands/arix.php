<?php

namespace Pterodactyl\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Illuminate\Support\Facades\File;

class Arix extends Command
{
    protected $signature = "arix {action?}";
    protected $description = "All management commands for Arix Theme on Pterodactyl Panel.";

    public function handle()
    {
        $action = $this->argument("action");

        if ($action === null) {
            $this->output->write("\033[2J\033[;H");
            $this->line("<fg=cyan;options=bold>
    ___         _       ______  __                         
   /   |  _____(_)  __ /_  __/ / /_   ___   ____ ___   ___ 
  / /| | / ___/ / |/_/  / /   / __ \ / _ \ / __ `__ \ / _ \
 / ___ |/ /  / />  <   / /   / / / //  __// / / / / //  __/
/_/  |_/_/  /_//_/|_| /_/   /_/ /_/ \___//_/ /_/ /_/ \___/ 
</>");
            $this->line("  <fg=magenta;options=bold>Arix Theme v2.0.8</> <fg=gray>•</> <fg=white;options=bold>Pterodactyl Panel Theme Manager</>");
            $this->line("  <fg=gray>Clean, Fast & Production-Ready</>");
            $this->line("<fg=cyan>─────────────────────────────────────────────────────────────</>");
            $this->line("");
            $this->line("  <fg=cyan;options=bold>[1]</> <fg=white;options=bold>Install Arix Theme</>");
            $this->line("  <fg=yellow;options=bold>[2]</> <fg=white;options=bold>Uninstall Arix Theme</>");
            $this->line("  <fg=green;options=bold>[3]</> <fg=white;options=bold>Repair / Fix Theme</>");
            $this->line("  <fg=red;options=bold>[0]</> <fg=gray>Exit</>");
            $this->line("");
            $this->line("<fg=cyan>─────────────────────────────────────────────────────────────</>");

            $choice = $this->ask("Select an option [0-3]");

            switch (trim((string)$choice)) {
                case '1':
                    $this->install();
                    break;
                case '2':
                    $this->uninstall();
                    break;
                case '3':
                    $this->repair();
                    break;
                case '0':
                default:
                    $this->info("Exiting.");
                    return 0;
            }
        } else {
            if ($action === "install") {
                $this->install();
            } elseif ($action === "uninstall") {
                $this->uninstall();
            } elseif ($action === "fix" || $action === "repair") {
                $this->repair();
            } elseif ($action === "update") {
                $this->update();
            } else {
                $this->error("Invalid action: {$action}. Supported actions: install, uninstall, fix");
            }
        }
    }

    public function installOrUpdate($isUpdate = false)
    {
        if ($isUpdate) {
            $this->info("\nUpdating Arix Theme (preserving user modifications and custom configuration)...");
        } else {
            $this->info("\nBeginning Arix Theme Installation...");
        }

        $themeSource = null;
        $arixDir = base_path("arix");

        if (File::isDirectory($arixDir)) {
            $versions = File::directories($arixDir);
            if (!empty($versions)) {
                // Filter out non-version directory names
                $versionNames = array_map('basename', $versions);
                $choice = $this->choice("Select theme version to deploy:", $versionNames, 0);
                $themeSource = $arixDir . DIRECTORY_SEPARATOR . $choice;
            } else {
                $themeSource = $arixDir;
            }
        } else {
            $this->error("Could not locate /arix directory in panel base path: {$arixDir}");
            return;
        }

        $this->info("Deploying Arix Theme files from: " . basename($themeSource) . "...");

        // Copy files into panel base directory
        $this->copyThemeFiles($themeSource, base_path(), $isUpdate);

        // Ensure Admin controllers exist
        $controllerSrc = $themeSource . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "Http" . DIRECTORY_SEPARATOR . "Controllers" . DIRECTORY_SEPARATOR . "Admin" . DIRECTORY_SEPARATOR . "Arix";
        $controllerDest = app_path("Http/Controllers/Admin/Arix");
        if (File::isDirectory($controllerSrc)) {
            File::makeDirectory($controllerDest, 0755, true, true);
            File::copyDirectory($controllerSrc, $controllerDest);
        }

        // Database migrations
        $this->info("Running database migrations...");
        $this->call('migrate', ['--force' => true]);

        // Install Node dependencies
        $this->info("Checking and installing frontend dependencies...");
        $packages = "cronstrue jszip react-turnstile @dnd-kit/core @dnd-kit/sortable @dnd-kit/utilities @types/md5 md5 react-icons@5.4.0 markdown-to-jsx@7.7.10 i18next-browser-languagedetector@7.2.1";
        
        if ($this->hasCommand('yarn')) {
            $this->executeStream("yarn add {$packages} --ignore-engines");
        } else {
            $this->executeStream("npm install {$packages} --legacy-peer-deps");
        }

        // Language compilation
        $this->info("Compiling translation dictionaries...");
        try {
            $this->callSilent('language:compile');
        } catch (\Throwable $e) {
            // Ignore if command does not exist in standard Pterodactyl
        }

        // Build frontend assets with OpenSSL legacy support for Node 17+
        $this->info("Building panel frontend assets (this may take 1-3 minutes)...");
        $buildCmd = "export NODE_OPTIONS=--openssl-legacy-provider; yarn build:production";
        if (!$this->hasCommand('yarn')) {
            $buildCmd = "export NODE_OPTIONS=--openssl-legacy-provider; npm run build";
        }
        $this->executeStream($buildCmd);

        // Auto-fix and self heal
        $this->info("Executing self-healing checks and directory verifications...");
        $this->callSilent('arix:fix', ['--force' => true]);

        // Fix permissions for the appropriate webserver user
        $this->info("Setting file ownership and permissions...");
        $this->fixPermissions();

        // Clear and refresh application caches
        $this->info("Refreshing application caches...");
        $this->callSilent('optimize:clear');
        $this->callSilent('view:clear');
        $this->callSilent('config:clear');
        $this->callSilent('route:clear');

        $statusMsg = $isUpdate ? "Theme Updated Successfully" : "ARIX THEME INSTALLED SUCCESSFULLY!";
        $this->line("\n<fg=green;options=bold>┌───────────────────────────────────────────────────────────┐</>");
        $this->line("<fg=green;options=bold>│</>  <fg=white;options=bold>✓ {$statusMsg}</>                    <fg=green;options=bold>│</>");
        $this->line("<fg=green;options=bold>│</>  <fg=gray>Open your browser and refresh the panel to see changes.</>  <fg=green;options=bold>│</>");
        $this->line("<fg=green;options=bold>└───────────────────────────────────────────────────────────┘</>\n");
    }

    private function copyThemeFiles(string $source, string $destination, bool $isUpdate)
    {
        if ($this->hasCommand('rsync')) {
            $excludeOption = $isUpdate ? "--exclude='routes.ts' --exclude='getServer.ts' --exclude='admin.blade.php' --exclude='admin.php' --exclude='ServerTransformer.php'" : '';
            exec("rsync -a {$excludeOption} \"{$source}/\" \"{$destination}/\" 2>/dev/null");
        } else {
            // PHP fallback when rsync is not installed
            File::copyDirectory($source, $destination);
        }
    }

    private function fixPermissions()
    {
        $base = base_path();
        $user = "www-data";

        // Detect existing web user
        foreach (["www-data", "nginx", "apache", "caddy"] as $u) {
            $output = shell_exec("id -u {$u} 2>/dev/null");
            if (!empty($output) && is_numeric(trim($output))) {
                $user = $u;
                break;
            }
        }

        @exec("chown -R {$user}:{$user} \"{$base}\" 2>/dev/null");
        @exec("chmod -R 755 \"{$base}/storage\" \"{$base}/bootstrap/cache\" \"{$base}/public\" 2>/dev/null");
    }

    private function hasCommand(string $cmd): bool
    {
        $which = shell_exec("command -v {$cmd} 2>/dev/null");
        return !empty(trim((string)$which));
    }

    private function executeStream(string $cmd)
    {
        $proc = popen($cmd . " 2>&1", "r");
        if ($proc) {
            while (!feof($proc)) {
                $line = fgets($proc);
                if ($line !== false && trim($line) !== "") {
                    $this->output->write("  " . $line);
                }
            }
            pclose($proc);
        }
    }

    public function install()
    {
        $this->installOrUpdate(false);
    }

    public function update()
    {
        $this->installOrUpdate(true);
    }

    public function repair()
    {
        $this->line("\n<fg=white;options=bold>Running Arix Theme Repair & Self-Healing...</>");
        $this->info("1. Clearing application & view caches...");
        $this->call('view:clear');
        $this->call('config:clear');
        $this->call('route:clear');
        $this->call('cache:clear');
        $this->call('optimize:clear');

        $this->info("2. Re-running database migrations & self-heals...");
        $this->call('migrate', ['--force' => true]);
        $this->call('arix:fix', ['--force' => true]);

        $this->info("3. Fixing file permissions...");
        $this->fixPermissions();

        if ($this->confirm("Do you also want to recompile frontend assets?", false)) {
            $this->info("Compiling assets...");
            $buildCmd = "export NODE_OPTIONS=--openssl-legacy-provider; yarn build:production";
            if (!$this->hasCommand('yarn')) {
                $buildCmd = "export NODE_OPTIONS=--openssl-legacy-provider; npm run build";
            }
            $this->executeStream($buildCmd);
        }

        $this->call('optimize');

        $this->line("\n<fg=green;options=bold>┌───────────────────────────────────────────────────────────┐</>");
        $this->line("<fg=green;options=bold>│</>  <fg=white;options=bold>✓ THEME REPAIRED & CACHES CLEARED SUCCESSFULLY!</>          <fg=green;options=bold>│</>");
        $this->line("<fg=green;options=bold>└───────────────────────────────────────────────────────────┘</>\n");
    }

    private function uninstall()
    {
        $this->line("Uninstalling Arix Theme and restoring official stock panel...");
        $this->call('down');

        $base = base_path();
        $tmp = sys_get_temp_dir() . "/pterodactyl_stock_" . time();
        @mkdir($tmp, 0755, true);

        $this->info("Downloading official Pterodactyl release archive...");
        $this->executeStream("curl -sSL https://github.com/pterodactyl/panel/releases/latest/download/panel.tar.gz -o {$tmp}/panel.tar.gz");

        if (File::exists("{$tmp}/panel.tar.gz")) {
            $this->info("Restoring stock panel files...");
            $this->executeStream("tar -xzf {$tmp}/panel.tar.gz -C {$tmp} && rsync -a --exclude='.env' --exclude='storage' {$tmp}/ {$base}/ 2>/dev/null");
            File::deleteDirectory($tmp);
        }

        // Clean Arix controllers and views
        File::deleteDirectory(app_path("Http/Controllers/Admin/Arix"));
        File::deleteDirectory(resource_path("views/admin/arix"));
        File::delete(config_path("arix.php"));

        $this->info("Rebuilding stock panel assets...");
        $this->executeStream("yarn build:production 2>/dev/null || npm run build 2>/dev/null");

        $this->fixPermissions();
        $this->call('optimize:clear');
        $this->call('up');
        $this->info("Stock Pterodactyl panel restored successfully.");
    }
}
