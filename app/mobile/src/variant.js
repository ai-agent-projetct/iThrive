/**
 * Page variant.
 *
 * One bundle serves two pages — Mobile App Development and Flutter App
 * Development. They are the same product: the same simulator, the same builder,
 * the same roadmap, the same estimator. Only the words change.
 *
 * So rather than fork the components or ship a second bundle, the copy that
 * differs lives here and the PHP page picks a variant by setting
 * `window.__ithriveVariant` before the module loads. Anything not overridden
 * falls back to the mobile page's text, which means a new variant only has to
 * declare what it actually changes.
 *
 * The alternative — duplicating fifteen components for a page whose behaviour
 * is identical — would guarantee the two drift the first time either is edited.
 */

const MOBILE = {
  key: 'mobile',

  heroBadge: 'Top Mobile App Development Company in Chennai',
  heroRating: '(150+ iOS & Android Apps)',
  heroTitleTop: 'Mobile App Development',
  heroTitleAccent: 'Company in Chennai',
  heroLeadOpen: 'iThrive Software engineers high-performance, visually stunning ',
  heroLeadA: 'iOS & Android Mobile Applications',
  heroLeadB: 'Flutter & React Native cross-platform apps',
  heroLeadC: 'AI-powered mobile solutions',
  heroLeadClose: ' for global enterprises and ambitious startups.',

  heroFeatures: [
    { title: '60 FPS Smooth UI',      body: 'Native Metal & SwiftUI 3D performance' },
    { title: 'Secure by Design',      body: 'Full source code ownership & security' },
    { title: 'On-device AI',          body: 'Smart LLMs & offline mobile intelligence' },
  ],

  ctaPrimary: 'Request Free Proposal & Quote',
  ctaSecondary: 'Estimate Mobile App Cost',

  servicesTitle: 'Mobile App Development Services',
  techTitle: 'Mobile App Development',
  costTitle: 'Mobile app development cost and timelines',
  costLink: 'View mobile app development costs',

  studioTitle: 'Chennai Mobile App Studio',
  studioKeyword: 'Mobile App Development Company in Chennai',

  /* The two picture bands. Drawn by tools/app-bands.mjs; see PictureBand.jsx
     for why these two subjects and not photographs. */
  bands: [
    { img: 'mobile-architecture',
      caption: 'The three layers under a mobile app — device, one API contract per screen, and the services behind it. All of it yours on handover.' },
    { img: 'mobile-release',
      caption: 'From a commit to both stores: signed CI builds, a real device matrix, internal tracks, and a rollback that is one flag rather than a hotfix release.' },
  ],
};

const FLUTTER = {
  key: 'flutter',

  heroBadge: 'Top Flutter App Development Company in Chennai',
  heroRating: '(Flutter apps shipped to both stores)',
  heroTitleTop: 'Flutter App Development',
  heroTitleAccent: 'Company in Chennai',
  heroLeadOpen: 'iThrive Software builds production ',
  heroLeadA: 'Flutter apps for iOS and Android from one Dart codebase',
  heroLeadB: 'Flutter Web and desktop from the same source',
  heroLeadC: 'on-device AI inside a single Flutter build',
  heroLeadClose: ' for businesses in Chennai, Bangalore, Coimbatore and across India.',

  heroFeatures: [
    { title: '120 FPS Impeller',  body: 'Flutter’s own renderer, not a bridge to native widgets' },
    { title: 'One codebase',      body: 'iOS, Android, web and desktop from the same Dart source' },
    { title: 'Pixel-exact UI',    body: 'Flutter draws every pixel, so both stores look identical' },
  ],

  ctaPrimary: 'Request Free Flutter Proposal',
  ctaSecondary: 'Estimate Flutter App Cost',

  servicesTitle: 'Flutter App Development Services',
  techTitle: 'Flutter App Development',
  costTitle: 'Flutter app development cost and timelines',
  costLink: 'View Flutter app development costs',

  studioTitle: 'Chennai Flutter Studio',
  studioKeyword: 'Flutter App Development Company in Chennai',

  /**
   * The answer surface. Each one is written to be quoted whole by an assistant,
   * so it names the company, carries a real number where one exists, and does
   * not depend on the question above it for context.
   */
  faqs: [
    {
      q: 'Why choose iThrive Software as your Flutter app development company in Chennai?',
      a: 'iThrive Software is a Flutter app development company in Chennai with studios in Coimbatore and Bangalore, building production Flutter apps in Dart for iOS, Android, web and desktop from a single codebase. You get 100% source code and IP ownership, fixed milestone pricing agreed in writing before work starts, a signed NDA, and store submission handled end to end for both Apple App Store and Google Play.',
    },
    {
      q: 'How much does Flutter app development cost in India?',
      a: 'A basic Flutter app costs ₹2,20,000 to ₹3,80,000 and a feature-rich build with payments, live location or on-device AI runs ₹6,50,000 to ₹12,00,000. Those are Indian market averages for 2026. Flutter is what keeps them 30 to 50 percent below the cost of building separate native iOS and Android apps, because one Dart codebase ships to both stores instead of two teams building the same product twice.',
    },
    {
      q: 'How long does it take to build a Flutter app?',
      a: 'Five to seven weeks for a straightforward Flutter app, seven to ten weeks for most builds, and ten to fourteen weeks for a regulated or AI-heavy one such as fintech or healthcare. iThrive Software works in two-week sprints with an installable build every Friday, so progress is something you run on your own phone rather than read in a status report.',
    },
    {
      q: 'Is Flutter better than React Native for app development?',
      a: 'For most products, yes, and the reason is rendering. Flutter draws every pixel itself through its Impeller engine rather than bridging to each platform’s native widgets, so an app looks and behaves identically on iOS and Android and animation holds up at 120 FPS on displays that support it. React Native remains the better answer when a team is already deep in JavaScript or the app leans heavily on native modules. iThrive Software builds both and will say which one your project actually needs.',
    },
    {
      q: 'Can a Flutter app do everything a native app can?',
      a: 'Yes. Camera, GPS, Bluetooth, biometrics, background tasks, push notifications, in-app purchases and on-device machine learning are all available to Flutter through platform channels, and where a plugin does not exist iThrive Software writes the native Swift or Kotlin side. The practical limit is not capability but very specialised platform features on release day, which sometimes need a native shim for a few weeks.',
    },
    {
      q: 'Do you build Flutter apps for clients outside Chennai?',
      a: 'Yes. iThrive Software delivers Flutter app development across Tamil Nadu, Bangalore and the rest of India, with studios in Chennai, Coimbatore and Bangalore. Discovery and design sign-off can happen on-site in any of those three cities; delivery runs remotely with an installable build each sprint.',
    },
    {
      q: 'Will I own the Flutter source code and the IP?',
      a: 'Yes, completely. On milestone sign-off iThrive Software transfers the GitHub or GitLab organisation itself rather than a zip file, with commit history, branches and CI pipelines intact. Cloud accounts, the Apple Developer and Google Play listings, signing keys, environment secrets and the Figma files move into your name at the same time.',
    },
    {
      q: 'Do you handle App Store and Google Play submission for Flutter apps?',
      a: 'Yes. App signing, screenshots, privacy and data-safety declarations, metadata and the review-rejection cycle are all handled for both stores until the app is live. One Flutter codebase produces both builds, so a release goes to iOS and Android together rather than one lagging the other by a sprint.',
    },
    {
      q: 'What support do you provide after a Flutter app launches?',
      a: 'Every build ships with a 90-day warranty at no cost: any defect traceable to our code is fixed at our expense, same-business-day response, fix targeted within 72 hours by severity. After that, annual plans cover Flutter and Dart SDK upgrades, OS releases and dependency drift — the work that keeps an app installable and submittable three years on, which is the real risk over that horizon.',
    },
    {
      q: 'Can you convert an existing native or React Native app to Flutter?',
      a: 'Yes. iThrive Software migrates existing iOS, Android and React Native apps to Flutter, usually screen by screen behind the existing shell so the app stays shippable throughout rather than going dark for a rewrite. The starting point is an audit of the current codebase and its analytics, so the migration order follows what users actually touch.',
    },
  ],

  bands: [
    { img: 'flutter-codebase',
      caption: 'One Dart codebase, four places it runs — with platform channels only where native is genuinely unavoidable.' },
    { img: 'flutter-flavours',
      caption: 'Dev, staging and production built from one source and signed separately, so a production build cannot reach a test database.' },
  ],
};

const VARIANTS = { mobile: MOBILE, flutter: FLUTTER };

const chosen = (typeof window !== 'undefined' && window.__ithriveVariant) || 'mobile';

/** Unknown names fall back rather than throwing — a typo in the PHP should not blank the page. */
const V = { ...MOBILE, ...(VARIANTS[chosen] || {}) };

export default V;
