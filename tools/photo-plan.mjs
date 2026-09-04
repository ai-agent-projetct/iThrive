/**
 * The site's photography brief: every slot, its subject, and its shape.
 *
 * Extracted so that more than one generator can work from ONE list. There are
 * two now — tools/site-photos.mjs draws each slot with gpt-image-2 through the
 * codex CLI, and tools/stock-photos.mjs sources it from a licensed stock
 * library and grades it to match — and a brief that lived inside either of them
 * would have had to be copied into the other and then kept in step by hand.
 *
 * Nothing here runs. Import it, do not execute it.
 */

/**
 * dir       where the files go, relative to the repo root
 * ratio     aspect ratio the slot is cropped to
 * items     [filename without extension, subject]
 *
 * The `photo/` subfolder is the convention includes/components/page-figure.php
 * and the MVP and PoC pages' own $img() helpers look in first, so a photograph
 * landing there replaces the drawing with no edit to any page.
 */
export const PLAN = {
  services: {
    dir: 'assets/img/pages/services/photo', ratio: '21:9', items: [
      ['ai-for-ecommerce', 'a retail merchandising team at a wall of screens showing product grids, one person pointing at a row'],
      ['cloud-devops', 'two platform engineers at a standing desk with terminal windows and a deploy pipeline on a wall screen'],
      ['custom-product-development', 'a product team around a table of printed screens and a laptop, mid-argument about a flow'],
      ['dedicated-engineering-team', 'a ring-fenced squad of five at adjoining desks, one shared board behind them'],
      ['ecommerce-development', 'a checkout flow being tested on a phone held in front of a monitor of order data'],
      ['micro-saas-development', 'two founders at a small desk, one laptop each, a subscription dashboard on the wall'],
      ['mvp-development', 'a small startup team at a glass wall of sticky notes, narrowing a long list to a short one'],
      ['on-demand-resources', 'a specialist engineer joining a team mid-project, being shown a codebase on a monitor'],
      ['poc-development', 'a single engineer at a bench with a laptop and a whiteboard of one question'],
      ['product-modernization', 'an engineer beside an old rack and a new cloud dashboard, comparing the two'],
      ['reactjs-development', 'a front-end developer at a wide monitor of component work, a design file open beside it'],
      ['ai-native-product-development', 'a team watching a model evaluation run on a large screen in a dark room'],
    ],
  },

  apps: {
    dir: 'assets/img/pages/apps/photo', ratio: '21:9', items: [
      ['mobile-architecture', 'a mobile engineer with a phone in one hand and an API response on the monitor behind'],
      ['mobile-release', 'a bench of test phones and tablets mid-release, one engineer checking a build'],
      ['flutter-codebase', 'one laptop of Dart code with the same app running on an iPhone and an Android beside it'],
      ['flutter-flavours', 'three phones side by side showing dev, staging and production builds of one app'],
    ],
  },

  capabilities: {
    dir: 'assets/img/capabilities/photo', ratio: '3:2', items: [
      ['cap-01', 'an engineer tracing a multi-step agent workflow on a large monitor, a colleague watching'],
      ['cap-02', 'a researcher comparing a document on the desk with a retrieval result on screen'],
      ['cap-03', 'a test run finishing on a big screen while two engineers read the result'],
      ['cap-04', 'a security engineer at a terminal reviewing a blocked request, calm and deliberate'],
      ['cap-05', 'a reviewer working a queue on screen, approving one item and correcting another'],
      ['cap-06', 'an operations engineer watching live telemetry on a wall of monitors in a dark room'],
    ],
  },

  'aidev-stack': {
    dir: 'assets/img/aidev/stack/photo', ratio: '4:3', items: [
      ['layer-01', 'a data engineer at a terminal ingesting documents, storage racks softly lit behind'],
      ['layer-02', 'a GPU server aisle with an engineer at a laptop between the racks'],
      ['layer-03', 'a researcher reading a long document beside a monitor of search results'],
      ['layer-04', 'two engineers watching an autonomous run step through a task on a big screen'],
      ['layer-05', 'a compliance reviewer with a printed policy and an audit log on screen'],
      ['layer-06', 'a support engineer on a headset watching uptime dashboards at night'],
    ],
  },

  /* The MVP page. Its own PHP already prefers assets/img/mvp/photo. */
  mvp: {
    dir: 'assets/img/mvp/photo', ratio: '3:2', items: [
      ['advantage-02', 'a founder and a finance lead at a laptop in a quiet meeting room, going through a budget'],
      ['advantage-03', 'a developer watching a live analytics dashboard at dusk, city lights out of focus behind'],
      ['advantage-04', 'a sprint board on a wall with cards in three columns, two engineers moving one across'],
      ['advantage-05', 'a single laptop on an empty meeting table, one person alone reading a result'],
      ['why-01', 'a researcher watching a real person use a phone app across a small table, notebook open'],
      ['why-02', 'an almost empty open-plan office late in the evening, one desk lit and one engineer working'],
      ['why-03', 'a founder presenting to two investors across a small table, a laptop turned toward them'],
      ['why-04', 'a senior engineer at a whiteboard drawing an architecture, another watching with arms folded'],
      ['why-05', 'a team standing around a monitor reading a result together, mixed expressions'],
      ['step-01', 'a discovery workshop, five people around a table of printed screens, one writing on a card'],
      ['step-02', 'two people at a wall of feature cards, removing most and leaving a small group'],
      ['step-03', 'a designer at a monitor of a prototype while a colleague taps through it on a phone'],
      ['step-04', 'two engineers pair programming at a desk of two monitors, late light'],
      ['step-05', 'a QA engineer with a rack of test devices on a bench, one in hand'],
      ['step-06', 'a team at a screen of usage funnels a fortnight after launch, one annotating on a tablet'],
      ['reason-01', 'a project lead crossing items off a printed scope document with a pen'],
      ['reason-02', 'two senior engineers at a whiteboard, deep in a design argument'],
      ['reason-03', 'a phone in hand showing a fresh build installing, Friday evening office behind'],
      ['reason-04', 'hands away from a keyboard, a repository transfer confirmed on the laptop screen'],
      ['reason-05', 'a server rack aisle with blue indicator lights, an engineer at the far end'],
      ['reason-06', 'a support engineer on a headset at a monitor, a clock on the wall behind'],
      ['industry-01', 'a fintech team at a desk with a payments dashboard and a card reader'],
      ['industry-02', 'a clinician using a tablet at a hospital workstation, monitors behind'],
      ['industry-03', 'a logistics control room with route screens on the wall and a dispatcher at a desk'],
      ['industry-04', 'a retail operations desk with stock shelves out of focus behind'],
      ['industry-05', 'a small classroom of adult learners at laptops, an instructor beside a screen'],
      ['industry-06', 'an estate agent showing a couple a property on a tablet in an empty modern apartment'],
      ['industry-07', 'a factory floor engineer at a ruggedised terminal beside a production line'],
      ['industry-08', 'a media edit suite, a colourist at a large calibrated monitor, dark room'],
      ['intro-01', 'a wide shot of a product team along one side of a long table in a dark office'],
      ['faq-01', 'a founder and an engineer talking across a desk, laptop closed, an honest conversation'],
    ],
  },

  /* Portrait, because the image trail lays its pictures out tall. */
  'mvp-trail': {
    dir: 'assets/img/mvp/photo', ratio: '2:3', items: [
      ['trail-01', 'a close vertical shot of hands using a mobile app, screen glow on the fingers'],
      ['trail-02', 'a vertical shot of a phone showing a login screen held up in a dim room'],
      ['trail-03', 'a vertical shot of two monitors side on, an API response and a terminal'],
      ['trail-04', 'a vertical shot of a wall-mounted dashboard in a dark office, someone walking past'],
      ['trail-05', 'a vertical shot over a support engineer at a helpdesk queue, headset on the desk'],
    ],
  },

  /*
   * The card grids that were still icon-only after the bands were done — the
   * two /solutions feature grids, the about values, the careers perks and the
   * process commitments. includes/components/feature-card.php looks these up
   * by the slug in the content array and falls back to the icon tile until the
   * file lands, so nothing breaks part-way through a run.
   */
  cards: {
    dir: 'assets/img/cards/photo', ratio: '3:2', items: [
      ['about-01', 'a team reading one number on a large wall screen, nobody celebrating, just assessing'],
      ['about-02', 'two colleagues disagreeing across a whiteboard early in a project, respectful and direct'],
      ['about-03', 'an engineer walking a client through a runbook on a shared monitor'],
      ['about-04', 'a plain, well-kept server cabinet with an engineer closing its door'],

      ['careers-01', 'an engineer watching an autonomous agent work through a task on a large screen'],
      ['careers-02', 'four people at one cluster of desks, no partitions, talking across them'],
      ['careers-03', 'an office at a normal hour with people leaving, one lamp still on'],
      ['careers-04', 'an engineer at a desk with a technical book open beside a laptop of course material'],

      ['insights-01', 'a data engineer joining several source systems on one wide monitor'],
      ['insights-02', 'someone typing a plain-language question at a laptop, an answer forming above'],
      ['insights-03', 'a marketing analyst comparing channel performance across two screens'],
      ['insights-04', 'an alert catching an operator mid-stride in a dim monitoring room'],
      ['insights-05', 'a weekly planning meeting with a short ranked list on the screen'],
      ['insights-06', 'an analyst studying customer segments on a monitor, notes on paper beside'],

      ['aichat-01', 'a visitor browsing a website on a laptop while an assistant panel sits open beside'],
      ['aichat-02', 'a support lead checking an answer against the source document open on the desk'],
      ['aichat-03', 'a sales engineer taking notes while a qualification conversation runs on screen'],
      ['aichat-04', 'a salesperson picking up a headset as a hot lead notification arrives'],
      ['aichat-05', 'a calendar booking being confirmed on a laptop, a diary open beside it'],
      ['aichat-06', 'a security engineer reviewing a filtered conversation log at a terminal'],

      ['process-01', 'one figure written large on a whiteboard with two people standing in front of it'],
      ['process-02', 'a fortnightly demo, a laptop mirrored to a screen, four people watching'],
      ['process-03', 'an engineer checking backup and error-tracking status before a first deploy'],
      ['process-04', 'a discovery session where one person is clearly pushing back on a proposal'],
      ['process-05', 'a printed architecture document beside a laptop, being annotated by hand'],
      ['process-06', 'a laptop showing a repository being transferred, two people shaking hands behind'],
    ],
  },

  /*
   * The PoC Development page. Its own PHP prefers assets/img/poc/photo the way
   * the MVP page prefers assets/img/mvp/photo, so each of these replaces the
   * drawn composition tools/poc-art.mjs made the moment it lands.
   *
   * The hero's six cube faces are NOT here: they are faces of an abstract 3D
   * object, and geometry is the right thing on them.
   */
  poc: {
    dir: 'assets/img/poc/photo', ratio: '3:2', items: [
      ['open-01', 'a single engineer alone at a bench early in a project, one laptop and one question on a whiteboard'],

      ['gain-01', 'an engineer catching a problem on screen and turning to tell a colleague'],
      ['gain-02', 'a founder and a finance lead closing a laptop, a budget document between them'],
      ['gain-03', 'a small group watching a working demo on a laptop, one of them nodding'],

      ['inside-01', 'two people assessing an idea against a document, neither convinced yet'],
      ['inside-02', 'an architect drawing a system on glass while a colleague photographs it'],
      ['inside-03', 'an engineer listing risks on sticky notes and ordering them on a wall'],
      ['inside-04', 'a developer building fast at a cluttered desk, one screen of code, late light'],
      ['inside-05', 'an engineer watching data move through a pipeline on a terminal'],
      ['inside-06', 'a developer testing a third-party integration, two laptops open side by side'],
      ['inside-07', 'a laptop turned around on a table to show a working demo to two people'],
      ['inside-08', 'a planning session with a scoped list and a number written beside it'],

      ['step-01', 'a thirty-minute video call on a laptop in a quiet room, notes being taken'],
      ['step-02', 'a written scope document on a desk being read carefully, pen in hand'],
      ['step-03', 'two engineers building at a shared desk, focused, mid-sprint'],
      ['step-04', 'a demo being reviewed on a large screen, a result being discussed honestly'],
      ['step-05', 'a laptop showing a repository handover, two people shaking hands behind it'],

      ['sector-01', 'a retail team reviewing catalogue and stock data on a wall of screens'],
      ['sector-02', 'a clinician at a hospital workstation with monitors behind, calm and focused'],
      ['sector-03', 'an enterprise team at a bank of desks with a shared dashboard above'],
      ['sector-04', 'a logistics control room, route screens on the wall, a dispatcher at a desk'],
      ['sector-05', 'a fintech engineer at a desk with a payments dashboard and a card reader'],
      ['sector-06', 'an e-commerce operations desk with a checkout flow open on two screens'],

      ['why-01', 'a senior engineer at a whiteboard drawing the real architecture, small'],
      ['why-02', 'one number written large on a whiteboard with two people looking at it'],
      ['why-03', 'a difficult but respectful conversation across a desk, laptop closed'],
      ['why-04', 'hands away from a keyboard as a repository transfer confirms on screen'],

      ['faq-01', 'a founder and an engineer talking across a desk early in a project'],
    ],
  },

  /*
   * The ReactJS Development page, in two sets because a set carries one ratio.
   *
   * Its hero deck and its physics-wall tiles are NOT here: those are lit panels
   * in a WebGL scene and small tumbling stickers, and the drawn orbit reads
   * better at both jobs than a photograph cropped square would.
   */
  react: {
    dir: 'assets/img/react/photo', ratio: '3:2', items: [
      ['doing-01', 'a product team at a wall of screens planning an application build'],
      ['doing-02', 'a developer testing a fast single-page app on a laptop and a phone'],
      ['doing-03', 'a designer and a developer comparing a design file with a running interface'],
      ['doing-04', 'an engineer beside an old system and a new one, migrating between them'],
      ['doing-05', 'a backend engineer at a terminal watching an API respond'],
      ['doing-06', 'an engineer studying a performance profile on a large monitor'],

      ['stack-01', 'a full-stack developer with server and client code open side by side'],
      ['stack-02', 'a developer working in a typed codebase, editor filling the screen'],
      ['stack-03', 'two engineers discussing a data-heavy dashboard on a wall screen'],
      ['stack-04', 'a security-minded engineer reviewing access rules at a desk'],
      ['stack-05', 'a designer and an engineer reviewing a polished interface together'],
      ['stack-06', 'a team watching a live collaborative tool update on two screens'],
      ['stack-07', 'a developer pair-working with an AI coding assistant on screen'],

      ['why-01', 'an engineer reading a performance trace, focused and unhurried'],
      ['why-02', 'a product discussion at a whiteboard where someone is pushing back'],
      ['why-03', 'a senior engineer drawing component boundaries on glass'],
      ['why-04', 'an architect at a laptop planning data flow, notes beside them'],
      ['why-05', 'a fortnightly demo, laptop mirrored to a screen, a small team watching'],
    ],
  },

  'react-wide': {
    dir: 'assets/img/react/photo', ratio: '4:3', items: [
      ['compare-01', 'a frustrated user waiting on a slow interface at a desk'],
      ['compare-02', 'the same kind of desk with a fast, modern interface and a relaxed user'],
      ['faq-01', 'an engineer and a client talking across a laptop early in a project'],
    ],
  },

  /* Blog thumbnails. The six post cards had icons and nothing else. */
  blog: {
    dir: 'assets/img/blog/photo', ratio: '3:2', items: [
      ['post-01', 'an architect at a whiteboard separating one service out from a large existing system'],
      ['post-02', 'an engineer watching an evaluation suite finish, reading the pass and fail counts'],
      ['post-03', 'an old system and a new one side by side on two monitors, one engineer between them'],
      ['post-04', 'a clothing warehouse aisle with someone measuring a garment beside a laptop'],
      ['post-05', 'a hospital reception workstation with a scheduling screen and a member of staff'],
      ['post-06', 'a single laptop of Python code with a model training run in a second window'],
    ],
  },
};

/** Final pixel size per ratio, shared by both generators. */
export const TARGET = {
  '21:9': [1500, 643], '3:2': [1400, 933], '4:3': [1200, 900],
  '1:1': [1000, 1000], '2:3': [900, 1350],
};
