import React, { useState, useRef } from 'react';
import { 
  Cpu, Smartphone, ShieldCheck, Sparkles, Terminal, Layers, 
  Database, Cloud, CheckCircle2, ArrowRight, Code2, Zap, Copy, Check, Star, ExternalLink
} from 'lucide-react';
import MouseOverText from './MouseOverText';
import V from '../variant';
import { playClickSound, playHoverSound } from './AudioEngine';

/**
 * Tech card with a real-time 3D tilt and a cursor-tracked spotlight.
 * Features real-time 3D tilt + cursor radial spotlight tracking!
 */
function InteractiveTechCard3D({ tech, isSelected, onSelect }) {
  const cardRef = useRef(null);
  const [transformStyle, setTransformStyle] = useState('');
  const [spotlightPos, setSpotlightPos] = useState({ x: 50, y: 50 });
  const [isHovered, setIsHovered] = useState(false);

  const handleMouseMove = (e) => {
    if (!cardRef.current) return;
    const rect = cardRef.current.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    // Calculate 3D tilt rotation relative to card center
    const centerX = rect.width / 2;
    const centerY = rect.height / 2;
    const rotateX = ((y - centerY) / centerY) * -12; // Rotate X axis
    const rotateY = ((x - centerX) / centerX) * 12;  // Rotate Y axis

    setTransformStyle(`perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) scale3d(1.04, 1.04, 1.04)`);
    setSpotlightPos({ x, y });
  };

  const handleMouseEnter = () => {
    setIsHovered(true);
    playHoverSound();
  };

  const handleMouseLeave = () => {
    setIsHovered(false);
    setTransformStyle('perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)');
  };

  return (
    <div
      ref={cardRef}
      onClick={() => {
        playClickSound();
        onSelect(tech.id);
      }}
      onMouseMove={handleMouseMove}
      onMouseEnter={handleMouseEnter}
      onMouseLeave={handleMouseLeave}
      className={`glass-panel p-6 rounded-3xl border cursor-pointer relative overflow-hidden transition-all duration-200 select-none ${
        isSelected
          ? 'bg-gradient-to-b from-slate-900 via-slate-900 to-slate-950 border-cyan-400 shadow-2xl shadow-cyan-500/40'
          : 'bg-slate-950/70 border-slate-800 hover:border-cyan-500/50'
      }`}
      style={{
        transform: transformStyle,
        transformStyle: 'preserve-3d',
        transition: isHovered ? 'transform 0.08s ease-out' : 'transform 0.4s ease-out'
      }}
    >
      {/* Radial Spotlight Overlay following Cursor */}
      {isHovered && (
        <div 
          className="pointer-events-none absolute inset-0 rounded-3xl transition-opacity duration-300"
          style={{
            background: `radial-gradient(circle 220px at ${spotlightPos.x}px ${spotlightPos.y}px, rgba(0, 229, 255, 0.22), transparent 80%)`
          }}
        />
      )}

      <div className="relative z-10 space-y-4">
        
        {/* Header Icon & Usage Badge */}
        <div className="flex justify-between items-center">
          <div className={`w-12 h-12 rounded-2xl flex items-center justify-center text-2xl transition-transform duration-300 ${
            isHovered ? 'scale-110 shadow-lg shadow-cyan-400/30 btn-ithrive-pill' : 'bg-slate-900 border border-slate-800'
          }`}>
            {tech.icon}
          </div>

          <span className={`text-[10px] font-bold px-3 py-1 rounded-full border font-mono transition-colors ${
            isSelected 
              ? 'bg-cyan-950 text-cyan-300 border-cyan-400' 
              : 'bg-slate-900 text-slate-400 border-slate-800'
          }`}>
            {tech.usage}
          </span>
        </div>

        {/* Tech Title */}
        <div>
          <h3 className="text-xl font-black text-slate-100 group-hover:text-cyan-300 transition-colors font-heading">
            <MouseOverText text={tech.name} variant="glow" />
          </h3>
          <p className="text-xs text-cyan-400 font-semibold mt-0.5">
            {tech.experience}
          </p>
        </div>

        <p className="text-xs text-slate-300 leading-relaxed">
          {tech.desc}
        </p>

        {/* Proficiency bar */}
        <div className="space-y-1 pt-2 border-t border-slate-800/80">
          <div className="flex justify-between text-[10px] font-bold text-slate-400">
            <span>Production Proficiency</span>
            <span className="text-cyan-400">{tech.proficiency}%</span>
          </div>
          <div className="w-full h-1.5 rounded-full bg-slate-900 overflow-hidden border border-slate-800">
            <div 
              className="h-full rounded-full bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 transition-all duration-500"
              style={{ width: `${tech.proficiency}%` }}
            />
          </div>
        </div>

        {/* Action Link */}
        <div className="pt-2 flex justify-between items-center text-xs text-cyan-400 font-bold">
          <span className="flex items-center gap-1">
            <CheckCircle2 className="w-3.5 h-3.5 text-emerald-400" /> Production Scale
          </span>
          <span className="text-[11px] text-slate-400 hover:text-cyan-300 flex items-center gap-1">
            Inspect Blueprint <ExternalLink className="w-3 h-3" />
          </span>
        </div>

      </div>
    </div>
  );
}

export default function TechStackSection() {
  const [activeCategory, setActiveCategory] = useState('all');
  const [selectedTechId, setSelectedTechId] = useState('flutter');
  const [copiedCode, setCopiedCode] = useState(false);

  const categories = [
    { id: 'all', label: 'All Technologies' },
    { id: 'mobile', label: 'Mobile Frameworks' },
    { id: 'backend', label: 'Backend & APIs' },
    { id: 'ai', label: 'AI & Data' },
    { id: 'cloud', label: 'Cloud & DevOps' },
  ];

  const technologies = [
    {
      id: 'flutter',
      name: 'Flutter 3.24',
      category: 'mobile',
      icon: '💙',
      usage: 'Cross-Platform Apps',
      experience: '60 FPS Impeller Engine',
      proficiency: 98,
      desc: 'Single codebase for iOS & Android with near-native 60 FPS Skia/Impeller GPU rendering engine.',
      deps: ['Dart 3.5', 'Riverpod', 'Impeller Engine', 'TestFlight'],
      codeSnippet: `// Flutter 60 FPS Animated Mobile Component
class iThriveCard extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return AnimatedContainer(
      duration: Duration(milliseconds: 300),
      decoration: BoxDecoration(
        color: Colors.black87,
        borderRadius: BorderRadius.circular(24),
      ),
      child: Text('iThrive 60FPS Flutter Engine'),
    );
  }
}`
    },
    {
      id: 'swift',
      name: 'SwiftUI & Swift 6',
      category: 'mobile',
      icon: '🍎',
      usage: 'Native iOS 18 Apps',
      experience: 'Metal 3D & CoreML',
      proficiency: 96,
      desc: 'Apple native framework with Metal 3D graphics shaders, WidgetKit, and Apple Pay integration.',
      deps: ['Swift concurrency', 'Metal 3D', 'WidgetKit', 'CoreData'],
      codeSnippet: `// SwiftUI Native iOS 18 View
struct iThriveAppView: View {
    var body: some View {
        VStack {
            Text("iThrive Native iOS Engine")
                .font(.custom("Outfit", size: 24))
                .foregroundColor(.cyan)
        }
    }
}`
    },
    {
      id: 'kotlin',
      name: 'Kotlin & Jetpack',
      category: 'mobile',
      icon: '🤖',
      usage: 'Native Android 15',
      experience: 'Coroutines & Compose',
      proficiency: 95,
      desc: 'Google native Android 15 development with Kotlin Coroutines, Flow, and Material 3 design system.',
      deps: ['Coroutines', 'Jetpack Compose', 'Ktor', 'Room DB'],
      codeSnippet: `// Kotlin Jetpack Compose UI
@Composable
fun iThriveAndroidScreen() {
    Surface(color = MaterialTheme.colorScheme.background) {
        Text(text = "iThrive Native Android 15")
    }
}`
    },
    {
      id: 'react-native',
      name: 'React Native 0.76',
      category: 'mobile',
      icon: '⚛️',
      usage: 'Hybrid Mobile',
      experience: 'Fabric Architecture',
      proficiency: 94,
      desc: 'Fabric architecture & TurboModules engine for cross-platform JavaScript mobile apps.',
      deps: ['TypeScript', 'Reanimated 3', 'Expo SDK 51', 'Hermes Engine'],
      codeSnippet: `// React Native Fabric Component
export default function App() {
  return (
    <View style={{ flex: 1, backgroundColor: '#02040a' }}>
      <Text style={{ color: '#00e5ff' }}>iThrive Fabric Engine</Text>
    </View>
  );
}`
    },
    {
      id: 'fastapi',
      name: 'Python & FastAPI',
      category: 'backend',
      icon: '🐍',
      usage: 'Async REST/GraphQL',
      experience: 'Sub-Second AI Backend',
      proficiency: 97,
      desc: 'High-concurrency async Python backend for AI models, microservices, and sub-second API execution.',
      deps: ['Python 3.12', 'Pydantic v2', 'Uvicorn', 'SQLAlchemy 2.0'],
      codeSnippet: `# FastAPI High Speed Mobile Endpoint
from fastapi import FastAPI

app = FastAPI(title="iThrive Mobile Backend")

@app.get("/api/v1/dispatch")
async def get_driver_location():
    return {"status": "ok", "latency_ms": 14}`
    },
    {
      id: 'postgis',
      name: 'PostgreSQL & PostGIS',
      category: 'ai',
      icon: '🐘',
      usage: 'Geospatial DB',
      experience: 'Live GPS Spatial Query',
      proficiency: 95,
      desc: 'Relational database with spatial indexing for live taxi dispatch, delivery routes, and geofencing.',
      deps: ['PostGIS 3.4', 'pgvector', 'Redis Cache', 'Connection Pooler'],
      codeSnippet: `-- PostGIS Spatial Location Query
SELECT id, ST_Distance(
  geom, ST_MakePoint(80.2707, 13.0827)::geography
) as distance_meters
FROM drivers
WHERE ST_DWithin(geom, ST_MakePoint(80.2707, 13.0827)::geography, 5000);`
    }
  ];

  const filteredTech = activeCategory === 'all'
    ? technologies
    : technologies.filter(t => t.category === activeCategory);

  const selectedTech = technologies.find(t => t.id === selectedTechId) || technologies[0];

  const handleCopyCode = () => {
    navigator.clipboard.writeText(selectedTech.codeSnippet);
    setCopiedCode(true);
    setTimeout(() => setCopiedCode(false), 2000);
  };

  return (
    <section id="techstack" className="py-20 md:py-28 relative bg-slate-950/90 border-t border-b border-slate-800/80 overflow-hidden">
      
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        {/* Section Header */}
        <div className="text-center max-w-3xl mx-auto space-y-4 mb-10">

          <h2 className="text-3xl sm:text-4xl md:text-5xl font-black font-heading tracking-tight text-slate-100">
            Tech Stack we use for <MouseOverText text={V.techTitle} variant="glow" className="text-cyan-400" />
          </h2>
        </div>

        {/* Filter Category Pills */}
        <div className="flex justify-center items-center gap-3 mb-10 flex-wrap">
          {categories.map(cat => (
            <button
              key={cat.id}
              onClick={() => {
                playClickSound();
                setActiveCategory(cat.id);
              }}
              className={`px-5 py-2.5 text-xs sm:text-sm font-bold transition-all ${
                activeCategory === cat.id
                  ? 'btn-ithrive-pill'
                  : 'btn-ithrive-outline opacity-70 hover:opacity-100'
              }`}
            >
              {cat.label}
            </button>
          ))}
        </div>

        {/* 3D TILT MOUSEOVER CARDS GRID */}
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
          {filteredTech.map((tech) => (
            <InteractiveTechCard3D
              key={tech.id}
              tech={tech}
              isSelected={selectedTechId === tech.id}
              onSelect={setSelectedTechId}
            />
          ))}
        </div>

        {/* LIVE TECH INSPECTOR & PRODUCTION CODE BLUEPRINT DRAWER */}
        <div className="glass-panel p-6 sm:p-8 rounded-3xl border border-cyan-500/40 shadow-2xl space-y-6">
          <div className="flex justify-between items-start pb-4 border-b border-slate-800 flex-wrap gap-4">
            <div className="space-y-1">
              <div className="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-cyan-950 border border-cyan-500/40 text-cyan-300 text-xs font-semibold">
                <span>{selectedTech.icon}</span>
                <span>{selectedTech.usage}</span>
              </div>
              <h3 className="text-2xl font-black text-slate-100 font-heading mt-1">
                <MouseOverText text={selectedTech.name} variant="glow" />
              </h3>
            </div>

            <button
              onClick={handleCopyCode}
              className="btn-ithrive-pill px-5 py-2.5 text-xs font-bold flex items-center gap-2"
            >
              {copiedCode ? <Check className="w-4 h-4" /> : <Copy className="w-4 h-4" />}
              <span>{copiedCode ? 'Code Blueprint Copied!' : 'Copy Code Blueprint'}</span>
            </button>
          </div>

          <p className="text-slate-300 text-sm leading-relaxed">
            {selectedTech.desc}
          </p>

          {/* Connected Dependencies Pills */}
          <div className="space-y-2">
            <span className="text-[11px] font-bold text-cyan-400 uppercase tracking-wider block">
              Connected Technical Ecosystem:
            </span>
            <div className="flex flex-wrap gap-2">
              {selectedTech.deps.map((dep, dIdx) => (
                <span 
                  key={dIdx} 
                  className="px-3 py-1 rounded-xl bg-slate-900 border border-slate-800 text-xs font-mono text-slate-200"
                >
                  ✓ {dep}
                </span>
              ))}
            </div>
          </div>

          {/* Code Block */}
          <pre className="p-4 rounded-2xl bg-slate-950 border border-slate-800/80 font-mono text-[11px] text-cyan-300 overflow-x-auto leading-relaxed shadow-inner">
            <code>{selectedTech.codeSnippet}</code>
          </pre>
        </div>

      </div>
    </section>
  );
}
