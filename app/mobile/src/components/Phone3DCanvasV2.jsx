import React, { useRef, useState, useEffect } from 'react';
import { Canvas, useFrame } from '@react-three/fiber';
import { Float, RoundedBox, Html, ContactShadows } from '@react-three/drei';
import * as THREE from 'three';
import { 
  Smartphone, Shield, Zap, TrendingUp, CreditCard, HeartPulse, 
  ShoppingBag, Sparkles, CheckCircle2, Layers, Cpu, Radio, Eye, Play, Pause, ArrowUpRight, Search, Menu
} from 'lucide-react';
import { playClickSound } from './AudioEngine';

/**
 * Photorealistic Smartphone Model with Auto-Scrolling Live Website Inside Screen
 */
function UltraRealisticPhone({ finishColor, activeScreen, exploded, isAutoScrolling, toggleAutoScroll, onScreenClick }) {
  const phoneGroup = useRef();
  const screenRef = useRef();
  const chipGroup = useRef();

  useFrame((state) => {
    if (!phoneGroup.current) return;
    const t = state.clock.getElapsedTime();
    const mouseX = state.pointer.x;
    const mouseY = state.pointer.y;

    // Smooth lerp rotation toward mouse for realistic 3D depth
    phoneGroup.current.rotation.y = THREE.MathUtils.lerp(phoneGroup.current.rotation.y, mouseX * 0.45, 0.08);
    phoneGroup.current.rotation.x = THREE.MathUtils.lerp(phoneGroup.current.rotation.x, -mouseY * 0.35, 0.08);
    
    // Gentle floating bob
    phoneGroup.current.position.y = Math.sin(t * 1.5) * 0.12;

    if (chipGroup.current) {
      chipGroup.current.rotation.z = t * 0.4;
    }
  });

  const finishes = {
    cyan: { color: '#00e5ff', metalness: 0.92, roughness: 0.1, emissive: '#0099ff', text: 'Titanium Sky Cyan' },
    emerald: { color: '#10b981', metalness: 0.92, roughness: 0.1, emissive: '#059669', text: 'Titanium Emerald' },
    violet: { color: '#a855f7', metalness: 0.92, roughness: 0.1, emissive: '#7c3aed', text: 'Deep Violet' },
    gold: { color: '#f59e0b', metalness: 0.92, roughness: 0.1, emissive: '#d97706', text: 'Titanium Gold' },
    titanium: { color: '#334155', metalness: 0.95, roughness: 0.08, emissive: '#0f172a', text: 'Space Gray Titanium' }
  };

  const mat = finishes[finishColor] || finishes.cyan;
  const expZ = exploded ? 0.6 : 0;

  return (
    <group ref={phoneGroup} scale={[1.18, 1.18, 1.18]} position={[0, 0, 0]}>
      
      {/* LAYER 1: Rear Glass Cover & Camera Module */}
      <group position={[0, 0, -expZ * 1.4]}>
        <RoundedBox args={[2.58, 5.25, 0.12]} radius={0.32} smoothness={10}>
          <meshStandardMaterial
            color={mat.color}
            metalness={mat.metalness}
            roughness={mat.roughness}
            emissive={mat.emissive}
            emissiveIntensity={0.2}
          />
        </RoundedBox>

        {/* Photorealistic Triple Camera Lens Island */}
        <group position={[0.62, 1.8, -0.09]}>
          <RoundedBox args={[0.95, 1.05, 0.1]} radius={0.2} smoothness={6}>
            <meshStandardMaterial color="#0b1329" roughness={0.1} metalness={0.95} />
          </RoundedBox>

          {/* Camera Lens 1 */}
          <group position={[-0.22, 0.26, -0.06]}>
            <mesh rotation={[Math.PI / 2, 0, 0]}>
              <cylinderGeometry args={[0.16, 0.16, 0.05, 32]} />
              <meshStandardMaterial color="#02040a" roughness={0.05} metalness={0.98} />
            </mesh>
            <mesh position={[0, 0, -0.03]} rotation={[Math.PI / 2, 0, 0]}>
              <cylinderGeometry args={[0.11, 0.11, 0.02, 32]} />
              <meshStandardMaterial color="#00e5ff" emissive="#00e5ff" emissiveIntensity={0.6} />
            </mesh>
          </group>

          {/* Camera Lens 2 */}
          <group position={[-0.22, -0.26, -0.06]}>
            <mesh rotation={[Math.PI / 2, 0, 0]}>
              <cylinderGeometry args={[0.16, 0.16, 0.05, 32]} />
              <meshStandardMaterial color="#02040a" roughness={0.05} metalness={0.98} />
            </mesh>
            <mesh position={[0, 0, -0.03]} rotation={[Math.PI / 2, 0, 0]}>
              <cylinderGeometry args={[0.11, 0.11, 0.02, 32]} />
              <meshStandardMaterial color="#3b82f6" emissive="#3b82f6" emissiveIntensity={0.6} />
            </mesh>
          </group>

          {/* Camera Lens 3 & Flash */}
          <group position={[0.22, 0, -0.06]}>
            <mesh rotation={[Math.PI / 2, 0, 0]}>
              <cylinderGeometry args={[0.13, 0.13, 0.05, 32]} />
              <meshStandardMaterial color="#02040a" roughness={0.05} metalness={0.98} />
            </mesh>
          </group>
        </group>
      </group>

      {/* LAYER 2: Motherboard (Visible in Explode View) */}
      {exploded && (
        <group position={[0, 0, 0]}>
          <RoundedBox args={[2.4, 4.9, 0.08]} radius={0.2}>
            <meshStandardMaterial color="#041226" roughness={0.3} metalness={0.7} />
          </RoundedBox>
          <mesh ref={chipGroup} position={[0, 0.6, 0.05]}>
            <boxGeometry args={[0.75, 0.75, 0.06]} />
            <meshStandardMaterial color="#00e5ff" emissive="#00e5ff" emissiveIntensity={0.9} />
          </mesh>
        </group>
      )}

      {/* LAYER 3: Main Titanium Chassis */}
      <group position={[0, 0, 0]}>
        <RoundedBox args={[2.6, 5.28, 0.22]} radius={0.34} smoothness={10}>
          <meshStandardMaterial color="#0f172a" metalness={0.98} roughness={0.06} />
        </RoundedBox>
      </group>

      {/* LAYER 4: Screen & Auto-Scrolling Live Website Canvas */}
      <group position={[0, 0, expZ * 1.4]}>
        <mesh ref={screenRef} position={[0, 0, 0.12]}>
          <planeGeometry args={[2.46, 5.14]} />
          <meshBasicMaterial color="#02040a" />

          {/* Live Mobile Website Screen HTML Overlay */}
          <Html
            transform
            wrapperClass="phone-screen-html-website"
            position={[0, 0, 0.01]}
            scale={0.254}
            distanceFactor={1.5}
          >
            <div className="w-[335px] h-[675px] bg-slate-950 text-white rounded-[40px] flex flex-col justify-between overflow-hidden shadow-2xl border border-slate-800 select-none relative font-sans">
              
              {/* Top Dynamic Island Notch */}
              <div className="absolute top-2 left-1/2 -translate-x-1/2 w-24 h-5 bg-black rounded-full z-40 flex items-center justify-between px-2.5 shadow-md">
                <div className="w-2.5 h-2.5 rounded-full bg-slate-900 border border-slate-800"></div>
                <div className="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></div>
              </div>

              {/* Status Bar */}
              <div className="flex justify-between items-center text-[10px] text-slate-300 pt-2 px-4 relative z-30 bg-slate-950/80 backdrop-blur-md">
                <span className="font-bold">09:41</span>
                <div className="flex items-center gap-1">
                  <span className="text-[9px] font-extrabold text-cyan-400">5G</span>
                  <div className="w-4 h-2 border border-slate-300 rounded-sm p-[1px]">
                    <div className="w-full h-full bg-emerald-400 rounded-px"></div>
                  </div>
                </div>
              </div>

              {/* Mobile Browser Nav Bar */}
              <div className="px-3 py-1.5 bg-slate-900/90 border-b border-slate-800 flex items-center justify-between text-[11px] relative z-30">
                <div className="flex items-center gap-1.5 text-cyan-400 font-bold">
                  <Smartphone className="w-3.5 h-3.5" />
                  <span className="text-[10px] text-white">ithrivesoftware.com</span>
                </div>
                <div className="flex items-center gap-2">
                  <button
                    onClick={toggleAutoScroll}
                    className="px-2 py-0.5 rounded-full bg-cyan-500/20 text-cyan-300 border border-cyan-500/40 text-[9px] font-bold flex items-center gap-1"
                    title={isAutoScrolling ? "Pause Auto Scroll" : "Play Auto Scroll"}
                  >
                    {isAutoScrolling ? <Pause className="w-2.5 h-2.5" /> : <Play className="w-2.5 h-2.5" />}
                    <span>{isAutoScrolling ? 'Scroll On' : 'Paused'}</span>
                  </button>
                </div>
              </div>

              {/* LIVE SCROLLING WEBSITE CONTAINER */}
              <div className="flex-1 overflow-hidden relative">
                <div 
                  className={`space-y-3 p-3 transition-transform duration-1000 ease-linear ${
                    isAutoScrolling ? 'animate-mobile-web-scroll' : ''
                  }`}
                  style={{
                    animationDuration: '14s',
                    animationIterationCount: 'infinite',
                    animationTimingFunction: 'ease-in-out'
                  }}
                >
                  {/* Website Hero Section */}
                  <div className="p-3.5 rounded-2xl bg-gradient-to-br from-cyan-950 via-slate-900 to-blue-950 border border-cyan-500/40 space-y-2">
                    <span className="text-[9px] font-extrabold px-2 py-0.5 rounded-full bg-cyan-500 text-slate-950 uppercase">
                      Official iThrive Mobile
                    </span>
                    <h4 className="text-xs font-black text-white leading-tight">
                      Mobile App Development Company in Chennai
                    </h4>
                    <p className="text-[10px] text-slate-300 leading-normal">
                      Two stores, one codebase, no compromise on launch time & 60 FPS performance.
                    </p>
                    <div className="pt-1 flex gap-2">
                      <button className="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-400 to-blue-600 text-slate-950 font-black text-[9px]">
                        Request Quote
                      </button>
                    </div>
                  </div>

                  {/* Feature Card 1 */}
                  <div className="p-3 rounded-xl bg-slate-900 border border-slate-800 space-y-1 text-[10px]">
                    <div className="flex justify-between items-center">
                      <span className="font-bold text-cyan-300">Native iOS & Android</span>
                      <span className="text-emerald-400 font-bold">SwiftUI / Kotlin</span>
                    </div>
                    <p className="text-slate-400 text-[9px]">
                      Custom high-performance mobile apps built with 100% IP ownership.
                    </p>
                  </div>

                  {/* Feature Card 2 - Tada Case Study */}
                  <div className="p-3 rounded-xl bg-slate-900 border border-blue-500/30 text-[10px] space-y-1">
                    <span className="text-[9px] text-cyan-400 font-bold">Case Study: Tada Taxi App</span>
                    <h5 className="font-bold text-white text-[11px]">AI Dispatch Cut Wait Times 40%</h5>
                    <p className="text-slate-400 text-[9px]">Python • FastAPI • PostgreSQL • PostGIS</p>
                  </div>

                  {/* Feature Card 3 - Toing Delivery */}
                  <div className="p-3 rounded-xl bg-slate-900 border border-purple-500/30 text-[10px] space-y-1">
                    <span className="text-[9px] text-purple-400 font-bold">Case Study: Toing Food</span>
                    <h5 className="font-bold text-white text-[11px]">Personalized Ordering +35%</h5>
                    <p className="text-slate-400 text-[9px]">Django • Celery • PostgreSQL</p>
                  </div>

                  {/* Interactive App Screen Switch Shortcuts */}
                  <div className="p-2 rounded-xl bg-slate-900 border border-slate-800 text-[9px] space-y-1">
                    <p className="text-slate-400 font-bold">Active App Engine Screen:</p>
                    <div className="grid grid-cols-2 gap-1 font-bold">
                      <button 
                        onClick={() => onScreenClick('fintech')}
                        className={`p-1 rounded text-center ${activeScreen === 'fintech' ? 'bg-cyan-500 text-slate-950' : 'bg-slate-800 text-slate-300'}`}
                      >
                        iPay Wallet
                      </button>
                      <button 
                        onClick={() => onScreenClick('healthcare')}
                        className={`p-1 rounded text-center ${activeScreen === 'healthcare' ? 'bg-emerald-500 text-slate-950' : 'bg-slate-300 text-slate-950'}`}
                      >
                        CarePulse AI
                      </button>
                    </div>
                  </div>

                  {/* Website Footer Preview inside Phone */}
                  <div className="p-3 rounded-2xl bg-slate-950 border border-slate-900 text-center text-[9px] text-slate-400 space-y-1">
                    <p className="font-bold text-white">iThrive Software Solutions</p>
                    <p className="text-[8px] text-slate-500">OMR IT Corridor, Chennai, India</p>
                  </div>

                </div>
              </div>

              {/* Mobile Home Bar Handle */}
              <div className="w-32 h-1 bg-slate-700 rounded-full mx-auto mb-1.5 relative z-30"></div>

            </div>
          </Html>
        </mesh>
      </group>

      {/* Orbiting 3D Ring */}
      <mesh rotation={[Math.PI / 3, 0, 0]}>
        <torusGeometry args={[3.3, 0.02, 16, 100]} />
        <meshBasicMaterial color={mat.color} transparent opacity={0.4} />
      </mesh>

    </group>
  );
}

export default function Phone3DCanvasV2({ 
  finishColor = 'cyan', 
  activeScreen = 'fintech',
  onFinishChange,
  onScreenChange 
}) {
  const [exploded, setExploded] = useState(false);
  const [isAutoScrolling, setIsAutoScrolling] = useState(true);

  return (
    <div className="w-full h-[550px] md:h-[650px] relative select-none cursor-grab active:cursor-grabbing">
      
      <Canvas
        camera={{ position: [0, 0, 8.8], fov: 45 }}
        gl={{ antialias: true, alpha: true }}
      >
        <ambientLight intensity={1.4} />
        <directionalLight position={[10, 10, 10]} intensity={2.2} />
        <directionalLight position={[-10, -10, -10]} intensity={0.7} color="#00e5ff" />
        <pointLight position={[0, 4, 4]} intensity={1.6} color="#3b82f6" />

        <Float speed={ exploded ? 0 : 2 } rotationIntensity={ exploded ? 0 : 0.3 } floatIntensity={0.5}>
          <UltraRealisticPhone 
            finishColor={finishColor} 
            activeScreen={activeScreen}
            exploded={exploded}
            isAutoScrolling={isAutoScrolling}
            toggleAutoScroll={() => setIsAutoScrolling(!isAutoScrolling)}
            onScreenClick={onScreenChange} 
          />
        </Float>

        <ContactShadows position={[0, -3.3, 0]} opacity={0.6} scale={8} blur={2.5} far={4} color="#00e5ff" />
      </Canvas>

      {/* Control Buttons */}
      <div className="absolute bottom-3 left-1/2 -translate-x-1/2 bg-slate-950/90 border border-slate-800 px-4 py-2 rounded-full flex items-center gap-4 text-xs z-20 backdrop-blur-md shadow-2xl">
        
        {/* Play/Pause Scroll Button */}
        <button
          onClick={() => {
            playClickSound();
            setIsAutoScrolling(!isAutoScrolling);
          }}
          className="px-3 py-1 rounded-full font-extrabold text-[11px] flex items-center gap-1 btn-ithrive-pill"
        >
          {isAutoScrolling ? <Pause className="w-3.5 h-3.5" /> : <Play className="w-3.5 h-3.5" />}
          <span>{isAutoScrolling ? 'Pause Website Scroll' : 'Play Website Scroll'}</span>
        </button>

        <button
          onClick={() => {
            playClickSound();
            setExploded(!exploded);
          }}
          className={`px-3 py-1 rounded-full font-bold text-[11px] flex items-center gap-1 transition-all ${
            exploded 
              ? 'btn-ithrive-pill' 
              : 'btn-ithrive-outline'
          }`}
        >
          <Layers className="w-3.5 h-3.5" />
          <span>{exploded ? 'Collapse Phone' : '3D Explode View'}</span>
        </button>

        <div className="hidden sm:flex items-center gap-2">
          {['cyan', 'emerald', 'violet', 'gold', 'titanium'].map(c => (
            <button
              key={c}
              onClick={() => onFinishChange(c)}
              className={`w-4 h-4 rounded-full transition-transform ${finishColor === c ? 'scale-125 ring-2 ring-white' : 'opacity-60'}`}
              style={{
                backgroundColor: c === 'cyan' ? '#00e5ff' : c === 'emerald' ? '#10b981' : c === 'violet' ? '#a855f7' : c === 'gold' ? '#f59e0b' : '#334155'
              }}
            />
          ))}
        </div>
      </div>

    </div>
  );
}
