/**
 * Writes docs/image-prompts.md — the full prompt set for the sixteen AI service
 * pages, 14 images each (6 in section 3, 5 in section 5, 3 in section 6).
 *
 *     node tools/image-prompts.mjs
 *
 * Why a generator rather than a hand-written document: the filenames have to
 * match what the pages load, and 224 hand-typed names is 224 chances to typo
 * one. The motifs and subjects are the content; everything else is mechanical.
 *
 * Every page gets its own MOTIF, which is the same rule the existing art
 * generators in this folder follow: a set is distinguishable by what it draws,
 * not by inventing a colour of its own. The palette is fixed site-wide.
 */

import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = path.resolve(fileURLToPath(new URL('..', import.meta.url)));

const STYLE = [
  'Original abstract 3D render, 16:9 landscape, no photography.',
  'Near-black navy background (hex 0B0F17).',
  'Light comes only from the subject: glowing cyan (hex 00F2FE) through blue',
  '(hex 4EA8FF) into violet (hex 9D4EDD).',
  'Cinematic studio lighting, soft depth of field, subtle volumetric haze,',
  'clean reflective floor, high detail, premium enterprise feel.',
  'No text, no letters, no numbers, no logos, no brand marks, no watermarks,',
  'no people, no faces, no hands.',
].join(' ');

/** [slug, label, motif, six section-3 subjects, five section-5, three section-6] */
const PAGES = [
  ['ai-consulting', 'AI Consulting', 'the decision map',
    ['layered translucent glass planes at staggered depths',
     'a row of glowing vertical bars of uneven height',
     'a wide grid floor with a few cells lit brighter than the rest',
     'two diverging paths of light, one brighter than the other',
     'a slow spiral of concentric rings narrowing to a point',
     'scattered nodes with a single one ringed in light'],
    ['a horizon line resolving out of haze',
     'stacked panels sliding into alignment',
     'a beam sweeping across a field of markers',
     'a ledger of glowing rows, one highlighted',
     'a wide arc of light closing into a circle'],
    ['a single tall column lit from within',
     'three plinths of descending height',
     'an open frame with light pouring through it']],

  ['gen-ai-development', 'Generative AI Development', 'chaos resolving into structure',
    ['fine particles streaming in from the left',
     'particles mid-coalescence into a solid cube',
     'a finished geometric form with a few motes still orbiting',
     'a lattice knitting itself together strand by strand',
     'a cloud of sparks compressed into a bright bar',
     'ribbons of light folding into a flat sheet'],
    ['a dense swarm at rest',
     'the swarm elongating into a stream',
     'the stream striking a surface and flattening',
     'a formed slab cooling, edges still glowing',
     'the finished object alone on a reflective floor'],
    ['a perfect cube suspended in haze',
     'two forms, one rough and one refined, side by side',
     'a bright seam running through a solid block']],

  ['ai-chatbot-development', 'AI Chatbot Development', 'concentric conversation',
    ['concentric rings expanding from a point',
     'two ring systems overlapping and interfering',
     'a vertical stack of rounded panels, each smaller',
     'a pulse travelling along a curved channel',
     'paired arcs facing one another across a gap',
     'a bright node with soft echo rings around it'],
    ['a single ring alone',
     'a second ring answering the first',
     'many rings in ordered sequence',
     'rings overlapping into a woven pattern',
     'the pattern settling into one steady circle'],
    ['a glowing speech-shaped void in a solid wall',
     'two spheres connected by a taut thread of light',
     'a ring standing upright on a mirrored floor']],

  ['ai-copilot-development', 'AI Copilot Development', 'the guiding light',
    ['a soft light source beside a flat working surface',
     'a panel with one edge lit by an unseen source',
     'a hovering marker above a grid, casting a glow',
     'a translucent overlay aligned above a solid plate',
     'a narrow beam pointing at one cell of many',
     'twin surfaces, one leading the other slightly'],
    ['an empty surface in low light',
     'a light arriving at its edge',
     'the surface illuminated and legible',
     'a second surface joining in the same light',
     'both surfaces aligned and glowing evenly'],
    ['a lamp-like form above a dark plane',
     'a bright line tracing the edge of a shape',
     'two panels at a slight angle, one lit']],

  ['rag-development', 'RAG Development', 'retrieval from the archive',
    ['tall stacks of glowing translucent sheets',
     'one sheet drawn out from a dense stack',
     'a beam searching across ranked rows',
     'sheets fanning out in an arc',
     'a bright core with sheets orbiting it',
     'a corridor of shelved panels receding into haze'],
    ['a closed archive of dark slabs',
     'a light entering the archive',
     'one slab lifting clear of the others',
     'the slab carried toward a bright core',
     'the core glowing brighter, archive dimmed'],
    ['a single illuminated page-like plane',
     'a citation thread linking two planes',
     'a lit vault door standing open']],

  ['computer-vision-development', 'Computer Vision Development', 'the scanning beam',
    ['a horizontal beam sweeping over geometric solids',
     'a wireframe outline forming around a solid shape',
     'a grid projected across an uneven surface',
     'a lens-like aperture of concentric rings',
     'objects on a belt under a bar of light',
     'a depth map rendered as coloured contours'],
    ['unlit objects in a dark field',
     'a beam beginning its sweep',
     'outlines appearing as it passes',
     'every object outlined and measured',
     'one object singled out in brighter light'],
    ['a single eye-like aperture of rings',
     'a solid and its wireframe twin',
     'a bright scanning line across a dark plane']],

  ['agentic-ai-strategy', 'Agentic AI Strategy & Consulting', 'the branching path',
    ['a trunk of light splitting into branches',
     'branches of differing brightness from one root',
     'a decision node with several outgoing paths',
     'one path lit, the others dimmed',
     'a tree of light seen from above',
     'nested forks receding into haze'],
    ['a single starting point',
     'the first split into two',
     'a widening fan of branches',
     'most branches fading, one persisting',
     'the chosen path running clear to the horizon'],
    ['a single bright fork',
     'a pruned tree with few strong limbs',
     'a lit trail across a dark plain']],

  ['custom-agent-development', 'Custom AI Agent Development', 'modular assembly',
    ['separate glowing blocks floating apart',
     'blocks drawing together into a column',
     'an assembled form with visible seams',
     'a block sliding into a waiting socket',
     'an exploded view of stacked components',
     'a finished assembly rotating on a plinth'],
    ['loose components scattered',
     'components aligning on an axis',
     'the first join completed',
     'the structure half assembled',
     'the completed mechanism glowing evenly'],
    ['one precision component alone',
     'a locked joint between two parts',
     'the finished assembly, lit from below']],

  ['ai-agent-solutions', 'AI Agent Solutions', 'the catalogue',
    ['a grid of identical glowing units',
     'one unit lifted from the grid',
     'rows of units receding into haze',
     'a unit opening to show its interior',
     'units on a shelf, one turned outward',
     'a wall of cells, a few lit brighter'],
    ['a sealed row of identical units',
     'one unit selected and raised',
     'the unit configured, edges brightening',
     'the unit placed into a working slot',
     'the slot alive with light'],
    ['a single ready-made unit',
     'a shelf of units in perspective',
     'one unit glowing among dark twins']],

  ['multi-agent-orchestration', 'Multi-Agent Orchestration', 'the orbiting system',
    ['several nodes orbiting a central point',
     'beams linking nodes to one another',
     'a conductor node brighter than the rest',
     'orbits at differing inclinations',
     'a node handing a bright pulse to its neighbour',
     'the whole system seen from above'],
    ['isolated nodes, unconnected',
     'the first link forming',
     'a full mesh of links',
     'a central node taking command',
     'the system turning in unison'],
    ['one hub with radiating spokes',
     'two nodes exchanging a pulse',
     'a halted system, one node still lit']],

  ['agentic-ai-integration', 'Agentic AI Integration', 'the contract layer',
    ['dissimilar shapes joined by a clean interface plate',
     'a pipe of light bridging two unlike solids',
     'a socket accepting a differently shaped plug',
     'an adapter ring between two cylinders',
     'a wall with ports of varying shapes, all lit',
     'a junction box with several bright inputs'],
    ['two incompatible forms apart',
     'an adapter appearing between them',
     'the first connection made',
     'traffic flowing across the join',
     'the join sealed and glowing steadily'],
    ['a single clean coupling',
     'a gate on a pipeline, closed',
     'the same gate open, light passing']],

  ['ai-integration', 'AI Integration Services', 'the central gateway',
    ['a hub with many radiating conduits',
     'traffic converging on one bright gate',
     'a routing plate splitting one beam into many',
     'metered channels of differing brightness',
     'a switchboard of lit connections',
     'a tower with tiers of glowing ports'],
    ['scattered endpoints unconnected',
     'a gateway rising among them',
     'endpoints connecting inward',
     'balanced flow through the gateway',
     'the gateway steady under full load'],
    ['one gateway monolith',
     'a meter reading steady light',
     'a failover path lighting as the main dims']],

  ['autonomous-workflow-automation', 'Autonomous Workflow Automation', 'the moving queue',
    ['a conveyor of glowing tiles',
     'tiles sorted into two diverging lanes',
     'a queue shortening toward a bright exit',
     'a gate passing most tiles and holding one',
     'tiles stacking neatly at the end of a run',
     'an overhead view of parallel lanes'],
    ['a long unmoved queue',
     'the queue beginning to advance',
     'tiles dividing at a junction',
     'the queue nearly cleared',
     'a single held tile under a bright light'],
    ['one tile mid-flight between lanes',
     'an empty lane, work complete',
     'a full lane and an empty one side by side']],

  ['agent-operations-support', 'Agent Operations, Training & Support', 'the instrument panel',
    ['a bank of glowing circular gauges',
     'a waveform tracing steadily across a panel',
     'stacked readouts of differing brightness',
     'one gauge swinging out of its normal band',
     'a wall of small indicators, one amber',
     'a control surface with a single lit switch'],
    ['a dark panel at rest',
     'the panel powering up',
     'readings settling into a steady band',
     'one reading drifting out of range',
     'the panel corrected and even again'],
    ['a single large gauge, centred',
     'a flatline becoming a pulse',
     'one prominent switch, lit']],

  ['rpa-development', 'RPA Development', 'the repeating mechanism',
    ['a row of identical arm-like forms mid-motion',
     'interlocking gears of light',
     'a repeating stamping motion frozen at intervals',
     'a rail carrying evenly spaced markers',
     'a cam and follower rendered in glass',
     'a mechanism seen end-on, tunnelling into haze'],
    ['a still mechanism',
     'the first motion beginning',
     'full repeating rhythm',
     'one arm stalled while others continue',
     'the stalled arm rejoining the rhythm'],
    ['a single clean mechanical joint',
     'a loop of rail with no start or end',
     'a bridge between an old cog and a new one']],

  ['hire-agentic-ai-developers', 'Hire Agentic AI Developers', 'the interlocking team',
    ['separate forms interlocking into one shape',
     'a ring of linked components',
     'a lattice where every strut carries load',
     'one piece joining an existing structure',
     'a scaffold being extended outward',
     'interlocked blocks lit from a single source'],
    ['one lone component',
     'a second arriving alongside',
     'the two locking together',
     'a growing connected structure',
     'a complete lattice standing alone'],
    ['a single strong joint',
     'a handover of light between two forms',
     'a finished structure with one piece removable']],
];

const lines = [];
const P = (s = '') => lines.push(s);

P('# Image prompts — 16 AI service pages, 14 images each');
P('');
P('224 images. Generate in ChatGPT (or any image model), save with the exact');
P('filename given, and drop them anywhere — installation, resizing and wiring');
P('into the pages is handled separately.');
P('');
P('## How to use');
P('');
P('1. Paste the STYLE BLOCK once at the start of a new chat.');
P('2. Then send one SUBJECT line at a time. Each produces one image.');
P('3. Save each result under the filename shown beside it.');
P('');
P('Keeping the style block in one conversation is what holds the sixteen sets');
P('together as one website rather than sixteen unrelated galleries.');
P('');
P('## STYLE BLOCK');
P('');
P('```');
P(STYLE);
P('```');
P('');
P('---');
P('');

let total = 0;
PAGES.forEach(([slug, label, motif, s3, s5, s6], i) => {
  const n = String(i + 1).padStart(2, '0');
  P(`## ${n} — ${label}`);
  P('');
  P(`**Motif:** ${motif}`);
  P('');
  const emit = (arr, section) => {
    P(`**Section ${section}** — ${arr.length} images`);
    P('');
    arr.forEach((subject, k) => {
      const file = `svc-${n}-s${section}-${k + 1}.jpg`;
      P(`- \`${file}\` — ${subject}`);
      total++;
    });
    P('');
  };
  emit(s3, 3);
  emit(s5, 5);
  emit(s6, 6);
  P('---');
  P('');
});

P(`Total: ${total} images across ${PAGES.length} pages.`);
P('');

fs.mkdirSync(path.join(ROOT, 'docs'), { recursive: true });
const out = path.join(ROOT, 'docs', 'image-prompts.md');
fs.writeFileSync(out, lines.join('\n'), 'utf8');
console.log(`wrote ${out}`);
console.log(`${total} prompts across ${PAGES.length} pages`);
