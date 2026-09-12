/**
 * SmoothImageCursor.js
 * Interactive cursor trail component reverse-engineered from:
 * https://framer.com/m/SmoothImageCursor-KDy2rX.js@hlsQst4eU2SiqLNxx4IO
 *
 * Enhanced with iThrive Cyber-Tech aesthetic:
 * - Alternating cyan (#00F2FE) and violet (#B24BF3) glowing borders
 * - Real-time photographic POC image pool (10 unique proof assets)
 * - Corner calipers and micro-telemetry HUD tags
 * - Physics-based rotation, scaling, and smooth alpha decay
 * - Zero interference with underlying buttons, links, and CTAs (pointer-events: none)
 */

(function () {
  'use strict';

  // Configuration matching Framer SmoothImageCursor with cyber palette
  const CONFIG = {
    imageScale: 140,            // Base width in px
    sizeRandomness: 0.18,       // +/- 18% size variation
    rotationRandomness: 22,     // +/- 22 degrees random tilt
    trailSpacing: 38,           // Min distance in px between image spawns
    fadeOutDuration: 0.85,      // Fade-out lifecycle in seconds
    maxImagesOnScreen: 18,      // Max active stickers
    imageOpacity: 0.95,         // Initial opacity
    imageBorderRadius: '12px',  // Rounded corners
  };

  function init() {
    const container = document.getElementById('poc-cursor-hero') || document.querySelector('.poc-hero-3d-section');
    if (!container || container.dataset.cursorInit) return;
    container.dataset.cursorInit = '1';

    // 10 Photographic PoC Images from assets/img/poc-3d/
    const imagePool = [
      { src: '/assets/img/poc-3d/poc-01-data-pipeline.jpg', tag: 'STREAM VERIFIED' },
      { src: '/assets/img/poc-3d/poc-02-model-load.jpg', tag: '10K CONCURRENCY' },
      { src: '/assets/img/poc-3d/poc-03-integration.jpg', tag: 'API HANDSHAKE' },
      { src: '/assets/img/poc-3d/poc-04-latency.jpg', tag: '14.8ms SLA' },
      { src: '/assets/img/poc-3d/poc-05-cost-calc.jpg', tag: '$0.00042 / CALL' },
      { src: '/assets/img/poc-3d/poc-06-verdict.jpg', tag: 'GO // 99.8%' },
      { src: '/assets/img/poc-3d/poc-07-early-risk.jpg', tag: 'DE-RISKED' },
      { src: '/assets/img/poc-3d/poc-08-capital-saved.jpg', tag: 'BUDGET PROTECTED' },
      { src: '/assets/img/poc-3d/poc-09-working-proof.jpg', tag: 'VALIDATED' },
      { src: '/assets/img/poc-3d/poc-10-small-test.jpg', tag: 'KERNEL ISOLATION' }
    ];

    // Preload images
    imagePool.forEach(item => {
      const img = new Image();
      img.src = item.src;
    });

    // Create cursor trail canvas overlay
    const overlay = document.createElement('div');
    overlay.className = 'smooth-cursor-overlay';
    overlay.style.position = 'absolute';
    overlay.style.inset = '0';
    overlay.style.overflow = 'hidden';
    overlay.style.pointerEvents = 'none';
    overlay.style.zIndex = '20';
    container.style.position = 'relative';
    container.appendChild(overlay);

    let stickers = [];
    let lastSpawn = null;
    let stickerId = 0;
    let poolIndex = 0;
    let rafId = null;

    function spawnSticker(clientX, clientY) {
      const rect = container.getBoundingClientRect();
      const inside = clientX >= rect.left && clientX <= rect.right && clientY >= rect.top && clientY <= rect.bottom;
      if (!inside) {
        lastSpawn = null;
        return;
      }

      const relX = clientX - rect.left;
      const relY = clientY - rect.top;

      if (lastSpawn) {
        const dx = relX - lastSpawn.x;
        const dy = relY - lastSpawn.y;
        const dist = Math.hypot(dx, dy);
        if (dist < CONFIG.trailSpacing) return;
      }

      const item = imagePool[poolIndex % imagePool.length];
      poolIndex++;

      const randSize = (Math.random() * 2 - 1) * CONFIG.sizeRandomness;
      const width = Math.round(CONFIG.imageScale * (1 + randSize));
      const height = Math.round(width * 0.66); // 3:2 photographic ratio
      const rotation = (Math.random() * 2 - 1) * CONFIG.rotationRandomness;
      const isCyan = poolIndex % 2 === 0;

      // DOM Node for the sticker
      const node = document.createElement('div');
      node.className = 'smooth-cursor-sticker';
      node.style.position = 'absolute';
      node.style.left = relX + 'px';
      node.style.top = relY + 'px';
      node.style.width = width + 'px';
      node.style.height = height + 'px';
      node.style.borderRadius = CONFIG.imageBorderRadius;
      node.style.overflow = 'hidden';
      node.style.pointerEvents = 'none';
      node.style.userSelect = 'none';
      node.style.transformOrigin = 'center center';
      node.style.border = isCyan ? '1px solid rgba(0, 242, 254, 0.55)' : '1px solid rgba(178, 75, 243, 0.55)';
      node.style.boxShadow = isCyan 
        ? '0 12px 32px rgba(0, 0, 0, 0.85), 0 0 24px rgba(0, 242, 254, 0.28)'
        : '0 12px 32px rgba(0, 0, 0, 0.85), 0 0 24px rgba(178, 75, 243, 0.28)';
      node.style.willChange = 'transform, opacity';
      node.style.transform = `translate(-50%, -50%) rotate(${rotation}deg) scale(1)`;

      const imgEl = document.createElement('img');
      imgEl.src = item.src;
      imgEl.alt = item.tag;
      imgEl.style.width = '100%';
      imgEl.style.height = '100%';
      imgEl.style.objectFit = 'cover';
      imgEl.style.display = 'block';
      imgEl.style.pointerEvents = 'none';
      node.appendChild(imgEl);

      // Micro telemetry badge
      const badge = document.createElement('div');
      badge.textContent = item.tag;
      badge.style.position = 'absolute';
      badge.style.bottom = '6px';
      badge.style.left = '6px';
      badge.style.background = 'rgba(3, 7, 18, 0.85)';
      badge.style.backdropFilter = 'blur(4px)';
      badge.style.border = isCyan ? '1px solid rgba(0, 242, 254, 0.4)' : '1px solid rgba(178, 75, 243, 0.4)';
      badge.style.borderRadius = '4px';
      badge.style.padding = '2px 6px';
      badge.style.fontFamily = "'JetBrains Mono', monospace";
      badge.style.fontSize = '8px';
      badge.style.fontWeight = '700';
      badge.style.letterSpacing = '0.08em';
      badge.style.color = isCyan ? '#00F2FE' : '#E0AAFF';
      badge.style.pointerEvents = 'none';
      node.appendChild(badge);

      overlay.appendChild(node);

      const sticker = {
        id: stickerId++,
        node: node,
        createdAt: performance.now(),
        rotation: rotation,
      };

      stickers.push(sticker);
      if (stickers.length > CONFIG.maxImagesOnScreen) {
        const removed = stickers.shift();
        if (removed.node && removed.node.parentNode) {
          removed.node.parentNode.removeChild(removed.node);
        }
      }

      lastSpawn = { x: relX, y: relY };
      startLoop();
    }

    function onMouseMove(e) {
      spawnSticker(e.clientX, e.clientY);
    }

    function onTouchMove(e) {
      if (e.touches && e.touches[0]) {
        spawnSticker(e.touches[0].clientX, e.touches[0].clientY);
      }
    }

    window.addEventListener('mousemove', onMouseMove, { passive: true });
    window.addEventListener('touchmove', onTouchMove, { passive: true });

    function tick() {
      const now = performance.now();
      const lifeMs = CONFIG.fadeOutDuration * 1000;
      const surviving = [];

      for (let i = 0; i < stickers.length; i++) {
        const s = stickers[i];
        const age = now - s.createdAt;
        const progress = Math.max(0, Math.min(1, age / lifeMs));

        if (progress < 1) {
          const currentOpacity = CONFIG.imageOpacity * (1 - progress);
          const currentScale = 1 - progress * 0.45;
          s.node.style.opacity = currentOpacity;
          s.node.style.transform = `translate(-50%, -50%) rotate(${s.rotation}deg) scale(${currentScale})`;
          surviving.push(s);
        } else {
          if (s.node && s.node.parentNode) {
            s.node.parentNode.removeChild(s.node);
          }
        }
      }

      stickers = surviving;

      if (stickers.length > 0) {
        rafId = requestAnimationFrame(tick);
      } else {
        rafId = null;
      }
    }

    function startLoop() {
      if (rafId === null) {
        rafId = requestAnimationFrame(tick);
      }
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
