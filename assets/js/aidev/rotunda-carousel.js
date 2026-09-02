/**
 * iThrive AI - Section 6: OriginKit Rotunda Carousel (3D Panoramic Curved Stage)
 * Mathematical 3D Cylindrical Ring Engine with Continuous Spring Interpolation
 * Path: assets/js/rotunda-carousel.js
 */

(function () {
  'use strict';

  /*
   * Where these pictures live. The paths in the data below are the source
   * project's, relative to a site root this page is not at — served from
   * /services/ they resolve to /services/assets/... and 404. The page publishes
   * the real directory on <html data-aidev-assets>, because BASE_URL here can be
   * a subdirectory and a hard-coded /assets/ would break on such an install.
   */
  const assetBase = document.documentElement.dataset.aidevAssets || 'assets/img/';

  const industryItems = [
    {
      index: '01',
      title: 'Healthcare & Life Sciences',
      subtitle: 'HIPAA & CLINICAL AI',
      icon: 'fa-solid fa-heart-pulse',
      desc: 'AI retinal scan segmentation, MRI/CT pathology detection & HIPAA clinical transcription with zero-retention private cloud VPC enclaves.',
      metric: '99.4% Diagnostic Accuracy',
      image: 'assets/img/industry-healthcare-ai.jpg',
      color: '#22D3EE'
    },
    {
      index: '02',
      title: 'FinTech, Banking & Insurance',
      subtitle: 'SUB-50MS FRAUD DEFENSE',
      icon: 'fa-solid fa-chart-line',
      desc: 'Sub-50ms payment fraud scoring, automated credit underwriting, algorithmic risk modeling & conversational wealth copilots.',
      metric: '99.9% Defense Precision',
      image: 'assets/img/industry-fintech-ai.jpg',
      color: '#3B5EFD'
    },
    {
      index: '03',
      title: 'Retail & Hyperlocal Commerce',
      subtitle: 'MULTILINGUAL CONVERSIONS',
      icon: 'fa-solid fa-cart-shopping',
      desc: 'Multilingual voice ordering copilots in 25+ Indian languages, real-time merchant inventory balancing & dynamic pricing engines.',
      metric: '3.4x Conversion Lift',
      image: 'assets/img/industry-retail-ai.jpg',
      color: '#D946EF'
    },
    {
      index: '04',
      title: 'Manufacturing & Industry 4.0',
      subtitle: 'EDGE VISION & IOT',
      icon: 'fa-solid fa-industry',
      desc: 'High-speed 60 FPS optical defect vision, IoT vibration anomaly predictive maintenance & factory worker safety analytics.',
      metric: '60 FPS Edge Vision',
      image: 'assets/img/industry-manufacturing-ai.jpg',
      color: '#F59E0B'
    },
    {
      index: '05',
      title: 'Autonomous Fleet & Logistics',
      subtitle: 'ROUTE OPTIMIZATION',
      icon: 'fa-solid fa-truck-fast',
      desc: 'Dynamic multi-point route optimization, automated bill-of-lading (BOL) OCR & predictive telemetry vehicle maintenance.',
      metric: '24% Fuel Savings',
      image: 'assets/img/industry-logistics-ai.jpg',
      color: '#10B981'
    },
    {
      index: '06',
      title: 'Real Estate & Smart Cities',
      subtitle: '3D TWINS & PROPTECH',
      icon: 'fa-solid fa-city',
      desc: 'Automated valuation models (AVM), 3D WebGL digital twin visualizers & smart energy IoT copilots for sustainable infrastructure.',
      metric: 'Real-time 3D Twins',
      image: 'assets/img/industry-smartcity-ai.jpg',
      color: '#8B2FC9'
    }
  ];

  function initRotundaCarousel() {
    const container = document.getElementById('rotunda-carousel-container');
    const ring = document.getElementById('rotunda-3d-ring');
    if (!container || !ring) return;

    const n = industryItems.length;
    const angleStep = (Math.PI * 2) / n;

    // HUD Elements
    const titleEl = document.getElementById('rotunda-hud-title');
    const descEl = document.getElementById('rotunda-hud-desc');
    const metricEl = document.getElementById('rotunda-hud-metric');
    const countEl = document.getElementById('rotunda-hud-count');
    const pillsContainer = document.getElementById('rotunda-industry-pills');
    const btnPrev = document.getElementById('rotunda-btn-prev');
    const btnNext = document.getElementById('rotunda-btn-next');

    // Build Cards
    ring.innerHTML = '';
    const cards = [];

    industryItems.forEach((item, i) => {
      const card = document.createElement('div');
      card.className = 'rotunda-3d-card corner-bracket-wrap';
      card.dataset.index = i;
      card.innerHTML = `
        <div class="corner-bracket-bottom-left"></div>
        <div class="corner-bracket-bottom-right"></div>
        <div class="rotunda-card-media">
          <img src="${assetBase + item.image.replace('assets/img/', '')}" alt="${item.title}" draggable="false" loading="lazy">
          <div class="rotunda-card-badge" style="border-color: ${item.color}66; color: ${item.color};">
            <i class="${item.icon}"></i> ${item.subtitle}
          </div>
          <div class="rotunda-card-num">${item.index} / 06</div>
        </div>
        <div class="rotunda-card-body">
          <div>
            <h4 class="rotunda-card-title">${item.title}</h4>
            <p class="rotunda-card-desc">${item.desc}</p>
          </div>
          <div class="rotunda-card-metric-chip" style="color: ${item.color}; background: ${item.color}15; border: 1px solid ${item.color}33;">
            <i class="fa-solid fa-circle-check"></i>
            <span>${item.metric}</span>
          </div>
        </div>
      `;
      ring.appendChild(card);
      cards.push(card);
    });

    let currentAngle = 0;
    let targetAngle = 0;
    let dragVelocity = 0;
    let isDragging = false;
    let isPointerOver = false;
    let lastActiveIndex = -1;
    let lastTime = performance.now();

    const drag = {
      startX: 0,
      startAngle: 0,
      lastX: 0,
      lastT: 0,
      moved: false
    };

    function updateActiveHUD(activeIdx) {
      const item = industryItems[activeIdx];
      if (!item) return;

      if (titleEl) titleEl.textContent = item.title;
      if (descEl) descEl.textContent = item.desc;
      if (metricEl) metricEl.innerHTML = `<i class="fa-solid fa-circle-check"></i> ${item.metric}`;
      if (countEl) countEl.textContent = `${item.index} / 06`;

      if (pillsContainer) {
        const pills = pillsContainer.querySelectorAll('.quick-pill-btn');
        pills.forEach((p, i) => {
          p.classList.toggle('active', i === activeIdx);
        });
      }

      cards.forEach((c, idx) => {
        c.classList.toggle('active-card', idx === activeIdx);
      });
    }

    function wrapAngle(rad) {
      const t = Math.PI * 2;
      return ((((rad + Math.PI) % t) + t) % t) - Math.PI;
    }

    function getDimensions() {
      const w = container.clientWidth || window.innerWidth || 1200;
      const isMobile = w <= 768;
      const radiusX = isMobile ? Math.min(320, w * 0.42) : Math.min(520, w * 0.38);
      const radiusZ = radiusX * 0.72;
      return { w, isMobile, radiusX, radiusZ };
    }

    // Mathematical 3D Render Loop
    function renderCards() {
      const { radiusX, radiusZ } = getDimensions();

      // Find closest centered index
      const normalizedRot = wrapAngle(-currentAngle);
      let activeIdx = Math.round(normalizedRot / angleStep);
      activeIdx = ((activeIdx % n) + n) % n;

      if (activeIdx !== lastActiveIndex) {
        lastActiveIndex = activeIdx;
        updateActiveHUD(activeIdx);
      }

      cards.forEach((card, i) => {
        const theta = wrapAngle(i * angleStep + currentAngle);
        const cosTheta = Math.cos(theta);
        const sinTheta = Math.sin(theta);

        // 3D Coordinates
        const x = sinTheta * radiusX;
        const z = (cosTheta - 1) * radiusZ; // center front is 0, back is -2*radiusZ
        const rotateY = (theta * 180) / Math.PI * 0.65; // inward facing angle
        
        // Depth styling
        const depthRatio = (cosTheta + 1) / 2; // 1 at front, 0 at back
        const scale = 0.76 + 0.28 * depthRatio;
        const opacity = depthRatio > 0.15 ? 0.35 + 0.65 * depthRatio : 0.12;
        const zIndex = Math.round(depthRatio * 1000);

        card.style.transform = `translate3d(${x}px, 0px, ${z}px) rotateY(${rotateY}deg) scale(${scale})`;
        card.style.opacity = opacity;
        card.style.zIndex = zIndex;
      });
    }

    // Continuous 60-120 FPS Spring Physics Animation
    function animate(now) {
      requestAnimationFrame(animate);
      const dt = Math.min(0.064, (now - lastTime) / 1000);
      lastTime = now;

      // Gentle auto-rotation when idle
      if (!isDragging && !isPointerOver && Math.abs(targetAngle - currentAngle) < 0.001) {
        targetAngle -= 0.05 * dt; // slow panoramic drift
      }

      // Butter-Smooth Spring Interpolation
      const diff = targetAngle - currentAngle;
      if (Math.abs(diff) > 0.0001) {
        currentAngle += diff * (1 - Math.exp(-dt * 14));
      } else {
        currentAngle = targetAngle;
      }

      renderCards();
    }
    requestAnimationFrame(animate);

    // Pointer / Touch Drag Handlers
    function onPointerDown(e) {
      isDragging = true;
      drag.startX = e.clientX;
      drag.startAngle = targetAngle;
      drag.lastX = e.clientX;
      drag.lastT = performance.now();
      drag.moved = false;
      dragVelocity = 0;
      container.style.cursor = 'grabbing';
      try { container.setPointerCapture(e.pointerId); } catch (_) {}
    }

    function onPointerMove(e) {
      if (!isDragging) return;
      const now = performance.now();
      const dx = e.clientX - drag.lastX;
      if (Math.abs(e.clientX - drag.startX) > 4) drag.moved = true;

      const dt = Math.max(1, now - drag.lastT);
      dragVelocity = (dx / dt) * 0.0035;
      drag.lastX = e.clientX;
      drag.lastT = now;

      targetAngle += dx * 0.0042;
    }

    function onPointerUp(e) {
      if (!isDragging) return;
      isDragging = false;
      container.style.cursor = 'grab';
      try { container.releasePointerCapture(e.pointerId); } catch (_) {}

      // Apply kinetic momentum flick
      targetAngle += dragVelocity * 10;
      dragVelocity = 0;
    }

    container.addEventListener('pointerdown', onPointerDown);
    window.addEventListener('pointermove', onPointerMove);
    window.addEventListener('pointerup', onPointerUp);
    window.addEventListener('pointercancel', onPointerUp);

    container.addEventListener('pointerenter', () => { isPointerOver = true; });
    container.addEventListener('pointerleave', () => { isPointerOver = false; });

    // Butter-Smooth Mouse Wheel / Trackpad Rotation
    container.addEventListener('wheel', (e) => {
      e.preventDefault();
      const delta = (Math.abs(e.deltaX) > Math.abs(e.deltaY) ? e.deltaX : e.deltaY);
      targetAngle -= delta * 0.0022;
    }, { passive: false });

    // Snap to Specific Industry with Shortest Angular Distance
    function snapToIndustry(idx) {
      const currentMod = wrapAngle(-targetAngle);
      const targetMod = wrapAngle(idx * angleStep);
      let diff = wrapAngle(targetMod - currentMod);
      targetAngle -= diff;
    }

    if (pillsContainer) {
      pillsContainer.addEventListener('click', (e) => {
        const pill = e.target.closest('.quick-pill-btn');
        if (pill) {
          const idx = parseInt(pill.getAttribute('data-index'), 10);
          if (!isNaN(idx)) snapToIndustry(idx);
        }
      });
    }

    if (btnPrev) {
      btnPrev.addEventListener('click', () => {
        targetAngle += angleStep;
      });
    }

    if (btnNext) {
      btnNext.addEventListener('click', () => {
        targetAngle -= angleStep;
      });
    }

    // Direct Card Click Rotation
    ring.addEventListener('click', (e) => {
      if (drag.moved) return;
      const card = e.target.closest('.rotunda-3d-card');
      if (card) {
        const idx = parseInt(card.dataset.index, 10);
        if (!isNaN(idx)) snapToIndustry(idx);
      }
    });

    // Resize Handler
    window.addEventListener('resize', () => {
      renderCards();
    });

    updateActiveHUD(0);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initRotundaCarousel);
  } else {
    initRotundaCarousel();
  }
})();
