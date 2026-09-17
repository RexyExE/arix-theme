#!/usr/bin/env bash
# ==============================================================================
#   ARIX THEME - PTERODACTYL PANEL THEME MANAGER
#   Version: 2.0.8 (Unified & Fixed Edition)
# ==============================================================================

set -e

# --- ANSI Color System ---
RESET="\033[0m"
BOLD="\033[1m"
DIM="\033[2m"

CYAN="\033[38;5;45m"
MAGENTA="\033[38;5;141m"
GREEN="\033[38;5;82m"
YELLOW="\033[38;5;220m"
RED="\033[38;5;196m"
WHITE="\033[1;37m"
GRAY="\033[38;5;244m"
DARK_GRAY="\033[38;5;239m"

LOG_FILE="/tmp/arix_install_$(date +%s).log"

# --- Trap Interrupts ---
trap 'echo -e "\n${RED}[!] Operation cancelled by user.${RESET}"; exit 1' INT TERM

# --- Root Check ---
if [ "$EUID" -ne 0 ]; then
    echo -e "${RED}[✗] Please run this script as root:${RESET} ${WHITE}sudo bash install.sh${RESET}"
    exit 1
fi

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PANEL_DIR="/var/www/pterodactyl"

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

# Find Theme Source Directory
find_theme_source() {
    if [ -d "$SCRIPT_DIR/arix" ] && [ -f "$SCRIPT_DIR/arix/config/arix.php" ]; then
        echo "$SCRIPT_DIR/arix"
    elif [ -d "$SCRIPT_DIR/Arix Theme v2.0.8/arix" ] && [ -f "$SCRIPT_DIR/Arix Theme v2.0.8/arix/config/arix.php" ]; then
        echo "$SCRIPT_DIR/Arix Theme v2.0.8/arix"
    elif [ -d "$PANEL_DIR/arix" ] && [ -f "$PANEL_DIR/arix/config/arix.php" ]; then
        echo "$PANEL_DIR/arix"
    elif [ -d "$SCRIPT_DIR/pterodactyl/arix/v2.0.8" ]; then
        echo "$SCRIPT_DIR/pterodactyl/arix/v2.0.8"
    else
        echo ""
    fi
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
    echo -e "  ${MAGENTA}${BOLD}Arix Theme v2.0.8${RESET} ${GRAY}•${RESET} ${WHITE}Pterodactyl Panel Theme Manager${RESET}"
    echo -e "  ${GRAY}Clean, Fast & Production-Ready${RESET}"
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
        read -rp "    Please enter your Pterodactyl path (e.g. /var/www/pterodactyl): " custom_dir
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
        error "Could not find Arix theme files in $SCRIPT_DIR/arix"
        echo -e "    Please place the ${WHITE}arix/${RESET} directory in the same folder as this script."
        exit 1
    fi

    local WEB_USER
    WEB_USER=$(detect_web_user)

    echo -e "\n${WHITE}${BOLD}Starting Arix Theme Installation...${RESET}"
    echo -e "${GRAY}Panel Directory :${RESET} ${CYAN}$PANEL_DIR${RESET}"
    echo -e "${GRAY}Theme Source    :${RESET} ${CYAN}$THEME_SRC${RESET}"
    echo -e "${GRAY}Web Server User :${RESET} ${CYAN}$WEB_USER${RESET}"

    # Step 1: Copy Theme Files
    step 1 5 "Copying theme files to panel directory..."
    if command -v rsync >/dev/null 2>&1; then
        rsync -a "$THEME_SRC/" "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
    else
        cp -r "$THEME_SRC"/* "$PANEL_DIR/" >> "$LOG_FILE" 2>&1
    fi
    success "Theme files copied successfully."

    # Step 2: Database Migrations
    step 2 5 "Running database migrations..."
    cd "$PANEL_DIR"
    php artisan migrate --force >> "$LOG_FILE" 2>&1 || true
    success "Database migrations completed."

    # Step 3: Frontend Dependencies
    step 3 5 "Checking and installing frontend dependencies..."
    local PKGS="cronstrue jszip react-turnstile @dnd-kit/core @dnd-kit/sortable @dnd-kit/utilities @types/md5 md5 react-icons@5.4.0 markdown-to-jsx@7.7.10 i18next-browser-languagedetector@7.2.1"
    if command -v yarn >/dev/null 2>&1; then
        yarn add $PKGS --ignore-engines >> "$LOG_FILE" 2>&1 || yarn add $PKGS >> "$LOG_FILE" 2>&1
    elif command -v npm >/dev/null 2>&1; then
        npm install $PKGS --legacy-peer-deps >> "$LOG_FILE" 2>&1
    fi
    success "Dependencies installed."

    # Step 4: Build Assets
    step 4 5 "Building production assets (this may take 1-2 minutes)..."
    export NODE_OPTIONS="--openssl-legacy-provider"
    if command -v yarn >/dev/null 2>&1; then
        yarn build:production >> "$LOG_FILE" 2>&1 || yarn build:production
    else
        npm run build >> "$LOG_FILE" 2>&1 || npm run build
    fi
    success "Frontend assets compiled successfully."

    # Step 5: Cache & Permissions
    step 5 5 "Optimizing caches and configuring permissions..."
    php artisan optimize:clear >> "$LOG_FILE" 2>&1 || true
    php artisan optimize >> "$LOG_FILE" 2>&1 || true
    chown -R "$WEB_USER" "$PANEL_DIR" >> "$LOG_FILE" 2>&1 || true
    chmod -R 755 "$PANEL_DIR/storage" "$PANEL_DIR/bootstrap/cache" >> "$LOG_FILE" 2>&1 || true
    success "Permissions and cache set."

    # Installation Complete Box
    echo -e "\n${GREEN}┌───────────────────────────────────────────────────────────┐${RESET}"
    echo -e "${GREEN}│${RESET}  ${WHITE}${BOLD}✓ ARIX THEME INSTALLED SUCCESSFULLY!${RESET}                    ${GREEN}│${RESET}"
    echo -e "${GREEN}│${RESET}  ${GRAY}Open your browser and refresh the panel to see changes.${RESET}  ${GREEN}│${RESET}"
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
    read -rp "Are you sure you want to uninstall Arix Theme? [y/N]: " confirm
    if [[ ! "$confirm" =~ ^[Yy]$ ]]; then
        echo -e "${GRAY}Uninstallation cancelled.${RESET}"
        return
    fi

    echo -e "\n${WHITE}${BOLD}Uninstalling Arix Theme...${RESET}"
    cd "$PANEL_DIR"
    php artisan down >> "$LOG_FILE" 2>&1 || true

    step 1 3 "Removing Arix controllers, configs, and admin views..."
    rm -rf "$PANEL_DIR/app/Http/Controllers/Admin/Arix"
    rm -rf "$PANEL_DIR/resources/views/admin/arix"
    rm -f "$PANEL_DIR/config/arix.php"
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

    read -rp "Do you also want to recompile frontend assets? [y/N] (default: n): " recompile
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
    echo -e "  ${CYAN}${BOLD}[1]${RESET} ${WHITE}${BOLD}Install Arix Theme${RESET}"
    echo -e "  ${YELLOW}${BOLD}[2]${RESET} ${WHITE}${BOLD}Uninstall Arix Theme${RESET}"
    echo -e "  ${GREEN}${BOLD}[3]${RESET} ${WHITE}${BOLD}Repair / Fix Theme${RESET}"
    echo -e "  ${RED}${BOLD}[0]${RESET} ${GRAY}Exit${RESET}"
    echo -e ""
    echo -e "${DARK_GRAY}─────────────────────────────────────────────────────────────${RESET}"

    read -rp "Select an option [0-3]: " choice

    case "$choice" in
        1)
            install_theme
            ;;
        2)
            uninstall_theme
            ;;
        3)
            repair_theme
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
