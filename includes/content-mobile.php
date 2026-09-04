<?php
/**
 * Mobile App page answers.
 *
 * The React FAQ section renders these same 11, but only once its JavaScript has
 * run. This copy exists so the server response carries them too: the surface
 * they are written for is an assistant quoting a page it never executed, and
 * without this it would find nothing there.
 *
 * The Flutter page has had this since it launched (see content-flutter.php).
 * The mobile page — the larger of the two — did not, so its FAQ was invisible
 * to every crawler and answer engine that does not run scripts, and it carried
 * no FAQPage schema either.
 *
 * Generated from app/mobile/src/components/FaqSection.jsx. Edit them there and
 * regenerate, rather than editing both by hand and letting the two drift.
 */

declare(strict_types=1);

const MOBILE_FAQ = [
    [
        'q' => 'Why should I choose iThrive Software for Mobile App Development in Chennai?',
        'a' => 'iThrive Software is Chennai’s premier mobile app engineering team. We specialize in '
             . 'high-performance native iOS (Swift), native Android (Kotlin), cross-platform (Flutter & React '
             . 'Native), and AI-powered mobile apps. We provide 100% IP ownership, transparent milestone '
             . 'pricing, strict NDAs, and guaranteed App Store approval.',
    ],
    [
        'q' => 'How much does it cost to build a mobile app with iThrive Software?',
        'a' => 'A basic cross-platform app runs ₹2,20,000 to ₹3,80,000 depending on the sector, and a '
             . 'feature-rich build with payment gateways, live GPS or AI agents runs ₹6,50,000 to ₹12,00,000. '
             . 'Those are Indian market averages for 2026 — Flutter and React Native are what keep them 30 to '
             . '50 percent below native. The arrow beside the quote button on this page opens the full rate '
             . 'card by category and by service.',
    ],
    [
        'q' => 'How long will it take to design and launch our mobile application?',
        'a' => 'A simple app is 5 to 7 weeks from discovery to store submission. Most builds land at 7 to 10 '
             . 'weeks, and a regulated or AI-heavy one — fintech, healthcare — runs 10 to 14 weeks. We work in '
             . 'two-week sprints with an installable build every Friday, so you see progress rather than hear '
             . 'about it.',
    ],
    [
        'q' => 'Do you handle Apple App Store & Google Play Store submission?',
        'a' => 'Yes, 100%! We handle the entire deployment pipeline including app signing, screenshot '
             . 'creation, privacy policy compliance, metadata optimization, and resolving any App Store review '
             . 'queries until your app is live.',
    ],
    [
        'q' => 'Will I own the source code and intellectual property (IP)?',
        'a' => 'Yes! Upon project completion, 100% of the source code, design assets, GitHub repositories, and '
             . 'intellectual property rights are legally transferred to your company.',
    ],
    [
        'q' => 'What post-launch support and maintenance do you provide?',
        'a' => 'We provide 60 days of free post-launch support covering bug fixes and OS compatibility. '
             . 'Afterward, we offer flexible monthly SLA maintenance plans for feature upgrades and server '
             . 'monitoring.',
    ],
    [
        'q' => 'Once the final payment is made, how is the code delivered to us?',
        'a' => 'On milestone sign-off we transfer the GitHub or GitLab organisation itself, not a zip file — '
             . 'full commit history, branches and CI pipelines intact. Cloud accounts, the Apple Developer and '
             . 'Google Play listings, signing keys, environment secrets and the Figma files move into your '
             . 'name at the same time. You also get architecture notes and a working local setup, so a '
             . 'different team could take over without ever speaking to us. Nothing is held back as leverage.',
    ],
    [
        'q' => 'What guarantee do I have if the app stops working three months after launch?',
        'a' => 'Every build ships with a 90-day warranty at no cost: any defect traceable to our code is fixed '
             . 'at our expense, with a same-business-day response and a fix targeted within 72 hours by '
             . 'severity. The warranty covers our code — it does not cover a third party changing their API, '
             . 'an OS release, or new features. Those fall under a maintenance plan, and we will tell you '
             . 'plainly which bucket an issue lands in rather than arguing the boundary.',
    ],
    [
        'q' => 'How does the iThrive support team actually work day to day?',
        'a' => 'You get a named engineer who worked on your build, not a ticket queue and a stranger. Support '
             . 'runs on a shared Slack or Teams channel plus email, with a tracked board you can see. Response '
             . 'targets are one business hour for anything production-down, same business day for a broken '
             . 'feature, and two working days for everything else. Every month you get an uptime, '
             . 'crash-free-rate and cost summary — sent whether the reading is flattering or not.',
    ],
    [
        'q' => 'Will I still be able to get support for the app three years from now?',
        'a' => 'Yes. Support is an annual rolling agreement with no expiry cliff, and we have clients on '
             . 'platforms first shipped years ago. The practical risk over that horizon is not us, it is '
             . 'drift: iOS and Android each ship a release a year, dependencies fall out of maintenance, and '
             . 'an unmaintained app becomes unsubmittable. Our annual plans include the OS and SDK upgrade '
             . 'work that keeps a three-year-old app installable and in the stores.',
    ],
    [
        'q' => 'What AI goes into my app, and how does it actually grow the business?',
        'a' => 'Only what earns its place. In practice that is a recommendation engine that lifts basket size, '
             . 'an on-device assistant that answers without a round trip, semantic search that finds what a '
             . 'keyword misses, predictive alerts that pre-empt churn or downtime, and document or voice '
             . 'intake that removes manual entry. Each ships behind a measurement: support tickets deflected, '
             . 'conversion rate, hours saved per employee. If a feature does not move its number, we say so '
             . 'and cut it rather than keep it for the brochure.',
    ],
];
