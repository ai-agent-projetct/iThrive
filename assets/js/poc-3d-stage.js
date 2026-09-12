/**
 * PoC 3D Interactive WebGL Engine & 3D Tilt Experience
 * Powered by Three.js & Spline-inspired interaction
 */
import * as THREE from '/assets/vendor/three/three.module.js';

document.addEventListener('DOMContentLoaded', () => {
  initThreeStage();
  init3DCardTilt();
  initCylinderCarousel();
});

function initThreeStage() {
  const container = document.getElementById('poc-three-canvas');
  if (!container) return;

  const w = container.clientWidth || container.parentElement.clientWidth || 1200;
  const h = container.clientHeight || container.parentElement.clientHeight || 680;

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, w / h, 0.1, 1000);
  camera.position.z = 24;

  const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
  renderer.setSize(w, h);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
  container.appendChild(renderer.domElement);

  // Concentric Gyroscopic Rings (Data, Model, Network layers)
  const gimbalGroup = new THREE.Group();
  scene.add(gimbalGroup);

  const ringMat1 = new THREE.MeshBasicMaterial({ color: 0x4EA8FF, wireframe: true, transparent: true, opacity: 0.35 });
  const ring1 = new THREE.Mesh(new THREE.TorusGeometry(8, 0.04, 16, 100), ringMat1);
  gimbalGroup.add(ring1);

  const ringMat2 = new THREE.MeshBasicMaterial({ color: 0x00F2FE, wireframe: true, transparent: true, opacity: 0.3 });
  const ring2 = new THREE.Mesh(new THREE.TorusGeometry(6.4, 0.035, 16, 100), ringMat2);
  ring2.rotation.x = Math.PI / 3;
  gimbalGroup.add(ring2);

  const ringMat3 = new THREE.MeshBasicMaterial({ color: 0xB24BF3, wireframe: true, transparent: true, opacity: 0.25 });
  const ring3 = new THREE.Mesh(new THREE.TorusGeometry(4.8, 0.03, 16, 100), ringMat3);
  ring3.rotation.y = Math.PI / 4;
  gimbalGroup.add(ring3);

  // Central Verification Core (Pulsing Icosahedron)
  const coreMat = new THREE.MeshBasicMaterial({ color: 0x00F2FE, wireframe: true, transparent: true, opacity: 0.45 });
  const coreMesh = new THREE.Mesh(new THREE.IcosahedronGeometry(2.2, 1), coreMat);
  gimbalGroup.add(coreMesh);

  // Ambient Star / Data Packet Particles
  const particleCount = 200;
  const geom = new THREE.BufferGeometry();
  const positions = new Float32Array(particleCount * 3);
  for (let i = 0; i < particleCount * 3; i += 3) {
    positions[i] = (Math.random() - 0.5) * 36;
    positions[i + 1] = (Math.random() - 0.5) * 24;
    positions[i + 2] = (Math.random() - 0.5) * 16;
  }
  geom.setAttribute('position', new THREE.BufferAttribute(positions, 3));
  const particleMat = new THREE.PointsMaterial({ color: 0x4EA8FF, size: 0.12, transparent: true, opacity: 0.5 });
  const particleSystem = new THREE.Points(geom, particleMat);
  scene.add(particleSystem);

  // Mouse Parallax
  let mouseX = 0, mouseY = 0;
  let targetX = 0, targetY = 0;

  window.addEventListener('mousemove', (e) => {
    const rect = container.getBoundingClientRect();
    if (e.clientY >= rect.top - 200 && e.clientY <= rect.bottom + 200) {
      targetX = ((e.clientX - (rect.left + rect.width / 2)) / rect.width) * 0.8;
      targetY = ((e.clientY - (rect.top + rect.height / 2)) / rect.height) * 0.8;
    }
  });

  window.addEventListener('resize', () => {
    const nw = container.clientWidth || container.parentElement.clientWidth;
    const nh = container.clientHeight || container.parentElement.clientHeight;
    camera.aspect = nw / nh;
    camera.updateProjectionMatrix();
    renderer.setSize(nw, nh);
  });

  let time = 0;
  function animate() {
    requestAnimationFrame(animate);
    time += 0.01;

    mouseX += (targetX - mouseX) * 0.05;
    mouseY += (targetY - mouseY) * 0.05;

    ring1.rotation.z += 0.003;
    ring2.rotation.y += 0.004;
    ring3.rotation.x += 0.005;

    coreMesh.rotation.x += 0.005;
    coreMesh.rotation.y += 0.007;
    const scale = 1 + Math.sin(time * 2) * 0.06;
    coreMesh.scale.set(scale, scale, scale);

    gimbalGroup.rotation.y = mouseX * 0.5;
    gimbalGroup.rotation.x = -mouseY * 0.5;
    particleSystem.rotation.y += 0.0008;

    renderer.render(scene, camera);
  }
  animate();
}

function initCylinderCarousel() {
  const carousel = document.getElementById('poc-carousel');
  if (!carousel) return;

  const cards = Array.from(carousel.querySelectorAll('.poc-3d-card'));
  const total = cards.length;
  if (total === 0) return;

  const angleStep = 360 / total;
  const radius = window.innerWidth < 768 ? 260 : 380;
  let currentAngle = 0;
  let isDragging = false;
  let startX = 0;
  let autoPlay = true;

  // Position cards in a 3D circle
  cards.forEach((card, idx) => {
    const angle = idx * angleStep;
    card.style.transform = `rotateY(${angle}deg) translateZ(${radius}px)`;
  });

  function updateCarousel() {
    carousel.style.transform = `rotateY(${currentAngle}deg)`;
  }

  // Auto rotation
  setInterval(() => {
    if (autoPlay && !isDragging) {
      currentAngle -= 0.18;
      updateCarousel();
    }
  }, 16);

  // Mouse & touch drag
  const host = carousel.closest('.poc-3d-stage') || carousel;
  host.addEventListener('pointerdown', (e) => {
    isDragging = true;
    startX = e.clientX;
    autoPlay = false;
  });

  window.addEventListener('pointermove', (e) => {
    if (!isDragging) return;
    const delta = e.clientX - startX;
    currentAngle += delta * 0.25;
    startX = e.clientX;
    updateCarousel();
  });

  window.addEventListener('pointerup', () => {
    if (isDragging) {
      isDragging = false;
      setTimeout(() => { autoPlay = true; }, 3000);
    }
  });
}

function init3DCardTilt() {
  const tiltCards = document.querySelectorAll('.poc-tilt-card');
  tiltCards.forEach(card => {
    card.addEventListener('mousemove', (e) => {
      const rect = card.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;

      const centerX = rect.width / 2;
      const centerY = rect.height / 2;

      const rotateX = ((y - centerY) / centerY) * -8;
      const rotateY = ((x - centerX) / centerX) * 8;

      card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
      card.style.setProperty('--mouse-x', `${x}px`);
      card.style.setProperty('--mouse-y', `${y}px`);
    });

    card.addEventListener('mouseleave', () => {
      card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
    });
  });
}
