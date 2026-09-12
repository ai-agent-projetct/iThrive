/**
 * iThrive Micro-SaaS - Core Page & 3D Orchestration Module
 * Connects 3D Hero Fan Deck, 3D Real-World Scenarios Blueprint,
 * 3D Card Tilt, Framework Accordions, and Verticals Tabs.
 */

import { initHero3D } from './saas-hero-3d.js';
import { initScenarios3D } from './saas-scenarios-3d.js';
import { init3DTilt } from './saas-3d-tilt.js';

document.addEventListener('DOMContentLoaded', () => {
  // 1. Initialize 3D Engines
  try { initHero3D(); } catch (e) { console.warn('Hero 3D init error:', e); }
  try { initScenarios3D(); } catch (e) { console.warn('Scenarios 3D init error:', e); }
  try { init3DTilt(); } catch (e) { console.warn('3D Tilt init error:', e); }

  // 2. Real-World Client Scenario Switcher
  const scenarioBtns = document.querySelectorAll('[data-scenario-btn]');
  const scenarioPanels = document.querySelectorAll('[data-scenario-panel]');

  if (scenarioBtns.length && scenarioPanels.length) {
    scenarioBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const scenarioId = btn.dataset.scenarioBtn;

        // Update button states
        scenarioBtns.forEach(b => {
          const isActive = (b === btn);
          b.classList.toggle('is-active', isActive);
          b.setAttribute('aria-selected', isActive ? 'true' : 'false');
        });

        // Show matching analysis panel
        scenarioPanels.forEach(panel => {
          const isMatch = (panel.dataset.scenarioPanel === scenarioId);
          panel.classList.toggle('is-active', isMatch);
          panel.style.display = isMatch ? 'flex' : 'none';
        });

        // Trigger 3D WebGL architecture reconfiguration
        if (typeof window.setScenario3D === 'function') {
          window.setScenario3D(scenarioId);
        }
      });
    });
  }

  // 3. Framework Accordion
  const frameCards = document.querySelectorAll('[data-frame-card]');
  if (frameCards.length) {
    frameCards.forEach(card => {
      card.addEventListener('click', (e) => {
        // Toggle card open state
        const wasOpen = card.classList.contains('is-open');
        frameCards.forEach(c => {
          c.classList.remove('is-open');
          c.setAttribute('aria-expanded', 'false');
        });
        if (!wasOpen) {
          card.classList.add('is-open');
          card.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  // 4. Industry Verticals Tabs
  const tabBtns = document.querySelectorAll('[data-ms-tab]');
  const tabPanels = document.querySelectorAll('[data-ms-panel]');

  if (tabBtns.length && tabPanels.length) {
    tabBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const target = btn.dataset.msTab;
        tabBtns.forEach(b => b.classList.toggle('is-active', b === btn));
        tabPanels.forEach(p => {
          const isTarget = (p.dataset.msPanel === target);
          p.classList.toggle('is-active', isTarget);
          p.hidden = !isTarget;
        });
      });
    });
  }

  // 5. Connect Scenario CTA to Modal
  const scenarioCta = document.getElementById('msScenarioCta');
  if (scenarioCta) {
    scenarioCta.addEventListener('click', () => {
      const activeBtn = document.querySelector('[data-scenario-btn].is-active');
      const scenarioTitle = activeBtn ? activeBtn.querySelector('.ms-scen-title')?.textContent : 'Micro-SaaS';
      const modalBtn = document.querySelector('[data-modal-open]');
      if (modalBtn) {
        modalBtn.setAttribute('data-modal-service', 'Micro-SaaS: ' + (scenarioTitle || 'Custom Scope'));
        modalBtn.click();
      }
    });
  }
});
