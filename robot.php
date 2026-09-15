<?php
/**
 * Robot — full-screen hero, the same tear-reveal treatment as neon.php.
 *
 * Two registered renders of one shot: the daylight plaza in front, the same
 * frame at neon night behind. Moving the pointer erases the daylight layer in
 * organic, torn patches that heal back over a few seconds, so the city drops
 * into night around the robot and the car and then comes back.
 *
 * The erase itself lives in assets/js/neon-reveal.js — this page only supplies
 * the two layers and the geometry custom properties it reads.
 */
declare(strict_types=1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>iThrive — Build better together</title>
<meta name="description" content="Intelligent apps and AI platforms, designed, built and shipped by a team that treats your product like its own.">
<meta name="theme-color" content="#07060f">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600&family=Inter:wght@400;500;600;800&display=swap" rel="stylesheet">
<style>
:root{
  --ink:#fff;
  --pill:#fff;
  --pill-ink:#141414;
  --pad:clamp(20px, 3.2vw, 44px);
  --fit-y:.5;             /* where contained art sits vertically (portrait only) */
  --fit-cover:1;          /* 1 = fill the frame, 0 = fit the whole frame in */
  --fit-ar:.5628;         /* the art's height / width — 1672 x 941 */
}
*{box-sizing:border-box}
html,body{margin:0;height:100%}
body{
  background:#07060f;color:var(--ink);
  font-family:Inter, system-ui, sans-serif;
  -webkit-font-smoothing:antialiased;
  overflow:hidden;
}

/* ---- stage ------------------------------------------------------------ */
.stage{position:relative;height:100dvh;width:100%;overflow:hidden;cursor:crosshair}
.layer{position:absolute;inset:0;width:100%;height:100%;pointer-events:none}
/* The whole frame is always on screen; the leftover area is filled with a
   blurred, over-scaled copy of the same shot so there are no letterbox bars. */
.layer--bleed{
  background:url(assets/img/robot/robot-night-wide.webp) 0 0/100% 100% no-repeat;
  filter:blur(48px) saturate(1.15);transform:scale(1.12);
}
.layer--back{object-fit:cover;object-position:50% 50%}
.layer--veil{display:block}
/* Unlike the neon page, the front layer here is a bright daylight shot, so the
   scrim has to carry white type over a blue sky and a pale plaza floor — the
   top and bottom bands are heavier, and the middle still stays clear so the
   robot, the car and the wall text read. */
.stage__scrim{
  position:absolute;inset:0;pointer-events:none;
  background:
    linear-gradient(180deg,
      rgba(5,4,12,.82) 0%,
      rgba(5,4,12,.42) 14%,
      rgba(5,4,12,.06) 34%,
      rgba(5,4,12,0)   48%,
      rgba(5,4,12,.42) 68%,
      rgba(5,4,12,.80) 86%,
      rgba(5,4,12,.94) 100%);
}

/* ---- nav -------------------------------------------------------------- */
.nav{
  position:absolute;top:0;left:0;right:0;z-index:3;
  display:flex;align-items:center;justify-content:space-between;
  gap:24px;padding:18px var(--pad);
}
.brand{display:flex;align-items:center;gap:12px;text-decoration:none;color:var(--ink)}
.brand img{width:30px;height:30px;border-radius:9px;display:block}
.brand span{font-family:Archivo,sans-serif;font-size:1.55rem;font-weight:500;letter-spacing:-.025em}
.nav__links{display:flex;align-items:center;gap:4px}
.nav__links a{
  font-family:Archivo,sans-serif;font-size:1rem;font-weight:500;letter-spacing:-.04em;
  color:var(--ink);text-decoration:none;padding:8px 20px;border-radius:999px;
  opacity:.9;transition:opacity .2s, background-color .2s;
}
.nav__links a:hover{opacity:1;background:rgba(255,255,255,.12)}

/* ---- pill button ------------------------------------------------------ */
.pill{
  display:inline-flex;align-items:center;justify-content:center;
  background:var(--pill);color:var(--pill-ink);text-decoration:none;
  border-radius:999px;padding:12px 24px;
  font-family:Archivo,sans-serif;font-size:.94rem;font-weight:600;letter-spacing:.025em;
  transition:transform .25s cubic-bezier(.16,1,.3,1), box-shadow .25s;
}
.pill:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(0,0,0,.35)}

/* ---- bottom band ------------------------------------------------------ */
.band{
  position:absolute;left:0;right:0;bottom:0;z-index:2;
  display:flex;align-items:flex-end;justify-content:space-between;
  gap:40px;padding:0 var(--pad) clamp(28px,4.4vh,56px);
}
.eyebrow{
  display:flex;align-items:center;gap:10px;margin:0 0 22px;
  font-size:.875rem;font-weight:600;letter-spacing:.01em;text-transform:uppercase;
}
.eyebrow svg{width:14px;height:14px;flex:none}
h1{
  margin:0;text-transform:uppercase;
  font-size:clamp(2.5rem, 5.6vw, 5.4rem);
  font-weight:800;line-height:.86;letter-spacing:-.045em;
  text-shadow:0 2px 30px rgba(5,4,12,.55);
}
.support{max-width:34ch;text-align:right;margin-left:auto}
.support p{margin:0 0 26px;font-size:clamp(1rem,1.35vw,1.25rem);line-height:1.2;letter-spacing:-.01em}
.band > *{animation:rise .9s cubic-bezier(.16,1,.3,1) both;animation-delay:.15s}
.band > *:last-child{animation-delay:.3s}
@keyframes rise{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:none}}

/* Fades out for good once the visitor has moved the pointer. */
.hint{
  position:absolute;left:50%;top:calc(50% + 150px);transform:translateX(-50%);
  z-index:2;margin:0;font-size:.78rem;font-weight:500;letter-spacing:.16em;
  text-transform:uppercase;color:rgba(255,255,255,.92);pointer-events:none;
  text-shadow:0 2px 14px rgba(5,4,12,.9);
  animation:pulse 2.6s ease-in-out infinite;transition:opacity .5s;
}
.is-touched .hint{animation:none;opacity:0}
@keyframes pulse{0%,100%{opacity:.5}50%{opacity:1}}

@media (max-width:860px){
  /* Portrait can't crop the wide frame and keep the wall text, the robot and
     the plate in shot, so it fits the whole frame instead, held high with the
     copy in the clear space below. */
  :root{--fit-y:.26;--fit-cover:0}
  .layer--back{
    inset:auto;left:0;width:100%;height:calc(100vw * var(--fit-ar));
    top:calc((100dvh - 100vw * var(--fit-ar)) * var(--fit-y));
  }
  .nav__links{display:none}
  .hint{top:auto;bottom:38dvh}
  .band{flex-direction:column;align-items:flex-start;gap:26px}
  .support{text-align:left;margin-left:0;max-width:38ch}
  .support p{margin-bottom:20px}
}
@media (prefers-reduced-motion:reduce){ .band > *,.hint{animation:none} }
</style>
</head>
<body>

<main class="stage" id="stage" data-neon-reveal
      data-front="assets/img/robot/robot-day-wide.webp">
  <div class="layer layer--bleed"></div>
  <img class="layer layer--back" id="back" src="assets/img/robot/robot-night-wide.webp" alt="The iThrive robot leaning on a black car in front of a neon city skyline at night" fetchpriority="high">
  <canvas class="layer layer--veil" id="veil"></canvas>
  <div class="stage__scrim"></div>

  <nav class="nav">
    <a class="brand" href="index.php">
      <img src="assets/img/logo-mark.png" width="30" height="30" alt="">
      <span>iThrive</span>
    </a>
    <div class="nav__links">
      <a href="services.php">Services</a>
      <a href="solutions.php">Solutions</a>
      <a href="case-studies.php">Case Studies</a>
      <a href="company/about.php">Company</a>
    </div>
    <a class="pill" href="contact.php">START YOUR PROJECT</a>
  </nav>

  <p class="hint">Move to reveal</p>

  <div class="band">
    <div>
      <p class="eyebrow">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0l2.4 7.2L21.6 9.6 14.4 12 12 19.2 9.6 12 2.4 9.6 9.6 7.2z"/></svg>
        AI-native product studio
      </p>
      <h1>Drive it<br>forward.</h1>
    </div>

    <div class="support">
      <p>Intelligent apps and AI platforms, designed, built and shipped by a team that treats your product like its own.</p>
      <a class="pill" href="services/ai-native-product-development.php">SEE HOW WE BUILD</a>
    </div>
  </div>
</main>

<script type="module" src="assets/js/neon-reveal.js"></script>

</body>
</html>
