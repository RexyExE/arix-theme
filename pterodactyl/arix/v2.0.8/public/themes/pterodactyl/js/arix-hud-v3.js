/**
 * Arix Theme v3 - Cyberpunk / Neon-Dark HUD Motion & Interaction System
 * Pterodactyl Panel Client Injected Script
 */

(function () {
  'use strict';

  // 1. Session-guarded Cold Boot Terminal Overlay Sequence
  function initColdBoot() {
    // Only run cold-boot once per browser session
    if (sessionStorage.getItem('arix_v3_booted')) {
      return;
    }

    const bootOverlay = document.createElement('div');
    bootOverlay.id = 'arix-cold-boot';
    bootOverlay.className = 'arix-cold-boot';
    bootOverlay.innerHTML = `
      <div class="arix-boot-content">
        <div class="arix-boot-terminal">
          <div class="arix-boot-line" id="boot-l1"><span class="arix-text-cyan">[SYS_INIT]</span> INITIALIZING ARIX HUD v3.0 KERNEL...</div>
          <div class="arix-boot-line" id="boot-l2"><span class="arix-text-violet">[MEM_UPLINK]</span> MAPPING HARDWARE PROTOCOLS... OK</div>
          <div class="arix-boot-line" id="boot-l3"><span class="arix-text-cyan">[DAEMON]</span> ESTABLISHING ENCRYPTED NODE SOCKET... ESTABLISHED</div>
          <div class="arix-boot-line" id="boot-l4"><span class="arix-text-violet">[HUD_CORE]</span> CALIBRATING NEON SPECTRA (VIOLET #8B5CF6 / CYAN #00E5FF)...</div>
        </div>
        <div class="arix-boot-progress-wrap">
          <div class="arix-boot-bar" id="arix-boot-progress-bar"></div>
        </div>
        <div class="arix-boot-pct-wrap">
          <span class="arix-boot-status-text">LINKING PANEL TELEMETRY</span>
          <span id="arix-boot-percent">0%</span>
        </div>
      </div>
    `;

    document.body.appendChild(bootOverlay);

    // Animation progress sequence (1.6s total)
    const progressBar = document.getElementById('arix-boot-progress-bar');
    const percentText = document.getElementById('arix-boot-percent');
    const lines = [
      document.getElementById('boot-l1'),
      document.getElementById('boot-l2'),
      document.getElementById('boot-l3'),
      document.getElementById('boot-l4')
    ];

    lines[0].style.opacity = '1';

    let progress = 0;
    const interval = setInterval(() => {
      progress += Math.floor(Math.random() * 12) + 6;
      if (progress > 100) progress = 100;

      if (progressBar) progressBar.style.width = progress + '%';
      if (percentText) percentText.textContent = progress + '%';

      if (progress >= 30 && lines[1]) lines[1].style.opacity = '1';
      if (progress >= 60 && lines[2]) lines[2].style.opacity = '1';
      if (progress >= 85 && lines[3]) lines[3].style.opacity = '1';

      if (progress >= 100) {
        clearInterval(interval);
        setTimeout(() => {
          bootOverlay.classList.add('fade-out');
          sessionStorage.setItem('arix_v3_booted', 'true');
          setTimeout(() => {
            if (bootOverlay.parentNode) {
              bootOverlay.parentNode.removeChild(bootOverlay);
            }
          }, 450);
        }, 300);
      }
    }, 85);
  }

  // 2. Glitch Flicker Effect on Action Buttons
  function initGlitchFlicker() {
    document.addEventListener('click', function (e) {
      const target = e.target.closest(
        'button, .button, a[role="button"], input[type="submit"], input[type="button"]'
      );
      if (!target) return;

      // Add HUD glitch effect
      target.classList.remove('hud-glitch-active');
      void target.offsetWidth; // Force reflow
      target.classList.add('hud-glitch-active');

      setTimeout(() => {
        target.classList.remove('hud-glitch-active');
      }, 150);
    }, true);
  }

  // 3. Dynamic Observer for React Route Changes, Status Dots, & HUD Elements
  function initHUDObserver() {
    // Decorate elements as React mounts and remounts views
    function scanAndDecorate() {
      // 1. Online status dots detection
      const potentialStatusDots = document.querySelectorAll(
        'span.w-2.h-2, span.w-3.h-3, div.w-2.h-2, div.w-3.h-3, .status-dot'
      );
      potentialStatusDots.forEach(dot => {
        const classNames = dot.className || '';
        if (
          classNames.includes('bg-green') ||
          classNames.includes('bg-emerald') ||
          classNames.includes('status-online') ||
          dot.style.backgroundColor?.includes('green')
        ) {
          if (!dot.classList.contains('hud-status-dot')) {
            dot.classList.add('hud-status-dot');
          }
        }
      });

      // 2. Add corner-bracket accents to primary dashboard & server cards
      const cards = document.querySelectorAll(
        '.bg-gray-700, .bg-gray-800, [class*="ServerRow___styled"], [class*="TitledGreyBox___styled"]'
      );
      cards.forEach(card => {
        if (!card.hasAttribute('data-hud-card') && !card.classList.contains('arix-cold-boot')) {
          card.setAttribute('data-hud-card', 'true');
          card.classList.add('hud-card');
        }
      });

      // 3. Enhance Terminal Console if present
      const xtermScreen = document.querySelector('.xterm-screen, #terminal, .terminal');
      if (xtermScreen) {
        const terminalBox = xtermScreen.closest('.hud-card, .bg-gray-700, .bg-gray-800, div');
        if (terminalBox && !terminalBox.classList.contains('hud-console-box')) {
          terminalBox.classList.add('hud-console-box');
        }
      }
    }

    // Initial scan
    scanAndDecorate();

    // Debounced MutationObserver for dynamic React DOM mutations
    let timeoutId = null;
    const observer = new MutationObserver(() => {
      if (timeoutId) clearTimeout(timeoutId);
      timeoutId = setTimeout(scanAndDecorate, 100);
    });

    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  }

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      initColdBoot();
      initGlitchFlicker();
      initHUDObserver();
    });
  } else {
    initColdBoot();
    initGlitchFlicker();
    initHUDObserver();
  }
})();
