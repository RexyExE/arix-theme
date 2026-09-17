#!/usr/bin/env bash
# ==============================================================================
#   ARIX THEME v3.0 - CYBERPUNK / NEON-DARK HUD THEME MANAGER
#   Pterodactyl Panel One-Liner Direct GitHub Installer & Repair Tool
# ==============================================================================

set -e

# --- ANSI Color System ---
RESET="\033[0m"
BOLD="\033[1m"
DIM="\033[2m"

CYAN="\033[38;5;45m"
VIOLET="\033[38;5;141m"
GREEN="\033[38;5;82m"
YELLOW="\033[38;5;220m"
RED="\033[38;5;196m"
WHITE="\033[1;37m"
GRAY="\033[38;5;244m"
DARK_GRAY="\033[38;5;239m"

LOG_FILE="/tmp/arix_install_$(date +%s).log"
PANEL_DIR="/var/www/pterodactyl"
GITHUB_REPO="https://github.com/RexyExE/arix-theme.git"
GITHUB_TAR="https://github.com/RexyExE/arix-theme/archive/refs/heads/main.tar.gz"

# --- Trap Interrupts ---
trap 'echo -e "\n${RED}[!] Operation cancelled by user.${RESET}"; exit 1' INT TERM

# --- Root Check ---
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}[✗] Please run this script as root:${RESET} ${WHITE}sudo bash -c \"\$(curl -fsSL https://raw.githubusercontent.com/RexyExE/arix-theme/main/install.sh)\"${RESET}"
    exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" 2>/dev/null && pwd || echo "/tmp")"

# Safe Read Input from Terminal (Supports Pipe / Command Substitution Execution)
safe_read() {
    local prompt="$1"
    local var_name="$2"
    local input_val=""
    if [ -c /dev/tty ]; then
        read -rp "$prompt" input_val < /dev/tty || true
    elif [ -t 0 ]; then
        read -rp "$prompt" input_val || true
    else
        read -rp "$prompt" input_val || true
    fi
    eval "$var_name=\$input_val"
}

# Detect Web User
detect_web_user() {
    if id -u www-data >/dev/null 2>&1; then
        echo "www-data:www-data"
    elif id -u nginx >/dev/null 2>&1; then
        echo "nginx:nginx"
    elif id -u apache >/dev/null 2>&1; then
        echo "apache:apache"
    elif id -u caddy >/dev/null 2>&1; then
        echo "caddy:caddy"
    else
        echo "www-data:www-data"
    fi
}

# Always Fetch Latest Theme Files Directly from GitHub
find_theme_source() {
    local GITHUB_TMP="/tmp/arix_v3_download"
    rm -rf "$GITHUB_TMP"
    mkdir -p "$GITHUB_TMP"
    echo -e "${CYAN}[*]${RESET} Pulling latest Arix Theme files directly from GitHub (${GITHUB_REPO})..." >&2
    
    # 1. Try git clone (fastest & full latest tree)
    if command -v git >/dev/null 2>&1; then
        if git clone --depth 1 "$GITHUB_REPO" "$GITHUB_TMP" >> "$LOG_FILE" 2>&1; then
            if [ -d "$GITHUB_TMP/arix" ]; then
                echo "$GITHUB_TMP/arix"
                return
            fi
        fi
    fi

    # 2. Fallback: curl tarball directly from GitHub
    if curl -sSL "$GITHUB_TAR" | tar -xz -C "$GITHUB_TMP" --strip-components=1 >> "$LOG_FILE" 2>&1; then
        if [ -d "$GITHUB_TMP/arix" ]; then
            echo "$GITHUB_TMP/arix"
            return
        fi
    fi

    # 3. Offline fallback only if GitHub cannot be reached
    if [ -d "$SCRIPT_DIR/arix" ] && [ -f "$SCRIPT_DIR/arix/config/arix.php" ]; then
        echo -e "${YELLOW}[!]${RESET} Could not reach GitHub, using local fallback." >&2
        echo "$SCRIPT_DIR/arix"
        return
    elif [ -d "$SCRIPT_DIR/Arix Theme v2.0.8/arix" ] && [ -f "$SCRIPT_DIR/Arix Theme v2.0.8/arix/config/arix.php" ]; then
        echo "$SCRIPT_DIR/Arix Theme v2.0.8/arix"
        return
    elif [ -d "$SCRIPT_DIR/pterodactyl/arix/v2.0.8" ]; then
        echo "$SCRIPT_DIR/pterodactyl/arix/v2.0.8"
        return
    fi

    echo ""
}

# Clean Terminal Header Banner
show_banner() {
    clear
    echo -e "${CYAN}${BOLD}"
    echo "    ___         _       ______  __                         "
    echo "   /   |  _____(_)  __ /_  __/ / /_   ___   ____ ___   ___ "
    echo "  / /| | / ___/ / |/_/  / /   / __ \ / _ \ / __ \`__ \ / _ \\"
    echo " / ___ |/ /  / />  <   / /   / / / //  __// / / / / //  __/"
    echo "/_/  |_/_/  /_//_/|_| /_/   /_/ /_/ \___//_/ /_/ /_/ \___/ "
    echo -e "${RESET}"
    echo -e "  ${VIOLET}${BOLD}Arix Theme v3.0${RESET} ${GRAY}•${RESET} ${CYAN}${BOLD}Cyberpunk / Neon-Dark HUD Edition${RESET}"
    echo -e "  ${GRAY}Direct GitHub One-Liner Installer & Manager${RESET}"
    echo -e "${DARK_GRAY}─────────────────────────────────────────────────────────────${RESET}"
}

# Print Step Progress
step() {
    local num="$1"
    local total="$2"
    local msg="$3"
    echo -e "\n${CYAN}[${num}/${total}]${RESET} ${WHITE}${BOLD}${msg}${RESET}"
}

# Print Success
success() {
    echo -e "${GREEN}[✓]${RESET} ${WHITE}$1${RESET}"
}

# Print Warning
warn() {
    echo -e "${YELLOW}[!]${RESET} ${YELLOW}$1${RESET}"
}

# Print Error
error() {
    echo -e "${RED}[✗]${RESET} ${RED}$1${RESET}"
}

# Verify Panel Directory
check_panel_dir() {
    if [ ! -f "$PANEL_DIR/artisan" ]; then
        echo -e "${YELLOW}[?] Pterodactyl panel not found at ${WHITE}$PANEL_DIR${RESET}"
        safe_read "    Please enter your Pterodactyl path (e.g. /var/www/pterodactyl): " custom_dir
        if [ -f "$custom_dir/artisan" ]; then
            PANEL_DIR="$custom_dir"
        else
            error "Could not find Pterodactyl artisan at $custom_dir. Exiting."
            exit 1
        fi
    fi
}

# ==============================================================================
#   ACTION: INSTALL THEME
# ==============================================================================
install_theme() {
    check_panel_dir
    local THEME_SRC
    THEME_SRC=$(find_theme_source)

    if [ -z "$THEME_SRC" ] || [ ! -d "$THEME_SRC" ]; then
        error "Could not download or find Arix theme files."
        echo -e "    Ensure your VPS has access to GitHub or clone manually."
        exit 1
    fi

    local WEB_USER
    WEB_USER=$(detect_web_user)

    echo -e "\n${WHITE}${BOLD}Starting Arix Theme v3 Installation...${RESET}"
    echo -e "${GRAY}Panel Directory :${RESET} ${CYAN}$PANEL_DIR${RESET}"
    echo -e "${GRAY}Theme Source    :${RESET} ${CYAN}$THEME_SRC${RESET}"
    echo -e "${GRAY}Web Server User :${RESET} ${CYAN}$WEB_USER${RESET}"

    # Step 1: Copy Theme Files
    step 1 5 "Injecting theme files & Cyberpunk HUD assets to panel..."
    if command -v rsync >/dev/null 2>&1; then
        rsync -a "$THEME_SRC/" "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
    else
        cp -r "$THEME_SRC"/* "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
    fi
    success "Theme files copied successfully."

    # Step 2: Database Migrations
    step 2 5 "Running database migrations & setting up Arix tables..."
    cd "$PANEL_DIR"
    php artisan migrate --force >> "$LOG_FILE" 2>&1 || true
    php artisan arix:fix --force >> "$LOG_FILE" 2>&1 || true
    success "Database migrations completed."

    # Step 3: Frontend Dependencies (Optional React components)
    step 3 5 "Verifying frontend dependencies..."
    local PKGS="cronstrue jszip react-turnstile @dnd-kit/core @dnd-kit/sortable @dnd-kit/utilities @types/md5 md5 react-icons@5.4.0 markdown-to-jsx@7.7.10 i18next-browser-languagedetector@7.2.1"
    if command -v yarn >/dev/null 2>&1; then
        yarn add $PKGS --ignore-engines >> "$LOG_FILE" 2>&1 || true
    elif command -v npm >/dev/null 2>&1; then
        npm install $PKGS --legacy-peer-deps >> "$LOG_FILE" 2>&1 || true
    fi
    success "Frontend dependencies verified."

    # Step 4: Build Assets Option
    step 4 5 "Configuring frontend assets..."
    echo -e "${GRAY}Note: Arix Theme v3 HUD runs instantly via injected CSS/JS overrides.${RESET}"
    safe_read "Do you want to recompile the full React client bundle as well? [y/N] (default: n): " do_build
    if [[ "$do_build" =~ ^[Yy]$ ]]; then
        echo -e "${CYAN}[*]${RESET} Compiling React production bundle (please wait 1-2 mins)..."
        export NODE_OPTIONS="--openssl-legacy-provider"
        if command -v yarn >/dev/null 2>&1; then
            yarn build:production >> "$LOG_FILE" 2>&1 || yarn build:production || true
        else
            npm run build >> "$LOG_FILE" 2>&1 || npm run build || true
        fi
        success "Frontend bundle compiled."
    else
        success "Fast installation mode: CSS/JS Cyberpunk HUD active."
    fi

    # Step 5: Cache & Permissions
    step 5 5 "Optimizing caches and configuring permissions..."
    php artisan view:clear >> "$LOG_FILE" 2>&1 || true
    php artisan config:clear >> "$LOG_FILE" 2>&1 || true
    php artisan route:clear >> "$LOG_FILE" 2>&1 || true
    php artisan optimize:clear >> "$LOG_FILE" 2>&1 || true
    php artisan optimize >> "$LOG_FILE" 2>&1 || true
    chown -R "$WEB_USER" "$PANEL_DIR" >> "$LOG_FILE" 2>&1 || true
    chmod -R 755 "$PANEL_DIR/storage" "$PANEL_DIR/bootstrap/cache" >> "$LOG_FILE" 2>&1 || true
    success "Permissions and cache set."

    # Installation Complete Box
    echo -e "\n${GREEN}┌───────────────────────────────────────────────────────────┐${RESET}"
    echo -e "${GREEN}│${RESET}  ${WHITE}${BOLD}✓ ARIX THEME v3 INSTALLED SUCCESSFULLY!${RESET}                 ${GREEN}│${RESET}"
    echo -e "${GREEN}│${RESET}  ${GRAY}Open your browser and refresh your Pterodactyl Panel.${RESET}     ${GREEN}│${RESET}"
    echo -e "${GREEN}│${RESET}  ${VIOLET}Neon HUD Palette & Cold Boot Sequence are active.${RESET}       ${GREEN}│${RESET}"
    echo -e "${GREEN}└───────────────────────────────────────────────────────────┘${RESET}\n"
}

# ==============================================================================
#   ACTION: UNINSTALL THEME
# ==============================================================================
uninstall_theme() {
    check_panel_dir
    local WEB_USER
    WEB_USER=$(detect_web_user)

    echo -e "\n${YELLOW}${BOLD}Warning:${RESET} This will remove Arix Theme and restore stock Pterodactyl files."
    safe_read "Are you sure you want to uninstall Arix Theme? [y/N]: " confirm
    if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
        echo -e "${GRAY}Uninstallation cancelled.${RESET}"
        return
    fi

    echo -e "\n${WHITE}${BOLD}Uninstalling Arix Theme...${RESET}"
    cd "$PANEL_DIR"
    php artisan down >> "$LOG_FILE" 2>&1 || true

    step 1 3 "Removing Arix controllers, configs, and HUD overrides..."
    rm -rf "$PANEL_DIR/app/Http/Controllers/Admin/Arix"
    rm -rf "$PANEL_DIR/resources/views/admin/arix"
    rm -f "$PANEL_DIR/config/arix.php"
    rm -f "$PANEL_DIR/public/themes/pterodactyl/css/arix-hud-v3.css"
    rm -f "$PANEL_DIR/public/themes/pterodactyl/js/arix-hud-v3.js"
    success "Arix custom files removed."

    step 2 3 "Restoring stock panel files from official release..."
    local TMP_DIR="/tmp/ptero_stock_$(date +%s)"
    mkdir -p "$TMP_DIR"
    if curl -sSL "https://github.com/pterodactyl/panel/releases/latest/download/panel.tar.gz" -o "$TMP_DIR/panel.tar.gz"; then
        tar -xzf "$TMP_DIR/panel.tar.gz" -C "$TMP_DIR"
        if command -v rsync >/dev/null 2>&1; then
            rsync -a --exclude='.env' --exclude='storage' "$TMP_DIR/" "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
        else
            cp -r "$TMP_DIR"/* "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
        fi
        rm -rf "$TMP_DIR"
        success "Stock panel files restored."
    else
        warn "Could not download stock archive. Proceeding with local cache wipe."
    fi

    step 3 3 "Rebuilding stock frontend assets and clearing cache..."
    export NODE_OPTIONS="--openssl-legacy-provider"
    yarn build:production >> "$LOG_FILE" 2>&1 || npm run build >> "$LOG_FILE" 2>&1 || true
    php artisan optimize:clear >> "$LOG_FILE" 2>&1 || true
    php artisan optimize >> "$LOG_FILE" 2>&1 || true
    chown -R "$WEB_USER" "$PANEL_DIR" >> "$LOG_FILE" 2>&1 || true
    chmod -R 755 "$PANEL_DIR/storage" "$PANEL_DIR/bootstrap/cache" >> "$LOG_FILE" 2>&1 || true
    php artisan up >> "$LOG_FILE" 2>&1 || true

    echo -e "\n${GREEN}┌───────────────────────────────────────────────────────────┐${RESET}"
    echo -e "${GREEN}│${RESET}  ${WHITE}${BOLD}✓ STOCK PTERODACTYL RESTORED SUCCESSFULLY!${RESET}               ${GREEN}│${RESET}"
    echo -e "${GREEN}└───────────────────────────────────────────────────────────┘${RESET}\n"
}

# ==============================================================================
#   ACTION: REPAIR / FIX THEME
# ==============================================================================
repair_theme() {
    check_panel_dir
    local WEB_USER
    WEB_USER=$(detect_web_user)

    echo -e "\n${WHITE}${BOLD}Running Arix Theme Repair & Self-Healing...${RESET}"
    cd "$PANEL_DIR"

    step 1 3 "Clearing all compiled views, routes, and configs..."
    php artisan view:clear >> "$LOG_FILE" 2>&1 || true
    php artisan config:clear >> "$LOG_FILE" 2>&1 || true
    php artisan route:clear >> "$LOG_FILE" 2>&1 || true
    php artisan cache:clear >> "$LOG_FILE" 2>&1 || true
    php artisan optimize:clear >> "$LOG_FILE" 2>&1 || true
    success "Caches cleared."

    step 2 3 "Re-running database migrations & self-heals..."
    php artisan migrate --force >> "$LOG_FILE" 2>&1 || true
    php artisan arix:fix --force >> "$LOG_FILE" 2>&1 || true
    success "Database verified."

    step 3 3 "Resetting file permissions and ownership..."
    chown -R "$WEB_USER" "$PANEL_DIR" >> "$LOG_FILE" 2>&1 || true
    chmod -R 755 "$PANEL_DIR/storage" "$PANEL_DIR/bootstrap/cache" >> "$LOG_FILE" 2>&1 || true
    success "Permissions fixed."

    safe_read "Do you also want to recompile frontend assets? [y/N] (default: n): " recompile
    if [[ "$recompile" =~ ^[Yy]$ ]]; then
        echo -e "${CYAN}[*]${RESET} Rebuilding assets (please wait)..."
        export NODE_OPTIONS="--openssl-legacy-provider"
        yarn build:production >> "$LOG_FILE" 2>&1 || npm run build >> "$LOG_FILE" 2>&1 || true
        success "Assets recompiled."
    fi

    php artisan optimize >> "$LOG_FILE" 2>&1 || true

    echo -e "\n${GREEN}┌───────────────────────────────────────────────────────────┐${RESET}"
    echo -e "${GREEN}│${RESET}  ${WHITE}${BOLD}✓ THEME REPAIRED & CACHES CLEARED SUCCESSFULLY!${RESET}          ${GREEN}│${RESET}"
    echo -e "${GREEN}└───────────────────────────────────────────────────────────┘${RESET}\n"
}

# ==============================================================================
#   MAIN MENU LOOP
# ==============================================================================
main() {
    show_banner
    echo -e ""
    echo -e "  ${CYAN}${BOLD}[1]${RESET} ${WHITE}${BOLD}Install Arix Theme v3 (Cyberpunk HUD)${RESET}"
    echo -e "  ${GREEN}${BOLD}[2]${RESET} ${WHITE}${BOLD}Repair / Fix Theme & Clear Caches${RESET}"
    echo -e "  ${YELLOW}${BOLD}[3]${RESET} ${WHITE}${BOLD}Uninstall Theme (Restore Stock Panel)${RESET}"
    echo -e "  ${RED}${BOLD}[0]${RESET} ${GRAY}Exit${RESET}"
    echo -e ""
    echo -e "${DARK_GRAY}─────────────────────────────────────────────────────────────${RESET}"

    safe_read "Select an option [0-3]: " choice

    case "$choice" in
        1)
            install_theme
            ;;
        2)
            repair_theme
            ;;
        3)
            uninstall_theme
            ;;
        0)
            echo -e "\n${GRAY}Exiting.${RESET}\n"
            exit 0
            ;;
        *)
            error "Invalid choice: $choice"
            sleep 1
            main
            ;;
    esac
}

main
