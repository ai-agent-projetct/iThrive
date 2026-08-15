/**
 * App Universe — the interactive 3D scene, embedded.
 *
 * This is the scene from 3d-app-universe.html, unchanged apart from one thing:
 * it used to own the whole window, sizing its camera, renderer and pointer
 * maths to window.innerWidth/innerHeight. Inside a hero it has to size to its
 * own box instead, so those four places now read the container's rect.
 *
 * Exposed as a function rather than run on load, because the hero that holds it
 * is rendered by React — the element does not exist when this file parses.
 *
 * Requires three r128 and its example scripts, vendored in assets/vendor/three128.
 */

window.ithriveUniverse = function (mountEl) {
  if (!mountEl || mountEl.dataset.universeReady) return;
  mountEl.dataset.universeReady = '1';

  const boxW = () => mountEl.clientWidth  || window.innerWidth;
  const boxH = () => mountEl.clientHeight || window.innerHeight;

  // A hero is not always on screen; pause the loop when it is not.
  let visible = true;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0 }).observe(mountEl);
  }
  window.__universeVisible = () => visible;

  // The box changes with layout, not just with the window.
  if ('ResizeObserver' in window) {
    new ResizeObserver(() => window.dispatchEvent(new Event('resize'))).observe(mountEl);
  }


(function(){

/* ============================================================
   CORE SETUP
============================================================ */
const container = mountEl;
const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(42, boxW()/boxH(), 0.1, 100);
camera.position.set(2.1, 1.0, 9.2);
const HOME_POS = camera.position.clone();

const renderer = new THREE.WebGLRenderer({ antialias:true, alpha:true, powerPreference:'high-performance' });
renderer.setSize(boxW(), boxH());
renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 0.95;
renderer.outputEncoding = THREE.sRGBEncoding;
container.appendChild(renderer.domElement);

const controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping = true;
controls.dampingFactor = 0.07;
controls.minDistance = 4.5;
controls.maxDistance = 16;
controls.autoRotate = true;
controls.autoRotateSpeed = 0.7;
controls.enablePan = false;
controls.target.set(0, 0.1, 0);
// Keep the camera on the front side always — icon artwork only exists on the
// front face of each tile, so a full 360° orbit would show blank backs.
controls.minAzimuthAngle = -Math.PI * 0.4;
controls.maxAzimuthAngle = Math.PI * 0.4;
controls.minPolarAngle = Math.PI * 0.28;
controls.maxPolarAngle = Math.PI * 0.68;

/* ============================================================
   LIGHTING
============================================================ */
scene.add(new THREE.AmbientLight(0x9fb4ff, 0.55));

const key = new THREE.DirectionalLight(0xffffff, 1.35);
key.position.set(5, 8, 6);
key.castShadow = true;
key.shadow.mapSize.set(2048,2048);
key.shadow.camera.near = 1; key.shadow.camera.far = 25;
key.shadow.radius = 4;
scene.add(key);

const rimBlue = new THREE.PointLight(0x53c7ff, 1.6, 20, 2);
rimBlue.position.set(-6, 1, -3);
scene.add(rimBlue);

const rimPink = new THREE.PointLight(0xff5fd1, 1.4, 20, 2);
rimPink.position.set(6, -2, 4);
scene.add(rimPink);

const fill = new THREE.PointLight(0xffe4a8, 0.5, 18);
fill.position.set(0, -4, 5);
scene.add(fill);

/* Soft ground shadow catcher */
const shadowMat = new THREE.ShadowMaterial({ opacity: 0.35 });
const shadowPlane = new THREE.Mesh(new THREE.PlaneGeometry(40,40), shadowMat);
shadowPlane.rotation.x = -Math.PI/2;
shadowPlane.position.y = -3.35;
shadowPlane.receiveShadow = true;
scene.add(shadowPlane);

/* ============================================================
   PARTICLE STARFIELD
============================================================ */
function makeGlowSprite(){
  const c = document.createElement('canvas'); c.width = c.height = 128;
  const ctx = c.getContext('2d');
  const g = ctx.createRadialGradient(64,64,0,64,64,64);
  g.addColorStop(0,'rgba(255,255,255,1)');
  g.addColorStop(0.35,'rgba(255,255,255,0.5)');
  g.addColorStop(1,'rgba(255,255,255,0)');
  ctx.fillStyle = g; ctx.fillRect(0,0,128,128);
  return new THREE.CanvasTexture(c);
}
const glowTex = makeGlowSprite();

const starCount = 900;
const starGeo = new THREE.BufferGeometry();
const starPos = new Float32Array(starCount*3);
const starCol = new Float32Array(starCount*3);
const palette = [ [0.43,0.78,1], [1,0.44,0.85], [0.7,0.85,1], [1,1,1] ];
for(let i=0;i<starCount;i++){
  const r = 7 + Math.random()*14;
  const th = Math.random()*Math.PI*2;
  const ph = Math.acos((Math.random()*2)-1);
  starPos[i*3]   = r*Math.sin(ph)*Math.cos(th);
  starPos[i*3+1] = r*Math.cos(ph)*0.6;
  starPos[i*3+2] = r*Math.sin(ph)*Math.sin(th);
  const c = palette[(Math.random()*palette.length)|0];
  starCol[i*3]=c[0]; starCol[i*3+1]=c[1]; starCol[i*3+2]=c[2];
}
starGeo.setAttribute('position', new THREE.BufferAttribute(starPos,3));
starGeo.setAttribute('color', new THREE.BufferAttribute(starCol,3));
const starMat = new THREE.PointsMaterial({
  size:0.05, map:glowTex, transparent:true, depthWrite:false,
  blending:THREE.AdditiveBlending, vertexColors:true, opacity:0.85
});
const stars = new THREE.Points(starGeo, starMat);
scene.add(stars);

/* ============================================================
   ROUNDED-RECT SHAPE HELPER (for realistic phone + tiles)
============================================================ */
function roundedRectShape(w,h,r){
  const s = new THREE.Shape();
  const x = -w/2, y = -h/2;
  s.moveTo(x, y+r);
  s.lineTo(x, y+h-r);
  s.quadraticCurveTo(x, y+h, x+r, y+h);
  s.lineTo(x+w-r, y+h);
  s.quadraticCurveTo(x+w, y+h, x+w, y+h-r);
  s.lineTo(x+w, y+r);
  s.quadraticCurveTo(x+w, y, x+w-r, y);
  s.lineTo(x+r, y);
  s.quadraticCurveTo(x, y, x, y+r);
  return s;
}

/* ============================================================
   PHONE ASSEMBLY
============================================================ */
const phoneRoot = new THREE.Group();
scene.add(phoneRoot);

const PW = 2.7, PH = 5.5, PT = 0.26;
const bodyShape = roundedRectShape(PW, PH, 0.34);
const bodyGeo = new THREE.ExtrudeGeometry(bodyShape, {
  depth: PT, bevelEnabled:true, bevelThickness:0.035, bevelSize:0.03, bevelSegments:6, curveSegments:12
});
bodyGeo.center();
const bodyMat = new THREE.MeshPhysicalMaterial({
  color:0x131722, metalness:0.9, roughness:0.28,
  clearcoat:0.6, clearcoatRoughness:0.25, reflectivity:0.6
});
const phoneBody = new THREE.Mesh(bodyGeo, bodyMat);
phoneBody.castShadow = true; phoneBody.receiveShadow = true;
phoneRoot.add(phoneBody);

// camera bump / lens on back (subtle realism)
const lensGeo = new THREE.CylinderGeometry(0.16,0.16,0.05,32);
const lensMat = new THREE.MeshPhysicalMaterial({color:0x0a0d14, metalness:0.8, roughness:0.15, clearcoat:1});
const lens = new THREE.Mesh(lensGeo, lensMat);
lens.rotation.x = Math.PI/2;
lens.position.set(0.85, 2.05, -PT/2-0.02);
phoneRoot.add(lens);

/* ---- Live animated screen (canvas texture, redrawn each frame) ---- */
const screenCanvas = document.createElement('canvas');
screenCanvas.width = 512; screenCanvas.height = 1040;
const sctx = screenCanvas.getContext('2d');
const screenTex = new THREE.CanvasTexture(screenCanvas);
screenTex.encoding = THREE.sRGBEncoding;

function drawScreen(t){
  const w = screenCanvas.width, h = screenCanvas.height;
  const g = sctx.createLinearGradient(0,0,w,h);
  const hue1 = (t*10)%360, hue2 = (hue1+70)%360, hue3=(hue1+140)%360;
  g.addColorStop(0, `hsl(${hue1},70%,18%)`);
  g.addColorStop(0.55, `hsl(${hue2},65%,14%)`);
  g.addColorStop(1, `hsl(${hue3},70%,10%)`);
  sctx.fillStyle = g; sctx.fillRect(0,0,w,h);

  // soft moving blobs (live wallpaper feel)
  for(let i=0;i<4;i++){
    const bx = w*0.5 + Math.sin(t*0.4+i*2.1)*w*0.32;
    const by = h*0.45 + Math.cos(t*0.33+i*1.7)*h*0.28;
    const rad = 160+i*40;
    const rg = sctx.createRadialGradient(bx,by,0,bx,by,rad);
    rg.addColorStop(0, `hsla(${(hue1+i*60)%360},90%,65%,0.35)`);
    rg.addColorStop(1, `hsla(${(hue1+i*60)%360},90%,65%,0)`);
    sctx.fillStyle = rg;
    sctx.beginPath(); sctx.arc(bx,by,rad,0,Math.PI*2); sctx.fill();
  }

  // status bar
  sctx.fillStyle = 'rgba(255,255,255,0.92)';
  sctx.font = '600 26px -apple-system, Segoe UI, sans-serif';
  sctx.textBaseline = 'middle';
  const now = new Date();
  const hh = now.getHours()%12 || 12, mm = String(now.getMinutes()).padStart(2,'0');
  sctx.fillText(`${hh}:${mm}`, 30, 50);
  sctx.font = '600 20px sans-serif';
  sctx.textAlign='right';
  sctx.fillText('5G  100%', w-30, 50);
  sctx.textAlign='left';

  // notch
  sctx.fillStyle='rgba(0,0,0,0.55)';
  sctx.beginPath();
  sctx.roundRect(w/2-80, 6, 160, 34, 20);
  sctx.fill();

  // dock at bottom
  const dockY = h-110, dockH=90;
  sctx.fillStyle='rgba(255,255,255,0.10)';
  sctx.beginPath(); sctx.roundRect(24, dockY, w-48, dockH, 28); sctx.fill();
  const dockIcons = ['📞','💬','🌐','📷'];
  const cellW = (w-48)/4;
  dockIcons.forEach((ic,i)=>{
    sctx.font = '42px "Segoe UI Emoji", sans-serif';
    sctx.textAlign='center';
    sctx.fillText(ic, 24+cellW*i+cellW/2, dockY+dockH/2+2);
  });
  sctx.textAlign='left';

  // home indicator
  sctx.fillStyle='rgba(255,255,255,0.55)';
  sctx.beginPath(); sctx.roundRect(w/2-60, h-18, 120, 5, 4); sctx.fill();

  screenTex.needsUpdate = true;
}
drawScreen(0);

const screenGeo = new THREE.PlaneGeometry(PW-0.22, PH-0.22);
const screenMat = new THREE.MeshStandardMaterial({
  map: screenTex, emissive:0xffffff, emissiveMap:screenTex, emissiveIntensity:0.35,
  roughness:0.32, metalness:0.05
});
const screenMesh = new THREE.Mesh(screenGeo, screenMat);
screenMesh.position.z = PT/2 + 0.045 + 0.03;
phoneRoot.add(screenMesh);

// glass cover over screen (fresnel-ish clearcoat)
const glassGeo = new THREE.PlaneGeometry(PW-0.1, PH-0.1);
const glassMat = new THREE.MeshPhysicalMaterial({
  color:0xffffff, transparent:true, opacity:0.06, roughness:0.05, metalness:0,
  clearcoat:1, clearcoatRoughness:0.05, transmission:0.9, thickness:0.05
});
const glass = new THREE.Mesh(glassGeo, glassMat);
glass.position.z = PT/2 + 0.045 + 0.045;
phoneRoot.add(glass);

/* ============================================================
   APP ICON DEFINITIONS (original, non-branded glyph set)
============================================================ */
const appsConfig = [
  { name:'Mail',      c1:'#ff6b6b', c2:'#c0392b', icon:'mail' },
  { name:'Book',      c1:'#a78bfa', c2:'#5b21b6', icon:'book' },
  { name:'Bus',       c1:'#34d399', c2:'#047857', icon:'bus' },
  { name:'Download',  c1:'#60a5fa', c2:'#1d4ed8', icon:'download' },
  { name:'Gift',      c1:'#f472b6', c2:'#be185d', icon:'gift' },
  { name:'Folder',    c1:'#a3a833', c2:'#6b6e12', icon:'folder' },
  { name:'Play',      c1:'#2dd4bf', c2:'#0f766e', icon:'play' },
  { name:'Train',     c1:'#f87171', c2:'#b91c1c', icon:'train' },
  { name:'Ideas',     c1:'#a3a833', c2:'#6b6e12', icon:'lightbulb' },
  { name:'Analytics', c1:'#60a5fa', c2:'#1e3a8a', icon:'chart' },
  { name:'Flights',   c1:'#a78bfa', c2:'#5b21b6', icon:'travel' },
  { name:'Weather',   c1:'#93c5fd', c2:'#334155', icon:'cloud' },
  { name:'Camera',    c1:'#b993ff', c2:'#6c2bd9', icon:'camera' },
  { name:'Cart',      c1:'#f472b6', c2:'#9d174d', icon:'cart' },
  { name:'Clock',     c1:'#94a3b8', c2:'#334155', icon:'clock' },
  { name:'Sync',      c1:'#4ade80', c2:'#166534', icon:'sync' },
  { name:'Call',      c1:'#fb923c', c2:'#c2410c', icon:'call' },
  { name:'Likes',     c1:'#60a5fa', c2:'#1e40af', icon:'thumbsup' },
  { name:'Contacts',  c1:'#f87171', c2:'#b91c1c', icon:'contact' },
  { name:'Reports',   c1:'#c084fc', c2:'#6b21a8', icon:'bug' },
  { name:'Wi‑Fi',     c1:'#a3e635', c2:'#4d7c0f', icon:'wifi' },
  { name:'Settings',  c1:'#facc15', c2:'#a16207', icon:'gear' },
  { name:'Secure Pay',c1:'#fb923c', c2:'#c2410c', icon:'dollarlock' },
  { name:'Car',       c1:'#ef4444', c2:'#7f1d1d', icon:'rides' },
  { name:'Notes',     c1:'#c084fc', c2:'#6b21a8', icon:'quill' },
  { name:'Network',   c1:'#fb923c', c2:'#9a3412', icon:'globe' },
];

/* roundRect polyfill — icon + screen textures depend on it; without native
   support the whole texture generation throws and tiles render blank. */
if (!CanvasRenderingContext2D.prototype.roundRect) {
  CanvasRenderingContext2D.prototype.roundRect = function(x, y, w, h, r){
    const rad = Math.min(typeof r === 'number' ? r : 0, w/2, h/2);
    this.moveTo(x + rad, y);
    this.lineTo(x + w - rad, y);
    this.quadraticCurveTo(x + w, y, x + w, y + rad);
    this.lineTo(x + w, y + h - rad);
    this.quadraticCurveTo(x + w, y + h, x + w - rad, y + h);
    this.lineTo(x + rad, y + h);
    this.quadraticCurveTo(x, y + h, x, y + h - rad);
    this.lineTo(x, y + rad);
    this.quadraticCurveTo(x, y, x + rad, y);
    return this;
  };
}

function drawGlyph(ctx, key){
  ctx.save();
  ctx.translate(128,128);
  ctx.strokeStyle = '#ffffff';
  ctx.fillStyle = '#ffffff';
  ctx.lineCap = 'round';
  ctx.lineJoin = 'round';

  switch(key){
    case 'maps': {
      ctx.beginPath();
      ctx.moveTo(0,-58);
      ctx.bezierCurveTo(34,-58, 50,-32, 50,-8);
      ctx.bezierCurveTo(50,26, 14,52, 0,64);
      ctx.bezierCurveTo(-14,52, -50,26, -50,-8);
      ctx.bezierCurveTo(-50,-32, -34,-58, 0,-58);
      ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      ctx.beginPath(); ctx.arc(0,-6,20,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation='source-over';
      break;
    }
    case 'browser': {
      ctx.lineWidth=7; ctx.beginPath(); ctx.arc(0,0,54,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.ellipse(0,0,54,20,0,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-54,0); ctx.lineTo(54,0); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(0,-54); ctx.lineTo(0,54); ctx.stroke();
      break;
    }
    case 'safari': {
      ctx.lineWidth=7; ctx.beginPath(); ctx.arc(0,0,54,0,Math.PI*2); ctx.stroke();
      for(let i=0;i<12;i++){
        const a=i*Math.PI/6, r1=46,r2=54;
        ctx.beginPath();
        ctx.moveTo(Math.cos(a)*r1, Math.sin(a)*r1);
        ctx.lineTo(Math.cos(a)*r2, Math.sin(a)*r2);
        ctx.lineWidth=3; ctx.stroke();
      }
      ctx.save(); ctx.rotate(-0.6);
      ctx.beginPath(); ctx.moveTo(0,-40); ctx.lineTo(10,0); ctx.lineTo(0,40); ctx.lineTo(-10,0); ctx.closePath();
      ctx.fillStyle='#ff4d4d'; ctx.fill();
      ctx.beginPath(); ctx.moveTo(0,-40); ctx.lineTo(10,0); ctx.lineTo(0,0); ctx.closePath();
      ctx.fillStyle='#ffffff'; ctx.fill();
      ctx.restore();
      break;
    }
    case 'edge': {
      ctx.beginPath();
      ctx.moveTo(-48,20);
      ctx.bezierCurveTo(-48,-40, 10,-58, 48,-30);
      ctx.bezierCurveTo(20,-42, -18,-30, -18,4);
      ctx.bezierCurveTo(-18,44, 30,54, 52,18);
      ctx.bezierCurveTo(40,58, -10,64, -48,20);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'pdf': {
      ctx.lineWidth=6;
      ctx.beginPath();
      ctx.moveTo(-34,-56); ctx.lineTo(16,-56); ctx.lineTo(34,-38); ctx.lineTo(34,56);
      ctx.lineTo(-34,56); ctx.closePath(); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(16,-56); ctx.lineTo(16,-38); ctx.lineTo(34,-38); ctx.stroke();
      ctx.font='700 22px sans-serif'; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillText('PDF',0,14);
      break;
    }
    case 'notebook': {
      ctx.lineWidth=6;
      ctx.strokeRect(-40,-56,80,112);
      for(let i=0;i<5;i++){ ctx.beginPath(); ctx.arc(-40,-40+i*20,6,0,Math.PI*2); ctx.stroke(); }
      ctx.lineWidth=4;
      for(let i=0;i<3;i++){ ctx.beginPath(); ctx.moveTo(-18,-20+i*22); ctx.lineTo(30,-20+i*22); ctx.stroke(); }
      break;
    }
    case 'travel': {
      ctx.beginPath();
      ctx.moveTo(0,-58);
      ctx.lineTo(12,-10); ctx.lineTo(52,10); ctx.lineTo(52,24); ctx.lineTo(12,16);
      ctx.lineTo(10,50); ctx.lineTo(24,60); ctx.lineTo(24,70); ctx.lineTo(0,62);
      ctx.lineTo(-24,70); ctx.lineTo(-24,60); ctx.lineTo(-10,50); ctx.lineTo(-12,16);
      ctx.lineTo(-52,24); ctx.lineTo(-52,10); ctx.lineTo(-12,-10);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'stays': {
      ctx.lineWidth=7;
      ctx.beginPath(); ctx.moveTo(-52,58); ctx.lineTo(-52,0); ctx.lineTo(52,0); ctx.lineTo(52,58); ctx.stroke();
      ctx.beginPath(); ctx.arc(-30,0,16,Math.PI,0); ctx.fill();
      ctx.fillRect(-52,-4,104,8);
      ctx.lineWidth=6; ctx.beginPath(); ctx.moveTo(-40,58); ctx.lineTo(-40,30); ctx.lineTo(40,30); ctx.lineTo(40,58); ctx.stroke();
      break;
    }
    case 'rides': {
      ctx.beginPath();
      ctx.moveTo(-52,14); ctx.lineTo(-38,-18); ctx.quadraticCurveTo(-20,-32,0,-32);
      ctx.quadraticCurveTo(20,-32,38,-18); ctx.lineTo(52,14); ctx.lineTo(52,36); ctx.lineTo(38,36);
      ctx.lineTo(38,24); ctx.lineTo(-38,24); ctx.lineTo(-38,36); ctx.lineTo(-52,36); ctx.closePath(); ctx.fill();
      ctx.fillStyle='#111827';
      ctx.beginPath(); ctx.arc(-28,36,12,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc(28,36,12,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'biketaxi': {
      ctx.lineWidth=8;
      ctx.beginPath(); ctx.arc(-32,32,22,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.arc(32,32,22,0,Math.PI*2); ctx.stroke();
      ctx.beginPath();
      ctx.moveTo(-32,32); ctx.lineTo(-6,-8); ctx.lineTo(30,-8);
      ctx.moveTo(-6,-8); ctx.lineTo(10,32); ctx.lineTo(32,32);
      ctx.moveTo(-32,32); ctx.lineTo(10,32);
      ctx.stroke();
      ctx.beginPath(); ctx.arc(30,-8,7,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'mail': {
      ctx.lineWidth=7;
      ctx.strokeRect(-54,-38,108,76);
      ctx.beginPath(); ctx.moveTo(-54,-38); ctx.lineTo(0,8); ctx.lineTo(54,-38); ctx.stroke();
      break;
    }
    case 'chat': {
      ctx.beginPath();
      ctx.moveTo(-52,-38);
      ctx.quadraticCurveTo(-56,-52,-40,-52);
      ctx.lineTo(40,-52);
      ctx.quadraticCurveTo(56,-52,56,-36);
      ctx.lineTo(56,10);
      ctx.quadraticCurveTo(56,26,40,26);
      ctx.lineTo(-8,26);
      ctx.lineTo(-30,48);
      ctx.lineTo(-26,26);
      ctx.lineTo(-40,26);
      ctx.quadraticCurveTo(-56,26,-56,10);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'music': {
      ctx.lineWidth=8;
      ctx.beginPath(); ctx.moveTo(-14,50); ctx.lineTo(-14,-46); ctx.lineTo(40,-58); ctx.lineTo(40,38); ctx.stroke();
      ctx.beginPath(); ctx.ellipse(-28,50,16,12,0.2,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.ellipse(26,38,16,12,0.2,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'camera': {
      ctx.lineWidth=6;
      ctx.beginPath(); ctx.roundRect(-56,-30,112,80,14); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-20,-30); ctx.lineTo(-10,-46); ctx.lineTo(10,-46); ctx.lineTo(20,-30); ctx.stroke();
      ctx.beginPath(); ctx.arc(0,10,26,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.arc(0,10,12,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'wallet': {
      ctx.lineWidth=6;
      ctx.beginPath(); ctx.roundRect(-56,-38,112,76,16); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-56,-10); ctx.lineTo(56,-10); ctx.stroke();
      ctx.beginPath(); ctx.roundRect(18,10,26,18,4); ctx.fill();
      break;
    }
    case 'weather': {
      ctx.beginPath(); ctx.arc(-14,-18,22,0,Math.PI*2); ctx.fill();
      for(let i=0;i<8;i++){
        const a=i*Math.PI/4;
        ctx.beginPath();
        ctx.moveTo(-14+Math.cos(a)*30,-18+Math.sin(a)*30);
        ctx.lineTo(-14+Math.cos(a)*40,-18+Math.sin(a)*40);
        ctx.lineWidth=5; ctx.stroke();
      }
      ctx.beginPath();
      ctx.arc(6,20,26,Math.PI*0.5,Math.PI*1.55);
      ctx.arc(30,4,20,Math.PI*1.05,Math.PI*2.05);
      ctx.arc(52,24,18,Math.PI*1.3,Math.PI*0.35);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'heart': {
      ctx.beginPath();
      ctx.moveTo(0,44);
      ctx.bezierCurveTo(-56,4, -46,-52, -6,-52);
      ctx.bezierCurveTo(6,-52, 0,-34, 0,-24);
      ctx.bezierCurveTo(0,-34, -6,-52, 6,-52);
      ctx.bezierCurveTo(46,-52, 56,4, 0,44);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'wifi': {
      ctx.lineWidth=8;
      for(let i=0;i<3;i++){
        ctx.beginPath();
        ctx.arc(0,28,20+i*22,Math.PI*1.2,Math.PI*1.8);
        ctx.stroke();
      }
      ctx.beginPath(); ctx.arc(0,28,6,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'headphones': {
      ctx.lineWidth=9;
      ctx.beginPath(); ctx.arc(0,0,46,Math.PI,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.roundRect(-56,-4,22,44,8); ctx.fill();
      ctx.beginPath(); ctx.roundRect(34,-4,22,44,8); ctx.fill();
      break;
    }
    case 'house': {
      ctx.beginPath();
      ctx.moveTo(0,-58); ctx.lineTo(56,-4); ctx.lineTo(42,-4); ctx.lineTo(42,54);
      ctx.lineTo(-42,54); ctx.lineTo(-42,-4); ctx.lineTo(-56,-4); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      ctx.beginPath(); ctx.roundRect(-14,10,28,44,4); ctx.fill();
      ctx.globalCompositeOperation='source-over';
      break;
    }
    case 'cart': {
      ctx.lineWidth=7;
      ctx.beginPath();
      ctx.moveTo(-54,-40); ctx.lineTo(-38,-40); ctx.lineTo(-16,18); ctx.lineTo(42,18); ctx.lineTo(54,-20); ctx.lineTo(-30,-20);
      ctx.stroke();
      ctx.beginPath(); ctx.arc(-10,42,10,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc(32,42,10,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'gift': {
      ctx.lineWidth=6;
      ctx.beginPath(); ctx.roundRect(-48,-8,96,64,6); ctx.fill();
      ctx.fillRect(-48,-26,96,20);
      ctx.fillRect(-8,-26,16,90);
      ctx.beginPath();
      ctx.arc(-16,-30,14,0,Math.PI*2); ctx.arc(16,-30,14,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'search': {
      ctx.lineWidth=10;
      ctx.beginPath(); ctx.arc(-8,-8,34,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(18,18); ctx.lineTo(52,52); ctx.stroke();
      break;
    }
    case 'star': {
      ctx.beginPath();
      for(let i=0;i<5;i++){
        const a = -Math.PI/2 + i*(Math.PI*2/5);
        const a2 = a + Math.PI/5;
        const [ox,oy] = [Math.cos(a)*54, Math.sin(a)*54];
        const [ix,iy] = [Math.cos(a2)*22, Math.sin(a2)*22];
        if(i===0) ctx.moveTo(ox,oy); else ctx.lineTo(ox,oy);
        ctx.lineTo(ix,iy);
      }
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'play': {
      ctx.lineWidth=7;
      ctx.beginPath(); ctx.arc(0,0,54,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-16,-26); ctx.lineTo(-16,26); ctx.lineTo(28,0); ctx.closePath(); ctx.fill();
      break;
    }
    case 'photo': {
      ctx.lineWidth=6;
      const sides=6, R=52;
      ctx.beginPath();
      for(let i=0;i<sides;i++){
        const a = -Math.PI/2 + i*(Math.PI*2/sides);
        const [px,py]=[Math.cos(a)*R, Math.sin(a)*R];
        if(i===0) ctx.moveTo(px,py); else ctx.lineTo(px,py);
      }
      ctx.closePath(); ctx.stroke();
      ctx.beginPath(); ctx.arc(0,0,18,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'call': {
      ctx.beginPath();
      ctx.moveTo(-46,-30);
      ctx.bezierCurveTo(-52,-46,-26,-56,-16,-40);
      ctx.bezierCurveTo(-10,-30,-16,-24,-10,-16);
      ctx.bezierCurveTo(0,-2,4,2,18,10);
      ctx.bezierCurveTo(26,16,32,10,42,16);
      ctx.bezierCurveTo(58,26,48,52,32,46);
      ctx.bezierCurveTo(-6,32,-32,8,-46,-30);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'pay': {
      ctx.lineWidth=6;
      ctx.beginPath(); ctx.roundRect(-56,-38,112,76,16); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-56,-12); ctx.lineTo(56,-12); ctx.stroke();
      ctx.font='700 40px sans-serif'; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillText('$',0,20);
      break;
    }
    case 'write': {
      ctx.save(); ctx.rotate(0.78);
      ctx.fillRect(-8,-56,16,86);
      ctx.beginPath(); ctx.moveTo(-8,30); ctx.lineTo(8,30); ctx.lineTo(0,52); ctx.closePath(); ctx.fill();
      ctx.fillRect(-8,-56,16,14);
      ctx.restore();
      break;
    }
    case 'network': {
      ctx.lineWidth=5;
      const pts=[[0,-48],[-46,30],[46,30]];
      ctx.beginPath();
      ctx.moveTo(pts[0][0],pts[0][1]); ctx.lineTo(pts[1][0],pts[1][1]);
      ctx.lineTo(pts[2][0],pts[2][1]); ctx.closePath(); ctx.stroke();
      pts.forEach(p=>{ ctx.beginPath(); ctx.arc(p[0],p[1],14,0,Math.PI*2); ctx.fill(); });
      break;
    }
    case 'book': {
      ctx.beginPath();
      ctx.moveTo(0,-40);
      ctx.bezierCurveTo(-10,-46,-40,-46,-52,-38);
      ctx.lineTo(-52,40);
      ctx.bezierCurveTo(-40,32,-10,32,0,40);
      ctx.closePath(); ctx.fill();
      ctx.beginPath();
      ctx.moveTo(0,-40);
      ctx.bezierCurveTo(10,-46,40,-46,52,-38);
      ctx.lineTo(52,40);
      ctx.bezierCurveTo(40,32,10,32,0,40);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'bus': {
      ctx.beginPath(); ctx.roundRect(-54,-34,108,68,16); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      for(let i=-1;i<=1;i++){ ctx.beginPath(); ctx.roundRect(-40+i*36,-22,26,22,4); ctx.fill(); }
      ctx.globalCompositeOperation='source-over';
      ctx.beginPath(); ctx.arc(-30,38,11,0,Math.PI*2); ctx.arc(30,38,11,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'download': {
      ctx.lineWidth=8;
      ctx.beginPath(); ctx.moveTo(0,-50); ctx.lineTo(0,16); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-22,-6); ctx.lineTo(0,18); ctx.lineTo(22,-6); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-38,32); ctx.lineTo(-38,50); ctx.lineTo(38,50); ctx.lineTo(38,32); ctx.stroke();
      break;
    }
    case 'folder': {
      ctx.beginPath();
      ctx.moveTo(-54,-18); ctx.lineTo(-20,-18); ctx.lineTo(-10,-32); ctx.lineTo(20,-32); ctx.lineTo(30,-18); ctx.lineTo(54,-18);
      ctx.lineTo(54,38); ctx.lineTo(-54,38); ctx.closePath(); ctx.fill();
      break;
    }
    case 'train': {
      ctx.beginPath(); ctx.roundRect(-46,-38,92,70,18); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      ctx.beginPath(); ctx.roundRect(-30,-24,60,26,6); ctx.fill();
      ctx.globalCompositeOperation='source-over';
      ctx.beginPath(); ctx.arc(-22,40,10,0,Math.PI*2); ctx.arc(22,40,10,0,Math.PI*2); ctx.fill();
      ctx.fillRect(-10,-58,20,14);
      break;
    }
    case 'lightbulb': {
      ctx.beginPath(); ctx.arc(0,-10,34,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.moveTo(-14,20); ctx.lineTo(14,20); ctx.lineTo(10,40); ctx.lineTo(-10,40); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      for(let i=0;i<3;i++){ ctx.beginPath(); ctx.rect(-12,25+i*5,24,2); ctx.fill(); }
      ctx.globalCompositeOperation='source-over';
      break;
    }
    case 'chart': {
      ctx.lineWidth=8;
      ctx.beginPath(); ctx.moveTo(-50,52); ctx.lineTo(-50,-50); ctx.moveTo(-50,52); ctx.lineTo(52,52); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-38,20); ctx.lineTo(-10,-6); ctx.lineTo(10,10); ctx.lineTo(44,-36); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(24,-36); ctx.lineTo(44,-36); ctx.lineTo(44,-16); ctx.stroke();
      break;
    }
    case 'cloud': {
      ctx.beginPath();
      ctx.arc(6,20,26,Math.PI*0.5,Math.PI*1.55);
      ctx.arc(30,4,20,Math.PI*1.05,Math.PI*2.05);
      ctx.arc(52,24,18,Math.PI*1.3,Math.PI*0.35);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'clock': {
      ctx.lineWidth=7;
      ctx.beginPath(); ctx.arc(0,0,50,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(0,0); ctx.lineTo(0,-28); ctx.moveTo(0,0); ctx.lineTo(18,10); ctx.stroke();
      break;
    }
    case 'sync': {
      ctx.lineWidth=8;
      ctx.beginPath(); ctx.arc(0,-6,36,-0.3,2.6); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(30,-36); ctx.lineTo(48,-24); ctx.lineTo(28,-12); ctx.closePath(); ctx.fill();
      ctx.beginPath(); ctx.arc(0,6,36,Math.PI-0.3,Math.PI+2.6); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-30,36); ctx.lineTo(-48,24); ctx.lineTo(-28,12); ctx.closePath(); ctx.fill();
      break;
    }
    case 'thumbsup': {
      ctx.beginPath(); ctx.roundRect(-46,-8,20,58,6); ctx.fill();
      ctx.beginPath();
      ctx.moveTo(-24,48); ctx.lineTo(-24,0);
      ctx.lineTo(-6,-44);
      ctx.bezierCurveTo(-2,-56, 16,-52, 12,-38);
      ctx.lineTo(8,-10);
      ctx.lineTo(40,-10);
      ctx.bezierCurveTo(54,-10,54,6,44,10);
      ctx.bezierCurveTo(54,14,52,30,40,30);
      ctx.bezierCurveTo(50,34,46,48,34,48);
      ctx.closePath(); ctx.fill();
      break;
    }
    case 'contact': {
      ctx.beginPath(); ctx.arc(0,-22,22,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc(0,60,44,Math.PI,0); ctx.fill();
      break;
    }
    case 'bug': {
      ctx.beginPath(); ctx.ellipse(0,4,26,34,0,0,Math.PI*2); ctx.fill();
      ctx.lineWidth=5;
      for(let i=-1;i<=1;i++){
        ctx.beginPath(); ctx.moveTo(-24,-10+i*16); ctx.lineTo(-48,-18+i*16); ctx.stroke();
        ctx.beginPath(); ctx.moveTo(24,-10+i*16); ctx.lineTo(48,-18+i*16); ctx.stroke();
      }
      ctx.beginPath(); ctx.moveTo(-10,-30); ctx.lineTo(-20,-48); ctx.moveTo(10,-30); ctx.lineTo(20,-48); ctx.stroke();
      break;
    }
    case 'gear': {
      ctx.lineWidth=10;
      ctx.beginPath(); ctx.arc(0,0,24,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.arc(0,0,9,0,Math.PI*2); ctx.fill();
      for(let i=0;i<8;i++){
        ctx.save(); ctx.rotate(i*Math.PI/4);
        ctx.fillRect(-6,-50,12,18);
        ctx.restore();
      }
      break;
    }
    case 'dollarlock': {
      ctx.font='700 44px sans-serif'; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillText('$',-16,8);
      ctx.lineWidth=6;
      ctx.beginPath(); ctx.arc(26,-10,14,Math.PI,0); ctx.stroke();
      ctx.beginPath(); ctx.roundRect(8,-10,36,30,6); ctx.fill();
      break;
    }
    case 'quill': {
      ctx.beginPath();
      ctx.moveTo(40,-50);
      ctx.bezierCurveTo(10,-40,-30,-10,-50,40);
      ctx.bezierCurveTo(-20,30,20,0,40,-50);
      ctx.closePath(); ctx.fill();
      ctx.lineWidth=3; ctx.strokeStyle='rgba(0,0,0,0.25)';
      ctx.beginPath(); ctx.moveTo(38,-46); ctx.lineTo(-46,42); ctx.stroke();
      ctx.strokeStyle='#ffffff';
      break;
    }
    case 'globe': {
      ctx.lineWidth=5;
      ctx.beginPath(); ctx.arc(0,0,44,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.ellipse(0,0,44,18,0,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(-44,0); ctx.lineTo(44,0); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(0,-44); ctx.lineTo(0,44); ctx.stroke();
      [[0,-44],[0,44],[-44,0],[44,0],[31,-31],[-31,31],[31,31],[-31,-31]].forEach(([dx,dy])=>{
        ctx.beginPath(); ctx.arc(dx,dy,6,0,Math.PI*2); ctx.fill();
      });
      break;
    }
    default: {
      ctx.font='700 90px sans-serif'; ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillText('?',0,8);
    }
  }
  ctx.restore();
}

function makeIconTexture(app){
  const cvs = document.createElement('canvas'); cvs.width=cvs.height=256;
  const ctx = cvs.getContext('2d');
  const g = ctx.createLinearGradient(0,0,256,256);
  g.addColorStop(0, app.c1); g.addColorStop(1, app.c2);
  ctx.fillStyle = g;
  ctx.beginPath(); ctx.roundRect(0,0,256,256,52); ctx.fill();

  const sheen = ctx.createLinearGradient(0,0,0,256);
  sheen.addColorStop(0,'rgba(255,255,255,0.35)');
  sheen.addColorStop(0.5,'rgba(255,255,255,0)');
  sheen.addColorStop(1,'rgba(0,0,0,0.18)');
  ctx.fillStyle = sheen;
  ctx.beginPath(); ctx.roundRect(0,0,256,256,52); ctx.fill();

  drawGlyph(ctx, app.icon);

  const tex = new THREE.CanvasTexture(cvs);
  tex.encoding = THREE.sRGBEncoding;
  return tex;
}

/* ============================================================
   BUILD FLOATING / BURSTING ICON TILES + LIGHT TRAILS
============================================================ */
const iconGroup = new THREE.Group();
phoneRoot.add(iconGroup);

const tileShape = roundedRectShape(0.56,0.56,0.13);
const tileGeoBase = new THREE.ExtrudeGeometry(tileShape,{depth:0.13,bevelEnabled:true,bevelThickness:0.012,bevelSize:0.01,bevelSegments:4,curveSegments:8});
tileGeoBase.center();

// Flat face plane carrying the icon artwork — sits just proud of the tile's front surface.
// MUST be PlaneGeometry: ShapeGeometry derives UVs from vertex positions rather than
// normalizing them 0-1, which makes the texture sample a single corner instead of the
// whole icon. The rounded silhouette comes from the texture's own alpha channel.
const faceGeo = new THREE.PlaneGeometry(0.56, 0.56);

const tiles = [];
const N = appsConfig.length;

// Front-facing cascade: a grid fans OUT of the screen toward the camera,
// each successive layer sitting further forward in +Z — never behind the phone.
function burstTarget(i, n){
  const cols = 6;
  const col = i % cols;
  const row = Math.floor(i / cols);
  const rows = Math.ceil(n / cols);
  const jitter = Math.sin(i * 12.9898) * 0.5 + 0.5;

  const x = (col - (cols - 1) / 2) * 0.88 + Math.sin(i * 2.1) * 0.08;
  const y = ((rows - 1) / 2 - row) * 0.82 + Math.cos(i * 1.7) * 0.06;
  const z = 1.1 + row * 0.4 + jitter * 0.3; // strictly positive: always in front

  return new THREE.Vector3(x, y, z);
}

appsConfig.forEach((app, i)=>{
  const tex = makeIconTexture(app);
  const bodyMatTile = new THREE.MeshBasicMaterial({color:app.c2});
  bodyMatTile.toneMapped = false;
  const frontMat = new THREE.MeshBasicMaterial({map:tex, transparent:true, side:THREE.DoubleSide});
  frontMat.toneMapped = false;

  const tile = new THREE.Mesh(tileGeoBase, bodyMatTile);
  tile.castShadow = true; tile.receiveShadow = true;

  const face = new THREE.Mesh(faceGeo, frontMat);
  // Tile front surface sits at depth/2 + bevelThickness = 0.065 + 0.012 = 0.077.
  // The face must clear that, or it renders sealed inside the tile body.
  face.position.z = 0.088;
  face.castShadow = false; face.receiveShadow = false;
  tile.add(face);

  const origin = new THREE.Vector3(0.3, (i-N/2)*0.02, PT/2+0.1); // near screen surface
  const target = burstTarget(i, N);

  tile.position.copy(origin);
  tile.userData = {
    origin, target,
    delay: i*0.06,
    speed: 0.9 + Math.random()*0.7,
    phase: Math.random()*Math.PI*2,
    bobAmp: 0.05 + Math.random()*0.05,
    rotSpeed: (Math.random()-0.5)*0.4,
    name: app.name,
    baseScale: 1
  };
  iconGroup.add(tile);
  tiles.push(tile);
});

/* ============================================================
   POSTPROCESSING (bloom for that glossy glow)
============================================================ */
/* Post-processing removed — bloom was overexposing the scene */

/* ============================================================
   STATE / INTERACTION
============================================================ */
let lockOpen = false;   // manual override: force apps to stay popped out
let burstProgress = 0;  // driven by camera zoom distance each frame
let autoTilt = { x:0, y:0 };
let targetTilt = { x:0, y:0 };

const raycaster = new THREE.Raycaster();
const pointerNDC = new THREE.Vector2();
const tooltip = document.getElementById('tooltip');
let hovered = null;
let downPos = null;

function setPointer(e){
  const p = e.touches ? e.touches[0] : e;
  const _r = container.getBoundingClientRect();
  pointerNDC.x = ((p.clientX - _r.left)/_r.width)*2-1;
  pointerNDC.y = -((p.clientY - _r.top)/_r.height)*2+1;
  return {x:p.clientX, y:p.clientY};
}

renderer.domElement.addEventListener('pointerdown', (e)=>{ downPos = setPointer(e); });
renderer.domElement.addEventListener('pointermove', (e)=>{
  const p = setPointer(e);
  raycaster.setFromCamera(pointerNDC, camera);
  const hits = raycaster.intersectObjects(tiles);
  if(hits.length){
    hovered = hits[0].object;
    tooltip.textContent = hovered.userData.name;
    tooltip.style.left = p.x+'px';
    tooltip.style.top = p.y+'px';
    tooltip.style.opacity = 1;
    renderer.domElement.style.cursor = 'pointer';
  } else {
    hovered = null;
    tooltip.style.opacity = 0;
    renderer.domElement.style.cursor = 'grab';
  }
});
renderer.domElement.addEventListener('pointerup', (e)=>{
  const p = setPointer(e);
  if(downPos && Math.hypot(p.x-downPos.x, p.y-downPos.y) < 6){
    raycaster.setFromCamera(pointerNDC, camera);
    const hits = raycaster.intersectObjects(tiles);
    if(hits.length) popTile(hits[0].object);
  }
});

const poppingClocks = new Map();
function popTile(tile){
  poppingClocks.set(tile, 0);
}

/* ============================================================
   UI BUTTONS
============================================================ */
const btnRotate = document.getElementById('btnRotate');
btnRotate.addEventListener('click', ()=>{
  controls.autoRotate = !controls.autoRotate;
  btnRotate.classList.toggle('active', controls.autoRotate);
});

const btnBurst = document.getElementById('btnBurst');
btnBurst.title = 'Pin apps open';
btnBurst.addEventListener('click', ()=>{
  lockOpen = !lockOpen;
  btnBurst.classList.toggle('active', lockOpen);
});

const btnReset = document.getElementById('btnReset');
btnReset.addEventListener('click', ()=>{
  camera.position.copy(HOME_POS);
  controls.target.set(0,0.1,0);
});

/* Gyroscope tilt parallax (Android auto, iOS needs permission) */
function applyTilt(beta, gamma){
  targetTilt.x = THREE.MathUtils.clamp((beta-45)/90, -1, 1) * 0.35;
  targetTilt.y = THREE.MathUtils.clamp(gamma/90, -1, 1) * 0.35;
}
if (window.DeviceOrientationEvent && typeof DeviceOrientationEvent.requestPermission === 'function'){
  const btn = document.getElementById('ios-tilt-btn');
  btn.style.display = 'block';
  btn.addEventListener('click', ()=>{
    DeviceOrientationEvent.requestPermission().then(state=>{
      if(state === 'granted'){
        window.addEventListener('deviceorientation', (e)=> applyTilt(e.beta||0, e.gamma||0));
        btn.style.display='none';
      }
    }).catch(()=>{});
  });
} else if (window.DeviceOrientationEvent && /Mobi|Android/i.test(navigator.userAgent)) {
  window.addEventListener('deviceorientation', (e)=> applyTilt(e.beta||0, e.gamma||0));
}

/* ============================================================
   RESIZE
============================================================ */
window.addEventListener('resize', ()=>{
  camera.aspect = boxW()/boxH();
  camera.updateProjectionMatrix();
  renderer.setSize(boxW(), boxH());
});

/* ============================================================
   ANIMATE
============================================================ */
const clock = new THREE.Clock();
let frameCount = 0, fpsAcc = 0, fpsLast = performance.now();
const fpsChip = document.getElementById('fpsChip');

function animate(){
  requestAnimationFrame(animate);
  const dt = Math.min(clock.getDelta(), 0.05);
  const t = clock.getElapsedTime();

  // live screen refresh (throttled)
  if (Math.floor(t*20) !== Math.floor((t-dt)*20)) drawScreen(t);

  // burst progress driven by zoom: closer camera => apps pop further out of the screen
  const dist = camera.position.distanceTo(controls.target);
  const zoomT = 1 - THREE.MathUtils.clamp((dist - controls.minDistance) / (controls.maxDistance - controls.minDistance), 0, 1);
  const targetProgress = lockOpen ? 1 : zoomT;
  burstProgress += (targetProgress - burstProgress) * Math.min(1, dt*3.2);

  tiles.forEach((tile,i)=>{
    const ud = tile.userData;
    const local = THREE.MathUtils.clamp((burstProgress - ud.delay*0.3), 0, 1);
    const eased = local*local*(3-2*local); // smoothstep
    const pos = ud.origin.clone().lerp(ud.target, eased);
    pos.y += Math.sin(t*ud.speed + ud.phase) * ud.bobAmp * eased;
    pos.x += Math.cos(t*ud.speed*0.7 + ud.phase) * ud.bobAmp*0.5*eased;
    tile.position.copy(pos);
    tile.rotation.y = eased*0.6 + Math.sin(t*0.6+ud.phase)*0.08;
    tile.rotation.x = Math.cos(t*0.5+ud.phase)*0.06*eased;
    tile.rotation.z += ud.rotSpeed*dt*0.2*eased;

    // pop animation
    if(poppingClocks.has(tile)){
      let pc = poppingClocks.get(tile) + dt*4;
      const bump = Math.sin(Math.min(pc,Math.PI)) * 0.35;
      tile.scale.setScalar(1+bump);
      if(pc >= Math.PI) poppingClocks.delete(tile); else poppingClocks.set(tile,pc);
    }
  });

  // gentle phone idle rotation + tilt parallax
  autoTilt.x += (targetTilt.x - autoTilt.x)*0.06;
  autoTilt.y += (targetTilt.y - autoTilt.y)*0.06;
  phoneRoot.rotation.x = -0.38 + Math.sin(t*0.25)*0.03 + autoTilt.x;
  phoneRoot.rotation.y = 0.15 + Math.cos(t*0.2)*0.04 + autoTilt.y;

  stars.rotation.y += dt*0.01;

  // hover pulse
  tiles.forEach(tile=>{
    const s = tile === hovered ? 1.12 : 1.0;
    tile.scale.x += (s - tile.scale.x)*0.2;
    tile.scale.y += (s - tile.scale.y)*0.2;
    tile.scale.z += (s - tile.scale.z)*0.2;
  });

  // bounded auto-rotate: reverse direction when nearing the frontal-arc limits
  const az = controls.getAzimuthalAngle();
  if (az >= controls.maxAzimuthAngle - 0.02) controls.autoRotateSpeed = -Math.abs(controls.autoRotateSpeed);
  if (az <= controls.minAzimuthAngle + 0.02) controls.autoRotateSpeed = Math.abs(controls.autoRotateSpeed);

  controls.update();
  renderer.render(scene, camera);

  // fps display
  frameCount++;
  const now = performance.now();
  if(now - fpsLast > 500){
    // The embed drops the FPS chip — it reads as debug UI on a marketing page.
    if (fpsChip) fpsChip.textContent = Math.round(frameCount*1000/(now-fpsLast)) + ' FPS · ' + N + ' apps live';
    frameCount = 0; fpsLast = now;
  }
}

animate();

/* Hide loader once first frame is ready */
requestAnimationFrame(()=>{
  requestAnimationFrame(()=>{
    document.getElementById('loader').classList.add('hidden');
  });
});

/* fade instruction badge after a while */
setTimeout(()=>{ document.getElementById('badge').style.opacity = 0.55; }, 6000);

})();

};
