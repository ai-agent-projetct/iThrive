/**
 * Mobile app cost & timeline estimator.
 *
 * The React original held this in component state; here the server renders the
 * choices and the numbers live in one data attribute, so the section is a
 * complete, readable price list before any JavaScript runs and this file only
 * has to do the arithmetic.
 *
 * The maths is the source repository's, unchanged:
 *   total = (platform base + selected feature prices) x design multiplier
 *   weeks = max(3, round(4 + features x 0.8))
 */

(function () {
  'use strict';

  const root = document.querySelector('[data-estimator]');
  if (!root) return;

  let cfg;
  try { cfg = JSON.parse(root.dataset.config); } catch { return; }

  const out = {
    total:    root.querySelector('[data-estimator-total]'),
    weeks:    root.querySelector('[data-estimator-weeks]'),
    platform: root.querySelector('[data-estimator-platform]'),
    count:    root.querySelector('[data-estimator-count]'),
    design:   root.querySelector('[data-estimator-design]'),
  };

  let currency = 'inr';

  const money = (value) => (currency === 'inr'
    // en-IN groups in lakhs — 2,80,000 rather than 280,000 — which is the
    // convention the rupee figures were written in.
    ? '₹' + value.toLocaleString('en-IN')
    : '$' + value.toLocaleString('en-US'));

  function render() {
    const platformId = root.querySelector('input[name="est-platform"]:checked')?.value;
    const designId   = root.querySelector('input[name="est-design"]:checked')?.value;
    const chosen     = Array.from(root.querySelectorAll('input[name="est-feature"]:checked'))
                            .map((i) => i.value);

    const platform = cfg.platforms.find((p) => p.id === platformId) || cfg.platforms[2];
    const design   = cfg.design.find((d) => d.id === designId) || cfg.design[1];

    let sum = 0;
    for (const id of chosen) {
      const feature = cfg.features.find((f) => f.id === id);
      if (feature) sum += currency === 'inr' ? feature.inr : feature.usd;
    }

    const base  = currency === 'inr' ? platform.inr : platform.usd;
    const total = Math.round((base + sum) * design.mult);
    const weeks = Math.max(3, Math.round(4 + chosen.length * 0.8));

    out.total.textContent    = money(total);
    out.weeks.textContent    = 'Estimated delivery: ' + weeks + '–' + (weeks + 2) + ' weeks';
    out.platform.textContent = platform.label;
    out.count.textContent    = chosen.length + (chosen.length === 1 ? ' module' : ' modules');
    out.design.textContent   = design.label;

    // The label carries the active state, since a bare radio or checkbox is
    // invisible against this design.
    root.querySelectorAll('.estimator-choice').forEach((label) => {
      const field = label.querySelector('input');
      label.classList.toggle('is-active', Boolean(field && field.checked));
    });
  }

  root.addEventListener('change', render);

  root.querySelectorAll('[data-estimator-currency]').forEach((button) => {
    button.addEventListener('click', () => {
      currency = button.dataset.estimatorCurrency;
      root.querySelectorAll('[data-estimator-currency]').forEach((b) => {
        b.classList.toggle('is-active', b === button);
      });
      render();
    });
  });

  render();
})();
