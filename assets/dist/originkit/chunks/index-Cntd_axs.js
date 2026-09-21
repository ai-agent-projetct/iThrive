import{r as s,j as e}from"./react-W1izUqcL.js";import{a as W,S as H,O as P,g as O,f as c,V as g,b as N,M as L}from"./three-DeHemVAZ.js";const G=[{num:"01",title:"Full-stack developers",tagline:"Architecture through UI",color:"#00F2FE",rgb:[0,.949,.996],desc:"From system architecture down to optimistic UI state. Engineers who own the entire vertical slice so features never get stuck between layers.",tags:["Next.js","React","Node.js","PostgreSQL","GraphQL"],image:"/assets/img/ondemand/role/01a.jpg"},{num:"02",title:"Mobile app developers",tagline:"Native-grade mobile UX",color:"#38BDF8",rgb:[.22,.741,.973],desc:"Flutter, React Native, Swift and Kotlin. Smooth 120fps gesture-driven interfaces, offline-first sync, and rock-solid state machines.",tags:["Flutter","React Native","Swift","Kotlin","SQLite"],image:"/assets/img/ondemand/role/02a.jpg"},{num:"03",title:"Front-end developers",tagline:"Pixel-perfect, Web Vitals first",color:"#6366F1",rgb:[.388,.4,.945],desc:"React and TypeScript against a rigorous design system, measured on Core Web Vitals and accessibility rather than just a screenshot.",tags:["React","TypeScript","Tailwind","Design Systems","Web Vitals"],image:"/assets/img/ondemand/role/03a.jpg"},{num:"04",title:"Back-end developers",tagline:"Fault-tolerant distributed systems",color:"#9D4EDD",rgb:[.616,.306,.867],desc:"Python, Go and Node behind resilient APIs designed for real-world failure modes, backpressure, queue processing and high concurrency.",tags:["Python","Go","FastAPI","Redis","Docker","Kafka"],image:"/assets/img/ondemand/role/04a.jpg"},{num:"05",title:"E-commerce developers",tagline:"High-conversion storefronts",color:"#EC4899",rgb:[.925,.282,.6],desc:"Custom headless storefronts, checkout pipelines, and ERP/payment integrations where 100 milliseconds is directly measurable in revenue.",tags:["Shopify Plus","Stripe","Headless","Medusa","Next Commerce"],image:"/assets/img/ondemand/role/05a.jpg"}],$=`
void main() {
  gl_Position = vec4(position, 1.0);
}
`,V=`
uniform float uTime;
uniform vec2 uResolution;
uniform float uDpr;
uniform vec2 uBoxDim;
uniform vec2 uBoxCenter;
uniform vec3 uColorCenter;
uniform vec3 uColorGlow;
uniform vec3 uBgColor;
uniform float uBoxR;
uniform float uBeamWidth;
uniform float uBeamTaper;
uniform vec2 uBeamOffset;
uniform float uBeamAngle;
uniform float uSpread;
uniform float uAnimationScale;
uniform float uEffectScale;
uniform float uAuraSize;
uniform float uCoreSize;
uniform float uHover;
uniform float uOverdriveGlowMult;
uniform float uShowBeamDust;
uniform float uBeamDustIntensity;
uniform float uBeamDustSpeed;
uniform float uBeamDustScale;
uniform float uShowGrid;
uniform vec3 uGridColor;
uniform float uGridSize;
uniform float uGridDotSize;
uniform float uGridOpacity;

float smin(float a, float b, float k) {
  float h = clamp(0.5 + 0.5 * (b - a) / k, 0.0, 1.0);
  return mix(b, a, h) - k * h * (1.0 - h);
}

float sdBox(in vec2 p, in vec2 b, in float r) {
  vec2 d = abs(p) - b + r;
  return length(max(d, 0.0)) + min(max(d.x, d.y), 0.0) - r;
}

float hash12(vec2 p) {
  vec3 p3 = fract(vec3(p.xyx) * 0.1031);
  p3 += dot(p3, p3.yzx + 33.33);
  return fract((p3.x + p3.y) * p3.z);
}

float vnoise(vec2 p) {
  vec2 i = floor(p);
  vec2 f = fract(p);
  vec2 u = f * f * (3.0 - 2.0 * f);
  return mix(mix(hash12(i + vec2(0.0,0.0)), hash12(i + vec2(1.0,0.0)), u.x),
             mix(hash12(i + vec2(0.0,1.0)), hash12(i + vec2(1.0,1.0)), u.x), u.y);
}

float fbm(vec2 p) {
  float v = 0.0;
  float a = 0.5;
  mat2 rot = mat2(0.866, -0.5, 0.5, 0.866);
  for (int i = 0; i < 4; ++i) {
    v += a * vnoise(p);
    p = rot * p * 2.0;
    a *= 0.5;
  }
  return v;
}

void main() {
  vec2 p = gl_FragCoord.xy - uResolution.xy * 0.5;
  float t = uTime;

  // Box bounds
  vec2 boxP = p - uBoxCenter;
  float dBox = sdBox(boxP, uBoxDim, uBoxR * uDpr);

  // Directional beam mapping
  vec2 rp = p - (uBoxCenter + uBeamOffset);
  float c = cos(uBeamAngle);
  float s = sin(uBeamAngle);
  vec2 bp = vec2(rp.x * c - rp.y * s, rp.x * s + rp.y * c);
  vec2 np = bp * uAnimationScale;
  float symY = abs(np.y);

  float distToBox = max(dBox, 0.0);
  float taperRatio = exp(-distToBox / (70.0 * uDpr));
  float baseWidth = (uBeamWidth + uBeamTaper * taperRatio) * uDpr;

  float flowTime = t * 3.0;
  float n1 = fbm(vec2(np.x * 0.02, symY * 0.01 + flowTime * 0.4));
  float n2 = fbm(vec2(np.x * 0.05 - flowTime * 0.1, symY * 0.02 + flowTime * 0.7));
  float cloudSmoke = (n1 + n2) * 0.5;
  float streaks = fbm(vec2(np.x * 0.15, symY * 0.002 + flowTime * 1.0));
  float pulse = pow(sin(symY * 0.005 + t * 2.5) * 0.5 + 0.5, 12.0);

  float baseSmoke = smoothstep(0.2, 0.8, cloudSmoke) * 0.4 + smoothstep(0.3, 0.7, streaks) * 0.4;
  float smokyEffect = baseSmoke + pulse * 0.6;

  float beamThickening = mix(1.0, 1.25, uHover);
  float currentBeamWidth = baseWidth * (0.8 + 0.4 * baseSmoke * uEffectScale + 0.6 * pulse * uEffectScale) * beamThickening;
  float dBeam = abs(bp.x) - currentBeamWidth;

  float dMerge = smin(dBox, dBeam, uSpread * uDpr);
  float dist = max(dMerge, 0.0);

  float auraRadius = uAuraSize * uDpr;
  float coreRadius = uCoreSize * uDpr;

  float aura = pow(auraRadius / (dist + auraRadius), 2.2) * 0.5;
  float core = pow(coreRadius / (dist + coreRadius), 3.0) * 0.8;

  float awayFromBox = smoothstep(0.0, uSpread * uDpr * 1.5, distToBox);
  float hardMask = smoothstep(1.0, -1.0, dMerge);
  float innerMask = hardMask * mix(1.0, 0.0, awayFromBox);

  float softBeamCore = smoothstep(currentBeamWidth * 2.0, 0.0, max(dBeam, 0.0));
  float beamEnergy = softBeamCore * smokyEffect * awayFromBox;

  float overdriveGlow = mix(1.0, uOverdriveGlowMult, uHover);
  core += beamEnergy * 1.2 * overdriveGlow;
  aura += beamEnergy * 0.6 * overdriveGlow;

  vec3 finalCol = uBgColor;

  if (uShowGrid > 0.5) {
    float cellSize = max(uGridSize, 1.0) * uDpr;
    vec2 gridFract = fract((p - uBoxCenter) / cellSize) - 0.5;
    float dotDist = length(gridFract);
    float dotRadius = uGridDotSize * 0.5;
    float blur = 1.0 / cellSize;
    float dotMask = smoothstep(dotRadius + blur, dotRadius - blur, dotDist);
    finalCol = mix(finalCol, uGridColor, dotMask * uGridOpacity);
  }

  finalCol += uColorGlow * aura;
  finalCol += mix(uColorGlow, uColorCenter, 0.6) * core;
  finalCol = mix(finalCol, uColorCenter, innerMask * 0.15);

  // Beam particles
  if (uShowBeamDust > 0.5) {
    float dBeamArea = max(dBeam, 0.0);
    float beamMask = smoothstep(40.0 * uDpr, -10.0 * uDpr, dBeamArea);
    float boxFadeOut = smoothstep(-20.0 * uDpr, 50.0 * uDpr, dBox);

    if (beamMask > 0.0 && boxFadeOut > 0.0) {
      float dust = 0.0;
      for (int i = 0; i < 4; i++) {
        float fi = float(i);
        float layerScale = uBeamDustScale * (1.0 + fi * 0.35);
        vec2 uv = vec2(bp.x, abs(bp.y)) / max(uResolution.x, uResolution.y) * layerScale;
        float fallSpeed = uBeamDustSpeed * (1.2 + hash12(vec2(fi)) * 0.8);
        uv.y += uTime * fallSpeed;
        uv.x += sin(abs(bp.y) * 0.01 + uTime * 5.0 + fi) * 0.02;

        vec2 gridId = floor(uv);
        vec2 gridP = fract(uv);
        vec2 offset = vec2(hash12(gridId * 15.3 + fi), hash12(gridId * 3.7 - fi)) * 0.7 + 0.15;
        float dDist = length(gridP - offset);
        float particleRadius = (hash12(gridId * 7.1) * 0.02 + 0.005);
        float twinkle = 0.5 + 0.5 * sin(uTime * 20.0 + hash12(gridId) * 100.0);
        float particle = smoothstep(particleRadius + 0.04, particleRadius, dDist) * twinkle;
        float densityGate = step(0.5, hash12(gridId * 2.2));
        dust += particle * densityGate * (0.4 + 0.6 * hash12(gridId * 9.5));
      }
      finalCol += mix(uColorGlow, vec3(1.0), 0.7) * dust * uBeamDustIntensity * beamMask * boxFadeOut;
    }
  }

  gl_FragColor = vec4(finalCol, 1.0);
}
`;function q(v){const h=v.disciplines&&v.disciplines.length>0?v.disciplines:G,b=s.useRef(null),B=s.useRef(null),l=s.useRef(null),[y,j]=s.useState(0),[E,C]=s.useState(!1),f=s.useRef(null),t=h[y]||h[0];return s.useEffect(()=>{const o=B.current,i=b.current;if(!o||!i)return;let a=!1,u=0;const d=new W({canvas:o,alpha:!0,antialias:!1,powerPreference:"high-performance"}),r=Math.min(window.devicePixelRatio||1,2);d.setPixelRatio(r);const D=new H,z=new P(-1,1,1,-1,0,1),R=new O(2,2),m=G[0].rgb,n={uTime:{value:0},uResolution:{value:new g},uDpr:{value:r},uBoxDim:{value:new g(320,240)},uBoxCenter:{value:new g(0,0)},uColorCenter:{value:new c(1,1,1)},uColorGlow:{value:new c(m[0],m[1],m[2])},uBgColor:{value:new c(.02,.03,.07)},uBoxR:{value:36},uBeamWidth:{value:6},uBeamTaper:{value:36},uBeamOffset:{value:new g(0,24)},uBeamAngle:{value:0},uSpread:{value:0},uAnimationScale:{value:.4},uEffectScale:{value:.25},uAuraSize:{value:280},uCoreSize:{value:45},uHover:{value:0},uOverdriveGlowMult:{value:2.4},uShowBeamDust:{value:1},uBeamDustIntensity:{value:2.8},uBeamDustSpeed:{value:.12},uBeamDustScale:{value:50},uShowGrid:{value:1},uGridColor:{value:new c(.85,.92,1)},uGridSize:{value:8},uGridDotSize:{value:.95},uGridOpacity:{value:.035}};f.current=n;const k=new N({vertexShader:$,fragmentShader:V,uniforms:n,depthTest:!1,depthWrite:!1}),T=new L(R,k);D.add(T);const w=()=>{if(!i||!o)return;const p=i.clientWidth||940,x=i.clientHeight||640;if(d.setSize(p,x,!1),n.uResolution.value.set(p*r,x*r),l.current){const S=l.current.offsetWidth*r,M=l.current.offsetHeight*r;n.uBoxDim.value.set(S*.5,M*.5)}};w(),window.addEventListener("resize",w);let I=performance.now();const A=new c(...m),F=p=>{if(a)return;const x=(p-I)*.001;n.uTime.value=x,n.uColorGlow.value.lerp(A,.08);const S=E?1:0;n.uHover.value+=(S-n.uHover.value)*.1,d.render(D,z),u=requestAnimationFrame(F)};return u=requestAnimationFrame(F),()=>{a=!0,cancelAnimationFrame(u),window.removeEventListener("resize",w),R.dispose(),k.dispose(),d.dispose()}},[]),s.useEffect(()=>{if(f.current&&t){const[o,i,a]=t.rgb;if(f.current.uColorGlow.value.setRGB(o,i,a),l.current&&b.current){const u=Math.min(window.devicePixelRatio||1,2),d=l.current.offsetWidth*u,r=l.current.offsetHeight*u;f.current.uBoxDim.value.set(d*.5,r*.5)}}},[y,t]),e.jsxs("div",{ref:b,style:{position:"relative",width:"100%",minHeight:"640px",height:"clamp(620px, 75vh, 760px)",overflow:"hidden",background:"#02040A",borderRadius:"28px",border:"1px solid rgba(255, 255, 255, 0.08)",boxShadow:"0 30px 90px -20px rgba(0, 0, 0, 0.95)",display:"flex",flexDirection:"column",alignItems:"center",justifyContent:"center"},onMouseEnter:()=>C(!0),onMouseLeave:()=>C(!1),children:[e.jsx("canvas",{ref:B,style:{position:"absolute",inset:0,width:"100%",height:"100%",pointerEvents:"none"}}),e.jsxs("div",{ref:l,style:{position:"relative",zIndex:10,width:"min(780px, 92%)",borderRadius:"36px",background:"rgba(6, 11, 24, 0.92)",backdropFilter:"blur(20px)",border:`1px solid ${t.color}66`,boxShadow:`0 24px 60px -15px rgba(0, 0, 0, 0.9), 0 0 40px ${t.color}26`,overflow:"hidden",display:"grid",gridTemplateColumns:"minmax(0, 1.25fr) minmax(0, 1fr)",transition:"border 0.4s ease, box-shadow 0.4s ease"},children:[e.jsxs("div",{style:{padding:"clamp(24px, 3.5vw, 44px)",display:"flex",flexDirection:"column",justifyContent:"space-between",zIndex:2},children:[e.jsxs("div",{children:[e.jsxs("div",{style:{display:"inline-flex",alignItems:"center",gap:"8px",padding:"6px 14px",borderRadius:"999px",background:`${t.color}18`,border:`1px solid ${t.color}4d`,marginBottom:"18px"},children:[e.jsx("span",{style:{fontFamily:"Fira Code, monospace",fontSize:"12px",fontWeight:800,color:t.color},children:t.num}),e.jsx("span",{style:{fontSize:"11px",fontWeight:700,color:"#E2E8F0",letterSpacing:"0.06em",textTransform:"uppercase"},children:t.tagline})]}),e.jsx("h3",{style:{fontSize:"clamp(1.7rem, 2.5vw, 2.2rem)",fontWeight:800,color:"#F8FAFC",lineHeight:1.2,letterSpacing:"-0.02em",margin:"0 0 14px"},children:t.title}),e.jsx("p",{style:{fontSize:"clamp(0.9rem, 1.05vw, 1rem)",lineHeight:1.65,color:"#94A3B8",margin:"0 0 20px"},children:t.desc}),e.jsx("div",{style:{display:"flex",flexWrap:"wrap",gap:"8px",marginBottom:"20px"},children:t.tags.map(o=>e.jsx("span",{style:{padding:"4px 10px",borderRadius:"6px",background:"rgba(255, 255, 255, 0.05)",border:"1px solid rgba(255, 255, 255, 0.08)",fontSize:"11px",fontFamily:"Fira Code, monospace",color:"#CBD5E1"},children:o},o))})]}),e.jsx("div",{children:e.jsx("button",{type:"button",className:"od-btn od-btn--primary","data-modal-open":!0,"data-modal-service":`Hire ${t.title}`,style:{background:`linear-gradient(90deg, ${t.color}, #3B82F6)`,color:"#040711",fontWeight:800,boxShadow:`0 6px 20px ${t.color}40`,cursor:"pointer"},children:"Deploy this discipline →"})})]}),e.jsxs("div",{style:{position:"relative",height:"100%",minHeight:"280px",overflow:"hidden",background:"#040711",display:"flex",alignItems:"center",justifyContent:"center"},children:[e.jsx("img",{src:t.image,alt:t.title,style:{width:"100%",height:"100%",objectFit:"cover",filter:"contrast(1.05) brightness(0.95)",transition:"opacity 0.4s ease"}}),e.jsx("div",{style:{position:"absolute",inset:0,background:"linear-gradient(to right, rgba(6, 11, 24, 0.95) 0%, transparent 40%), linear-gradient(to top, rgba(6, 11, 24, 0.8) 0%, transparent 50%)",pointerEvents:"none"}})]})]}),e.jsx("div",{style:{position:"relative",zIndex:20,marginTop:"28px",display:"flex",alignItems:"center",gap:"10px",padding:"8px 16px",borderRadius:"999px",background:"rgba(6, 11, 24, 0.85)",backdropFilter:"blur(16px)",border:"1px solid rgba(255, 255, 255, 0.12)",boxShadow:"0 12px 36px rgba(0, 0, 0, 0.6)"},children:h.map((o,i)=>{const a=y===i;return e.jsxs("button",{type:"button",onClick:()=>j(i),style:{display:"flex",alignItems:"center",gap:"6px",padding:a?"6px 14px":"6px 10px",borderRadius:"999px",background:a?o.color:"transparent",color:a?"#040711":"rgba(226, 232, 240, 0.65)",fontWeight:a?800:500,fontSize:"12px",fontFamily:"Inter, sans-serif",border:"none",cursor:"pointer",transition:"all 0.3s cubic-bezier(0.16, 1, 0.3, 1)"},children:[e.jsx("span",{children:o.num}),a&&e.jsx("span",{children:o.title.split(" ")[0]})]},o.num)})}),e.jsx("p",{style:{position:"relative",zIndex:20,marginTop:"10px",fontSize:"11px",color:"rgba(148, 163, 184, 0.7)",fontFamily:"Fira Code, monospace",letterSpacing:"0.04em"},children:"Click to switch disciplines & watch the flare pulse"})]})}export{q as default};
