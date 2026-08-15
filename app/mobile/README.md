# Mobile app page — the embedded React build

`services/mobile-app-development.php` is the one page on this site that is not
PHP templates. It is the React app from
[ai-agent-projetct/mobile-app-page](https://github.com/ai-agent-projetct/mobile-app-page),
mounted inside a PHP page so the site's real header, navigation, footer, chat
widget and schema wrap around it.

## Rebuilding

```bash
cd app/mobile
npm install
npm run build
```

Output goes to `assets/dist/mobile/mobile-app.{js,css}` with fixed filenames —
the PHP template references them directly and `asset()` adds a filemtime
cache-buster.

## What differs from upstream, and why

Upstream is a standalone site. Five things had to change for it to live inside
another one; each is commented at the point it happens.

1. **`src/embed.jsx` replaces `src/main.jsx`.** It mounts the *sections only* —
   no Navbar, no Footer, no router — into `#ithrive-mobile-root`. Keeping the
   section order identical to upstream's `App.jsx` means a future upstream
   change shows up as a clean diff between those two files.
2. **No Tailwind CDN.** Upstream loads `cdn.tailwindcss.com`, which Tailwind
   ships for prototyping and explicitly not for production. Tailwind is compiled
   here instead, with the same theme extension upstream configured on the script
   tag.
3. **Preflight is off, and upstream's global CSS is scoped.** Preflight is a
   global reset; it would strip the type and layout off every other page on the
   site. Upstream's `*`, `html`, `body` and `h1-h6` rules are scoped under
   `.ithrive-mobile-app` for the same reason.
4. **`@tailwind utilities` is written last in `embed.css`.** The scoped reset
   sets `padding: 0` on every descendant and has the same specificity as a
   utility like `.px-8`, so source order decides. Upstream never hit this
   because the CDN injected its utilities after `index.css`.
5. **No `overflow-x: hidden` on the wrapper.** On `<body>` it is harmless; on a
   div it creates a scroll container, and a scroll container silently kills
   `position: sticky` for everything inside — which broke the scroll-scrubbed
   video stage.

## Deliberate content changes

- **Hero 3D**: `Phone3DCanvasV2` was replaced by `AppUniverse`, which mounts the
  scene from `assets/js/universe.js` (the client's own `3d-app-universe.html`,
  resized to its container instead of the window). This also dropped
  `@react-three/fiber`, `drei` and `three` from the bundle — 1096KB to 251KB.
- **App simulator**: the heading and app tabs moved above the video and the app
  details below it, so nothing covers the footage. The scrub readout, tech-stack
  chip, scroll hint and lock badge were removed. The section is one viewport
  tall rather than 350vh, because the scrub is wheel-driven and the extra 250vh
  was dead space.
- **Process flow**: heading is "Our Process Flow"; the wheel now holds the page
  until all five steps have played, then releases it.

## Assets

Videos live at `/videos` and images at `/images` — root-absolute, matching the
paths in upstream's components so those files need no edits.

The source videos are 4K and 63-82MB each. They are re-encoded to 1600x900,
24fps, CRF 26, **`-g 3`** — a keyframe every eighth of a second. The tight GOP
is the point: scrubbing seeks constantly, and a long GOP makes the decoder walk
back to the previous keyframe on every seek, which is what makes a scroll video
feel steppy.

```bash
ffmpeg -i source.mp4 -an -vf "scale=1600:900:flags=lanczos,fps=24" \
  -c:v libx264 -profile:v high -pix_fmt yuv420p \
  -g 3 -keyint_min 3 -sc_threshold 0 -crf 26 -preset medium \
  -movflags +faststart videos/name.mp4
```
