import{r as k,j as G}from"./react-B6aDbEU9.js";import{u as Pt}from"../originkit.js";import{W as At,C as Ae,S as ct,O as dt,T as Dt,L as kt,c as vt,d as It,M as ft,a as pt,e as zt,V as mt,b as Wt,f as Ft}from"./three-vXTBWVp-.js";import{g as ht,G as Tt}from"./gsap-BSYeGmHT.js";const Y=ht??ht??Tt;function De(d){return d==null?"":String(d).replace(/<[^>]*>/g,"").replace(/&nbsp;/gi," ").replace(/&amp;/gi,"&").replace(/&lt;/gi,"<").replace(/&gt;/gi,">").replace(/&quot;/gi,'"').replace(/&#39;/g,"'").trim()}const Xt=`
    #define PI 3.14159265
    precision highp float;
    varying vec2 vUv;
    uniform sampler2D uTex;
    uniform vec2  uRes;
    uniform vec2  uCenter;
    uniform float uSizeX;
    uniform float uSizeY;
    uniform float uAspect;
    uniform float uZoom;
    uniform float uDispersion;
    uniform float uBlur;
    uniform float uGlow;
    uniform float uWhiteGlow;
    uniform float uNovaSize;
    uniform float uBlueRing;
    uniform float uRingRadius;
    uniform float uRingWidth;
    uniform float uShimmer;
    uniform float uShimmerFreq;
    uniform float uShimmerSpeed;
    uniform float uShimmerDepth;
    uniform float uTime;
    uniform float uRimStart;
    uniform float uRimTangential;
    uniform float uRimInward;
    uniform float uRimFreq1;
    uniform float uRimFreq2;
    uniform vec3  uBlueColor;
    uniform float uRimLine;
    uniform float uRimLinePos;
    uniform float uRimLineWidth;
    uniform float uShape;
    uniform float uSquareRound;
    uniform float uRotation;
    uniform int   uSamples;

    const int MAX_SAMPLES = 16;

    float sdRoundBox(vec2 p, vec2 b, float r) {
        vec2 q = abs(p) - b + r;
        return min(max(q.x, q.y), 0.0) + length(max(q, 0.0)) - r;
    }

    vec3 glassLens(vec2 center, float aspectCorrect, out float outA) {
        vec2 p = vUv - center;
        p.x *= aspectCorrect;
        float ca = cos(uRotation), sa = sin(uRotation);
        p = mat2(ca, -sa, sa, ca) * p;
        vec2 halfSize = vec2(uSizeX, uSizeY);
        float dist = length(p / halfSize);
        outA = 0.0;

        float maskND;
        if (uShape > 0.5) {
            float corner = min(uSizeX, uSizeY) * clamp(uSquareRound, 0.0, 1.0);
            float sd = sdRoundBox(p, halfSize, corner);
            maskND = 1.0 + sd / min(uSizeX, uSizeY);
        } else {
            maskND = dist;
        }

        if (maskND > 1.0) return vec3(0.0);

        float shapeND = clamp(maskND, 0.0, 1.0);
        float nd = clamp(dist, 0.0, 1.0);
        vec2 offset = vUv - center;
        vec2 radialDir = normalize(offset + 1e-6);
        vec2 tangentDir = vec2(-radialDir.y, radialDir.x);
        float angle = atan(p.y, p.x);

        float pull = uZoom * 0.30 * nd * nd;
        float rimStrength = smoothstep(uRimStart, 1.0, nd);
        float fluidWave = sin(angle * uRimFreq1) * 0.55 +
                          sin(angle * uRimFreq2) * 0.25;
        float rScreen = (uSizeX + uSizeY) * 0.5;

        vec2 rimOff = tangentDir * fluidWave * rimStrength *
                      rScreen * uRimTangential;
        vec2 rimPull = -radialDir * rimStrength * rScreen * uRimInward;
        vec2 baseUV = center + offset * (1.0 - pull) + rimOff + rimPull;

        float rimMask = smoothstep(0.55, 1.0, nd);
        vec2 dispDir = offset * uDispersion * 0.004 * rimMask;

        int count = uSamples;
        if (count < 2) count = 2;
        if (count > MAX_SAMPLES) count = MAX_SAMPLES;

        vec3 col = vec3(0.0);
        vec3 caW = vec3(0.0);

        for (int i = 0; i < MAX_SAMPLES; i++) {
            if (i >= count) break;

            float t = float(i) / float(count - 1);
            vec2 sUV = baseUV + dispDir * (t - 0.5);
            vec3 sampleColor = texture2D(uTex, sUV).rgb;

            vec3 weight = vec3(
                exp(-pow((t - 0.00) / 0.38, 2.0)),
                exp(-pow((t - 0.50) / 0.38, 2.0)),
                exp(-pow((t - 1.00) / 0.38, 2.0))
            );

            col += sampleColor * weight;
            caW += weight;
        }

        col /= max(caW, vec3(0.001));

        float blurFade = 1.0 - smoothstep(0.72, 0.98, nd);

        if (uBlur > 0.01 && blurFade > 0.01) {
            vec2 blurRad = vec2(uBlur) / uRes * blurFade;
            vec3 bcol = vec3(0.0);
            float totalWeight = 0.0;

            for (float a = 0.0; a < PI * 2.0; a += PI * 2.0 / 6.0) {
                for (float rr = 0.4; rr <= 1.001; rr += 0.3) {
                    vec2 o = vec2(cos(a), sin(a)) * blurRad * rr;
                    float weight = 1.0 - rr * 0.38;
                    bcol += texture2D(uTex, baseUV + o).rgb * weight;
                    totalWeight += weight;
                }
            }

            col = mix(bcol / totalWeight, col, rimMask);
        }

        col *= mix(0.91, 1.0, smoothstep(0.0, 0.38, shapeND));

        float r2 = shapeND * shapeND * 0.25;
        float gs = max(uNovaSize * uGlow * 0.003, 0.004);
        float nova = exp(-r2 / gs) + exp(-r2 / (gs * 7.0)) * 0.18;

        nova *= uWhiteGlow * (uGlow / 17.0) * 1.15;
        col += vec3(nova);

        float dC = shapeND * 0.5;
        float tR = clamp(uRingRadius, 0.1, 0.49);
        float rW = max(uRingWidth, 0.003);

        float ring = exp(-pow((dC - tR) / rW, 2.0));
        ring *= uBlueRing * (uGlow / 17.0) * 1.8;

        if (uShimmer > 0.5) {
            ring *= sin(angle * uShimmerFreq + uTime * uShimmerSpeed) *
                    uShimmerDepth + (1.0 - uShimmerDepth);
        }

        float aura = exp(-pow((dC - tR) / (rW * 6.0), 2.0)) *
                     0.28 * uBlueRing * (uGlow / 17.0);

        col += uBlueColor * (ring + aura);

        col += vec3(
            exp(
                -pow(
                    (dC - uRimLinePos) /
                    max(uRimLineWidth, 0.0001),
                    2.0
                )
            ) * uRimLine
        );

        outA = smoothstep(1.0, 0.93, maskND);

        return col;
    }

    void main() {
        vec3 outputColor = texture2D(uTex, vUv).rgb;
        float alpha = 0.0;
        vec3 lensColor = glassLens(uCenter, uAspect, alpha);
        outputColor = mix(outputColor, lensColor, alpha);
        gl_FragColor = vec4(outputColor, 1.0);
    }
`;function gt(d,T){const P=document.createElement("canvas");P.width=1200,P.height=800;const M=P.getContext("2d"),S=(d*47+210)%360,N=M.createLinearGradient(0,0,1200,800);N.addColorStop(0,`hsl(${S}, 72%, 58%)`),N.addColorStop(1,`hsl(${(S+80)%360}, 70%, 22%)`),M.fillStyle=N,M.fillRect(0,0,P.width,P.height),M.fillStyle="rgba(255,255,255,.92)",M.font="600 66px Arial, sans-serif",M.textAlign="center",M.textBaseline="middle",M.fillText(De(T)||`Project ${d+1}`,600,400);const z=new Ft(P);return z.colorSpace=vt,z.needsUpdate=!0,z}function jt(d,T){const{projects:P,propsRef:M,cursorElement:S,onActiveChange:N,onFocusChange:z,onEntryDone:Q}=T,s=()=>M.current,he=P.length?P:[{brand:"Project One",description:"Add your own image"},{brand:"Project Two",description:"Add your own image"},{brand:"Project Three",description:"Add your own image"}];let f=Math.max(1,d.clientWidth),h=Math.max(1,d.clientHeight);const m=new At({antialias:!0,alpha:!0}),C=Math.min(window.devicePixelRatio||1,s().pixelRatio);m.setPixelRatio(C),m.setSize(f,h),m.setClearColor(new Ae(s().background),1),m.domElement.style.width="100%",m.domElement.style.height="100%",m.domElement.style.display="block",m.domElement.style.touchAction="none",d.style.touchAction="none",d.appendChild(m.domElement);const oe=()=>{const e=s().panelHeight,t=h*.48,n=f*.78;return Math.max(110,Math.min(e,t,n))},W=()=>{const e=oe()/Math.max(1,s().panelHeight);return Math.max(6,s().gap*Math.min(1,e))},re=new ct,F=new dt(-f/2,f/2,h/2,-h/2,-100,100);F.position.z=10;const ae=new Dt;ae.setCrossOrigin("anonymous");let J=!1;const a=he.map((e,t)=>{var g;const n={texture:null,aspect:1.5,bound:!1},r=(g=e.image)==null?void 0:g.src;return r?ae.load(r,o=>{o.minFilter=kt,o.generateMipmaps=!0,o.anisotropy=m.capabilities.getMaxAnisotropy(),o.colorSpace=vt,n.aspect=o.image.width/o.image.height,n.texture=o,$(),J||(x=j(0),E=x)},void 0,()=>{n.texture=gt(t,e.brand)}):n.texture=gt(t,e.brand),n}),V=e=>a[e].aspect*oe()+W();let X=[],b=0;function $(){X=[];let e=0;a.forEach((t,n)=>{X.push(e),e+=V(n)}),b=Math.max(e,1)}$();function j(e){const t=a.length,n=Math.floor(e/t),r=(e%t+t)%t;return X[r]+V(r)/2-W()/2+n*b}function c(e){let t=0,n=1/0;for(let r=0;r<a.length;r++){const g=X[r]+V(r)/2-W()/2,o=Math.round((e-g)/b),i=Math.abs(g+o*b-e);i<n&&(n=i,t=r+o*a.length)}return t}function A(e){let t=0,n=1/0;for(let r=0;r<a.length;r++){const g=X[r]+V(r)/2-W()/2,o=Math.round((e-g)/b),i=Math.abs(g+o*b-e);i<n&&(n=i,t=r)}return t}const H=4,D=[];for(let e=0;e<H;e++)for(let t=0;t<a.length;t++){const n=new It({color:14540253,transparent:!0}),r=new ft(new pt(1,1),n);r.visible=!1,re.add(r),D.push({mesh:r,material:n,sourceIndex:t})}let x=j(0),E=x,ke=x,ge=0,ee=null,ve=0,ie=!1,Ie=-1,xe=new zt(f*C,h*C);const ze=new ct,xt=new dt(-1,1,1,-1,0,1),w={uTex:{value:xe.texture},uRes:{value:new mt(f*C,h*C)},uCenter:{value:new mt(s().lensX,s().lensY)},uSizeX:{value:s().lensWidth},uSizeY:{value:s().lensHeight},uShape:{value:s().lensShape==="square"?1:0},uSquareRound:{value:0},uRotation:{value:0},uAspect:{value:f/h},uZoom:{value:s().zoom},uDispersion:{value:s().dispersion},uBlur:{value:s().blur},uGlow:{value:s().glow},uWhiteGlow:{value:.24},uNovaSize:{value:12},uBlueRing:{value:s().blueRing},uRingRadius:{value:.49},uRingWidth:{value:.014},uShimmer:{value:s().shimmer?1:0},uShimmerFreq:{value:12},uShimmerSpeed:{value:3.5},uShimmerDepth:{value:.12},uTime:{value:0},uRimStart:{value:.578},uRimTangential:{value:s().rimWave},uRimInward:{value:0},uRimFreq1:{value:2},uRimFreq2:{value:1},uBlueColor:{value:new Ae(s().blueColor)},uRimLine:{value:1.4},uRimLinePos:{value:.488},uRimLineWidth:{value:.003},uSamples:{value:16}},We=new Wt({uniforms:w,vertexShader:`
            varying vec2 vUv;

            void main() {
                vUv = uv;
                gl_Position = vec4(position.xy, 0.0, 1.0);
            }
        `,fragmentShader:Xt}),Fe=new ft(new pt(2,2),We);ze.add(Fe);const le=s().entryAnimation&&!0,l={active:!1,sourceIndex:-1,poolIndex:-1,lensFx:le?0:1,animation:null},se=new Array(D.length).fill(0),Me=new Array(D.length).fill(le?0:1),ue=new Array(D.length).fill(le?0:1),U=new Array(D.length);let te=1,Z=le,_=!1,K=null,Ce=[],q=null;function Te(){Ce=[],q=null;let e=1/0;const t=f/2,n=oe(),r=W(),g=n;D.forEach((o,i)=>{const B=Math.floor(i/a.length),u=o.sourceIndex,L=a[u];let v=X[u]+V(u)/2-r/2-x;v=(v%b+b)%b,v+=(B-Math.floor(H/2))*b,v>t+b&&(v-=b*H);const R=v,Je=Z||_;if(!Je&&(R<-t-g||R>t+g)){o.mesh.visible=!1,U[i]=void 0;return}U[i]=R;const et=1-.25*ge,Mt=n*et,Ct=L.aspect*n*et;L.texture&&!o.bound&&(o.material.map=L.texture,o.material.color.set(16777215),o.material.needsUpdate=!0,o.bound=!0);let Se=0,be=Ct,de=Mt;l.active&&l.poolIndex===i?(be*=te,de*=te):se[i]>0&&(Se=-se[i]*h*1.4);let tt=R,nt=Se,ot=be,rt=de;if(Je){const Et=Me[i],Lt=ue[i],Re=Math.min(80,n*.35),lt=Re+(de-Re)*Lt;rt=lt,ot=lt*L.aspect;const fe=A(x);let O=u-fe;O>a.length/2&&(O-=a.length),O<-a.length/2&&(O+=a.length);const st=Math.floor(H/2);if(B!==st){o.mesh.visible=!1,U[i]=void 0;return}const ye=I=>Re+(n-Re)*ue[st*a.length+I];let Pe=0;if(O>0)for(let I=0;I<O;I++){const pe=(fe+I)%a.length,me=(fe+I+1)%a.length;Pe+=(a[pe].aspect*ye(pe)+a[me].aspect*ye(me))/2+r}else if(O<0)for(let I=0;I<-O;I++){const pe=((fe-I)%a.length+a.length)%a.length,me=((fe-I-1)%a.length+a.length)%a.length;Pe-=(a[pe].aspect*ye(pe)+a[me].aspect*ye(me))/2+r}tt=Pe;const ut=-h*.9;nt=ut+(Se-ut)*Et}o.mesh.visible=!0,o.mesh.position.set(tt,nt,0),o.mesh.scale.set(ot,rt,1);const at=R+f/2,it=h/2-Se;Ce.push({left:at-be/2,right:at+be/2,top:it-de/2,bottom:it+de/2,poolIndex:i,sourceIndex:u,centerX:R}),Math.abs(R)<e&&(e=Math.abs(R),q={sourceIndex:u,poolIndex:i,centerX:R})})}function Xe(e,t){return Ce.find(n=>e>=n.left&&e<=n.right&&t>=n.top&&t<=n.bottom)||null}const p=m.domElement;S&&Y.set(S,{xPercent:20,yPercent:30,scale:0,autoAlpha:0});const je=S?Y.quickTo(S,"x",{duration:.5,ease:"power3.out"}):null,qe=S?Y.quickTo(S,"y",{duration:.5,ease:"power3.out"}):null;let Be=!1;function ne(e){(Z||_)&&(e=!1),p.style.cursor=e?"pointer":"",!(e===Be||!S)&&(Be=e,Y.to(S,{scale:e?1:0,autoAlpha:e?1:0,duration:e?.35:.25,ease:e?"power3.out":"power3.in"}))}function Ge(e){const t=p.getBoundingClientRect();return{x:e.clientX-t.left,y:e.clientY-t.top}}let ce=null,He=0,Ue=0,Ee=!1,Le=!1;function _e(e){e.preventDefault(),!(l.active||Z||_)&&(J=!0,ee=null,E+=(e.deltaY||e.deltaX)*s().wheelSensitivity,ve=performance.now(),ie=!0)}function Oe(e){var t;l.active||Z||_||e.pointerType==="mouse"&&e.button!==0||(ce=e.pointerId,He=e.clientX,Ue=E,Ee=!1,J=!0,ee=null,(t=p.setPointerCapture)==null||t.call(p,e.pointerId))}function Ye(e){const t=Ge(e);if(je&&je(t.x),qe&&qe(t.y),ce===e.pointerId){const n=e.clientX-He;Math.abs(n)>6&&(Ee=!0),E=Ue-n*s().wheelSensitivity,ve=performance.now(),ie=!0,ne(!1);return}if(l.active)return ne(!1);e.pointerType==="mouse"&&ne(Xe(t.x,t.y)!==null)}function we(e){var t;ce===e.pointerId&&((t=p.releasePointerCapture)==null||t.call(p,e.pointerId),ce=null,Ee&&(Le=!0,ve=performance.now(),ie=!0))}function Ne(){ce===null&&ne(!1)}function Ve(e){if(Le){Le=!1;return}if(l.active||Z||_)return;const t=Ge(e),n=Xe(t.x,t.y);if(n){if(q&&n.poolIndex===q.poolIndex){$e();return}J=!0,E=j(c(x+n.centerX)),ee={sourceIndex:n.sourceIndex},ne(!1)}}function $e(){var B;if(l.active||!q)return;l.active=!0,l.sourceIndex=q.sourceIndex,l.poolIndex=q.poolIndex,E=j(c(x));const e=U[l.poolIndex]||0,t=D.map((u,L)=>({index:L,x:U[L]})).filter(u=>u.index!==l.poolIndex&&u.x!==void 0).map(u=>({...u,distance:Math.abs(u.x-e)})).sort((u,L)=>u.distance-L.distance);let n=0,r=-1;const g=t.map(u=>(r>=0&&u.distance-r>1&&n++,r=u.distance,{index:u.index,rank:n}));(B=l.animation)==null||B.kill();const o=Y.timeline();o.to(l,{lensFx:0,duration:.85,ease:"power3.out"},0);const i={value:te};o.to(i,{value:s().focusScale,duration:.9,ease:"power3.out",onUpdate:()=>te=i.value},0),g.forEach(u=>{o.to(se,{[u.index]:1,duration:.7,ease:"power4.out"},u.rank*.06)}),l.animation=o,ne(!1),z(!0)}function wt(){var g;if(!l.active)return;(g=l.animation)==null||g.kill(),z(!1);const e=U[l.poolIndex]||0,t=D.map((o,i)=>({index:i,x:U[i]})).filter(o=>o.x!==void 0&&(se[o.index]||0)>0).map(o=>({...o,distance:Math.abs(o.x-e)})).sort((o,i)=>i.distance-o.distance),n=Y.timeline({onComplete:()=>{l.active=!1,l.sourceIndex=-1}});n.to(l,{lensFx:1,duration:.68,ease:"power3.inOut"},0);const r={value:te};n.to(r,{value:1,duration:.76,ease:"power3.out",onUpdate:()=>te=r.value},0),t.forEach((o,i)=>{n.to(se,{[o.index]:0,duration:.6,ease:"power4.out"},i*.035)}),l.animation=n}function St(){if(!le){Q(!0);return}K==null||K.kill(),Me.fill(0),ue.fill(0),Z=!0,_=!1,l.lensFx=0,Q(!1),E=j(c(x)),x=E,Te();const e=U.map((y,v)=>y===void 0?-1:v).filter(y=>y>=0),t=Y.timeline({delay:.5}),n=.07*Math.max(e.length-1,1);let r=0;e.forEach(y=>{const v=Math.random()*n;r=Math.max(r,v+1),t.to(Me,{[y]:1,duration:1,ease:"power3.out"},v)}),t.call(()=>{Z=!1,_=!0},void 0,r);const g=A(x),o=Math.floor(H/2),i=[];let B=0;for(let y=0;y<a.length;y++){let v=y-g;v>a.length/2&&(v-=a.length),v<-a.length/2&&(v+=a.length);const R=Math.abs(v);B=Math.max(B,R),i.push({index:o*a.length+y,distanceRank:R})}const u=r+.25;let L=u;t.to(l,{lensFx:1,duration:1.4,ease:"power2.inOut"},u),i.forEach(y=>{const v=B-y.distanceRank,R=u+v*.085;L=Math.max(L,R+2.15),t.to(ue,{[y.index]:1,duration:2.15,ease:"expo.inOut"},R)}),t.call(()=>{_=!1,ue.fill(1),Q(!0)},void 0,L),K=t}p.addEventListener("wheel",_e,{passive:!1}),p.addEventListener("pointerdown",Oe),p.addEventListener("pointermove",Ye),p.addEventListener("pointerup",we),p.addEventListener("pointercancel",we),p.addEventListener("pointerleave",Ne),p.addEventListener("click",Ve);let Ze=0;function bt(){const e=s();m.setClearColor(new Ae(e.background),1),e.snap&&ie&&!l.active&&Math.abs(E-x)<e.snapDistance&&performance.now()-ve>e.snapDelay&&(E=j(c(E)),ie=!1),x+=(E-x)*e.glide;const t=A(x);t!==Ie&&(Ie=t,N(t));const n=x-ke;ke=x;const r=Math.min(1,Math.abs(n)/Math.max(1,e.speedShrink)),g=r>ge?.25:.06;if(ge+=(r-ge)*g,Te(),ee&&!l.active&&Math.abs(E-x)<.5){const i=ee;ee=null,q&&q.sourceIndex===i.sourceIndex&&$e()}w.uCenter.value.set(e.lensX,e.lensY),w.uSizeX.value=e.lensWidth,w.uSizeY.value=e.lensHeight,w.uShape.value=e.lensShape==="square"?1:0,w.uRotation.value=e.lensRotation*Math.PI/180,w.uAspect.value=f/h,w.uTime.value=performance.now()*.001,w.uBlur.value=e.blur,w.uGlow.value=e.glow,w.uShimmer.value=e.shimmer?1:0,w.uBlueColor.value.set(e.blueColor);const o=l.lensFx;w.uDispersion.value=e.dispersion*o,w.uBlueRing.value=e.blueRing*o,w.uRimLine.value=1.4*o,w.uZoom.value=e.zoom*o,w.uRimTangential.value=e.rimWave*o,m.setRenderTarget(xe),m.render(re,F),m.setRenderTarget(null),m.render(ze,xt)}function Ke(){bt(),Ze=requestAnimationFrame(Ke)}Ke(),St();function Rt(){f=Math.max(1,d.clientWidth),h=Math.max(1,d.clientHeight),m.setSize(f,h),F.left=-f/2,F.right=f/2,F.top=h/2,F.bottom=-h/2,F.updateProjectionMatrix(),xe.setSize(f*C,h*C),w.uRes.value.set(f*C,h*C),$()}const Qe=new ResizeObserver(Rt);Qe.observe(d);function yt(){var e;try{cancelAnimationFrame(Ze),Qe.disconnect(),p.removeEventListener("wheel",_e),p.removeEventListener("pointerdown",Oe),p.removeEventListener("pointermove",Ye),p.removeEventListener("pointerup",we),p.removeEventListener("pointercancel",we),p.removeEventListener("pointerleave",Ne),p.removeEventListener("click",Ve),(e=l.animation)==null||e.kill(),K==null||K.kill(),S&&Y.killTweensOf(S),m.dispose(),xe.dispose(),Fe.geometry.dispose(),We.dispose(),D.forEach(t=>{t.mesh.geometry.dispose(),t.material.dispose()}),a.forEach(t=>{var n;return(n=t.texture)==null?void 0:n.dispose()}),m.domElement.remove()}catch(t){console.error("LiquidGlassCarousel cleanup failed",t)}}return{closeFocus:wt,destroy:yt}}function qt(d){const{projects:T,background:P,foreground:M,showLabels:S,showCursor:N,font:z,style:Q}=d,s=k.useRef(null),he=k.useRef(null),f=k.useRef(null),h=k.useRef(d);h.current=d;const m=Pt(),[C,oe]=k.useState(0),[W,re]=k.useState(!1),[F,ae]=k.useState(!d.entryAnimation),[J,a]=k.useState(()=>typeof window>"u"||!window.matchMedia?!0:window.matchMedia("(hover: hover) and (pointer: fine)").matches),V=k.useMemo(()=>T.map(c=>{var A;return`${((A=c.image)==null?void 0:A.src)||""}|${c.brand}|${c.description}`}).join("::"),[T]);k.useEffect(()=>{var H;if(typeof window>"u"||!window.matchMedia)return;const c=window.matchMedia("(hover: hover) and (pointer: fine)"),A=()=>a(c.matches);return A(),(H=c.addEventListener)==null||H.call(c,"change",A),()=>{var D;return(D=c.removeEventListener)==null?void 0:D.call(c,"change",A)}},[]);const[X,b]=k.useState(null),$=N&&J;k.useEffect(()=>{if(s.current){b(null);try{f.current=jt(s.current,{projects:T,propsRef:h,cursorElement:$?he.current:null,staticMode:m,onActiveChange:oe,onFocusChange:re,onEntryDone:ae})}catch(c){console.error("LiquidGlassCarousel failed to initialize",c),f.current=null,re(!1),ae(!0),b("The carousel could not initialize its graphics engine.")}return()=>{var c;try{(c=f.current)==null||c.destroy()}catch(A){console.error("LiquidGlassCarousel destroy failed",A)}f.current=null}}},[V,$,m,d.panelHeight,d.gap,d.entryAnimation,d.pixelRatio]);const j=T[C]||{brand:`Project ${C+1}`,description:"Add your project image and copy"};return X?G.jsx("div",{role:"status",style:{...Q,width:"100%",height:"100%",display:"flex",alignItems:"center",justifyContent:"center",padding:32,boxSizing:"border-box",textAlign:"center",color:M,background:P,...z},children:X}):G.jsxs("div",{style:{...Q,position:"relative",width:"100%",height:"100%",overflow:"hidden",background:P,color:M,touchAction:"none",...z},children:[G.jsx("div",{ref:s,style:{position:"absolute",inset:0,touchAction:"none"}}),S&&G.jsxs("div",{style:{position:"absolute",top:"10%",left:"50%",width:"min(92vw, 520px)",transform:`translate(-50%, ${W?"-4vh":"0"})`,opacity:F?1:0,transition:"opacity .5s, transform .4s",textAlign:"center",pointerEvents:"none",mixBlendMode:"exclusion",color:"white",whiteSpace:"normal",wordBreak:"break-word",padding:"0 12px",boxSizing:"border-box"},children:[G.jsx("div",{children:De(j.brand)}),G.jsx("div",{children:De(j.description)})]}),S&&G.jsxs("div",{style:{position:"absolute",bottom:"10%",left:"50%",transform:"translateX(-50%)",opacity:F&&!W?1:0,transition:"opacity .4s",pointerEvents:"none"},children:[String(C+1).padStart(2,"0"),"/",String(Math.max(T.length,3)).padStart(2,"0")]}),$&&G.jsx("div",{ref:he,style:{position:"absolute",top:0,left:0,zIndex:4,pointerEvents:"none",whiteSpace:"nowrap",mixBlendMode:"exclusion",color:"white",willChange:"transform"},children:"View"}),G.jsx("button",{type:"button","aria-label":"Close focused project",onClick:()=>{var c;return(c=f.current)==null?void 0:c.closeFocus()},style:{position:"absolute",top:"2vh",right:"4vw",zIndex:5,padding:0,border:0,background:"transparent",color:"white",cursor:"pointer",opacity:W?1:0,pointerEvents:W?"auto":"none",mixBlendMode:"exclusion",transition:"opacity .3s",...z},children:"Close"})]})}qt.defaultProps={projects:[{brand:"Project One",description:"Digital experience"},{brand:"Project Two",description:"Interactive campaign"},{brand:"Project Three",description:"Brand platform"},{brand:"Project Four",description:"Product launch"},{brand:"Project Five",description:"Editorial story"}],panelHeight:450,gap:12,glide:.075,wheelSensitivity:1,snap:!0,snapDistance:60,snapDelay:120,speedShrink:60,lensShape:"circle",lensRotation:65,lensWidth:.565,lensHeight:1,lensX:.5,lensY:.5,dispersion:11,zoom:0,blur:0,glow:4.2,blueRing:6,blueColor:"#009dff",shimmer:!0,rimWave:.6,entryAnimation:!0,focusScale:1.18,background:"#ffffff",foreground:"#000000",showLabels:!0,showCursor:!0,font:{fontFamily:"Inter, sans-serif",fontSize:16,fontWeight:400,lineHeight:"1.25em"},pixelRatio:2};const Ot={exports:{default:{type:"reactComponent",name:"LiquidGlassCarousel",slots:[],annotations:{framerContractVersion:"1"}},__FramerMetadata__:{type:"variable"}}};export{Ot as __FramerMetadata__,qt as default};
