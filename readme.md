# 🚀 Arix Pterodactyl Theme (Unified & Fixed Edition)

![Pterodactyl Version](https://img.shields.io/badge/Pterodactyl-v1.11.x%20--%20v1.12.x+-blue.svg)
![PHP Version](https://img.shields.io/badge/PHP-8.1%20%7C%208.2%20%7C%208.3-8892BF.svg)
![Node Version](https://img.shields.io/badge/Node.js-18%20%7C%2020-green.svg)
![License](https://img.shields.io/badge/License-MIT-green.svg)

This repository contains the **clean, unified, and fixed production release** of the **Arix Theme** for Pterodactyl Panel. It seamlessly combines and resolves all issues across versions **v1.3.1** and **v2.0.8**, eliminating installation bugs, remote verification traps, UI glitches, and dependency build failures.

---

## 🌟 What Was Fixed & Merged

1. **Rock-Solid VPS Installer Automation**:
   - Fixed remote verification/IP logger crashes (`verify.bosd.io.vn` removed).
   - Local directory priority: installs directly from local files without requiring external GitHub clones.
   - Cross-platform webserver permissions detection (`www-data`, `nginx`, `apache`, `caddy`).
   - Added `NODE_OPTIONS=--openssl-legacy-provider` and all required NPM dependencies for Node 18 & 20 support.
   - Built-in self-healing `php artisan arix:fix` command.

2. **Unified Configuration (`config/arix.php`)**:
   - Merged all configuration keys from `v1.3.1` (`status`, `billing`, `slot1..slot7`, `loginGradient`, `announcementType`, `announcementCloseable`) with `v2.0.8` (`logoLight`, `announcementColor`, `announcementIcon`, `backgroundFaded`, `dashboardWidgets`, `alertLink`, `dashboardPage`, `registration`, `socials`, `languageOptions`, `defaultLang`).
   - Dynamic fallbacks: automatically converts legacy `slot1..7` into dynamic `dashboardWidgets` and converts `billing`/`status`/`support` URLs into interactive dashboard social cards if `socials` is unconfigured.

3. **Backend & Controller Hardening**:
   - `AssetComposer.php`: Protected against missing settings and database timeouts with fallback defaults.
   - `Admin Controllers`: Fixed validation rules in `ArixAnnouncementRequest`, `ArixSocialRequest`, `ArixStylingRequest`, and `ArixAdvancedRequest` so empty/optional fields never block saving settings.
   - `Auth/ArixController.php`: Restored clean API version endpoint extending `AbstractLoginController`.
   - Removed hidden tracking/watermark artifacts (`app/Models/d7ba418f97817ab6` and `db53a25ea4a4fe28`).
   - `ServerTransformer.php`: Added nullsafe operators (`?->`) to prevent crashes when node or egg associations are null.
   - Migrations: Added `Schema::hasTable('server_orders')` existence check to prevent migration collision errors.
   - Mail template: Initialized `$siteConfiguration` with defaults so password reset and server creation emails never crash.

4. **Frontend UI Fixes**:
   - `LowResourcesAlert.tsx`: Fixed broken object destructuring and CSS conflicts; calculates accurate 95% resource thresholds.
   - `StatGraphs.tsx`: Fixed inverted Inbound vs Outbound network tooltip icon colors.
   - `PanelSounds.tsx`: Added unhandled promise rejection catches to audio playback.
   - `DashboardContainer.tsx`: Added error boundaries around Discord widget API fetching.

---

## ⚡ VPS Installation & Management

### Option 1: One-Command Shell Installer (Recommended)

Simply run the installer as `root` on your VPS:
```bash
bash install.sh
```

It opens an interactive, colorful menu:
```text
  [1] Install Arix Theme
  [2] Uninstall Arix Theme
  [3] Repair / Fix Theme
  [0] Exit
```

- **Press 1**: Automatically copies theme files, migrates database, installs packages, compiles frontend assets with Node 18/20 support, and sets web server permissions.
- **Press 2**: Safely uninstalls the theme and restores the official stock Pterodactyl panel.
- **Press 3**: Clears all compiled view/config/route caches, re-runs database migrations, and fixes file permissions.

---

### Option 2: Artisan Command

If the theme files are placed in `/var/www/pterodactyl`:
```bash
cd /var/www/pterodactyl

# Interactive menu
php artisan arix

# Or direct commands:
php artisan arix install     # Install
php artisan arix uninstall   # Uninstall
php artisan arix fix         # Repair & clear caches
```

---

### Option 3: Manual Step-by-Step Installation

```bash
cd /var/www/pterodactyl

# 1. Copy theme files into panel root (from the arix/ directory)
cp -r /path/to/arix/* /var/www/pterodactyl/

# 2. Run database migrations
php artisan migrate --step --force

# 3. Install required frontend packages
NODE_OPTIONS=--openssl-legacy-provider yarn add cronstrue jszip react-turnstile @dnd-kit/core @dnd-kit/sortable @dnd-kit/utilities @types/md5 md5 react-icons@5.4.0 markdown-to-jsx@7.7.10 i18next-browser-languagedetector@7.2.1 --ignore-engines

# 4. Build production frontend assets
NODE_OPTIONS=--openssl-legacy-provider yarn build:production

# 5. Clear application caches
php artisan optimize:clear
php artisan optimize

# 6. Set proper web server permissions
chown -R www-data:www-data /var/www/pterodactyl/*
chmod -R 755 /var/www/pterodactyl/storage /var/www/pterodactyl/bootstrap/cache
```

---

## 🔧 Troubleshooting & Self-Healing

If you experience any issues, cache conflicts, or styling glitches after upgrading:

```bash
cd /var/www/pterodactyl
php artisan arix:fix
```

Or re-run `bash install.sh` and select **Option 3 (Fix / Repair Theme)**.