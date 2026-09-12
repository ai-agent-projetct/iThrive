/**
 * iThrive Micro-SaaS - 3D Perspective Card Tilt & Specular Glare Physics
 * Applies smooth gyroscopic 3D tilt, specular glare reflection and depth pop.
 */

export function init3DTilt() {
  const cards = document.querySelectorAll('.ms-shard, .ms-frame-card, .ms-adv-card, .ms-runway-card');
  if (!cards.length) return;

  const maxTilt = 12; // degrees

  cards.forEach(card => {
    // Add specular glare overlay if missing
    let glare = card.querySelector('.ms-glare');
    if (!glare) {
      glare = document.createElement('div');
      glare.className = 'ms-glare';
      card.appendChild(glare);
    }

    card.addEventListener('pointermove', e => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const px = (x / rect.width) * 2 - 1; // -1 to 1
      const py = (y / rect.height) * 2 - 1; // -1 to 1

      const tiltX = -py * maxTilt;
      const tiltY = px * maxTilt;

      card.style.transform = `perspective(1100px) rotateX(${tiltX.toFixed(2)}deg) rotateY(${tiltY.toFixed(2)}deg) translateZ(16px) scale3d(1.02, 1.02, 1.02)`;
      
      const glareX = (x / rect.width) * 100;
      const glareY = (y / rect.height) * 100;
      card.style.setProperty('--glare-x', `${glareX}%`);
      card.style.setProperty('--glare-y', `${glareY}%`);
      card.style.setProperty('--glare-opacity', '0.35');
    });

    card.addEventListener('pointerleave', () => {
      card.style.transform = '';
      card.style.setProperty('--glare-opacity', '0');
    });
  });
}
