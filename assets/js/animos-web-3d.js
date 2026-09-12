/**
 * Animos 3D Interactive Card Engine
 * Modeled after animos.app/editor#
 *
 * Implements real-time 3D cursor tracking, specular sheen gradients,
 * 3D gyro perspective rings, and multi-service transitions.
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', initAnimos3D);

  function initAnimos3D() {
    const wrap = document.querySelector('[data-animos-showcase]');
    if (!wrap) return;

    const card = wrap.querySelector('[data-animos-card]');
    const tabs = Array.from(wrap.querySelectorAll('[data-animos-tab]'));
    const prevBtn = wrap.querySelector('[data-animos-prev]');
    const nextBtn = wrap.querySelector('[data-animos-next]');
    const dots = Array.from(wrap.querySelectorAll('[data-animos-dot]'));
    const toggleBtns = Array.from(wrap.querySelectorAll('[data-view-toggle]'));
    const studioView = wrap.querySelector('[data-view-studio]');
    const matrixView = wrap.querySelector('[data-view-matrix]');

    // Data source embedded in JSON script tag or DOM
    const dataScript = wrap.querySelector('#animos-services-data');
    if (!dataScript) return;

    let services = [];
    try {
      services = JSON.parse(dataScript.textContent);
    } catch (e) {
      console.error('[animos-3d] Failed to parse services data', e);
      return;
    }

    if (!services.length) return;

    let activeIdx = 0;
    let isHovering = false;
    let tilt = { rx: 0, ry: 0, px: 50, py: 50 };
    let animFrame = null;

    // Elements inside the 3D card to update
    const elNumTag = card.querySelector('[data-animos-num]');
    const elCat = card.querySelector('[data-animos-cat]');
    const elBadge = card.querySelector('[data-animos-badge]');
    const elTitle = card.querySelector('[data-animos-title]');
    const elTagline = card.querySelector('[data-animos-tagline]');
    const elImg = card.querySelector('[data-animos-img]');
    const elCrosshair = card.querySelector('[data-animos-crosshair]');
    const elLegit = card.querySelector('[data-animos-legit]');
    const elWaste = card.querySelector('[data-animos-waste]');
    const elMetrics = card.querySelector('[data-animos-metrics]');
    const elStack = card.querySelector('[data-animos-stack]');
    const elAction = card.querySelector('[data-animos-action]');

    // --- 3D Cursor Tilt Math ---
    function handleMouseMove(e) {
      if (!card) return;
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      // Normalized coordinates (-1 to 1)
      const normX = (x / rect.width - 0.5) * 2;
      const normY = (y / rect.height - 0.5) * 2;

      // Degrees of rotation (max 15 deg)
      tilt.ry = normX * 15;
      tilt.rx = -normY * 15;
      tilt.px = Math.max(0, Math.min(100, (x / rect.width) * 100));
      tilt.py = Math.max(0, Math.min(100, (y / rect.height) * 100));

      if (!animFrame) {
        animFrame = requestAnimationFrame(updateCardTransform);
      }
    }

    function updateCardTransform() {
      animFrame = null;
      if (!card) return;

      if (isHovering) {
        card.style.transform = `rotateX(${tilt.rx.toFixed(2)}deg) rotateY(${tilt.ry.toFixed(2)}deg)`;
        card.style.setProperty('--mouse-x', `${tilt.px.toFixed(1)}%`);
        card.style.setProperty('--mouse-y', `${tilt.py.toFixed(1)}%`);
      } else {
        card.style.transform = 'rotateX(0deg) rotateY(0deg)';
        card.style.setProperty('--mouse-x', '50%');
        card.style.setProperty('--mouse-y', '50%');
      }
    }

    function handleMouseEnter() {
      isHovering = true;
      card.style.transition = 'transform 0.08s ease-out';
    }

    function handleMouseLeave() {
      isHovering = false;
      tilt = { rx: 0, ry: 0, px: 50, py: 50 };
      card.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
      if (!animFrame) {
        animFrame = requestAnimationFrame(updateCardTransform);
      }
    }

    card.addEventListener('mousemove', handleMouseMove);
    card.addEventListener('mouseenter', handleMouseEnter);
    card.addEventListener('mouseleave', handleMouseLeave);

    // Touch support for mobile devices
    card.addEventListener('touchmove', function (e) {
      if (!e.touches.length) return;
      const t = e.touches[0];
      const rect = card.getBoundingClientRect();
      const x = t.clientX - rect.left;
      const y = t.clientY - rect.top;
      const normX = (x / rect.width - 0.5) * 2;
      const normY = (y / rect.height - 0.5) * 2;
      tilt.ry = normX * 10;
      tilt.rx = -normY * 10;
      tilt.px = (x / rect.width) * 100;
      tilt.py = (y / rect.height) * 100;
      isHovering = true;
      if (!animFrame) animFrame = requestAnimationFrame(updateCardTransform);
    }, { passive: true });

    card.addEventListener('touchend', handleMouseLeave);

    // --- Service Selection & 3D Transitions ---
    function selectService(idx) {
      if (idx < 0) idx = services.length - 1;
      if (idx >= services.length) idx = 0;
      activeIdx = idx;

      const svc = services[activeIdx];
      if (!svc) return;

      // Update card theme custom properties
      card.style.setProperty('--card-accent', svc.accentColor || '#00f2fe');
      card.style.setProperty('--card-accent-alpha', svc.glowColor || 'rgba(0, 242, 254, 0.35)');
      card.style.setProperty('--card-glow', svc.glowColor || 'rgba(0, 242, 254, 0.25)');

      // Micro 3D card push
      card.style.transition = 'transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease';
      card.style.opacity = '0.7';

      setTimeout(function () {
        // Update texts and badges
        if (elNumTag) elNumTag.textContent = svc.num;
        if (elCat) elCat.textContent = svc.category;
        if (elBadge) elBadge.textContent = '✦ ' + svc.badge;
        if (elTitle) elTitle.textContent = svc.name;
        if (elTagline) elTagline.textContent = svc.tagline;
        if (elCrosshair) elCrosshair.textContent = `SYS::${svc.id.toUpperCase()}_v3D`;

        // Update 3D Image Preview
        if (elImg && svc.image) {
          elImg.src = svc.image;
          elImg.alt = svc.name;
        }

        // Update Reality Check
        if (elLegit) elLegit.textContent = svc.legitimateUse;
        if (elWaste) elWaste.textContent = svc.fashionableUse;

        // Update Metrics Triad
        if (elMetrics && svc.metrics) {
          elMetrics.innerHTML = svc.metrics.map(function (m) {
            return `
              <div class="animos-metric-tile">
                <span class="animos-metric-val">${m.value}</span>
                <span class="animos-metric-label">${m.label}</span>
                <span class="animos-metric-sub">${m.sub}</span>
              </div>
            `;
          }).join('');
        }

        // Update Tech Stack
        if (elStack && svc.stack) {
          elStack.innerHTML = `
            <span class="animos-stack-lead">Engineered In:</span>
            ${svc.stack.map(s => `<span class="animos-stack-tag">${s}</span>`).join('')}
          `;
        }

        // Update Action link
        if (elAction) {
          elAction.href = `contact.php?service=${encodeURIComponent(svc.name)}`;
        }

        card.style.opacity = '1';
      }, 100);

      // Update Tabs active state
      tabs.forEach(function (t, i) {
        const isActive = i === activeIdx;
        t.classList.toggle('is-active', isActive);
        t.setAttribute('aria-selected', isActive ? 'true' : 'false');
        if (isActive) {
          t.style.setProperty('--active-accent', svc.accentColor || '#00f2fe');
          t.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
      });

      // Update Dots
      dots.forEach(function (d, i) {
        d.classList.toggle('is-active', i === activeIdx);
      });
    }

    // Tab click handlers
    tabs.forEach(function (t, i) {
      t.addEventListener('click', function () {
        selectService(i);
      });
    });

    // Arrow buttons
    if (prevBtn) {
      prevBtn.addEventListener('click', function () {
        selectService(activeIdx - 1);
      });
    }

    if (nextBtn) {
      nextBtn.addEventListener('click', function () {
        selectService(activeIdx + 1);
      });
    }

    // Dots
    dots.forEach(function (d, i) {
      d.addEventListener('click', function () {
        selectService(i);
      });
    });

    // Keyboard navigation
    wrap.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') {
        selectService(activeIdx - 1);
        e.preventDefault();
      } else if (e.key === 'ArrowRight') {
        selectService(activeIdx + 1);
        e.preventDefault();
      }
    });

    // --- View Toggle (Studio 3D vs All Services Matrix) ---
    toggleBtns.forEach(function (btn) {
      btn.addEventListener('click', function () {
        const targetView = btn.dataset.viewToggle;
        toggleBtns.forEach(b => b.classList.toggle('is-active', b === btn));

        if (targetView === 'studio') {
          if (studioView) studioView.hidden = false;
          if (matrixView) matrixView.hidden = true;
        } else {
          if (studioView) studioView.hidden = true;
          if (matrixView) matrixView.hidden = false;
        }
      });
    });

    // Initialize with first service
    selectService(0);
  }
})();
