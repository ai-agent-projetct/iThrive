<?php
/**
 * Our Enterprise AI Solutions — as a scroll-driven polaroid gallery.
 *
 * After Soyeb's "Polaroid Scroll" on the Framer marketplace, whose own
 * description is the spec: photos that "gently glide across the screen as you
 * scroll, creating the feeling of a curated gallery rather than a traditional
 * image grid… each polaroid smoothly moves across a large canvas, naturally
 * changing composition and focus to create depth, motion, and visual interest."
 *
 * That component is a paid one ($9) with no public module, unlike Framer's Cover
 * Flow Gallery in section four, which publishes its code and is therefore run
 * here verbatim. This is the described behaviour built from scratch rather than
 * a copy of their file — the honest option when the source is not available.
 *
 * The mechanics, in assets/js/aidev/polaroid-scroll.js:
 * - Every polaroid has a lane (--lane), a depth (--depth) and a tilt. Depth
 *   drives how far it travels, how big it is and how sharp: near cards glide
 *   further and stay crisp, far cards drift slowly and sit back. That is the
 *   "changing composition and focus" the reference describes.
 * - Travel is tied to the section's own scroll progress, not to each card's, so
 *   the whole wall moves as one thing.
 *
 * Degrades: with no JavaScript the polaroids sit in their lanes as a static
 * gallery, and every solution's name and description is ordinary markup either
 * way — the picture is never the only copy of the information.
 *
 * The nine are the same nine this section has always listed.
 */

declare(strict_types=1);

/**
 * lane   which row it rides in (0 top, 2 bottom)
 * depth  0 = nearest and sharpest, 1 = furthest and softest
 * tilt   the handled, pinned-to-a-board feel; degrees
 */
$solutions = [
    ['n' => '01', 'img' => 'strategy',    'lane' => 0, 'depth' => 0.10, 'tilt' => -3.2,
     'title' => 'AI Strategy & Consulting',
     'body'  => 'We instrument what you already run, find where the money and the hours actually go, and rank the AI opportunities by effort against measured impact before anyone writes code.'],
    ['n' => '02', 'img' => 'product',     'lane' => 1, 'depth' => 0.55, 'tilt' => 2.4,
     'title' => 'Custom AI Product Development',
     'body'  => 'Greenfield products built around an agentic core — the model owns the workflow and the interface exists so a person can supervise it, not the other way round.'],
    ['n' => '03', 'img' => 'genai',       'lane' => 2, 'depth' => 0.28, 'tilt' => -1.6,
     'title' => 'Generative AI & LLM Agents',
     'body'  => 'Fine-tuned models and multi-step agents on your own corpus, with typed tool contracts, approval gates and a trace on every run.'],
    ['n' => '04', 'img' => 'voice',       'lane' => 0, 'depth' => 0.70, 'tilt' => 3.0,
     'title' => 'Conversational AI & Voicebots',
     'body'  => 'Assistants that answer in the language the customer speaks — 25+ of them — grounded in your documentation and escalating cleanly the moment they should stop guessing.'],
    ['n' => '05', 'img' => 'vision',      'lane' => 1, 'depth' => 0.15, 'tilt' => -2.2,
     'title' => 'Computer Vision, OCR & Video AI',
     'body'  => 'Reading documents, inspecting product on the line and classifying footage at a volume nobody can staff for, with the uncertain cases routed to a person.'],
    ['n' => '06', 'img' => 'integration', 'lane' => 2, 'depth' => 0.62, 'tilt' => 2.0,
     'title' => 'Enterprise AI Integration',
     'body'  => 'Non-invasive services and middleware into SAP, Salesforce, Dynamics, Oracle and your own data lakes — no downtime and no rewrite of the systems that earn.'],
    ['n' => '07', 'img' => 'analytics',   'lane' => 0, 'depth' => 0.34, 'tilt' => -2.8,
     'title' => 'Predictive Analytics & BI',
     'body'  => 'Forecasts, churn and demand models with anomaly alerts that page someone, measured against a held-out control rather than a dashboard.'],
    ['n' => '08', 'img' => 'governance',  'lane' => 1, 'depth' => 0.78, 'tilt' => 1.4,
     'title' => 'AI Security & Compliance',
     'body'  => 'ISO/IEC 27001, SOC 2 Type II and the NIST AI Risk Management Framework, with PII redaction, RBAC and an audit trail that predates the audit.'],
    ['n' => '09', 'img' => 'edge',        'lane' => 2, 'depth' => 0.22, 'tilt' => -3.6,
     'title' => 'Edge AI, Robotics & IoT',
     'body'  => 'Models quantised to run on the device where the decision is made, so a dropped connection does not stop the line.'],
];
?>
<section id="solutions" class="section-padding polaroid-section">
  <div class="container">
    <div class="polaroid-head">
      <span class="section-badge"><span class="dot"></span> ENGINEERING CAPABILITIES</span>
      <h2 class="section-title">Our Enterprise <span class="gradient-text">AI Solutions</span></h2>
      <p class="section-subtitle">
        Nine things we build. Scroll, and the wall moves past you.
      </p>
    </div>
  </div>

  <?php /* The canvas is wider than the viewport on purpose: the polaroids ride
           across it, so the gallery reads as bigger than the window it is seen
           through. */ ?>
  <div class="polaroid-scroll" data-polaroid>
    <?php foreach ($solutions as $s): ?>
      <figure class="polaroid"
              style="--lane: <?= (int) $s['lane'] ?>; --depth: <?= e((string) $s['depth']) ?>; --tilt: <?= e((string) $s['tilt']) ?>deg;">
        <div class="polaroid-photo">
          <img src="<?= e(asset('assets/img/aidev/solutions/' . $s['img'] . '.jpg')) ?>"
               alt="" width="1200" height="900" loading="lazy" decoding="async">
        </div>
        <figcaption class="polaroid-caption">
          <span class="polaroid-num"><?= e($s['n']) ?></span>
          <h3 class="polaroid-title"><?= e($s['title']) ?></h3>
          <p class="polaroid-body"><?= e($s['body']) ?></p>
        </figcaption>
      </figure>
    <?php endforeach; ?>
  </div>
</section>
