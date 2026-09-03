import{jsx as _jsx,jsxs as _jsxs}from"react/jsx-runtime";import{useMemo,useRef,useEffect,useState}from"react";import{addPropertyControls,ControlType,useIsStaticRenderer}from"framer";/**
 * ============================================================
 * GRADIENT MOTION BACKGROUND
 * ------------------------------------------------------------
 * Generates soft, blurred, animated gradient "blob" backgrounds
 * (aurora / mesh-gradient style). Shapes are absolutely positioned
 * blurred divs (radial gradients) that drift, pulse, rotate,
 * wave, or orbit around the frame using CSS transforms driven by
 * requestAnimationFrame — no external animation libraries.
 *
 * STATIC RENDERING:
 * On the Framer canvas and during image/PDF export, React runs
 * in a "static" context — there's no user interaction and no
 * screen refresh loop watching it. Continuous rAF loops there
 * just burn CPU in the editor and can capture a mid-transition
 * frame during export, causing visual artifacts. We detect this
 * with useIsStaticRenderer() and fall back to a single frozen
 * frame (tick = 0, no rAF loop, no animated grain) whenever it's
 * true — only Preview and the published site actually animate.
 * ============================================================
 */// ------------------------------------------------------------
// Deterministic seeded PRNG (mulberry32) so "Seed" always
// reproduces the same starting composition.
// ------------------------------------------------------------
function mulberry32(seed){let a=seed;return function(){a|=0;a=a+1831565813|0;let t=Math.imul(a^a>>>15,1|a);t=t+Math.imul(t^t>>>7,61|t)^t;return((t^t>>>14)>>>0)/4294967296;};}// ------------------------------------------------------------
// Builds a tileable film-grain noise texture as an SVG data URI
// using feTurbulence. Generated once per size/seed and reused —
// cheap to render, no canvas or per-frame pixel work required.
// ------------------------------------------------------------
function buildGrainDataUri(tileSize,grainSeed){const freq=.9// fixed fractal frequency; tileSize controls apparent grain scale
;const svg=`<svg xmlns='http://www.w3.org/2000/svg' width='${tileSize}' height='${tileSize}'>
        <filter id='n'>
            <feTurbulence type='fractalNoise' baseFrequency='${freq}' numOctaves='2' seed='${grainSeed}' stitchTiles='stitch' result='noise'/>
            <feColorMatrix in='noise' type='matrix' values='0 0 0 0 1  0 0 0 0 1  0 0 0 0 1  0 0 0 1 0'/>
        </filter>
        <rect width='100%' height='100%' filter='url(#n)'/>
    </svg>`;return`url("data:image/svg+xml;utf8,${encodeURIComponent(svg)}")`;}// ------------------------------------------------------------
// Easing helpers for the animation loop
// ------------------------------------------------------------
function ease(t,type){if(type==="linear")return t;if(type==="sine")return(Math.sin((t-.25)*Math.PI*2)+1)/2;// ease-in-out (smoothstep-ish, looping)
const p=(Math.sin((t-.25)*Math.PI*2)+1)/2;return p*p*(3-2*p);}export default function GradientMotionBackground(props){const{// Colors
colorStops,baseBackground,blendMode,opacity,contrast,// Shape
shapeStyle,blobCount,blurAmount,sizeMin,sizeMax,sizeRandomness,// Motion
animate,speed,motionStyle,motionRange,direction,randomDirection,easeType,seed,// Randomness
positionJitter,sizeVariation,randomColorPerShape,// Grain
grainEnabled,grainAmount,grainSize,grainBlendMode,grainAnimate}=props;// --------------------------------------------------------
// Static renderer detection (Framer canvas + export).
// Everything below that drives continuous motion must be
// gated behind `!isStatic`, not just the raw `animate` prop.
// --------------------------------------------------------
const isStatic=useIsStaticRenderer();const effectiveAnimate=animate&&!isStatic;const effectiveGrainAnimate=grainAnimate&&!isStatic;const containerRef=useRef(null);const[tick,setTick]=useState(0);const startTimeRef=useRef(null);const rafRef=useRef(null);// --------------------------------------------------------
// Build the blob composition deterministically from seed.
// Regenerates only when seed / count / colors / size / jitter change.
// --------------------------------------------------------
const blobs=useMemo(()=>{const rand=mulberry32(Math.floor(seed*1e5)+1);const colors=colorStops&&colorStops.length>0?colorStops:["#22c55e"];const count=Math.max(1,Math.min(10,blobCount));const list=[];for(let i=0;i<count;i++){const baseX=(i+.5)/count*100;const baseY=30+rand()*40;const jitterX=(rand()-.5)*2*positionJitter;const jitterY=(rand()-.5)*2*positionJitter;const sizeBase=sizeMin+rand()*(sizeMax-sizeMin);const sizeJitter=sizeRandomness?sizeBase*(1+(rand()-.5)*2*(sizeVariation/100)):sizeBase;const color=randomColorPerShape?colors[Math.floor(rand()*colors.length)]:colors[i%colors.length];const dirAngle=randomDirection?rand()*Math.PI*2:direction/180*Math.PI;list.push({id:i,xPct:Math.min(100,Math.max(0,baseX+jitterX)),yPct:Math.min(100,Math.max(0,baseY+jitterY)),sizePct:Math.max(10,sizeJitter),color,rotation:rand()*360,phase:rand(),dirX:Math.cos(dirAngle),dirY:Math.sin(dirAngle)});}return list;},[seed,blobCount,JSON.stringify(colorStops),sizeMin,sizeMax,sizeRandomness,sizeVariation,positionJitter,randomDirection,direction,randomColorPerShape]);// --------------------------------------------------------
// Grain texture — regenerated only when size/seed change.
// For animated grain we cycle through a handful of pre-seeded
// tiles rather than rebuilding SVG every frame (keeps it cheap).
// In a static context we only ever build/use a single frame.
// --------------------------------------------------------
const grainFrameCount=6;const grainTextures=useMemo(()=>{if(!grainEnabled)return[];const count=effectiveGrainAnimate?grainFrameCount:1;const arr=[];for(let i=0;i<count;i++){arr.push(buildGrainDataUri(grainSize,seed*13+i*97+1));}return arr;},[grainEnabled,grainSize,effectiveGrainAnimate,seed]);const grainFrameIndex=effectiveGrainAnimate&&grainTextures.length>1?Math.floor(tick*12)%grainTextures.length:0;// --------------------------------------------------------
// Animation loop (rAF). Uses CSS transforms only — never
// touches layout properties — to stay performant.
// Never runs when isStatic is true: canvas/export gets one
// frozen frame (tick stays 0) instead of a live rAF loop.
// --------------------------------------------------------
useEffect(()=>{if(!effectiveAnimate){setTick(0);return;}let mounted=true;const loop=t=>{if(!mounted)return;if(startTimeRef.current===null)startTimeRef.current=t;const elapsed=(t-startTimeRef.current)/1e3;setTick(elapsed*(speed/100));rafRef.current=requestAnimationFrame(loop);};rafRef.current=requestAnimationFrame(loop);return()=>{mounted=false;if(rafRef.current)cancelAnimationFrame(rafRef.current);startTimeRef.current=null;};},[effectiveAnimate,speed]);// --------------------------------------------------------
// Per-blob transform for the current motion style/time.
// --------------------------------------------------------
function getTransform(b){if(!effectiveAnimate)return"translate(-50%, -50%)";const loopT=(tick+b.phase*6)%6/6// 6s base loop, phase-offset
;const e=ease(loopT,easeType);const swing=Math.sin(e*Math.PI*2);const range=motionRange;let tx=0;let ty=0;let rot=0;let scale=1;switch(motionStyle){case"Drift":tx=b.dirX*range*swing;ty=b.dirY*range*swing;break;case"Pulse":scale=1+range/100*(.5+.5*swing)*.5;break;case"Rotate":rot=e*360;break;case"Wave Flow":tx=Math.sin(e*Math.PI*2+b.id)*range;ty=Math.cos(e*Math.PI*4+b.id)*(range/2);break;case"Orbit":tx=Math.cos(e*Math.PI*2)*range;ty=Math.sin(e*Math.PI*2)*range;break;}return`translate(-50%, -50%) translate(${tx}px, ${ty}px) rotate(${rot}deg) scale(${scale})`;}const shapeBorderRadius={Blob:"50% 45% 55% 50% / 50% 55% 45% 50%","Radial Glow":"50%",Wave:"60% 40% 30% 70% / 60% 30% 70% 40%",Mesh:"40%","Diagonal Streak":"10% 90% 10% 90% / 90% 10% 90% 10%"};return /*#__PURE__*/_jsxs("div",{ref:containerRef,style:{position:"relative",width:"100%",height:"100%",overflow:"hidden",background:baseBackground,filter:`contrast(${contrast}%)`},children:[/*#__PURE__*/_jsx("div",{style:{position:"absolute",inset:0,opacity:opacity/100},children:blobs.map(b=>{const isStreak=shapeStyle==="Diagonal Streak";return /*#__PURE__*/_jsx("div",{style:{position:"absolute",left:`${b.xPct}%`,top:`${b.yPct}%`,width:isStreak?`${b.sizePct*2.2}%`:`${b.sizePct}%`,height:isStreak?`${b.sizePct*.6}%`:`${b.sizePct}%`,background:shapeStyle==="Radial Glow"?`radial-gradient(circle, ${b.color} 0%, transparent 70%)`:b.color,borderRadius:shapeBorderRadius[shapeStyle]||"50%",filter:`blur(${blurAmount}px)`,mixBlendMode:blendMode,transform:`${getTransform(b)} rotate(${b.rotation}deg)`,transition:effectiveAnimate?"none":"transform 0.3s ease",willChange:"transform"}},b.id);})}),grainEnabled&&grainTextures.length>0&&/*#__PURE__*/_jsx("div",{style:{position:"absolute",inset:0,backgroundImage:grainTextures[grainFrameIndex],backgroundRepeat:"repeat",backgroundSize:`${grainSize}px ${grainSize}px`,opacity:grainAmount/100,mixBlendMode:grainBlendMode,pointerEvents:"none"}})]});}// ------------------------------------------------------------
// Defaults: dark near-black base, 3 vivid green blobs, heavy
// blur, screen blend, slow drift — resembles a neon aurora glow.
// ------------------------------------------------------------
GradientMotionBackground.defaultProps={colorStops:["#22c55e","#16a34a","#4ade80"],baseBackground:"#050805",blendMode:"screen",opacity:100,contrast:110,shapeStyle:"Blob",blobCount:3,blurAmount:120,sizeMin:60,sizeMax:90,sizeRandomness:true,animate:true,speed:40,motionStyle:"Drift",motionRange:60,direction:45,randomDirection:true,easeType:"ease-in-out",seed:7,positionJitter:15,sizeVariation:25,randomColorPerShape:false,grainEnabled:false,grainAmount:15,grainSize:120,grainBlendMode:"overlay",grainAnimate:false};addPropertyControls(GradientMotionBackground,{// --- Colors ---
colorStops:{type:ControlType.Array,title:"Colors",control:{type:ControlType.Color},defaultValue:["#22c55e","#16a34a","#4ade80"],maxCount:5},baseBackground:{type:ControlType.Color,title:"Background",defaultValue:"#050805"},blendMode:{type:ControlType.Enum,title:"Blend Mode",options:["normal","screen","lighten","overlay","soft-light","difference"],optionTitles:["Normal","Screen","Lighten","Overlay","Soft Light","Difference"],defaultValue:"screen"},opacity:{type:ControlType.Number,title:"Opacity",min:0,max:100,step:1,unit:"%",defaultValue:100},contrast:{type:ControlType.Number,title:"Contrast / Glow",min:50,max:200,step:1,unit:"%",defaultValue:110},// --- Shape ---
shapeStyle:{type:ControlType.Enum,title:"Shape Style",options:["Blob","Radial Glow","Wave","Mesh","Diagonal Streak"],defaultValue:"Blob"},blobCount:{type:ControlType.Number,title:"Shape Count",min:1,max:10,step:1,defaultValue:3},blurAmount:{type:ControlType.Number,title:"Blur",min:0,max:250,step:1,unit:"px",defaultValue:120},sizeMin:{type:ControlType.Number,title:"Size Min",min:5,max:150,step:1,unit:"%",defaultValue:60},sizeMax:{type:ControlType.Number,title:"Size Max",min:5,max:200,step:1,unit:"%",defaultValue:90},sizeRandomness:{type:ControlType.Boolean,title:"Size Random",defaultValue:true},// --- Motion ---
animate:{type:ControlType.Boolean,title:"Animate",defaultValue:true},speed:{type:ControlType.Number,title:"Speed",min:1,max:200,step:1,defaultValue:40,hidden:props=>!props.animate},motionStyle:{type:ControlType.Enum,title:"Motion Style",options:["Drift","Pulse","Rotate","Wave Flow","Orbit"],defaultValue:"Drift",hidden:props=>!props.animate},motionRange:{type:ControlType.Number,title:"Motion Range",min:0,max:300,step:1,unit:"px",defaultValue:60,hidden:props=>!props.animate},direction:{type:ControlType.Number,title:"Direction",min:0,max:360,step:1,unit:"\xb0",defaultValue:45,hidden:props=>!props.animate||props.randomDirection},randomDirection:{type:ControlType.Boolean,title:"Random Direction",defaultValue:true,hidden:props=>!props.animate},easeType:{type:ControlType.Enum,title:"Ease",options:["linear","ease-in-out","sine"],optionTitles:["Linear","Ease In-Out","Sine"],defaultValue:"ease-in-out",hidden:props=>!props.animate},seed:{type:ControlType.Number,title:"Seed",min:0,max:999,step:1,defaultValue:7},// --- Randomness ---
positionJitter:{type:ControlType.Number,title:"Position Jitter",min:0,max:50,step:1,unit:"%",defaultValue:15},sizeVariation:{type:ControlType.Number,title:"Size Variation",min:0,max:100,step:1,unit:"%",defaultValue:25,hidden:props=>!props.sizeRandomness},randomColorPerShape:{type:ControlType.Boolean,title:"Random Color Per Shape",defaultValue:false},// --- Grain ---
grainEnabled:{type:ControlType.Boolean,title:"Grain",defaultValue:false},grainAmount:{type:ControlType.Number,title:"Grain Amount",min:0,max:100,step:1,unit:"%",defaultValue:15,hidden:props=>!props.grainEnabled},grainSize:{type:ControlType.Number,title:"Grain Size",min:30,max:400,step:1,unit:"px",defaultValue:120,hidden:props=>!props.grainEnabled},grainBlendMode:{type:ControlType.Enum,title:"Grain Blend",options:["overlay","soft-light","screen","multiply","normal"],optionTitles:["Overlay","Soft Light","Screen","Multiply","Normal"],defaultValue:"overlay",hidden:props=>!props.grainEnabled},grainAnimate:{type:ControlType.Boolean,title:"Animate Grain",defaultValue:false,hidden:props=>!props.grainEnabled}});
export const __FramerMetadata__ = {"exports":{"default":{"type":"reactComponent","name":"GradientMotionBackground","slots":[],"annotations":{"framerContractVersion":"1"}},"__FramerMetadata__":{"type":"variable"}}}
//# sourceMappingURL=./GradientMotionBackground.map