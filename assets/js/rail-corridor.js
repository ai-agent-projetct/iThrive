/**
 * Scroll-driven image corridor.
 *
 * A `[data-corridor]` stage holds a list of cards. They start as an ordinary
 * grid — that is what a crawler, a reader with scripts off, and anyone under
 * prefers-reduced-motion gets, and the words are in the markup either way. When
 * this runs, the cards are lifted into a corridor receding away from the
 * viewer, and how far you have scrolled through the section decides which one
 * is at the front. The front card is the only one at full brightness; the rest
 * fall back in Z, dim and blur with distance.
 *
 * There is no WebGL here on purpose. The page already mounts several canvases,
 * and a sixth context is how a tab starts losing them.
 */

const SPACING = 420; /* px of Z between neighbouring cards */
const FRONT_Z = 40; /* how far forward the focused card sits */
const EASE = 0.12; /* how quickly the corridor follows the scroll target */

/** Distance in "cards" from the front, as a positive number. */
function depth(index, position) {
  return index - position;
}

function setup(stage) {
  const track = stage.querySelector('[data-corridor-track]');
  const cards = Array.from(stage.querySelectorAll('[data-corridor-card]'));
  if (!track || cards.length === 0) return;

  const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduced) return; /* the grid is the fallback, and it is a good one */

  stage.classList.add('is-corridor');

  let target = 0;
  let current = 0;
  let raf = 0;
  let visible = false;

  /* Where the section sits in its own scroll: 0 as its top reaches the middle
     of the viewport, 1 as its bottom leaves it. */
  const progress = () => {
    const r = stage.getBoundingClientRect();
    const span = r.height + window.innerHeight;
    const seen = window.innerHeight - r.top;
    return Math.max(0, Math.min(1, seen / span));
  };

  const paint = () => {
    cards.forEach((card, i) => {
      const d = depth(i, current);
      const z = -Math.abs(d) * SPACING + (d === 0 ? FRONT_Z : 0);
      /* A modest fan plus a turn: far enough for the stack to read as a
         corridor, near enough that the back cards stay in the frame. */
      const x = d * 13;
      const y = -Math.abs(d) * 10;
      const turn = d * -7;
      const near = Math.max(0, 1 - Math.abs(d) / 2.6);

      card.style.transform = `translate3d(${x}%, ${y}px, ${z}px) rotateY(${turn}deg)`;
      card.style.opacity = String(0.18 + near * 0.82);
      card.style.filter = `blur(${Math.min(6, Math.abs(d) * 2.1)}px)`;
      card.style.zIndex = String(100 - Math.round(Math.abs(d) * 10));
      card.classList.toggle('is-front', Math.abs(d) < 0.5);
      card.setAttribute('aria-current', Math.abs(d) < 0.5 ? 'true' : 'false');
    });
  };

  const tick = () => {
    raf = 0;
    const delta = target - current;
    current += delta * EASE;
    if (Math.abs(delta) < 0.001) current = target;
    paint();
    if (current !== target && visible) raf = requestAnimationFrame(tick);
  };

  const schedule = () => {
    if (!raf) raf = requestAnimationFrame(tick);
  };

  const onScroll = () => {
    if (!visible) return;
    target = progress() * (cards.length - 1);
    schedule();
  };

  /* Clicking a card brings it to the front without waiting for the scroll. */
  cards.forEach((card, i) => {
    card.addEventListener('click', (event) => {
      if (event.target.closest('a, button')) return;
      target = i;
      schedule();
    });
  });

  const io = new IntersectionObserver((entries) => {
    visible = entries[0].isIntersecting;
    if (visible) {
      onScroll();
      schedule();
    } else if (raf) {
      cancelAnimationFrame(raf);
      raf = 0;
    }
  }, { rootMargin: '120px' });

  io.observe(stage);

  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', onScroll, { passive: true });

  target = progress() * (cards.length - 1);
  current = target;
  paint();
}

document.querySelectorAll('[data-corridor]').forEach(setup);
