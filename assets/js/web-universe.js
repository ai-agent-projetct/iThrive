/**
 * Web Universe — the 3D website showcase, embedded.
 *
 * The scene from webuniverse.html, unchanged apart from being made to live in a
 * box. The standalone version owned the whole window: it sized its camera and
 * renderer to window.innerWidth/innerHeight and computed pointer NDC from page
 * coordinates. Inside a section both have to read the container's rect instead,
 * or the laptop is the wrong shape and the cards cannot be hovered.
 *
 * Its chrome is scoped too — the tooltip, loader, badge and the three control
 * buttons are looked up inside the mount rather than by document id, so a page
 * could hold two of these without them fighting over the same elements.
 *
 * Exposed as a function rather than run on load, so the caller decides when the
 * element exists. Requires three r128 and OrbitControls, vendored in
 * assets/vendor/three128.
 */

window.ithriveWebUniverse = function (mountEl) {
  if (!mountEl || mountEl.dataset.wuReady) return;
  mountEl.dataset.wuReady = '1';

  // The canvas lives in .wu-stage; the loader, tooltip, badge and buttons are
  // its siblings inside .wu. Sizing reads the stage, chrome reads the host.
  const ui = mountEl.closest('[data-web-universe]') || mountEl;

  const boxW = () => mountEl.clientWidth  || window.innerWidth;
  const boxH = () => mountEl.clientHeight || window.innerHeight;

  // A hero is not always on screen; the loop idles when it is not.
  let visible = true;
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(([e]) => { visible = e.isIntersecting; }, { threshold: 0 }).observe(mountEl);
  }

  // The box changes with layout, not only with the window.
  if ('ResizeObserver' in window) {
    new ResizeObserver(() => window.dispatchEvent(new Event('resize'))).observe(mountEl);
  }

(function(){

/* ================================================================
   COLOUR UTILITY
================================================================ */
function hexRgba(hex, a){
  const r=parseInt(hex.slice(1,3),16), g=parseInt(hex.slice(3,5),16), b=parseInt(hex.slice(5,7),16);
  return `rgba(${r},${g},${b},${a})`;
}

/* ================================================================
   CORE — renderer, camera, controls
================================================================ */
const container = mountEl;
const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(40, boxW()/boxH(), 0.1, 150);
camera.position.set(1.8, 2.2, 11.0);
const HOME_CAM = camera.position.clone();

const renderer = new THREE.WebGLRenderer({antialias:true, alpha:true, powerPreference:'high-performance'});
renderer.setSize(boxW(), boxH());
renderer.setPixelRatio(Math.min(devicePixelRatio, 2));
renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 0.88;
renderer.outputEncoding = THREE.sRGBEncoding;
container.appendChild(renderer.domElement);

const controls = new THREE.OrbitControls(camera, renderer.domElement);
controls.enableDamping  = true;
controls.dampingFactor  = 0.065;
controls.minDistance    = 5.8;
controls.maxDistance    = 20;
controls.autoRotate     = true;
controls.autoRotateSpeed= 0.55;
controls.enablePan      = false;
controls.target.set(0, 0.9, 0);
controls.minAzimuthAngle= -Math.PI * 0.36;
controls.maxAzimuthAngle=  Math.PI * 0.36;
controls.minPolarAngle  =  Math.PI * 0.20;
controls.maxPolarAngle  =  Math.PI * 0.66;

/* ================================================================
   LIGHTING
================================================================ */
scene.add(new THREE.AmbientLight(0x8fa8d8, 0.48));

const sun = new THREE.DirectionalLight(0xffffff, 1.25);
sun.position.set(4, 10, 8);
sun.castShadow = true;
sun.shadow.mapSize.set(2048,2048);
sun.shadow.camera.near=1; sun.shadow.camera.far=32; sun.shadow.radius=5;
scene.add(sun);

const rimA = new THREE.PointLight(0x6ee7ff, 1.4, 28, 2);
rimA.position.set(-8, 3, -5); scene.add(rimA);
const rimB = new THREE.PointLight(0xa78bfa, 1.2, 28, 2);
rimB.position.set(8, -2, 4); scene.add(rimB);
const fill = new THREE.PointLight(0xffe4b0, 0.4, 22);
fill.position.set(0, -6, 7); scene.add(fill);

/* Shadow catcher */
const shadowCatcher = new THREE.Mesh(
  new THREE.PlaneGeometry(60,60),
  new THREE.ShadowMaterial({opacity:0.28})
);
shadowCatcher.rotation.x = -Math.PI/2;
shadowCatcher.position.y = -1.4;
shadowCatcher.receiveShadow = true;
scene.add(shadowCatcher);

/* ================================================================
   STARFIELD
================================================================ */
let stars;
(function(){
  const c=document.createElement('canvas'); c.width=c.height=128;
  const cx=c.getContext('2d');
  const g=cx.createRadialGradient(64,64,0,64,64,64);
  g.addColorStop(0,'rgba(255,255,255,1)'); g.addColorStop(.45,'rgba(255,255,255,.45)'); g.addColorStop(1,'rgba(255,255,255,0)');
  cx.fillStyle=g; cx.fillRect(0,0,128,128);
  const tex=new THREE.CanvasTexture(c);

  const N=750, pos=new Float32Array(N*3), col=new Float32Array(N*3);
  const pal=[[.42,.78,1],[.65,.52,1],[.75,.88,1],[1,1,1]];
  for(let i=0;i<N;i++){
    const r=9+Math.random()*18, th=Math.random()*Math.PI*2, ph=Math.acos(Math.random()*2-1);
    pos[i*3]=r*Math.sin(ph)*Math.cos(th); pos[i*3+1]=r*Math.cos(ph)*.52; pos[i*3+2]=r*Math.sin(ph)*Math.sin(th);
    const p=pal[Math.floor(Math.random()*pal.length)];
    col[i*3]=p[0]; col[i*3+1]=p[1]; col[i*3+2]=p[2];
  }
  const geo=new THREE.BufferGeometry();
  geo.setAttribute('position',new THREE.BufferAttribute(pos,3));
  geo.setAttribute('color',new THREE.BufferAttribute(col,3));
  stars=new THREE.Points(geo,new THREE.PointsMaterial({
    size:.05,map:tex,transparent:true,depthWrite:false,
    blending:THREE.AdditiveBlending,vertexColors:true,opacity:.78
  }));
  scene.add(stars);
})();

/* ================================================================
   DOT-GRID BACKGROUND PLANE
================================================================ */
(function(){
  const c=document.createElement('canvas'); c.width=c.height=512;
  const ctx=c.getContext('2d');
  ctx.fillStyle='#07080f'; ctx.fillRect(0,0,512,512);
  ctx.fillStyle='rgba(255,255,255,0.09)';
  for(let x=0;x<512;x+=22) for(let y=0;y<512;y+=22){
    ctx.beginPath(); ctx.arc(x,y,1.1,0,Math.PI*2); ctx.fill();
  }
  const tex=new THREE.CanvasTexture(c);
  tex.wrapS=tex.wrapT=THREE.RepeatWrapping; tex.repeat.set(3,2);
  const m=new THREE.Mesh(
    new THREE.PlaneGeometry(70,45),
    new THREE.MeshBasicMaterial({map:tex,transparent:true,opacity:.35,depthWrite:false})
  );
  m.position.z=-10; scene.add(m);
})();

/* ================================================================
   ROUNDED RECT SHAPE
================================================================ */
function rrShape(w,h,r){
  const s=new THREE.Shape(), x=-w/2, y=-h/2;
  s.moveTo(x,y+r); s.lineTo(x,y+h-r); s.quadraticCurveTo(x,y+h,x+r,y+h);
  s.lineTo(x+w-r,y+h); s.quadraticCurveTo(x+w,y+h,x+w,y+h-r);
  s.lineTo(x+w,y+r); s.quadraticCurveTo(x+w,y,x+w-r,y);
  s.lineTo(x+r,y); s.quadraticCurveTo(x,y,x,y+r);
  return s;
}

/* roundRect canvas polyfill */
if(!CanvasRenderingContext2D.prototype.roundRect){
  CanvasRenderingContext2D.prototype.roundRect=function(x,y,w,h,r){
    const rad=Math.min(typeof r==='number'?r:0,w/2,h/2);
    this.moveTo(x+rad,y); this.lineTo(x+w-rad,y); this.quadraticCurveTo(x+w,y,x+w,y+rad);
    this.lineTo(x+w,y+h-rad); this.quadraticCurveTo(x+w,y+h,x+w-rad,y+h);
    this.lineTo(x+rad,y+h); this.quadraticCurveTo(x,y+h,x,y+h-rad);
    this.lineTo(x,y+rad); this.quadraticCurveTo(x,y,x+rad,y); return this;
  };
}

/* ================================================================
   LAPTOP ASSEMBLY
================================================================ */
const laptopRoot = new THREE.Group();
scene.add(laptopRoot);

/* shared materials */
const bodyMat = new THREE.MeshPhysicalMaterial({
  color:0x1a1d2a, metalness:.90, roughness:.20,
  clearcoat:.75, clearcoatRoughness:.16, reflectivity:.7
});
const darkMat = new THREE.MeshPhysicalMaterial({color:0x0f1019, metalness:.65, roughness:.72});
const hingeMat= new THREE.MeshPhysicalMaterial({color:0x252836, metalness:.94, roughness:.20});

/* ── BASE ── */
const BW=5.8, BD=3.7, BH=0.20;
const baseShape=rrShape(BW,BD,.28);
const baseGeo=new THREE.ExtrudeGeometry(baseShape,{depth:BH,bevelEnabled:true,bevelThickness:.022,bevelSize:.018,bevelSegments:4,curveSegments:10});
baseGeo.center(); baseGeo.rotateX(Math.PI/2);
const baseMesh=new THREE.Mesh(baseGeo,bodyMat);
baseMesh.castShadow=true; baseMesh.receiveShadow=true;
laptopRoot.add(baseMesh);

/* ── KEYBOARD CANVAS TEXTURE ── */
function makeKeyboardTex(){
  const W=1024, H=580;
  const c=document.createElement('canvas'); c.width=W; c.height=H;
  const ctx=c.getContext('2d');
  // dark base
  ctx.fillStyle='#0b0e1a'; ctx.fillRect(0,0,W,H);
  const vi=ctx.createRadialGradient(W/2,H*.35,0,W/2,H*.35,W*.65);
  vi.addColorStop(0,'rgba(28,34,68,0.20)'); vi.addColorStop(1,'rgba(0,0,0,0.0)');
  ctx.fillStyle=vi; ctx.fillRect(0,0,W,H);

  function kDraw(x,y,w,h,txt){
    if(w<4) return;
    const r=Math.min(5,w*.07);
    // shadow
    ctx.fillStyle='rgba(0,0,0,.50)';
    ctx.beginPath(); ctx.roundRect(x+1,y+2,w,h,r); ctx.fill();
    // body gradient
    const g=ctx.createLinearGradient(x,y,x,y+h);
    g.addColorStop(0,'#232646'); g.addColorStop(.48,'#1d2040'); g.addColorStop(1,'#14172a');
    ctx.fillStyle=g; ctx.beginPath(); ctx.roundRect(x,y,w,h,r); ctx.fill();
    // top sheen
    ctx.fillStyle='rgba(255,255,255,.052)';
    ctx.beginPath(); ctx.roundRect(x+1,y+1,w-2,Math.ceil(h*.42),r); ctx.fill();
    // border
    ctx.strokeStyle='rgba(255,255,255,.13)'; ctx.lineWidth=.75;
    ctx.beginPath(); ctx.roundRect(x+.4,y+.4,w-.8,h-.8,r); ctx.stroke();
    // label
    if(txt&&txt!==' '){
      const fs=w<46?7.5:w<68?9:10.5;
      ctx.fillStyle='rgba(185,202,255,.66)';
      ctx.font=`500 ${fs}px -apple-system,sans-serif`;
      ctx.textAlign='center'; ctx.textBaseline='middle';
      ctx.fillText(txt,x+w*.5,y+h*.5+.5);
    }
  }

  const PX=16, PY=14, G=4, TW=W-PX*2, KH=55, FH=27, RH=KH+G;
  function row(y,h,specs){
    const tot=specs.reduce((s,[,u])=>s+u,0);
    const uw=(TW-(specs.length-1)*G)/tot;
    let cx=PX;
    specs.forEach(([lb,u])=>{ kDraw(cx,y,u*uw,h,lb); cx+=u*uw+G; });
  }

  const Y0=PY, Y1=PY+FH+G+3, Y2=Y1+RH, Y3=Y2+RH, Y4=Y3+RH, Y5=Y4+RH;
  // Fn row
  row(Y0,FH,[['esc',1],['F1',1],['F2',1],['F3',1],['F4',1],['F5',1],['F6',1],
             ['F7',1],['F8',1],['F9',1],['F10',1],['F11',1],['F12',1]]);
  // Number row
  row(Y1,KH,[['`',1],['1',1],['2',1],['3',1],['4',1],['5',1],['6',1],
             ['7',1],['8',1],['9',1],['0',1],['-',1],['=',1],['⌫',1.8]]);
  // QWERTY row
  row(Y2,KH,[['tab',1.5],['Q',1],['W',1],['E',1],['R',1],['T',1],['Y',1],
             ['U',1],['I',1],['O',1],['P',1],['[',1],[']',1],['\\',1.5]]);
  // ASDF row
  row(Y3,KH,[['caps',1.75],['A',1],['S',1],['D',1],['F',1],['G',1],['H',1],
             ['J',1],['K',1],['L',1],[';',1],["'",1],['⏎',2.25]]);
  // ZXCV row
  row(Y4,KH,[['⇧',2.25],['Z',1],['X',1],['C',1],['V',1],['B',1],['N',1],
             ['M',1],[',',1],['.',1],['/',1],['⇧',2.25]]);
  // Space bar row
  row(Y5,KH,[['ctrl',1.2],['fn',1],['⌥',1],['⌘',1.3],[' ',5.5],
             ['⌘',1.3],['⌥',1],['←',1],['⇕',1],['→',1]]);
  // subtle trackpad outline below
  const tpY=Y5+KH+G+10, tpH=H-tpY-PY, tpW=Math.round(TW*.44);
  if(tpH>14){
    ctx.strokeStyle='rgba(255,255,255,0.052)'; ctx.lineWidth=1;
    ctx.beginPath(); ctx.roundRect(PX+(TW-tpW)/2,tpY,tpW,tpH,10); ctx.stroke();
  }
  return new THREE.CanvasTexture(c);
}

/* keyboard deck */
const deckGeo=new THREE.BoxGeometry(BW-.4,.007,BD-.62);
const _kbTex=makeKeyboardTex(); _kbTex.encoding=THREE.sRGBEncoding;
const keyboardMat=new THREE.MeshStandardMaterial({map:_kbTex,roughness:.82,metalness:.08});
const deckMesh=new THREE.Mesh(deckGeo,keyboardMat);
deckMesh.position.set(0,BH/2+.003,.16);
laptopRoot.add(deckMesh);

/* trackpad */
const tpShape=rrShape(1.7,1.12,.14);
const tpGeo=new THREE.ExtrudeGeometry(tpShape,{depth:.004,bevelEnabled:false});
tpGeo.center(); tpGeo.rotateX(Math.PI/2);
const tpMat=new THREE.MeshPhysicalMaterial({color:0x1c1f2e,metalness:.75,roughness:.42,clearcoat:.95,clearcoatRoughness:.06});
const tp=new THREE.Mesh(tpGeo,tpMat);
tp.position.set(0,BH/2+.003,BD/2-.74);
laptopRoot.add(tp);

/* speaker grille dots */
const spkMat=new THREE.MeshPhysicalMaterial({color:0x0b0c14,metalness:.5,roughness:.9});
for(let side=-1;side<=1;side+=2) for(let r=0;r<2;r++) for(let c=0;c<5;c++){
  const d=new THREE.Mesh(new THREE.CylinderGeometry(.017,.017,.01,8),spkMat);
  d.position.set(side*(BW/2-.40)+c*.075*side*-1, BH/2+.005, -BD/2+.36+r*.096);
  laptopRoot.add(d);
}

/* hinge */
const hingeGeo=new THREE.CylinderGeometry(.052,.052,BW-.55,32);
const hingeMesh=new THREE.Mesh(hingeGeo,hingeMat);
hingeMesh.rotation.z=Math.PI/2;
hingeMesh.position.set(0,BH/2+.020,-BD/2+.052);
laptopRoot.add(hingeMesh);

/* ── LID ── */
const LW=5.75, LH=3.55, LT=.092;
const lidPivot=new THREE.Group();
lidPivot.position.set(0,BH/2+.016,-BD/2+.052);
lidPivot.rotation.x=0.15;
laptopRoot.add(lidPivot);

const lidShape=rrShape(LW,LH,.26);
const lidGeo=new THREE.ExtrudeGeometry(lidShape,{depth:LT,bevelEnabled:true,bevelThickness:.020,bevelSize:.016,bevelSegments:4,curveSegments:10});
lidGeo.center();
const lidMesh=new THREE.Mesh(lidGeo,bodyMat);
lidMesh.position.set(0,LH/2,0);
lidMesh.castShadow=true; lidMesh.receiveShadow=true;
lidPivot.add(lidMesh);

/* logo ring on lid back */
const logoM=new THREE.Mesh(new THREE.RingGeometry(.12,.155,32),new THREE.MeshPhysicalMaterial({color:0x252836,metalness:.96,roughness:.18,side:THREE.DoubleSide}));
logoM.position.set(0,LH/2,-LT/2-.001); lidPivot.add(logoM);

/* bezel */
const bezelM=new THREE.Mesh(new THREE.BoxGeometry(LW-.10,LH-.10,.014),new THREE.MeshPhysicalMaterial({color:0x050609,metalness:.1,roughness:.96}));
bezelM.position.set(0,LH/2,LT/2+.003); lidPivot.add(bezelM);

/* ── SCREEN CANVAS ── */
const scrCanvas=document.createElement('canvas');
scrCanvas.width=1280; scrCanvas.height=800;
const scrCtx=scrCanvas.getContext('2d');
const scrTex=new THREE.CanvasTexture(scrCanvas);
scrTex.encoding=THREE.sRGBEncoding;

/* sites config — needed in drawScreen, declared before it */
const SITES=[
  {name:'Coonor Club',          url:'coonorclub.com',          c1:'#4ade80',c2:'#14532d',icon:'mountain', tag:'Tourism'   },
  {name:'Cute Crew',            url:'cutecrew.in',             c1:'#fb7185',c2:'#881337',icon:'smile',    tag:'Fashion'   },
  {name:'LogiSethu',            url:'logisethu.com',           c1:'#60a5fa',c2:'#1e3a8a',icon:'bridge',   tag:'Logistics' },
  {name:'Central Adventures',   url:'centraladv.in',           c1:'#fb923c',c2:'#7c2d12',icon:'compass',  tag:'Adventure' },
  {name:'Aruvanaa',             url:'aruvanaa.com',            c1:'#c084fc',c2:'#4c1d95',icon:'lotus',    tag:'Lifestyle' },
  {name:'Maduragrandeur',       url:'maduragrandeur.com',      c1:'#fbbf24',c2:'#78350f',icon:'crown',    tag:'Hospitality'},
  {name:'Bharani Beauty',       url:'bharanibeautyclinic.com', c1:'#f9a8d4',c2:'#9d174d',icon:'beauty',   tag:'Beauty'    },
  {name:'Lotus Eye',            url:'lotuseye.org',            c1:'#34d399',c2:'#064e3b',icon:'eye',      tag:'Healthcare'},
  {name:'Drone World',          url:'thedroneworld.in',        c1:'#94a3b8',c2:'#0f172a',icon:'drone',    tag:'Aerial'    },
  {name:'Erode Public School',  url:'erodepublicschool.in',    c1:'#818cf8',c2:'#1e1b4b',icon:'school',   tag:'Education' },
];

function drawScreen(t){
  const w=scrCanvas.width, h=scrCanvas.height;
  const sctx=scrCtx;

  /* app base */
  sctx.fillStyle='#07090f'; sctx.fillRect(0,0,w,h);

  /* sidebar */
  const sbW=210;
  sctx.fillStyle='#0b0d16'; sctx.fillRect(0,0,sbW,h);
  sctx.strokeStyle='rgba(255,255,255,0.055)'; sctx.lineWidth=1;
  sctx.beginPath(); sctx.moveTo(sbW,0); sctx.lineTo(sbW,h); sctx.stroke();

  /* logo */
  sctx.fillStyle='rgba(255,255,255,.88)';
  sctx.font='700 17px -apple-system,sans-serif';
  sctx.textAlign='left'; sctx.textBaseline='middle';
  sctx.fillText('◉ WebUniverse',18,34);

  /* nav */
  const nav=[['⌂','Dashboard',false],['◈','My Websites',true],['★','Starred',false],['⊕','Recent',false],['⚙','Settings',false]];
  nav.forEach(([ic,lb,act],i)=>{
    const ny=78+i*52;
    if(act){
      sctx.fillStyle='rgba(110,231,255,0.11)';
      sctx.beginPath(); sctx.roundRect(8,ny-2,sbW-16,42,8); sctx.fill();
    }
    sctx.fillStyle=act?'rgba(110,231,255,.9)':'rgba(255,255,255,.32)';
    sctx.font=`${act?'600':'400'} 15px -apple-system,sans-serif`;
    sctx.textAlign='left'; sctx.textBaseline='middle';
    sctx.fillText(`${ic}  ${lb}`,18,ny+20);
  });

  /* main area */
  const mx=sbW+22;

  /* top bar */
  sctx.fillStyle='rgba(255,255,255,.038)';
  sctx.beginPath(); sctx.roundRect(mx,14,w-mx-130,36,18); sctx.fill();
  sctx.fillStyle='rgba(255,255,255,.25)'; sctx.font='400 13px -apple-system,sans-serif';
  sctx.textAlign='left'; sctx.textBaseline='middle';
  sctx.fillText('🔍  Search websites…',mx+15,32);

  /* avatar */
  sctx.fillStyle='rgba(110,231,255,.8)';
  sctx.beginPath(); sctx.arc(w-50,32,17,0,Math.PI*2); sctx.fill();
  sctx.fillStyle='#07090f'; sctx.font='700 13px sans-serif'; sctx.textAlign='center'; sctx.textBaseline='middle';
  sctx.fillText('V',w-50,32);

  /* section title */
  sctx.fillStyle='rgba(255,255,255,.88)'; sctx.font='700 22px -apple-system,sans-serif';
  sctx.textAlign='left'; sctx.textBaseline='middle';
  sctx.fillText('My Websites',mx,72);
  sctx.fillStyle='rgba(255,255,255,.24)'; sctx.font='400 12px sans-serif';
  sctx.fillText('10 sites',mx+168,72);

  /* view toggles */
  ['Grid','List','Gallery'].forEach((v,vi)=>{
    const vx=w-170+vi*54;
    sctx.fillStyle=vi===0?'rgba(110,231,255,.13)':'transparent';
    sctx.beginPath(); sctx.roundRect(vx,58,48,26,6); sctx.fill();
    sctx.fillStyle=vi===0?'rgba(110,231,255,.85)':'rgba(255,255,255,.25)';
    sctx.font=`${vi===0?'600':'400'} 12px sans-serif`; sctx.textAlign='center'; sctx.textBaseline='middle';
    sctx.fillText(v,vx+24,71);
  });

  /* divider */
  sctx.strokeStyle='rgba(255,255,255,.05)'; sctx.lineWidth=1;
  sctx.beginPath(); sctx.moveTo(mx,92); sctx.lineTo(w-20,92); sctx.stroke();

  /* website cards grid */
  const cW=172,cH=118,gx=16,gy=16, gridX=mx+2, gridY=104;
  const activeIdx=Math.floor(t/3.2)%SITES.length;
  SITES.forEach((s,ci)=>{
    const col=ci%5, row=Math.floor(ci/5);
    const cx=gridX+col*(cW+gx), cy=gridY+row*(cH+gy);
    const hH=Math.floor(cH*.58);

    /* card base */
    sctx.fillStyle='#101420';
    sctx.beginPath(); sctx.roundRect(cx,cy,cW,cH,9); sctx.fill();

    /* hero gradient */
    const g=sctx.createLinearGradient(cx,cy,cx+cW,cy+hH);
    g.addColorStop(0,hexRgba(s.c1,.88)); g.addColorStop(1,hexRgba(s.c2,.72));
    sctx.fillStyle=g;
    sctx.beginPath(); sctx.roundRect(cx,cy,cW,hH+8,9); sctx.fill();
    sctx.fillRect(cx,cy+hH,cW,8);

    /* site name */
    sctx.fillStyle='rgba(255,255,255,.88)'; sctx.font='600 12px -apple-system,sans-serif';
    sctx.textAlign='left'; sctx.textBaseline='middle';
    sctx.fillText(s.name.split(' ')[0],cx+8,cy+hH+cH*.58*.44*.5+cH*.42*.25);

    /* url */
    sctx.fillStyle='rgba(255,255,255,.28)'; sctx.font='400 10px monospace';
    sctx.fillText(s.url,cx+8,cy+hH+(cH-hH)*.72);

    /* active highlight */
    if(ci===activeIdx){
      sctx.strokeStyle=hexRgba(s.c1,.85); sctx.lineWidth=1.5;
      sctx.beginPath(); sctx.roundRect(cx+.75,cy+.75,cW-1.5,cH-1.5,9); sctx.stroke();
    } else {
      sctx.strokeStyle='rgba(255,255,255,.055)'; sctx.lineWidth=1;
      sctx.beginPath(); sctx.roundRect(cx+.5,cy+.5,cW-1,cH-1,9); sctx.stroke();
    }
  });

  /* status bar */
  sctx.fillStyle='rgba(255,255,255,.025)'; sctx.fillRect(0,h-30,w,30);
  sctx.fillStyle='rgba(255,255,255,.18)'; sctx.font='400 11px monospace'; sctx.textAlign='left'; sctx.textBaseline='middle';
  sctx.fillText('10 websites · All online',sbW+18,h-15);
  sctx.textAlign='right'; sctx.fillText('✓ synced just now',w-18,h-15);

  scrTex.needsUpdate=true;
}
drawScreen(0);

const scrMesh=new THREE.Mesh(
  new THREE.PlaneGeometry(LW-.24,LH-.24),
  new THREE.MeshStandardMaterial({map:scrTex,emissive:0xffffff,emissiveMap:scrTex,emissiveIntensity:.30,roughness:.26,metalness:0})
);
scrMesh.position.set(0,LH/2,LT/2+.025); lidPivot.add(scrMesh);

/* glass over screen */
const glassMesh=new THREE.Mesh(
  new THREE.PlaneGeometry(LW-.10,LH-.10),
  new THREE.MeshPhysicalMaterial({color:0xffffff,transparent:true,opacity:.038,roughness:.04,clearcoat:1,clearcoatRoughness:.04})
);
glassMesh.position.set(0,LH/2,LT/2+.038);
lidPivot.add(glassMesh);

/* ================================================================
   GLYPH DRAWING  (ctx centred 0,0; ±65 range)
================================================================ */
function drawGlyph(ctx,key){
  ctx.save();
  ctx.strokeStyle='#fff'; ctx.fillStyle='rgba(255,255,255,.95)';
  ctx.lineCap='round'; ctx.lineJoin='round';
  switch(key){
    case 'mountain':{
      ctx.beginPath(); ctx.moveTo(-65,52); ctx.lineTo(-22,-54); ctx.lineTo(10,-18); ctx.lineTo(42,-60); ctx.lineTo(70,52); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      ctx.beginPath(); ctx.moveTo(-22,-54); ctx.lineTo(-4,-22); ctx.lineTo(-40,-22); ctx.closePath(); ctx.fill();
      ctx.beginPath(); ctx.moveTo(42,-60); ctx.lineTo(58,-28); ctx.lineTo(26,-28); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='source-over';
      ctx.beginPath(); ctx.arc(55,-52,9,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'smile':{
      ctx.lineWidth=7; ctx.beginPath(); ctx.arc(0,-2,52,0,Math.PI*2); ctx.stroke();
      ctx.beginPath(); ctx.ellipse(-20,-14,7,10,-.1,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.ellipse(20,-14,7,10,.1,0,Math.PI*2); ctx.fill();
      ctx.beginPath(); ctx.arc(0,8,27,.18,Math.PI-.18); ctx.lineWidth=7; ctx.stroke();
      ctx.globalAlpha=.4; ctx.beginPath(); ctx.arc(-33,12,11,0,Math.PI*2); ctx.fill(); ctx.beginPath(); ctx.arc(33,12,11,0,Math.PI*2); ctx.fill(); ctx.globalAlpha=1;
      break;
    }
    case 'bridge':{
      ctx.lineWidth=7; ctx.beginPath(); ctx.moveTo(-65,30); ctx.lineTo(65,30); ctx.stroke();
      ctx.beginPath(); ctx.arc(-20,-4,34,Math.PI,0); ctx.stroke();
      ctx.beginPath(); ctx.arc(20,-4,34,Math.PI,0); ctx.stroke();
      ctx.lineWidth=5; [[-50],[-8],[8],[50]].forEach(([px])=>{ ctx.beginPath(); ctx.moveTo(px,-38); ctx.lineTo(px,30); ctx.stroke(); });
      ctx.fillStyle='rgba(255,255,255,.9)'; [[-20,-40],[20,-40]].forEach(([nx,ny])=>{ ctx.beginPath(); ctx.arc(nx,ny,7,0,Math.PI*2); ctx.fill(); });
      break;
    }
    case 'compass':{
      ctx.lineWidth=5; ctx.beginPath(); ctx.arc(0,0,52,0,Math.PI*2); ctx.stroke();
      [0,Math.PI/2,Math.PI,Math.PI*1.5].forEach((a,i)=>{
        ctx.save(); ctx.rotate(a);
        ctx.fillStyle=i===0?'rgba(255,120,100,.95)':'rgba(255,255,255,.92)';
        ctx.beginPath(); ctx.moveTo(0,-52); ctx.lineTo(8,-20); ctx.lineTo(0,-10); ctx.lineTo(-8,-20); ctx.closePath(); ctx.fill(); ctx.restore();
      });
      ctx.fillStyle='rgba(255,255,255,.9)'; ctx.beginPath(); ctx.arc(0,0,6,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'lotus':{
      ctx.fillStyle='rgba(255,255,255,.92)';
      for(let i=0;i<8;i++){ ctx.save(); ctx.rotate(i*Math.PI*2/8); ctx.beginPath(); ctx.moveTo(0,0); ctx.bezierCurveTo(-9,-24,-6,-52,0,-55); ctx.bezierCurveTo(6,-52,9,-24,0,0); ctx.closePath(); ctx.fill(); ctx.restore(); }
      ctx.globalAlpha=.5;
      for(let i=0;i<8;i++){ ctx.save(); ctx.rotate(i*Math.PI*2/8+Math.PI/8); ctx.beginPath(); ctx.moveTo(0,0); ctx.bezierCurveTo(-6,-15,-4,-33,0,-36); ctx.bezierCurveTo(4,-33,6,-15,0,0); ctx.closePath(); ctx.fill(); ctx.restore(); }
      ctx.globalAlpha=1; ctx.beginPath(); ctx.arc(0,0,10,0,Math.PI*2); ctx.fill();
      break;
    }
    case 'crown':{
      ctx.beginPath(); ctx.moveTo(-58,28); ctx.lineTo(-58,-8); ctx.lineTo(-36,-8); ctx.lineTo(-28,-52); ctx.lineTo(-10,-8); ctx.lineTo(0,-62); ctx.lineTo(10,-8); ctx.lineTo(28,-52); ctx.lineTo(36,-8); ctx.lineTo(58,-8); ctx.lineTo(58,28); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out'; [[-36,-6],[0,-6],[36,-6]].forEach(([gx,gy])=>{ ctx.beginPath(); ctx.arc(gx,gy,8,0,Math.PI*2); ctx.fill(); }); ctx.globalCompositeOperation='source-over';
      ctx.fillStyle='rgba(255,255,255,.9)'; ctx.beginPath(); ctx.roundRect(-58,14,116,14,4); ctx.fill();
      break;
    }
    case 'beauty':{
      ctx.beginPath(); ctx.moveTo(0,55); ctx.bezierCurveTo(-48,30,-58,-30,-10,-55); ctx.bezierCurveTo(10,-60,50,-30,30,20); ctx.bezierCurveTo(20,40,10,50,0,55); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out'; ctx.lineWidth=4; ctx.beginPath(); ctx.moveTo(0,55); ctx.bezierCurveTo(-5,20,-8,-18,-10,-55); ctx.stroke(); ctx.globalCompositeOperation='source-over';
      [[46,-36],[52,4],[26,-54]].forEach(([sx,sy])=>{ ctx.save(); ctx.translate(sx,sy); ctx.beginPath(); for(let j=0;j<4;j++){ const a=j*Math.PI/2,a2=a+Math.PI/4; if(!j) ctx.moveTo(Math.cos(a)*13,Math.sin(a)*13); else ctx.lineTo(Math.cos(a)*13,Math.sin(a)*13); ctx.lineTo(Math.cos(a2)*5,Math.sin(a2)*5); } ctx.closePath(); ctx.fill(); ctx.restore(); });
      break;
    }
    case 'eye':{
      ctx.beginPath(); ctx.moveTo(-60,0); ctx.bezierCurveTo(-40,-44,40,-44,60,0); ctx.bezierCurveTo(40,44,-40,44,-60,0); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out'; ctx.beginPath(); ctx.arc(0,0,27,0,Math.PI*2); ctx.fill(); ctx.globalCompositeOperation='source-over';
      ctx.fillStyle='rgba(255,255,255,.85)'; ctx.beginPath(); ctx.arc(0,0,27,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation='destination-out'; ctx.beginPath(); ctx.arc(0,0,13,0,Math.PI*2); ctx.fill(); ctx.globalCompositeOperation='source-over';
      ctx.fillStyle='rgba(255,255,255,.9)'; ctx.beginPath(); ctx.arc(8,-10,6,0,Math.PI*2); ctx.fill();
      [-36,-18,0,18,36].forEach((lx,li)=>{ ctx.save(); ctx.translate(lx,-40+Math.abs(li-2)*4); ctx.beginPath(); ctx.moveTo(0,0); ctx.bezierCurveTo(-5,-11,5,-18,0,-22); ctx.bezierCurveTo(-5,-18,5,-11,0,0); ctx.closePath(); ctx.fill(); ctx.restore(); });
      break;
    }
    case 'drone':{
      ctx.beginPath(); ctx.roundRect(-18,-18,36,36,6); ctx.fill();
      ctx.lineWidth=6;
      [[1,1],[1,-1],[-1,1],[-1,-1]].forEach(([dx,dy])=>{
        ctx.beginPath(); ctx.moveTo(dx*18,dy*18); ctx.lineTo(dx*46,dy*46); ctx.stroke();
        ctx.beginPath(); ctx.arc(dx*50,dy*50,15,0,Math.PI*2); ctx.stroke();
        ctx.save(); ctx.translate(dx*50,dy*50);
        for(let b=0;b<2;b++){ ctx.save(); ctx.rotate(b*Math.PI); ctx.fillStyle='rgba(255,255,255,.88)'; ctx.beginPath(); ctx.ellipse(0,0,13,4,0,0,Math.PI*2); ctx.fill(); ctx.restore(); }
        ctx.restore();
      });
      ctx.fillStyle='rgba(255,255,255,.9)'; ctx.beginPath(); ctx.arc(0,0,5,0,Math.PI*2); ctx.fill();
      ctx.globalCompositeOperation='destination-out'; ctx.beginPath(); ctx.arc(-1,2,7,0,Math.PI*2); ctx.fill(); ctx.globalCompositeOperation='source-over';
      break;
    }
    case 'school':{
      ctx.beginPath(); ctx.rect(-50,10,100,48); ctx.fill();
      ctx.beginPath(); ctx.moveTo(-56,10); ctx.lineTo(0,-30); ctx.lineTo(56,10); ctx.closePath(); ctx.fill();
      ctx.globalCompositeOperation='destination-out';
      ctx.beginPath(); ctx.roundRect(-11,26,22,32,3); ctx.fill();
      ctx.beginPath(); ctx.roundRect(-36,16,18,18,3); ctx.fill();
      ctx.beginPath(); ctx.roundRect(18,16,18,18,3); ctx.fill();
      ctx.globalCompositeOperation='source-over';
      ctx.fillStyle='rgba(255,255,255,.9)'; ctx.lineWidth=4;
      ctx.beginPath(); ctx.moveTo(0,-30); ctx.lineTo(0,-62); ctx.stroke();
      ctx.beginPath(); ctx.moveTo(0,-62); ctx.lineTo(20,-54); ctx.lineTo(0,-46); ctx.closePath(); ctx.fill();
      break;
    }
    default:{ ctx.font='700 90px sans-serif'; ctx.textAlign='center'; ctx.textBaseline='middle'; ctx.fillText('?',0,8); }
  }
  ctx.restore();
}

/* ================================================================
   CARD TEXTURE — poly.app-style website preview card
================================================================ */
function makeCardTex(site){
  const W=480,H=320, heroH=Math.floor(H*.58);
  const cvs=document.createElement('canvas'); cvs.width=W; cvs.height=H;
  const ctx=cvs.getContext('2d');

  /* ── card base (dark) ── */
  ctx.fillStyle='#0c0e18';
  ctx.beginPath(); ctx.roundRect(0,0,W,H,18); ctx.fill();

  /* ── hero gradient ── */
  const g=ctx.createLinearGradient(0,0,W,heroH);
  g.addColorStop(0,hexRgba(site.c1,.95)); g.addColorStop(.65,hexRgba(site.c2,.88)); g.addColorStop(1,hexRgba(site.c2,.65));
  ctx.fillStyle=g;
  ctx.save(); ctx.beginPath(); ctx.roundRect(0,0,W,heroH+18,18); ctx.clip(); ctx.fillRect(0,0,W,heroH+18); ctx.restore();

  /* ── subtle dot pattern in hero ── */
  ctx.save(); ctx.globalAlpha=.10;
  ctx.fillStyle='rgba(255,255,255,1)';
  for(let px=0;px<W;px+=20) for(let py=0;py<heroH;py+=20){ ctx.beginPath(); ctx.arc(px,py,1.2,0,Math.PI*2); ctx.fill(); }
  ctx.restore();

  /* ── wavy highlight streak ── */
  ctx.save(); ctx.globalAlpha=.12;
  const wg=ctx.createLinearGradient(0,0,W,0);
  wg.addColorStop(0,'rgba(255,255,255,0)'); wg.addColorStop(.4,'rgba(255,255,255,1)'); wg.addColorStop(1,'rgba(255,255,255,0)');
  ctx.fillStyle=wg; ctx.beginPath(); ctx.rect(0,8,W,18); ctx.fill();
  ctx.restore();

  /* ── glyph icon centred in hero ── */
  ctx.save(); ctx.translate(W/2,heroH/2+4); ctx.scale(.6,.6);
  drawGlyph(ctx,site.icon);
  ctx.restore();

  /* ── top sheen ── */
  ctx.save();
  const sheen=ctx.createLinearGradient(0,0,0,heroH);
  sheen.addColorStop(0,'rgba(255,255,255,.22)'); sheen.addColorStop(.5,'rgba(255,255,255,0)');
  ctx.fillStyle=sheen;
  ctx.beginPath(); ctx.roundRect(0,0,W,heroH+18,18); ctx.clip(); ctx.fillRect(0,0,W,heroH+18);
  ctx.restore();

  /* ── info panel ── */
  const panelY=heroH, panelH=H-heroH;

  /* site name */
  ctx.fillStyle='rgba(255,255,255,.95)';
  ctx.font='700 26px -apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif';
  ctx.textAlign='left'; ctx.textBaseline='middle';
  const nameShort=site.name.length>17?site.name.replace(' ','​\n'):site.name; // soft break
  ctx.fillText(site.name,20,panelY+panelH*.28);

  /* url */
  ctx.fillStyle='rgba(255,255,255,.35)';
  ctx.font='400 13px "SF Mono",monospace';
  ctx.fillText(site.url,20,panelY+panelH*.62);

  /* tag pill */
  ctx.font='500 11px -apple-system,sans-serif';
  ctx.textAlign='left';
  const tw=ctx.measureText(site.tag).width+20;
  ctx.fillStyle=hexRgba(site.c1,.16);
  ctx.beginPath(); ctx.roundRect(W-tw-14,panelY+panelH*.20,tw+2,26,13); ctx.fill();
  ctx.fillStyle=hexRgba(site.c1,.92);
  ctx.textAlign='center'; ctx.textBaseline='middle';
  ctx.fillText(site.tag,W-tw/2-14,panelY+panelH*.33);

  /* accent bottom bar */
  ctx.fillStyle=site.c1;
  ctx.save(); ctx.beginPath(); ctx.roundRect(0,H-4,W,4,[0,0,18,18]); ctx.clip(); ctx.fillRect(0,H-4,W,4); ctx.restore();

  /* outer border */
  ctx.strokeStyle='rgba(255,255,255,.07)'; ctx.lineWidth=1;
  ctx.beginPath(); ctx.roundRect(.5,.5,W-1,H-1,18); ctx.stroke();

  const tex=new THREE.CanvasTexture(cvs);
  tex.encoding=THREE.sRGBEncoding;
  return tex;
}

/* ================================================================
   GLOW DISC FACTORY
================================================================ */
function makeGlowTex(hex){
  const c=document.createElement('canvas'); c.width=c.height=256;
  const ctx=c.getContext('2d');
  const r=parseInt(hex.slice(1,3),16),g=parseInt(hex.slice(3,5),16),b=parseInt(hex.slice(5,7),16);
  const gr=ctx.createRadialGradient(128,128,0,128,128,128);
  gr.addColorStop(0,`rgba(${r},${g},${b},.7)`);
  gr.addColorStop(.38,`rgba(${r},${g},${b},.28)`);
  gr.addColorStop(1,`rgba(${r},${g},${b},0)`);
  ctx.fillStyle=gr; ctx.fillRect(0,0,256,256);
  return new THREE.CanvasTexture(c);
}

/* ================================================================
   CARD TILES
================================================================ */
const iconGroup=new THREE.Group();
laptopRoot.add(iconGroup);

const TW=1.45, TH=0.97; // 480:320 ≈ 1.5 ratio
const tileShape=rrShape(TW,TH,.092);
const tileGeoBase=new THREE.ExtrudeGeometry(tileShape,{depth:.075,bevelEnabled:true,bevelThickness:.008,bevelSize:.006,bevelSegments:4,curveSegments:8});
tileGeoBase.center();
const faceGeo=new THREE.PlaneGeometry(TW,TH);
const glowGeo=new THREE.PlaneGeometry(TW*2.4,TH*2.0);

/* uniform dark extrude body for all tiles */
const tileBodyMat=new THREE.MeshPhysicalMaterial({color:0x0c0e18,metalness:.65,roughness:.55,clearcoat:.4});
tileBodyMat.toneMapped=false;

const tiles=[]; const N=SITES.length;

/* concave-arc burst targets — 5 cols × 2 rows */
const COLS=5;
function burstTarget(i){
  const col=i%COLS, row=Math.floor(i/COLS);
  const ctr=(COLS-1)/2, dist=Math.abs(col-ctr);
  const jitter=(Math.sin(i*12.9898)*.5+.5);
  const x=(col-ctr)*1.62 + Math.sin(i*2.1)*.05;
  // Both rows fly FORWARD out of the screen — well above the keyboard deck (y~0.1)
  // row0 ≈ 2.10, row1 ≈ 1.32 — both comfortably above keyboard
  const y=2.10-row*0.78 + Math.cos(i*1.7)*.05;
  // All cards go strongly toward camera (positive z), concave arc shape
  const z=2.68-dist*.08+row*.14+jitter*.30;
  return new THREE.Vector3(x,y,z);
}

SITES.forEach((site,i)=>{
  const tex=makeCardTex(site);
  const glowTex=makeGlowTex(site.c1);

  const tile=new THREE.Mesh(tileGeoBase,tileBodyMat.clone());
  tile.castShadow=true;

  /* face */
  const face=new THREE.Mesh(faceGeo,new THREE.MeshBasicMaterial({map:tex,transparent:true,side:THREE.DoubleSide}));
  face.material.toneMapped=false;
  face.position.z=.052; tile.add(face);

  /* glow disc (behind card) */
  const glow=new THREE.Mesh(glowGeo,new THREE.MeshBasicMaterial({map:glowTex,transparent:true,depthWrite:false,blending:THREE.AdditiveBlending,opacity:.55}));
  glow.material.toneMapped=false;
  glow.position.set(0,-.18,-.12); tile.add(glow);

  /* spawn from screen face — screen centre in laptopRoot ≈ (0, 1.86, -1.46) */
  const oCol=(i%COLS)-2, oRow=Math.floor(i/COLS);
  const origin=new THREE.Vector3(oCol*.50, 1.82-oRow*0.44, -1.32);
  const target=burstTarget(i);

  tile.position.copy(origin);
  tile.userData={
    origin,target,
    delay:i*.055,
    speed:.88+Math.random()*.65,
    phase:Math.random()*Math.PI*2,
    bobAmp:.038+Math.random()*.032,
    rotSpeed:(Math.random()-.5)*.32,
    name:site.name, url:site.url,
    c1:site.c1,
  };
  iconGroup.add(tile);
  tiles.push(tile);
});

/* ================================================================
   INTERACTION
================================================================ */
let lockOpen=false, burstProgress=0;
let autoTilt={x:0,y:0}, targetTilt={x:0,y:0};

const raycaster=new THREE.Raycaster();
const ndcPtr=new THREE.Vector2();
const tooltip=ui.querySelector('[data-wu="tooltip"]');
const ttName=ui.querySelector('[data-wu="ttName"]');
const ttUrl=ui.querySelector('[data-wu="ttUrl"]');
let hovered=null, downPos=null;

function setPtr(e){
  const p=e.touches?e.touches[0]:e;
  const r=container.getBoundingClientRect();
  ndcPtr.x=((p.clientX-r.left)/r.width)*2-1;
  ndcPtr.y=-((p.clientY-r.top)/r.height)*2+1;
  return {x:p.clientX,y:p.clientY};
}

renderer.domElement.addEventListener('pointerdown',e=>{ downPos=setPtr(e); });
renderer.domElement.addEventListener('pointermove',e=>{
  const p=setPtr(e);
  raycaster.setFromCamera(ndcPtr,camera);
  const hits=raycaster.intersectObjects(tiles);
  if(hits.length){
    hovered=hits[0].object;
    while(hovered.parent&&hovered.parent!==iconGroup) hovered=hovered.parent;
    const ud=hovered.userData;
    ttName.textContent=ud.name;
    ttUrl.textContent=ud.url;
    tooltip.style.left=p.x+'px'; tooltip.style.top=p.y+'px';
    tooltip.style.opacity=1; tooltip.style.transform='translate(-50%,-130%) scale(1)';
    tooltip.style.borderColor=hexRgba(ud.c1,.35);
    renderer.domElement.style.cursor='pointer';
  } else {
    hovered=null;
    tooltip.style.opacity=0; tooltip.style.transform='translate(-50%,-130%) scale(.95)';
    renderer.domElement.style.cursor='grab';
  }
});
renderer.domElement.addEventListener('pointerup',e=>{
  const p=setPtr(e);
  if(downPos&&Math.hypot(p.x-downPos.x,p.y-downPos.y)<6){
    raycaster.setFromCamera(ndcPtr,camera);
    const hits=raycaster.intersectObjects(tiles);
    if(hits.length){ let t=hits[0].object; while(t.parent&&t.parent!==iconGroup) t=t.parent; popTile(t); }
  }
});

const popping=new Map();
function popTile(t){ popping.set(t,0); }

/* ================================================================
   UI BUTTONS
================================================================ */
ui.querySelector('[data-wu="btnRotate"]')?.addEventListener('click',function(){ controls.autoRotate=!controls.autoRotate; this.classList.toggle('active',controls.autoRotate); });
ui.querySelector('[data-wu="btnBurst"]')?.addEventListener('click',function(){ lockOpen=!lockOpen; this.classList.toggle('active',lockOpen); });
ui.querySelector('[data-wu="btnReset"]')?.addEventListener('click',()=>{ camera.position.copy(HOME_CAM); controls.target.set(0,.9,0); });

/* gyro */
if(window.DeviceOrientationEvent&&!/requestPermission/.test(DeviceOrientationEvent)&&/Mobi|Android/i.test(navigator.userAgent))
  window.addEventListener('deviceorientation',e=>{ targetTilt.x=THREE.MathUtils.clamp((e.beta-45)/90,-1,1)*.28; targetTilt.y=THREE.MathUtils.clamp(e.gamma/90,-1,1)*.28; });

/* resize */
window.addEventListener('resize',()=>{ camera.aspect=boxW()/boxH(); camera.updateProjectionMatrix(); renderer.setSize(boxW(),boxH()); });

/* ================================================================
   ANIMATE
================================================================ */
const clock=new THREE.Clock();
let fCount=0,fLast=performance.now();
const fpsChip=null;

function animate(){
  requestAnimationFrame(animate);
  if(!visible) return;
  const dt=Math.min(clock.getDelta(),.05), t=clock.getElapsedTime();

  /* screen refresh at 20fps */
  if(Math.floor(t*20)!==Math.floor((t-dt)*20)) drawScreen(t);

  /* burst driven by zoom */
  const dist=camera.position.distanceTo(controls.target);
  const zoomT=1-THREE.MathUtils.clamp((dist-controls.minDistance)/(controls.maxDistance-controls.minDistance),0,1);
  burstProgress+=(((lockOpen?1:zoomT))-burstProgress)*Math.min(1,dt*2.9);

  /* tiles */
  tiles.forEach((tile,i)=>{
    const ud=tile.userData;
    const local=THREE.MathUtils.clamp((burstProgress-ud.delay*.26),0,1);
    const eased=local*local*(3-2*local);
    const pos=ud.origin.clone().lerp(ud.target,eased);
    pos.y+=Math.sin(t*ud.speed+ud.phase)*ud.bobAmp*eased;
    pos.x+=Math.cos(t*ud.speed*.72+ud.phase)*ud.bobAmp*.46*eased;
    tile.position.copy(pos);
    tile.rotation.y=eased*.48+Math.sin(t*.52+ud.phase)*.065;
    tile.rotation.x=Math.cos(t*.46+ud.phase)*.05*eased;
    tile.rotation.z+=ud.rotSpeed*dt*.16*eased;

    /* pop */
    if(popping.has(tile)){
      let pc=popping.get(tile)+dt*4.2;
      tile.scale.setScalar(1+Math.sin(Math.min(pc,Math.PI))*.42);
      if(pc>=Math.PI) popping.delete(tile); else popping.set(tile,pc);
    }
  });

  /* tilt */
  autoTilt.x+=(targetTilt.x-autoTilt.x)*.055;
  autoTilt.y+=(targetTilt.y-autoTilt.y)*.055;

  /* laptop idle rock */
  laptopRoot.rotation.x=-0.11+Math.sin(t*.23)*.020+autoTilt.x;
  laptopRoot.rotation.y= 0.07+Math.cos(t*.18)*.026+autoTilt.y;

  /* stars drift */
  if(stars) stars.rotation.y+=dt*.008;

  /* hover scale */
  tiles.forEach(tile=>{
    const s=tile===hovered?1.10:1.0;
    tile.scale.x+=(s-tile.scale.x)*.16;
    tile.scale.y+=(s-tile.scale.y)*.16;
    tile.scale.z+=(s-tile.scale.z)*.16;
  });

  /* glow opacity on hovered tile */
  tiles.forEach(tile=>{
    const glowMesh=tile.children[1];
    if(!glowMesh) return;
    const target=tile===hovered?.80:.50;
    glowMesh.material.opacity+=(target-glowMesh.material.opacity)*.14;
  });

  /* bounded auto-rotate */
  const az=controls.getAzimuthalAngle();
  if(az>=controls.maxAzimuthAngle-.02) controls.autoRotateSpeed=-Math.abs(controls.autoRotateSpeed);
  if(az<=controls.minAzimuthAngle+.02) controls.autoRotateSpeed= Math.abs(controls.autoRotateSpeed);

  controls.update();
  renderer.render(scene,camera);

  fCount++; const now=performance.now();
  if(now-fLast>500){ if(fpsChip) fpsChip.textContent=Math.round(fCount*1000/(now-fLast))+' FPS'; fCount=0; fLast=now; }
}

animate();

requestAnimationFrame(()=>{ requestAnimationFrame(()=>{ ui.querySelector('[data-wu="loader"]')?.classList.add('hidden'); }); });
setTimeout(()=>{ const b=ui.querySelector('[data-wu="badge"]'); if(b) b.style.opacity='.45'; },7500);

})();
};
