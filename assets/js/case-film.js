/**
 * Case study product films.
 *
 * The markup ships a plain <video controls>, which is the whole experience
 * without JavaScript. Here that becomes the frameless, muted, looping film:
 * native controls off, playback only while the film is on screen (no decoding
 * or data spent on a video nobody is looking at), and two small buttons for
 * pause and sound, since moving content needs a way to stop it.
 *
 * Under prefers-reduced-motion nothing autoplays; the film waits on its poster
 * until the visitor presses play.
 */

(function () {
  'use strict';

  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  document.querySelectorAll('[data-case-film]').forEach((video) => {
    const stage    = video.closest('.case-film-stage');
    const controls = stage && stage.querySelector('.case-film-controls');
    const playBtn  = stage && stage.querySelector('[data-case-film-play]');
    const soundBtn = stage && stage.querySelector('[data-case-film-sound]');
    if (!controls || !playBtn || !soundBtn) return;

    video.controls = false;
    video.muted = true;
    controls.hidden = false;

    // Set once the visitor pauses by hand, so scrolling back does not undo it.
    let heldByUser = reduce;

    const sync = () => {
      const playing = !video.paused;
      stage.classList.toggle('is-playing', playing);
      stage.classList.toggle('is-muted', video.muted);
      playBtn.setAttribute('aria-label', playing ? 'Pause video' : 'Play video');
      soundBtn.setAttribute('aria-label', video.muted ? 'Turn sound on' : 'Turn sound off');
    };

    const play = () => {
      const p = video.play();
      if (p && p.catch) p.catch(() => sync()); // autoplay refused: stay on the poster
    };

    playBtn.addEventListener('click', () => {
      if (video.paused) { heldByUser = false; play(); }
      else { heldByUser = true; video.pause(); }
    });

    soundBtn.addEventListener('click', () => {
      video.muted = !video.muted;
      if (!video.muted && video.paused) { heldByUser = false; play(); }
      sync();
    });

    video.addEventListener('play', sync);
    video.addEventListener('pause', sync);
    video.addEventListener('volumechange', sync);

    if ('IntersectionObserver' in window) {
      new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && entry.intersectionRatio >= 0.35) {
            if (!heldByUser) play();
          } else if (!video.paused) {
            video.pause();
          }
        });
      }, { threshold: [0, 0.35] }).observe(video);
    } else if (!heldByUser) {
      play();
    }

    sync();
  });
})();
