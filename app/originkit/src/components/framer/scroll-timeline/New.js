import{jsx as _jsx,jsxs as _jsxs}from"react/jsx-runtime";import{useEffect,useRef}from"react";import{addPropertyControls,ControlType,useIsStaticRenderer}from"framer";import{useMotionValue,useMotionValueEvent,animate}from"framer-motion";export default function ScrollTimeline(props){const{items,labelFont,labelOpacity,descFont,yearFont,frameBackground,cornerRadius,frameInset,panelPadding,headerMaxWidth,totalScrollHeight,scrollTransition}=props;const wrapRef=useRef(null);const isStatic=useIsStaticRenderer();// Motion value that gets animated toward the raw scroll progress
// using the user's chosen scrollTransition. With the default
// { type: "tween", duration: 0 } it lands instantly, i.e. the
// exact same 1:1 scroll-linked behavior as before.
const progress=useMotionValue(0);useEffect(()=>{if(isStatic)return;const wrap=wrapRef.current;if(!wrap)return;const panels=Array.from(wrap.querySelectorAll(".panel"));const n=panels.length;function applyAt(raw){const scaled=Math.min(n-1,Math.max(0,raw));const idx=Math.min(n-2,Math.floor(scaled));const t=scaled-idx;panels.forEach((panel,i)=>{const year=panel.querySelector(".year");if(!year)return;if(i<idx){panel.style.clipPath="inset(0 0 0 100%)";year.style.transform="rotate(-90deg)";}else if(i===idx){const visible=1-t;panel.style.clipPath=`inset(0 ${(1-visible)*100}% 0 0)`;year.style.transform=`rotate(${-90*t}deg)`;}else if(i===idx+1){const visible=t;panel.style.clipPath=`inset(0 0 0 ${(1-visible)*100}%)`;year.style.transform="rotate(0deg)";}else{panel.style.clipPath="inset(0 0 0 100%)";year.style.transform="rotate(0deg)";}panel.style.zIndex=String(i);});}function update(){const rect=wrap.getBoundingClientRect();const total=wrap.offsetHeight-window.innerHeight;let raw=total>0?-rect.top/total:0;raw=Math.min(1,Math.max(0,raw));const scaled=raw*(n-1);animate(progress,scaled,scrollTransition);}window.addEventListener("scroll",update,{passive:true});window.addEventListener("resize",update);applyAt(0);update();const unsubscribe=progress.on?progress.on("change",applyAt):undefined;return()=>{window.removeEventListener("scroll",update);window.removeEventListener("resize",update);if(unsubscribe)unsubscribe();};// eslint-disable-next-line react-hooks/exhaustive-deps
},[isStatic,scrollTransition]);// Fallback subscription hook (kept separate so it works even if
// progress.on above isn't available in a given runtime).
useMotionValueEvent(progress,"change",v=>{if(isStatic)return;const wrap=wrapRef.current;if(!wrap)return;const panels=Array.from(wrap.querySelectorAll(".panel"));const n=panels.length;if(!n)return;const scaled=Math.min(n-1,Math.max(0,v));const idx=Math.min(n-2,Math.floor(scaled));const t=scaled-idx;panels.forEach((panel,i)=>{const year=panel.querySelector(".year");if(!year)return;if(i<idx){panel.style.clipPath="inset(0 0 0 100%)";year.style.transform="rotate(-90deg)";}else if(i===idx){const visible=1-t;panel.style.clipPath=`inset(0 ${(1-visible)*100}% 0 0)`;year.style.transform=`rotate(${-90*t}deg)`;}else if(i===idx+1){const visible=t;panel.style.clipPath=`inset(0 0 0 ${(1-visible)*100}%)`;year.style.transform="rotate(0deg)";}else{panel.style.clipPath="inset(0 0 0 100%)";year.style.transform="rotate(0deg)";}panel.style.zIndex=String(i);});});const sections=items;const sharedStyle=`
        .frame{
            position: sticky;
            top: ${frameInset}px;
            height: calc(100vh - ${frameInset*2}px);
            margin: 0 ${frameInset}px;
            border-radius: ${cornerRadius}px;
            overflow: hidden;
            background:${frameBackground};
        }
        .panel{
            position:absolute;
            inset:0;
            clip-path: inset(0 0 0 100%);
        }
        .panel-inner{
            position:relative;
            height:100%;
            padding: ${panelPadding};
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            box-sizing:border-box;
        }
        .panel-header{
            align-self:flex-end;
            max-width: ${headerMaxWidth}px;
            text-align:left;
        }
        .eyebrow{
            display:block;
            text-transform:uppercase;
            opacity:${labelOpacity};
            margin-bottom:10px;
        }
        .desc{
            margin:0;
        }
        .year{
            margin:0;
            transform-origin: left bottom;
            will-change: transform;
        }
    `;// Static (canvas/export) fallback: no listeners, no animation,
// just the first panel shown as a plain styled element.
if(isStatic){const first=sections[0];return /*#__PURE__*/_jsxs("div",{ref:wrapRef,className:"timeline",style:{height:totalScrollHeight},children:[/*#__PURE__*/_jsx("style",{children:sharedStyle}),/*#__PURE__*/_jsx("div",{className:"frame",children:/*#__PURE__*/_jsx("section",{className:"panel",style:{background:first?.bg,color:first?.fg,clipPath:"inset(0 0 0 0)"},children:/*#__PURE__*/_jsxs("div",{className:"panel-inner",children:[/*#__PURE__*/_jsxs("div",{className:"panel-header",children:[/*#__PURE__*/_jsx("span",{className:"eyebrow",style:labelFont,children:first?.eyebrow}),/*#__PURE__*/_jsx("p",{className:"desc",style:descFont,children:first?.desc})]}),/*#__PURE__*/_jsx("h2",{className:"year",style:yearFont,children:first?.year})]})})})]});}return /*#__PURE__*/_jsxs("div",{ref:wrapRef,className:"timeline",style:{height:totalScrollHeight},children:[/*#__PURE__*/_jsx("style",{children:sharedStyle}),/*#__PURE__*/_jsx("div",{className:"frame",children:sections.map((s,i)=>/*#__PURE__*/_jsx("section",{className:"panel",style:{background:s.bg,color:s.fg},children:/*#__PURE__*/_jsxs("div",{className:"panel-inner",children:[/*#__PURE__*/_jsxs("div",{className:"panel-header",children:[/*#__PURE__*/_jsx("span",{className:"eyebrow",style:labelFont,children:s.eyebrow}),/*#__PURE__*/_jsx("p",{className:"desc",style:descFont,children:s.desc})]}),/*#__PURE__*/_jsx("h2",{className:"year",style:yearFont,children:s.year})]})},i))})]});}ScrollTimeline.defaultProps={items:[{bg:"#151515",fg:"#f2f2f2",eyebrow:"01/ Origins of the web",desc:"A network of static, text-first pages connected by hyperlinks. No design system existed yet — just documents, linked together.",year:"1991"},{bg:"#ff4433",fg:"#151515",eyebrow:"02/ First graphical browser",desc:"The release of Mosaic, the first widely-used graphical web browser, made the internet accessible to non-technical users. Websites became visual and interactive.",year:"1993"},{bg:"#aeeaf6",fg:"#151515",eyebrow:"03/ Social media rise",desc:"The rise of social media platforms redefined online interaction and content sharing. The internet evolved into a social space, connecting people worldwide.",year:"2004"},{bg:"#0b0b0b",fg:"#beeaf6",eyebrow:"04/ Smartphones & mobile web",desc:"The launch of smartphones revolutionized how people access the internet, putting powerful web browsing and apps in everyone's pocket.",year:"2007"},{bg:"#7c5cff",fg:"#101014",eyebrow:"05/ AI-powered web",desc:"Generative interfaces and AI copilots began shaping how pages are built and browsed, turning static sites into responsive, conversational experiences.",year:"2023"}],labelFont:{fontFamily:"JetBrains Mono",fontWeight:400,fontSize:12,letterSpacing:"0.14em",lineHeight:"1.2em"},labelOpacity:.65,descFont:{fontFamily:"Inter",fontWeight:500,fontSize:16,lineHeight:"1.55em"},yearFont:{fontFamily:"Archivo Black",fontWeight:900,fontSize:216,lineHeight:"0.78em"},frameBackground:"#000000",cornerRadius:28,frameInset:24,panelPadding:"48px 48px 48px 48px",headerMaxWidth:420,totalScrollHeight:"500vh",scrollTransition:{type:"tween",ease:"linear",duration:0}};addPropertyControls(ScrollTimeline,{items:{type:ControlType.Array,title:"Items",control:{type:ControlType.Object,controls:{eyebrow:{type:ControlType.String,title:"Label",defaultValue:"01/ Section label"},desc:{type:ControlType.String,title:"Description",defaultValue:"Description text goes here.",displayTextArea:true},year:{type:ControlType.String,title:"Big Text",defaultValue:"2024"},bg:{type:ControlType.Color,title:"Background",defaultValue:"#151515"},fg:{type:ControlType.Color,title:"Text Color",defaultValue:"#f2f2f2"}}},minCount:2},// ---- Label (eyebrow) ----
labelFont:{type:ControlType.Font,title:"Label Font",controls:"extended"},labelOpacity:{type:ControlType.Number,title:"Label Opacity",min:0,max:1,step:.05},// ---- Description ----
descFont:{type:ControlType.Font,title:"Desc Font",controls:"extended"},// ---- Big text (year) ----
yearFont:{type:ControlType.Font,title:"Big Text Font",controls:"extended"},// ---- Frame ----
frameBackground:{type:ControlType.Color,title:"Frame Background"},cornerRadius:{type:ControlType.Number,title:"Corner Radius",min:0,max:100,step:1,unit:"px"},frameInset:{type:ControlType.Number,title:"Frame Inset",min:0,max:100,step:1,unit:"px",description:"Matches the original top/side inset (24px default)."},// ---- Panel padding & layout ----
panelPadding:{type:ControlType.Padding,title:"Panel Padding"},headerMaxWidth:{type:ControlType.Number,title:"Header Max Width",min:100,max:900,step:10,unit:"px"},// ---- Scroll length & feel ----
totalScrollHeight:{type:ControlType.String,title:"Total Scroll Height",description:"Matches original hardcoded '500vh'. Should roughly equal (item count \xd7 100vh) for even pacing."},scrollTransition:{type:ControlType.Transition,title:"Scroll Transition",description:"Default (duration: 0) matches the original instant, 1:1 scroll-linked reveal. Increase duration or change easing to add lag/smoothing to the scrub."}});
export const __FramerMetadata__ = {"exports":{"default":{"type":"reactComponent","name":"ScrollTimeline","slots":[],"annotations":{"framerContractVersion":"1"}},"__FramerMetadata__":{"type":"variable"}}}
//# sourceMappingURL=./New.map