/*
 * Text Lift — Origin Kit registry component `textlift`, as it ships.
 *
 * Each letter is a stack of copies of itself pushed to one side, so the word
 * reads as extruded type; hovering a letter expands its own stack in that
 * direction and lifts it off the surface. It is the Custom Product Development
 * page's headline, and the reason that page's hero is 3D without a canvas.
 *
 * WHY THIS ONE. Seven components on this site have rendered nothing because
 * they computed their layout inside requestAnimationFrame or painted to a
 * canvas, and a tab that never gets a frame gets an empty rectangle. This has
 * neither: it is spans with framer-motion transforms, so the word is laid out
 * and readable at first paint whether or not a single frame ever runs. The
 * lift is the enhancement, not the content.
 *
 * Two edits from the registry source, both noted inline:
 *   - TypeScript annotations removed, since the rest of this bundle is JSX.
 *   - `useIsStaticRenderer` is the shim's, not a local stub, so it agrees with
 *     every other component here about which surface it is drawing to.
 *
 * COMPONENT_DEFAULTS is merged inside the component rather than declared
 * through addPropertyControls, which matters off the Framer canvas: a control's
 * defaultValue is applied by the editor, so anything not passed from PHP would
 * otherwise arrive undefined. Here an unpassed prop still has a value.
 */
import { motion } from 'framer-motion';
import { useState } from 'react';
import { useIsStaticRenderer } from '../framer/framer-shim.js';

const DIRS = {
  topLeft: { x: -0.72, y: -0.72 },
  top: { x: 0, y: -1 },
  topRight: { x: 0.72, y: -0.72 },
  bottomLeft: { x: -0.72, y: 0.72 },
  bottom: { x: 0, y: 1 },
  bottomRight: { x: 0.72, y: 0.72 },
};

function Letter(props) {
  const {
    char, depth, spread, expand, dir, frontColor, depthColor,
    strokeColor, stroke, filled, fade, transition, font, isStatic,
  } = props;

  const [hover, setHover] = useState(false);
  const on = hover && !isStatic;
  const space = char === ' ';

  // Hovered letter always lifts to a high positive z — never negative. A
  // negative z on the spring-animating parent forces the browser to recompute
  // paint order every frame as overlap with neighbours changes, which is what
  // produced the downward jitter.
  const activeZ = on ? 1000 : 'auto';

  return (
    <span
      style={{
        position: 'relative',
        display: 'inline-block',
        whiteSpace: 'pre',
        cursor: 'default',
        zIndex: activeZ,
      }}
    >
      {/* In-flow spacer at the base: defines the footprint AND owns the hover
          hit-area, pinned to the base where the last layer sits. */}
      <span
        onPointerEnter={() => setHover(true)}
        onPointerLeave={() => setHover(false)}
        aria-hidden
        style={{ display: 'inline-block', color: 'transparent', ...font }}
      >
        {space ? ' ' : char}
      </span>

      {Array.from({ length: depth }).map((_, i) => {
        // The readable front face (i = depth-1) moves furthest in the push
        // direction; the layers follow behind it. i = 0 is the deepest layer
        // and stays pinned to the base in both rest and hover.
        const isTop = i === depth - 1;
        const s = on ? i * expand : i * spread;
        const lc = isTop ? frontColor : depthColor;

        return (
          <motion.span
            key={i}
            aria-hidden={!isTop}
            animate={{ x: s * dir.x, y: s * dir.y }}
            transition={transition || { type: 'spring', stiffness: 320, damping: 22 }}
            style={{
              position: 'absolute',
              left: 0,
              top: 0,
              pointerEvents: 'none',
              color: filled ? lc : 'transparent',
              WebkitTextStrokeWidth: stroke > 0 ? `${stroke}px` : undefined,
              WebkitTextStrokeColor: stroke > 0 ? strokeColor : undefined,
              opacity: fade ? Math.max(0.2, 1 - ((depth - 1 - i) / depth) * 0.85) : 1,
              zIndex: i + 1,
              display: 'inline-block',
              willChange: 'transform',
              ...font,
            }}
          >
            {space ? ' ' : char}
          </motion.span>
        );
      })}
    </span>
  );
}

const COMPONENT_DEFAULTS = {
  text: 'TEXT LIFT',
  direction: 'bottomRight',
  depth: 10,
  spread: 0,
  expand: 18,
  fade: true,
  filled: true,
  stroke: 3,
  strokeColor: '#FFFFFF',
  frontColor: '#FFFFFF',
  depthColor: '#FFFFFF',
  transition: { type: 'spring', stiffness: 320, damping: 22 },
  font: {
    fontFamily: 'Inter',
    fontWeight: 700,
    fontSize: '120px',
    letterSpacing: '-0.02em',
    lineHeight: '1em',
  },
};

export default function TextLift(userProps) {
  const props = { ...COMPONENT_DEFAULTS, ...userProps };
  const {
    text, frontColor, depthColor, strokeColor, stroke,
    filled, depth, spread, expand, direction, fade, transition, font,
  } = props;

  const isStatic = useIsStaticRenderer();
  const dir = DIRS[direction] || DIRS.topRight;
  const safeDepth = Math.max(1, Math.round(depth));

  return (
    <div
      style={{
        display: 'inline-flex',
        flexWrap: 'wrap',
        width: 'max-content',
        maxWidth: '100%',
        ...font,
      }}
    >
      {text.split('').map((c, idx) => (
        <Letter
          key={idx}
          char={c}
          depth={safeDepth}
          spread={spread}
          expand={expand}
          dir={dir}
          frontColor={frontColor}
          depthColor={depthColor}
          strokeColor={strokeColor}
          stroke={stroke}
          filled={filled}
          fade={fade}
          transition={transition}
          font={font}
          isStatic={isStatic}
        />
      ))}
    </div>
  );
}
