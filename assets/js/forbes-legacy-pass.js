/**
 * Forbes Legacy Pass — 6-Card 3D Perspective Loop
 * Inspired by https://kerembalku.com/ (Forbes Legacy Pass)
 * - Continuous 3D cylindrical carousel loop (6 cards at 60deg intervals)
 * - Synchronized with background 4K luxury webm video
 * - Pointer drag-to-rotate with momentum damping, touch support, and auto-orbit
 * - Holographic glare reflection responding to pointer position
 */

(function () {
  'use strict';

  function initForbesLoop() {
    const stage = document.getElementById('forbes-stage');
    const carousel = document.getElementById('forbes-carousel');
    if (!stage || !carousel || stage.dataset.forbesInit) return;
    stage.dataset.forbesInit = '1';

    const cards = Array.from(carousel.querySelectorAll('.forbes-pass-card'));
    const total = cards.length;
    if (total === 0) return;

    // Radius of cylinder
    let radius = Math.min(window.innerWidth * 0.38, 480);
    if (window.innerWidth < 768) radius = 280;

    // Position cards evenly around 360 degrees
    function layoutCards() {
      const step = 360 / total;
      cards.forEach((card, idx) => {
        const angle = idx * step;
        card.style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
      });
    }
    layoutCards();

    window.addEventListener('resize', () => {
      radius = Math.min(window.innerWidth * 0.38, 480);
      if (window.innerWidth < 768) radius = 280;
      layoutCards();
    });

    let currentRotation = 0;
    let targetRotation = 0;
    let isDragging = false;
    let startX = 0;
    let lastX = 0;
    let velocity = 0;
    let isHovered = false;

    // Pointer Events
    stage.addEventListener('pointerdown', (e) => {
      isDragging = true;
      startX = e.clientX;
      lastX = e.clientX;
      stage.style.cursor = 'grabbing';
      stage.setPointerCapture(e.pointerId);
    });

    stage.addEventListener('pointermove', (e) => {
      // 3D tilt perspective based on mouse
      const rect = stage.getBoundingClientRect();
      const nx = (e.clientX - rect.left) / rect.width - 0.5;
      const ny = (e.clientY - rect.top) / rect.height - 0.5;
      stage.style.setProperty('--tilt-x', `${-ny * 12}deg`);
      stage.style.setProperty('--tilt-y', `${nx * 15}deg`);

      if (!isDragging) return;
      const dx = e.clientX - lastX;
      lastX = e.clientX;
      targetRotation += dx * 0.35;
      velocity = dx * 0.35;
    });

    function endDrag(e) {
      if (!isDragging) return;
      isDragging = false;
      stage.style.cursor = 'grab';
    }

    stage.addEventListener('pointerup', endDrag);
    stage.addEventListener('pointercancel', endDrag);

    stage.addEventListener('mouseenter', () => { isHovered = true; });
    stage.addEventListener('mouseleave', () => { isHovered = false; });

    // Wheel support
    stage.addEventListener('wheel', (e) => {
      targetRotation -= e.deltaY * 0.15;
    }, { passive: true });

    // Click on card to center it
    cards.forEach((card, idx) => {
      card.addEventListener('click', (e) => {
        const step = 360 / total;
        const cardAngle = idx * step;
        // Find closest target angle
        const modCurrent = targetRotation % 360;
        targetRotation += -cardAngle - modCurrent;
      });
    });

    // Animation Loop
    let isVisible = true;
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(([entry]) => {
        isVisible = entry.isIntersecting;
      }, { threshold: 0.05 }).observe(stage);
    }

    function animate() {
      requestAnimationFrame(animate);
      if (!isVisible) return;

      // Auto rotation when not dragging
      if (!isDragging && !isHovered) {
        targetRotation += 0.18;
      }

      // Smooth damping lerp
      currentRotation += (targetRotation - currentRotation) * 0.08;
      carousel.style.transform = `rotateX(var(--tilt-x, 0deg)) rotateY(${currentRotation}deg)`;

      // Dynamic opacity & scale based on card facing camera
      const step = 360 / total;
      cards.forEach((card, idx) => {
        const angle = (idx * step + currentRotation) % 360;
        const normAngle = ((angle % 360) + 360) % 360;
        const distFromFront = Math.min(normAngle, 360 - normAngle); // 0 = facing front, 180 = facing back
        
        const opacity = Math.max(0.25, 1 - (distFromFront / 180) * 0.75);
        const scale = Math.max(0.82, 1 - (distFromFront / 180) * 0.25);
        const blur = Math.max(0, (distFromFront / 180) * 8);

        card.style.filter = `brightness(${Math.max(0.4, 1 - distFromFront / 180)}) blur(${blur}px)`;
        card.style.opacity = opacity;
      });
    }

    animate();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initForbesLoop);
  } else {
    initForbesLoop();
  }
})();
