import{r as C,j}from"./react-W1izUqcL.js";import{S as N,W as V,a as $,P as q,B as J,b as W,I as Q,c as b,D as tt,R as et,C as st,N as it,L as at,d as nt,e as rt}from"./three-DeHemVAZ.js";const z=75,T=6,H=2*T*Math.tan(z*Math.PI/360),O=40,w=60,ot=.005,k=250,ht=512,ct=4096,_=[.72,1.5,.78,1.33,1,1.62,.68,1.2,.86,1.45],lt=10,R={tap:!0,zoom:5,speed:5},E={drift:2,smoothing:5,wave:5},l={images:[],background:"transparent",pages:20,spacing:5,tilt:0,turn:0,pageWidth:600,pageHeight:500,scrollSens:5},ut=.22,dt=6,ft=600,pt=1600;function g(e,t,i,n){const a=typeof e=="number"&&isFinite(e)?e:n;return Math.max(t,Math.min(i,a))}function X(e){return typeof e=="string"?e:(e==null?void 0:e.src)??""}function gt(e){return typeof e=="string"?"":(e==null?void 0:e.alt)??""}function L(e){return e&&typeof e=="object"&&"image"in e?e.image??"":e}function Y(e){if(e&&typeof e=="object"&&"offsetY"in e){const t=e.offsetY;return typeof t=="number"&&isFinite(t)?t:0}return 0}function mt(e){return e<=0?0:e>=1?1:e<.5?4*e*e*e:1-Math.pow(-2*e+2,3)/2}function vt(e,t,i){const n=H/Math.max(1,i),a=Math.max(1,t)/Math.max(1,i),s=g(e.pageWidth,40,1200,l.pageWidth),o=g(e.pageHeight,40,1600,l.pageHeight),r=s*n,h=o*n,v=g(e.spacing,0,10,l.spacing),u=g(e.travel.smoothing,0,10,E.smoothing),p=g(e.travel.wave,0,10,E.wave),P=g(e.travel.drift,-10,10,E.drift),x=Math.min(T*.55,r*.75),d=H*(T-x)/T,y=d*a,f=.6+g(e.view.zoom,0,10,R.zoom)*.04;return{pageWidth:r,pageHeight:h,pageWidthPx:s,pageHeightPx:o,worldPerPx:n,pages:Math.round(g(e.pages,4,w,l.pages)),pageSpacing:r*(.1+v*.08),thickness:r*ot,tilt:g(e.tilt,-45,45,l.tilt)*Math.PI/180,turn:g(e.turn,-60,60,l.turn)*Math.PI/180,wave:r*.04*p,lerp:.35*Math.pow(.82,u),driftPerSecond:P*r*.15,wheel:.4+g(e.scrollSens,0,10,l.scrollSens)*.16,tapToView:e.view.tap!==!1,focusZ:x,focusScale:Math.min(d*f/h,y*f/r),viewDuration:1.6-g(e.view.speed,0,10,R.speed)*.13}}const D=`
attribute float aIndex;
attribute vec4 aRect;
attribute float aAspect;
attribute float aOffset;

uniform float uPageThickness;
uniform float uPageWidth;
uniform float uPageHeight;
uniform float uMeshCount;
uniform float uPageSpacing;
uniform float uScrollY;
uniform float uSpeedY;
uniform float uWave;
uniform float uTilt;
uniform float uTurn;
uniform float uFocusIndex;
uniform float uFocusProgress;
uniform float uFocusScale;
uniform float uFocusZ;

varying vec2 vUv;
varying vec4 vRect;
varying float vAspect;
varying float vOffset;
varying float vIndex;
varying float vDim;

const float TAU_HALF = 3.14159265359;

mat3 rotY(float a) {
    return mat3(cos(a), 0.0, sin(a), 0.0, 1.0, 0.0, -sin(a), 0.0, cos(a));
}

mat3 rotX(float a) {
    return mat3(1.0, 0.0, 0.0, 0.0, cos(a), -sin(a), 0.0, sin(a), cos(a));
}

void main() {
    float PI = TAU_HALF;

    vec3 basePos = vec3(
        position.x * uPageWidth,
        position.y * uPageHeight,
        position.z * uPageThickness
    );

    vec3 rotationCenter = vec3(-uPageWidth * 0.5, 0.0, 0.0);

    float fromMiddle = aIndex - (uMeshCount - 1.0) * 0.5;

    float yAngle = -PI * 0.5 + uTurn;
    float xAngle = uTilt;

    float boxCenterZ = uPageSpacing * (-fromMiddle);
    float maxZ = uMeshCount * (uPageSpacing + uPageThickness) * 0.5;

    float bow = sin((position.y + 0.5) * 2.0) * uWave;
    float speed = clamp(uSpeedY / uPageWidth * 4.0, -2.0, 2.0);

    float zCorridor = mod(boxCenterZ - uScrollY + maxZ, 2.0 * maxZ) - maxZ
        - bow * speed;

    float focused = step(abs(aIndex - uFocusIndex), 0.5);
    float e = focused * uFocusProgress;

    float k = mix(1.0, uFocusScale, e);
    vec3 pivot = rotationCenter * (1.0 - e);

    vec3 vertexLocal = basePos * k - pivot;
    vertexLocal.z += zCorridor * (1.0 - e);

    vec3 rotated = rotY(yAngle * (1.0 - e)) * vertexLocal + pivot;

    rotated.z -= uPageWidth * 0.5 * (1.0 - e);
    rotated.x += uPageWidth * 0.5 * (1.0 - e);

    vec3 newPosition = rotX(xAngle * (1.0 - e)) * rotated;
    newPosition.z += uFocusZ * e;

    vec4 modelPosition = modelMatrix * vec4(newPosition, 1.0);
    gl_Position = projectionMatrix * viewMatrix * modelPosition;

    vUv = uv;
    vRect = aRect;
    vAspect = aAspect;

    vOffset = aOffset;
    vIndex = aIndex;

    vDim = uFocusProgress * (1.0 - focused);
}
`,wt=`
uniform sampler2D uAtlas;
uniform float uPageAspect;

varying vec2 vUv;
varying vec4 vRect;
varying float vAspect;
varying float vOffset;
varying float vDim;

void main() {
    vec2 uv = vUv;
    float s = vAspect / uPageAspect;

    float band = min(s, 1.0 / s);
    float slack = (1.0 - band) * 0.5;
    float slide = clamp(vOffset, -1.0, 1.0) * slack;
    if (s >= 1.0) {
        uv.x = (uv.x - 0.5) * band + 0.5 - slide;
    } else {
        uv.y = (uv.y - 0.5) * band + 0.5 + slide;
    }

    vec2 atlasUv = mix(vRect.xy, vRect.zw, clamp(uv, 0.0, 1.0));
    vec4 color = texture2D(uAtlas, atlasUv);

    gl_FragColor = vec4(color.rgb * mix(1.0, ${ut.toFixed(2)}, vDim), color.a);
}
`,Pt=`
varying float vIndex;

void main() {
    gl_FragColor = vec4((vIndex + 1.0) / 255.0, 0.0, 0.0, 1.0);
}
`,I=new Map,U=new Map;function xt(e){if(I.has(e))return Promise.resolve(I.get(e)??null);const t=U.get(e);if(t)return t;const i=new Promise(n=>{const a=new window.Image;a.crossOrigin="anonymous",a.onload=()=>{I.set(e,a),n(a)},a.onerror=()=>{I.set(e,null),n(null)},a.src=e});return U.set(e,i),i}function At(e,t,i,n,a,s){const o=t*47%360,r=e.createLinearGradient(i,n,i+a,n+s);r.addColorStop(0,`hsl(${o}, 22%, 27%)`),r.addColorStop(.55,`hsl(${o}, 18%, 13%)`),r.addColorStop(1,`hsl(${(o+40)%360}, 24%, 23%)`),e.fillStyle=r,e.fillRect(i,n,a,s),e.strokeStyle="rgba(255,255,255,0.14)",e.lineWidth=Math.max(1,Math.round(a*.008)),e.strokeRect(i+1,n+1,a-2,s-2),e.fillStyle="rgba(255,255,255,0.68)",e.font=`500 ${Math.round(Math.min(a,s)*.26)}px ui-sans-serif, system-ui, -apple-system, sans-serif`,e.textAlign="center",e.textBaseline="middle",e.fillText(String(t+1).padStart(2,"0"),i+a/2,n+s/2)}async function Mt(e,t){const i=Math.max(1,e.length),n=await Promise.all(e.map(P=>P?xt(P):Promise.resolve(null))),a=Math.ceil(Math.sqrt(i)),s=Math.ceil(i/a),o=Math.min(ht,Math.floor(ct/Math.max(a,s))),r=document.createElement("canvas");r.width=a*o,r.height=s*o;const h=r.getContext("2d");if(!h)return null;const v=P=>{h.clearRect(0,0,r.width,r.height);const x=[];for(let d=0;d<i;d++){const y=d%a*o,f=Math.floor(d/a)*o,A=P?n[d]:null,M=A&&A.naturalHeight>0?A.naturalWidth/A.naturalHeight:_[d%_.length],c=M>=1?o:o*M,m=M>=1?o/M:o,S=y+(o-c)/2,F=f+(o-m)/2;A?h.drawImage(A,S,F,c,m):At(h,d,S,F,c,m);const Z=(S+1)/r.width,G=(S+c-1)/r.width,B=1-(F+1)/r.height,K=1-(F+m-1)/r.height;x.push({rect:[Z,K,G,B],aspect:M})}return x};let u=v(!0);try{h.getImageData(0,0,1,1)}catch{u=v(!1)}const p=new st(r);return p.colorSpace=it,p.generateMipmaps=!0,p.minFilter=at,p.magFilter=nt,p.wrapS=p.wrapT=rt,p.anisotropy=t,p.needsUpdate=!0,{texture:p,cells:u}}function yt(){const e=new tt(new Uint8Array([46,46,48,255]),1,1,et);return e.needsUpdate=!0,e}class St{constructor(t,i){this.scene=new N,this.atlas=null,this.pickTarget=new V(1,1),this.pickBuffer=new Uint8Array(4),this.width=1,this.height=1,this.frameId=0,this.lastT=0,this.disposed=!1,this.atlasToken=0,this.atlasKey="",this.scroll={target:0,current:0,speed:0},this.drag={active:!1,lastX:0,id:-1},this.focus={index:-1,t:0,target:0},this.tap={x:0,y:0,at:0,id:-1,hit:-1},this.settingsCache=null,this.onAtlasReady=null,this.onKeyDown=s=>{s.key==="Escape"&&this.focus.index>=0&&(this.focus.target=0)},this.onWheel=s=>{if(this.disposed||this.focus.index>=0)return;s.preventDefault();const o=this.wheelScale(s),r=s.deltaX*o,h=s.deltaY*o,v=Math.abs(r)>Math.abs(h)?r:h,u=this.settings();this.push(v*u.worldPerPx*u.wheel)},this.onPointerDown=s=>{var o,r;this.disposed||s.button!==0||(this.tap={x:s.clientX,y:s.clientY,at:performance.now(),id:s.pointerId,hit:this.focus.index<0&&this.settings().tapToView?this.pick(s.clientX,s.clientY):-1},(r=(o=this.container).setPointerCapture)==null||r.call(o,s.pointerId),!(this.focus.index>=0)&&(this.drag.active=!0,this.drag.lastX=s.clientX,this.drag.id=s.pointerId))},this.onPointerMove=s=>{if(!this.drag.active||s.pointerId!==this.drag.id)return;const o=this.drag.lastX-s.clientX;this.drag.lastX=s.clientX;const r=this.settings();this.push(o*2*r.worldPerPx*r.wheel)},this.onPointerUp=s=>{var r,h;if(s.pointerId===this.drag.id&&(this.drag.active=!1,this.drag.id=-1),s.pointerId!==this.tap.id)return;(h=(r=this.container).releasePointerCapture)==null||h.call(r,s.pointerId),this.tap.id=-1,Math.hypot(s.clientX-this.tap.x,s.clientY-this.tap.y)<=dt&&performance.now()-this.tap.at<=ft&&this.onTap(this.tap.hit)},this.onPointerCancel=s=>{var o,r;s.pointerId===this.drag.id&&(this.drag.active=!1,this.drag.id=-1),s.pointerId===this.tap.id&&((r=(o=this.container).releasePointerCapture)==null||r.call(o,s.pointerId),this.tap.id=-1)},this.container=t,this.cfg=i,this.renderer=new $({antialias:!0,alpha:!0}),this.renderer.setPixelRatio(Math.min(window.devicePixelRatio||1,2)),this.renderer.setClearColor(0,0);const n=this.renderer.domElement;n.style.cssText="position:absolute;inset:0;width:100%;height:100%;display:block",t.appendChild(n),this.camera=new q(z,1,.1,200),this.camera.position.z=T,this.scene.add(this.camera),this.blank=yt(),this.geometry=new J(1,1,1,O,O,1),this.material=new W({vertexShader:D,fragmentShader:wt,transparent:!0,uniforms:{uPageThickness:{value:.01},uPageWidth:{value:2},uPageHeight:{value:3},uMeshCount:{value:l.pages},uPageSpacing:{value:1},uScrollY:{value:0},uSpeedY:{value:0},uWave:{value:.4},uTilt:{value:0},uTurn:{value:0},uFocusIndex:{value:-1},uFocusProgress:{value:0},uFocusScale:{value:1},uFocusZ:{value:0},uPageAspect:{value:2/3},uAtlas:{value:this.blank}}}),this.pickMaterial=new W({vertexShader:D,fragmentShader:Pt,uniforms:this.material.uniforms}),this.mesh=new Q(this.geometry,this.material,w),this.mesh.frustumCulled=!1;const a=new Float32Array(w);for(let s=0;s<w;s++)a[s]=s;this.geometry.setAttribute("aIndex",new b(a,1)),this.rectAttr=new b(new Float32Array(w*4),4),this.aspectAttr=new b(new Float32Array(w).fill(1),1),this.offsetAttr=new b(new Float32Array(w),1),this.geometry.setAttribute("aRect",this.rectAttr),this.geometry.setAttribute("aAspect",this.aspectAttr),this.geometry.setAttribute("aOffset",this.offsetAttr);for(let s=0;s<w;s++)this.rectAttr.setXYZW(s,0,0,1,1);this.rectAttr.needsUpdate=!0,this.scene.add(this.mesh),this.applyConfig(),this.loadAtlas()}applyConfig(){const t=this.settings(),i=this.material.uniforms;this.mesh.count=t.pages,i.uMeshCount.value=t.pages,i.uPageWidth.value=t.pageWidth,i.uPageHeight.value=t.pageHeight,i.uPageThickness.value=t.thickness,i.uPageSpacing.value=t.pageSpacing,i.uWave.value=t.wave,i.uTilt.value=t.tilt,i.uTurn.value=t.turn,i.uPageAspect.value=t.pageWidthPx/t.pageHeightPx,i.uFocusScale.value=t.focusScale,i.uFocusZ.value=t.focusZ,this.writeOffsets(),(this.focus.index>=t.pages||!t.tapToView)&&this.clearFocus()}clearFocus(){this.focus.index=-1,this.focus.t=0,this.focus.target=0,this.material.uniforms.uFocusIndex.value=-1,this.material.uniforms.uFocusProgress.value=0}writeOffsets(){const t=this.cfg.images,i=Math.max(1,t.length);for(let n=0;n<w;n++){const a=t.length?t[n%i]:void 0,s=a?g(Y(a),-k,k,0):0;this.offsetAttr.setX(n,s/k)}this.offsetAttr.needsUpdate=!0}writeCells(){var i;const t=(i=this.atlas)==null?void 0:i.cells;if(!(!t||!t.length)){for(let n=0;n<w;n++){const a=t[n%t.length];this.rectAttr.setXYZW(n,a.rect[0],a.rect[1],a.rect[2],a.rect[3]),this.aspectAttr.setX(n,a.aspect)}this.rectAttr.needsUpdate=!0,this.aspectAttr.needsUpdate=!0}}sourceList(){const t=this.cfg.images;return t&&t.length?t.map(i=>X(L(i))):Array.from({length:lt},()=>"")}loadAtlas(){const t=this.sourceList(),i=t.join("|");if(i===this.atlasKey)return;this.atlasKey=i;const n=++this.atlasToken;Mt(t,this.renderer.capabilities.getMaxAnisotropy()).then(a=>{var s,o;if(this.disposed||n!==this.atlasToken){a==null||a.texture.dispose();return}(s=this.atlas)==null||s.texture.dispose(),this.atlas=a,a&&(this.material.uniforms.uAtlas.value=a.texture,this.writeCells()),(o=this.onAtlasReady)==null||o.call(this)}).catch(()=>{})}settings(){return this.settingsCache||(this.settingsCache=vt(this.cfg,this.width,this.height)),this.settingsCache}pick(t,i){const n=this.container.getBoundingClientRect();if(n.width<=0||n.height<=0)return-1;const a=(t-n.left)/n.width,s=(i-n.top)/n.height;if(a<0||s<0||a>=1||s>=1)return-1;const o=Math.min(1,pt/Math.max(this.width,this.height)),r=Math.max(1,Math.round(this.width*o)),h=Math.max(1,Math.round(this.height*o));(this.pickTarget.width!==r||this.pickTarget.height!==h)&&this.pickTarget.setSize(r,h);const v=this.mesh.material;this.mesh.material=this.pickMaterial,this.renderer.setRenderTarget(this.pickTarget),this.renderer.setClearColor(0,1),this.renderer.render(this.scene,this.camera),this.renderer.readRenderTargetPixels(this.pickTarget,Math.min(r-1,Math.floor(a*r)),Math.min(h-1,Math.floor((1-s)*h)),1,1,this.pickBuffer),this.renderer.setRenderTarget(null),this.renderer.setClearColor(0,0),this.mesh.material=v;const u=this.pickBuffer[0]-1;return u>=0&&u<this.settings().pages?u:-1}onTap(t){if(this.settings().tapToView){if(this.focus.index>=0){this.focus.target=0;return}t>=0&&(this.focus.index=t,this.focus.target=1)}}wheelScale(t){return t.deltaMode===1?16:t.deltaMode===2?this.height:1}push(t){isFinite(t)&&(this.scroll.target+=t,this.scroll.speed+=t)}attach(){const t=this.container;t.addEventListener("wheel",this.onWheel,{passive:!1}),t.addEventListener("pointerdown",this.onPointerDown),t.addEventListener("pointermove",this.onPointerMove),t.addEventListener("pointerup",this.onPointerUp),t.addEventListener("pointercancel",this.onPointerCancel),window.addEventListener("keydown",this.onKeyDown)}detach(){const t=this.container;t.removeEventListener("wheel",this.onWheel),t.removeEventListener("pointerdown",this.onPointerDown),t.removeEventListener("pointermove",this.onPointerMove),t.removeEventListener("pointerup",this.onPointerUp),t.removeEventListener("pointercancel",this.onPointerCancel),window.removeEventListener("keydown",this.onKeyDown)}setSize(t,i){this.disposed||(this.width=Math.max(1,t),this.height=Math.max(1,i),this.renderer.setSize(this.width,this.height,!1),this.camera.aspect=this.width/this.height,this.camera.updateProjectionMatrix(),this.settingsCache=null,this.applyConfig())}updateConfig(t){this.disposed||(this.cfg=t,this.settingsCache=null,this.loadAtlas(),this.applyConfig(),this.writeCells())}setCursor(t){this.container.style.cursor!==t&&(this.container.style.cursor=t)}renderStatic(){this.disposed||this.renderer.render(this.scene,this.camera)}start(){this.attach(),this.lastT=performance.now();const t=()=>{this.disposed||(this.frameId=requestAnimationFrame(t),this.step())};this.frameId=requestAnimationFrame(t)}step(){const t=performance.now();let i=(t-this.lastT)/1e3;this.lastT=t,(!isFinite(i)||i<0)&&(i=0),i>.05&&(i=.05);const n=this.settings(),a=this.material.uniforms;if(this.focus.index>=0){const h=i/Math.max(.05,n.viewDuration);this.focus.t=Math.min(1,Math.max(0,this.focus.t+(this.focus.target?h:-h))),this.focus.t===0&&this.focus.target===0&&(this.focus.index=-1)}a.uFocusIndex.value=this.focus.index,a.uFocusProgress.value=mt(this.focus.t),this.setCursor(this.focus.index>=0&&this.focus.target===1?"zoom-out":"grab"),n.driftPerSecond!==0&&this.focus.index<0&&this.push(n.driftPerSecond*i);const s=i*60,o=1-Math.pow(1-n.lerp,s);this.scroll.current+=(this.scroll.target-this.scroll.current)*o,this.scroll.speed*=Math.pow(.835,s);const r=n.pages*(n.pageSpacing+n.thickness);if(Math.abs(this.scroll.current)>r){const h=Math.sign(this.scroll.current)*r;this.scroll.current-=h,this.scroll.target-=h}a.uScrollY.value=this.scroll.current,a.uSpeedY.value=this.scroll.speed,this.renderer.render(this.scene,this.camera)}dispose(){var i,n;this.disposed=!0,cancelAnimationFrame(this.frameId),this.detach(),this.geometry.dispose(),this.material.dispose(),this.pickMaterial.dispose(),this.pickTarget.dispose(),this.blank.dispose(),(i=this.atlas)==null||i.texture.dispose(),this.mesh.dispose(),this.renderer.dispose();const t=this.renderer.domElement;(n=t.parentNode)==null||n.removeChild(t)}}function Ft(e){const{images:t=l.images,background:i=l.background,pages:n=l.pages,spacing:a=l.spacing,tilt:s=l.tilt,turn:o=l.turn,pageWidth:r=l.pageWidth,pageHeight:h=l.pageHeight,view:v,scrollSens:u=l.scrollSens,travel:p,style:P}=e,x=C.useRef(null),d=C.useRef(null),y=C.useRef(null),f={images:Array.isArray(t)?t:[],pages:n,spacing:a,tilt:s,turn:o,pageWidth:r,pageHeight:h,view:{...R,...v},scrollSens:u,travel:{...E,...p}};y.current=f;const A=f.images.map(c=>`${X(L(c))}@${Y(c)}`).join("|");C.useEffect(()=>{const c=x.current;if(!c)return;let m;try{m=new St(c,y.current)}catch{return}d.current=m,m.setSize(c.clientWidth,c.clientHeight),m.start();const S=new ResizeObserver(()=>{m.setSize(c.clientWidth,c.clientHeight)});return S.observe(c),()=>{S.disconnect(),m.dispose(),d.current=null}},[]),C.useEffect(()=>{const c=d.current;c&&c.updateConfig(y.current)},[A,n,a,s,o,r,h,u,f.view.tap,f.view.zoom,f.view.speed,f.travel.drift,f.travel.smoothing,f.travel.wave]);const M=f.images[0];return j.jsx("div",{ref:x,role:"img","aria-label":(M?gt(L(M)):"")||"A corridor of magazine pages you scroll through, and tap to hold one up",style:{position:"relative",width:"100%",height:"100%",minWidth:200,minHeight:200,overflow:"hidden",background:i,cursor:"grab",touchAction:"pan-y",...P}})}export{Ft as default};
