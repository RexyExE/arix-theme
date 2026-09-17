/**
 * ==============================================================================
 *  ARIX THEME — SILK VEIL / BUBBLE GLASSMORPHISM JS ENGINE
 *  Reactive UI Enhancer, Dynamic Status Beacons & Frosted Glass Interactivity
 * ==============================================================================
 */

(function () {
  'use strict';

  // Enhance status badges with live pulsing neon aura
  function enhanceStatusIndicators() {
    const dots = document.querySelectorAll(
      'span.w-2.h-2, span.w-3.h-3, div.w-2.h-2, div.w-3.h-3, .status-dot, [class*="StatusIndicator"]'
    );
    dots.forEach(dot => {
      const cls = (dot.className || '').toLowerCase();
      const style = dot.style || {};
      const bg = (style.backgroundColor || '').toLowerCase();

      if (cls.includes('green') || cls.includes('emerald') || bg.includes('green') || bg.includes('10,') || bg.includes('16,')) {
        dot.style.boxShadow = '0 0 14px rgba(16, 185, 129, 0.85), 0 0 4px rgba(16, 185, 129, 1)';
        dot.style.borderRadius = '50%';
      } else if (cls.includes('red') || cls.includes('rose') || bg.includes('red') || bg.includes('239,')) {
        dot.style.boxShadow = '0 0 12px rgba(244, 63, 94, 0.75)';
        dot.style.borderRadius = '50%';
      } else if (cls.includes('yellow') || cls.includes('amber') || bg.includes('yellow') || bg.includes('245,')) {
        dot.style.boxShadow = '0 0 12px rgba(245, 158, 11, 0.75)';
        dot.style.borderRadius = '50%';
      }
    });
  }

  // Micro-interactions on buttons and bubble pills
  function enhanceButtons() {
    const buttons = document.querySelectorAll(
      'button, a.button, [role="button"], input[type="submit"]'
    );
    buttons.forEach(btn => {
      if (!btn.hasAttribute('data-sv-interactive')) {
        btn.setAttribute('data-sv-interactive', 'true');
        btn.addEventListener('mousedown', function () {
          this.style.transform = 'scale(0.98)';
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

  // Dialog & Modal Backdrop Blur enhancement
  function enhanceModals() {
    const overlays = document.querySelectorAll(
      '[class*="Modal___styled"], [class*="Dialog___styled"], .modal-backdrop, [role="dialog"]'
    );
    overlays.forEach(overlay => {
      if (!overlay.hasAttribute('data-sv-glass')) {
        overlay.setAttribute('data-sv-glass', 'true');
        overlay.style.backdropFilter = 'blur(16px) saturate(180%)';
        overlay.style.webkitBackdropFilter = 'blur(16px) saturate(180%)';
      }
    });
  }

  // Master decoration cycle
  function scanAndDecorate() {
    enhanceStatusIndicators();
    enhanceButtons();
    enhanceModals();
  }

  // Initialize once DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', scanAndDecorate);
  } else {
    scanAndDecorate();
  }

  // Observe React SPA transitions smoothly with debounce
  let debounceTimer = null;
  const observer = new MutationObserver(() => {
    if (debounceTimer) clearTimeout(debounceTimer);
    debounceTimer = setTimeout(scanAndDecorate, 100);
  });

  if (document.body) {
    observer.observe(document.body, {
      childList: true,
      subtree: true
    });
  }
})();
