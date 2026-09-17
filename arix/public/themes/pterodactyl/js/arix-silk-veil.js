/**
 * ==============================================================================
 *  ARIX THEME — SILK VEIL / BUBBLE GLASSMORPHISM JS ENGINE
 *  Dynamic Hero Banner, Live Telemetry Pill Bar, and Silk Bubble Decorator
 * ==============================================================================
 */

(function () {
  'use strict';

  // Helper to extract username
  function getUsername() {
    if (window.PterodactylUser && window.PterodactylUser.username) {
      return window.PterodactylUser.username;
    }
    const nameEl = document.querySelector('[class*="NavigationBar___styled"] span, .account span');
    return nameEl ? nameEl.textContent.trim() : 'Operator';
  }

  // Inject Command Center Hero Banner & Telemetry Pill Bar
  function injectMoriCommandCenter() {
    // Only inject on main dashboard route
    const isDashboard = window.location.pathname === '/' || window.location.pathname === '';
    if (!isDashboard) {
      const existingBanner = document.getElementById('sv-command-banner');
      if (existingBanner) existingBanner.remove();
      const existingTelemetry = document.getElementById('sv-telemetry-bar');
      if (existingTelemetry) existingTelemetry.remove();
      return;
    }

    // Locate dashboard container
    const mainContainer = document.querySelector('main, #app main, [class*="DashboardContainer___styled"]');
    if (!mainContainer) return;

    // 1. Inject Command Center Hero Banner if missing
    if (!document.getElementById('sv-command-banner')) {
      const banner = document.createElement('div');
      banner.id = 'sv-command-banner';
      banner.className = 'mori-hero-banner';
      banner.innerHTML = `
        <span class="mori-hero-tag">COMMAND CENTER</span>
        <h1 class="mori-hero-title">Welcome back, ${getUsername()}.</h1>
        <p class="mori-hero-subtitle">A quiet glance at your empire — nothing more, nothing less.</p>
      `;

      // Insert at the top of main content
      mainContainer.prepend(banner);
    }

    // 2. Inject Live Telemetry Pill Bar if missing
    if (!document.getElementById('sv-telemetry-bar')) {
      const telemetryBar = document.createElement('div');
      telemetryBar.id = 'sv-telemetry-bar';
      telemetryBar.className = 'live-telemetry-bar';
      telemetryBar.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.6rem;">
          <span class="telemetry-live-dot"></span>
          <span style="font-weight: 700; font-size: 0.75rem; letter-spacing: 0.12em; color: #10b981;">LIVE</span>
          <span class="telemetry-item" style="margin-left: 0.5rem;">uptime <strong>99.98%</strong></span>
          <span class="telemetry-item">STATUS <strong>OPTIMAL</strong></span>
        </div>
        <div style="display: flex; align-items: center; gap: 1.25rem; flex-wrap: wrap;">
          <span class="telemetry-item">CORE <strong>SYNCED</strong></span>
          <span class="telemetry-item">LATENCY <strong>12ms</strong></span>
          <a href="https://discord.gg/geCjrRbAwC" target="_blank" rel="noopener noreferrer" style="color: #c084fc; text-decoration: none; font-size: 0.78rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(168, 85, 247, 0.12); padding: 0.35rem 0.85rem; border-radius: 9999px; border: 1px solid rgba(168, 85, 247, 0.25);">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0 12.64 12.64 0 0 0-.617-1.25.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07..07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057 19.9 19.9 0 0 0 5.993 3.03.078.078 0 0 0 .084-.028c.462-.63.874-1.295 1.226-1.994.021-.041.001-.09-.041-.106a13.107 13.107 0 0 1-1.872-.892.077.077 0 0 1-.008-.128 10.2 10.2 0 0 0 .372-.292.074.074 0 0 1 .077-.01c3.929 1.793 8.18 1.793 12.061 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127 12.299 12.299 0 0 1-1.873.894.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028 19.839 19.839 0 0 0 6.002-3.03.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.028z"/></svg>
            DISCORD
          </a>
        </div>
      `;

      const banner = document.getElementById('sv-command-banner');
      if (banner && banner.nextSibling) {
        banner.parentNode.insertBefore(telemetryBar, banner.nextSibling);
      } else if (banner) {
        banner.parentNode.appendChild(telemetryBar);
      }
    }
  }

  // Scan and decorate React DOM elements into Silk Veil Bubble surfaces
  function scanAndDecorate() {
    injectMoriCommandCenter();

    // 1. Online status beacon pulse
    const potentialDots = document.querySelectorAll(
      'span.w-2.h-2, span.w-3.h-3, div.w-2.h-2, div.w-3.h-3, .status-dot'
    );
    potentialDots.forEach(dot => {
      const cls = dot.className || '';
      if (cls.includes('bg-green') || cls.includes('bg-emerald') || dot.style.backgroundColor?.includes('green')) {
        dot.style.boxShadow = '0 0 12px rgba(16, 185, 129, 0.8)';
        dot.style.borderRadius = '50%';
      }
    });

    // 2. Add smooth ripple click on primary bubble buttons
    const primaryButtons = document.querySelectorAll(
      'button.bg-primary-500, button[class*="Button___styled-primary"], .button-primary, button[type="submit"]'
    );
    primaryButtons.forEach(btn => {
      if (!btn.hasAttribute('data-sv-bubble')) {
        btn.setAttribute('data-sv-bubble', 'true');
        btn.addEventListener('mousedown', function () {
          this.style.transform = 'scale(0.97)';
        });
        btn.addEventListener('mouseup', function () {
          this.style.transform = '';
        });
        btn.addEventListener('mouseleave', function () {
          this.style.transform = '';
        });
      }
    });
  }

  // Initialize once DOM is ready & observe SPA transitions
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
      scanAndDecorate();
    });
  } else {
    scanAndDecorate();
  }

  // Observe React SPA transitions
  let debounceTimeout = null;
  const observer = new MutationObserver(() => {
    if (debounceTimeout) clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(scanAndDecorate, 120);
  });

  observer.observe(document.body, {
    childList: true,
    subtree: true
  });
})();
