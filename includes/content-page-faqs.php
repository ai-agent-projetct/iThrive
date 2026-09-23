<?php
/**
 * Ten questions and answers for the pages that belong to no catalogue.
 *
 * The service pages get theirs from content-service-faqs.php, the case studies
 * from content-case-faqs.php and the two products from
 * content-solution-faqs.php. What is left is the home page, the three hubs, the
 * company pages, contact, and the handful of service pages built standalone
 * rather than on templates/service-detail.php. Those are keyed here by a short
 * page key and rendered with components/faq-section.php.
 *
 * House rules, the same ones content-service-faqs.php uses:
 *   - Answer the question asked in the first sentence, then justify it.
 *   - Name the real constraint. "It depends" is only useful with the "on what".
 *   - Where the honest answer is "you may not need this", say so.
 *
 * A hub page has a failure mode of its own: it is tempting to answer questions
 * about the company instead of about the choice the visitor is on that page to
 * make. The questions here are the ones asked on THAT page — on services, which
 * service; on case studies, whether the work is real; on careers, what the job
 * is actually like.
 */

declare(strict_types=1);

const PAGE_FAQS = [

    /* ---- Home ------------------------------------------------------------ */
    'home' => [
        ['q' => 'What does iThrive Software actually do?',
         'a' => 'We build software, and increasingly software with AI inside it — agents, copilots, retrieval systems — alongside the web, mobile and product engineering that has always paid the bills. The distinction that matters is that we build and then run things in production rather than delivering strategy decks and leaving.'],
        ['q' => 'Where are you based and does it matter?',
         'a' => 'Chennai and Coimbatore, with delivery teams working across Indian, European and US hours. It matters for two reasons only: cost, which is materially lower than a US or UK studio at the same engineering level, and overlap, which we arrange so you have real working hours with the people building your product rather than a handover note.'],
        ['q' => 'How do engagements usually start?',
         'a' => 'With a scoping conversation, then a short paid discovery for anything substantial. Discovery produces a scope, an architecture and a real estimate, and it is the single best predictor of whether a project lands on time. Projects that skip it are the ones that turn into change requests.'],
        ['q' => 'What does a typical project cost?',
         'a' => 'It ranges too widely for a number here to be honest — a website is weeks and an ERP is a year. What we can commit to is that you get a written estimate with the assumptions visible before you commit, and that we will tell you when your budget and your scope do not meet.'],
        ['q' => 'Do we own the code?',
         'a' => 'Entirely, including the models, prompts and infrastructure definitions, in your own repository from the first commit rather than handed over at the end. We keep no rights to what we build for you and nothing is locked to a platform only we can operate.'],
        ['q' => 'Do you only take AI projects now?',
         'a' => 'No, and we will talk you out of AI where it does not help. A substantial share of what we ship is ordinary well-built software, and some of the best engagements start with someone asking for an AI feature and leaving with a fixed data pipeline that solved the actual problem.'],
        ['q' => 'How long does it take to see something working?',
         'a' => 'Weeks, not quarters, and deliberately so. We aim to have something running that you can use early, because an opinion formed against a working product is worth more than any amount of agreement on a specification. A first usable version in four to six weeks is a normal shape for a product build.'],
        ['q' => 'What happens after launch?',
         'a' => 'Whatever you want to happen. Some clients take the code and run it with their own team, which we support with documentation and handover; others keep us on a monthly arrangement for changes and operations. We are not structured to require the second, and a handover is a legitimate ending.'],
        ['q' => 'How do you handle our data?',
         'a' => 'Minimally, and under your terms. Development runs on anonymised or synthetic data wherever it can, production data stays in your tenancy, and access is scoped and logged. We sign whatever your legal team requires before anything sensitive is shared.'],
        ['q' => 'What if the project is not a good fit for you?',
         'a' => 'We say so in the first conversation and point you elsewhere where we can. The projects that go badly are almost always the ones someone took knowing it was a stretch, and a fortnight of scoping time is cheaper for both of us than six months of the wrong team.'],
    ],

    /* ---- Services hub ---------------------------------------------------- */
    'services' => [
        ['q' => 'There are a lot of services here. Where should I start?',
         'a' => 'From the problem, not the service name. If you know what you want built, go to the service that names it. If you know something is inefficient but not what to do about it, start with AI Consulting or a discovery conversation — picking a service before diagnosing the problem is how organisations buy the wrong build.'],
        ['q' => 'What is the difference between an AI agent, a copilot and automation?',
         'a' => 'Autonomy and who initiates. Automation runs a fixed sequence you defined. A copilot sits beside a person and suggests, while the person decides. An agent decides and acts within boundaries you set. Cost and risk rise across that order, so the right answer is usually the least autonomous option that solves the problem.'],
        ['q' => 'Do I need AI at all?',
         'a' => 'Often not, and we would rather establish that early. If the process is deterministic, rules are cheaper, faster and auditable. AI earns its place where inputs are messy, language is involved, or the rules have too many exceptions to enumerate. A rules engine that works beats a model that mostly works.'],
        ['q' => 'Can you work with our existing systems rather than replacing them?',
         'a' => 'That is the usual case. Most of what we build integrates with an ERP, a CRM or a warehouse that is staying exactly where it is. Replacement projects are expensive, risky and rarely necessary, and a vendor whose first proposal is a rebuild is solving for their convenience.'],
        ['q' => 'How do you price — fixed or time and materials?',
         'a' => 'Fixed where scope is genuinely knowable, such as a discovery, a website or a defined integration. Time and materials for product development, where fixing the scope means fixing the wrong scope early. We will tell you which one your project is and why, rather than defaulting to whichever suits us.'],
        ['q' => 'Do you provide a team or a project?',
         'a' => 'Both, and they suit different situations. A project is right when the outcome is defined and you want it delivered. A dedicated team is right when the roadmap is yours, changes often, and you need capacity that accumulates context. Buying a project when you need a team produces endless change requests.'],
        ['q' => 'What technologies do you work in?',
         'a' => 'Python, TypeScript, Go and Java on the server; React, Next.js and Flutter on the client; Postgres, vector stores and the usual cloud platforms underneath. For AI we are deliberately model-agnostic and benchmark against your tasks, because naming a single model in a proposal ages badly.'],
        ['q' => 'How quickly can you start?',
         'a' => 'Usually within two to three weeks for a new engagement, faster for a scoping or discovery phase. We would rather tell you a real start date than take a project immediately and staff it with whoever is free, which is the standard way an agency disappoints a client in month two.'],
        ['q' => 'Do you work with startups or only established companies?',
         'a' => 'Both, and the work differs. A startup needs the smallest thing that proves the idea, built to be thrown away if it fails. An established business needs something that fits existing systems and survives audit. Applying the wrong one of those two postures is the most common scoping mistake we see.'],
        ['q' => 'What if we are not sure which service we need?',
         'a' => 'Describe the problem and we will tell you, including when the answer is that you need nobody. The first conversation is not a sales call with a scope attached; it is an attempt to work out whether there is a project here worth doing at all.'],
    ],

    /* ---- Solutions hub ---------------------------------------------------- */
    'solutions' => [
        ['q' => 'What is the difference between a solution and a service here?',
         'a' => 'A solution is a product we already built and configure for you; a service is a team building something new. The products get you running in weeks with a known cost; a service gets you exactly what you need and takes longer. If a product covers eighty percent of your requirement, take the product.'],
        ['q' => 'Can we try one before committing?',
         'a' => 'Yes — a scoped pilot on your own data, because a demonstration on ours proves nothing about yours. The pilot is where you find out whether your data is in the shape the product assumes, which is the real risk in any product implementation.'],
        ['q' => 'What if the product covers most of what we need but not all?',
         'a' => 'We extend it, and that is the common case. Products are built with the extension points that matter — connectors, rules, workflows — and bespoke work on top is quoted separately. Where the gap is more than a third of your requirement, a build is usually the better value.'],
        ['q' => 'How are they priced?',
         'a' => 'A platform fee plus usage, with the usage component modelled against your real volume before you commit. We give a ceiling. Products priced per seat regardless of activity tend to be bought broadly and used narrowly, which is a bad outcome for both sides.'],
        ['q' => 'Where does our data go?',
         'a' => 'Into your own tenancy or a single-tenant instance in a region you choose. We do not pool customer data across clients and we do not train on it. Anything that must reach a model provider is minimised and recorded so you can evidence exactly what left.'],
        ['q' => 'How long does implementation take?',
         'a' => 'Weeks rather than months, and the variable is almost never the software. It is how clean your identifiers are and how quickly your organisation can agree on definitions. A company that already knows what it means by "active customer" implements fast.'],
        ['q' => 'Do they integrate with our existing stack?',
         'a' => 'Yes, through documented connectors for common platforms and APIs for everything else. If a system you depend on has no interface at all, say so early — that is the one situation where a product implementation genuinely stalls.'],
        ['q' => 'What support comes with them?',
         'a' => 'Onboarding, a named contact and an agreed response commitment, with the depth set by what you are running. We would rather agree a realistic response time than promise an hour on paper and miss it.'],
        ['q' => 'Can we leave and take our data with us?',
         'a' => 'Yes, in a structured export, and the contract says so. A product you cannot exit is a product you should not enter, and being asked this question is entirely reasonable.'],
        ['q' => 'What if we want the product but run it ourselves?',
         'a' => 'Possible for most deployments, and sensible where your compliance position demands it. It changes the commercial shape and puts operational responsibility on your team, so it is worth being certain you want that before choosing it.'],
    ],

    /* ---- Case studies hub -------------------------------------------------- */
    'case-studies' => [
        ['q' => 'Are these real projects?',
         'a' => 'Yes, all of them, with named clients. Where a figure appears it came from the client\'s own measurement, and where we could not publish something — commercial terms, internal metrics — it is simply absent rather than approximated. An unnamed case study with a round percentage is worth nothing and we do not publish them.'],
        ['q' => 'Why are there no numbers on some of them?',
         'a' => 'Because we did not have permission to publish them, or because the honest measurement does not exist. A small business website rarely has a clean before-and-after, and inventing one would be the easy option. The absence of a figure is more informative than a fabricated one.'],
        ['q' => 'Can I speak to any of these clients?',
         'a' => 'For serious engagements, yes — we will arrange a reference call with a client in a comparable sector where they are willing. We ask rather than volunteer them, because a client who is tired of taking reference calls stops being a good reference.'],
        ['q' => 'Do you have a case study in my industry?',
         'a' => 'Possibly, and it may not matter as much as you think. Domain familiarity helps with vocabulary and regulation; it matters far less than whether we have built the shape of thing you need. A dispatch engine is a dispatch engine whether it moves taxis or service engineers.'],
        ['q' => 'How long did these projects take?',
         'a' => 'From a few weeks for a marketing site to most of a year for an ERP, and each study states its own shape. Timelines on this page are real elapsed time including the client\'s decision-making, not the idealised engineering estimate.'],
        ['q' => 'What did they cost?',
         'a' => 'Not published, because commercial terms are the client\'s business and because a number without its scope misleads. We will give you a realistic range for your own project in the first conversation, which is more use than someone else\'s invoice.'],
        ['q' => 'Are these projects still running?',
         'a' => 'Most are, several with us still involved. That is the more meaningful signal than launch: software that is still in use two years later survived contact with a real operation, which is a harder test than shipping.'],
        ['q' => 'Do you only work with Indian clients?',
         'a' => 'No — the work spans India and international clients, including export and cross-border businesses. Delivery is arranged around the client\'s working hours rather than ours.'],
        ['q' => 'What do these projects have in common?',
         'a' => 'Someone had a manual process they had stopped noticing. Almost every study here began with a person describing something tedious they did every day rather than with a technology request, and that is still the best starting point for a conversation with us.'],
        ['q' => 'How do I get a project like one of these started?',
         'a' => 'Describe the problem in whatever detail you have. You do not need a specification, a budget or a technology preference to have a useful first conversation — you need to be able to describe what is going wrong and who it affects.'],
    ],

    /* ---- Blog -------------------------------------------------------------- */
    'blog' => [
        ['q' => 'Who writes these?',
         'a' => 'The people doing the work, edited rather than ghostwritten. That is why they are specific and occasionally inconvenient — an engineer who spent a fortnight on a problem writes about what actually happened, which is more useful and less promotional than a marketing summary of the same topic.'],
        ['q' => 'How often do you publish?',
         'a' => 'When there is something worth saying, which is less often than a content calendar would demand. We would rather publish one piece a month that someone finds genuinely useful than four that exist to hit a schedule.'],
        ['q' => 'Is any of this AI-generated?',
         'a' => 'The writing is ours. We use models as we would any tool — drafting, checking, summarising — but a piece published under our name reflects what we actually think and has been through a person who is accountable for it. Generated filler is the reason most company blogs are unread.'],
        ['q' => 'Can I use what I read here in my own work?',
         'a' => 'Please do. Technical posts are written to be acted on, and the approaches described are not proprietary. A link back is appreciated if you quote at length, and we would rather you implemented something yourself than hired us to do it badly.'],
        ['q' => 'Do you take guest posts?',
         'a' => 'No. It is the fastest way for a blog to become a link farm, and a pitch offering a guest article on our own subject area is almost always about somebody else\'s backlinks.'],
        ['q' => 'Can I ask a question about something you wrote?',
         'a' => 'Yes, through the contact page, and it is not a sales trigger. A question about a technical post gets a technical answer from whoever wrote it. Some of our better engagements started that way, but plenty of those conversations end with a useful answer and nothing more.'],
        ['q' => 'Do you cover topics on request?',
         'a' => 'Sometimes, when a question comes up often enough that writing it down once is more useful than answering it repeatedly. Several posts here exist because three separate clients asked the same thing in a month.'],
        ['q' => 'Is the advice specific to Indian businesses?',
         'a' => 'Some of it is — payments, compliance and market conditions are local, and we mark those clearly. The engineering posts are not: an evaluation harness or a retrieval design works the same wherever it runs.'],
        ['q' => 'Why are some posts critical of things you sell?',
         'a' => 'Because the alternative is not being trusted about anything. If agents are the wrong choice for a category of problem, saying so is what makes it worth reading when we say they are the right choice for another. A blog that endorses everything the company sells is an advertisement.'],
        ['q' => 'Can I subscribe?',
         'a' => 'You can follow the site or reach us through the contact page to be notified. We do not run a high-frequency newsletter, mostly because we would not have enough to say in it to justify the interruption.'],
    ],

    /* ---- Contact ------------------------------------------------------------ */
    'contact' => [
        ['q' => 'How quickly will someone reply?',
         'a' => 'Within one working day for anything that describes a real project, usually sooner. If it is urgent, call — a form is the wrong channel for something that needs an answer this afternoon, and we would rather you rang than waited.'],
        ['q' => 'Who actually replies?',
         'a' => 'Someone who can talk about the work, not a scheduler whose job is to book a call for someone else. The first reply should be useful in itself, and if your question has a short answer you should get the short answer rather than a calendar link.'],
        ['q' => 'What should I include to get a useful first response?',
         'a' => 'What is going wrong, who it affects, and roughly when you need it solved. Budget and technology preference help but are not required. You do not need a specification — most good projects start from a description of a problem, not a document.'],
        ['q' => 'Is the first conversation free?',
         'a' => 'Yes, including a reasonably detailed one about approach and feasibility. Paid work starts at discovery, where we produce a scope, an architecture and a real estimate. Nothing before that is chargeable and nothing before that is committed.'],
        ['q' => 'Will I get a sales sequence if I enquire?',
         'a' => 'No. You will get a reply, and a follow-up if we said we would send something. If the answer is that there is no project here, the conversation ends there rather than becoming a mailing list entry.'],
        ['q' => 'Can we sign an NDA before talking?',
         'a' => 'Yes, send yours over or we will provide one. It is a normal request and it takes a day. For a first conversation about whether a problem is tractable, one is rarely needed, but we will not argue about it.'],
        ['q' => 'Do you work with clients outside India?',
         'a' => 'Regularly, across European and US time zones, with working-hours overlap arranged rather than assumed. Contracting, invoicing and data-residency arrangements for international clients are routine.'],
        ['q' => 'What if I just want technical advice, not a project?',
         'a' => 'Ask. A specific question usually gets a specific answer, and we would rather be the people who gave you a straight answer in March than not hear from you at all. Where it needs real work to answer properly, we will say that too.'],
        ['q' => 'Can I visit your office?',
         'a' => 'Yes, in Chennai or Coimbatore, by arrangement. For a substantial engagement we would encourage it — meeting the team that will actually build the thing tells you more than any proposal document.'],
        ['q' => 'What happens to the information I send?',
         'a' => 'It reaches the people who need to answer it and nowhere else. We do not sell or share enquiry data, and if you ask us to delete it we will.'],
    ],

    /* ---- Company: About ------------------------------------------------------ */
    'about' => [
        ['q' => 'How long has iThrive Software been operating?',
         'a' => 'Long enough to have projects still running years after launch, which is the measure that matters more than a founding date. Several of the systems in our case studies have been in daily use since delivery, and a few have been maintained through more than one change of platform underneath them.'],
        ['q' => 'How big is the team?',
         'a' => 'Deliberately mid-sized: large enough to staff a real project with senior people, small enough that the person you meet is involved in your work. The size we are not trying to be is the one where a good pitch team hands you to whoever was free.'],
        ['q' => 'Where are you located?',
         'a' => 'Chennai and Coimbatore, with delivery to clients in India, Europe and the US. Both are real offices with teams in them rather than registered addresses, and you are welcome to visit either.'],
        ['q' => 'What kind of work do you turn down?',
         'a' => 'Projects where the technology is not the problem, timelines that would require us to skip the parts that make software survivable, and anything where we would be the wrong team and know it. We also decline AI work where a simpler system would serve better and the client is not open to hearing it.'],
        ['q' => 'What is your approach to AI, honestly?',
         'a' => 'Sceptical and practical. We build a lot of it and we talk clients out of a fair amount of it. The useful applications are narrow, well-evaluated and boring in the right way; the projects that fail are the ones that started from the technology rather than from a process that was actually broken.'],
        ['q' => 'Who owns the code you write?',
         'a' => 'You do, in your repository from the first commit, including models, prompts and infrastructure definitions. We retain no rights and build nothing that only we can operate.'],
        ['q' => 'What happens if we want to move to another vendor?',
         'a' => 'You can, and we will help with the handover. Everything is in your repository in standard technologies with documentation written for a successor team. A client who cannot leave is a client kept by friction, which is not a business we want.'],
        ['q' => 'How do you handle confidentiality?',
         'a' => 'NDAs as a matter of course, access scoped to who needs it, development on anonymised or synthetic data where possible, and nothing published without written permission. Some of our best work is not on this site for exactly that reason.'],
        ['q' => 'Do you work with agencies as a delivery partner?',
         'a' => 'Yes, under white label where that is what the relationship needs. It works when the agency owns the client relationship and we own delivery, with both sides clear about which is which.'],
        ['q' => 'What should we expect working with you?',
         'a' => 'Direct access to the people building your product, a working version early rather than a long silence, and an opinion when we think you are about to make an expensive mistake. That last one is the part clients say they value and occasionally find uncomfortable in the moment.'],
    ],

    /* ---- Company: Careers ----------------------------------------------------- */
    'careers' => [
        ['q' => 'What roles do you usually hire for?',
         'a' => 'Backend and full-stack engineers, AI and ML engineers, mobile developers, designers and delivery leads. Openings come and go, and we would rather hear from a strong engineer when nothing is posted than post a role we are not ready to fill.'],
        ['q' => 'Do you hire freshers?',
         'a' => 'Selectively, and with real mentoring rather than a title and a backlog. We take fewer juniors than a body-shop would because supporting someone properly costs senior time, and hiring more than we can teach helps nobody.'],
        ['q' => 'What does the interview process look like?',
         'a' => 'A conversation, a practical exercise close to real work, and a technical discussion with the people you would work with. No competitive-programming puzzles unrelated to the job, and no unpaid multi-week take-home. If an exercise is substantial, we pay for it.'],
        ['q' => 'Is the work remote, hybrid or in office?',
         'a' => 'Mostly hybrid, anchored on the Chennai and Coimbatore offices, and it varies by team and project. Some client engagements need more in-person time than others, and we would rather be specific with you during the process than advertise a policy we bend.'],
        ['q' => 'What will I actually be working on?',
         'a' => 'Client products, in production, with users. That is the honest appeal and the honest limitation: the work is real and shipping rather than research, and you will see the consequences of your decisions, which is the fastest way to become good.'],
        ['q' => 'Will I get to work on AI projects?',
         'a' => 'Very likely, though probably not exclusively. Most AI work here sits inside an ordinary product, so the job involves retrieval, evaluation and cost control alongside the normal engineering. Anyone hoping to train foundation models would be in the wrong place.'],
        ['q' => 'How do you handle learning and progression?',
         'a' => 'Through the work, code review and time to go deep on the thing you are building, rather than a course allowance nobody claims. Progression here is mostly about scope — owning more of a system and more of the decisions about it.'],
        ['q' => 'What is the team culture like?',
         'a' => 'Direct and low-ceremony. Code review is frank, decisions are argued about, and "I do not know" is an acceptable and frequently used sentence. If you want an environment where nobody questions your design, this would be uncomfortable.'],
        ['q' => 'How long does hiring take?',
         'a' => 'Usually a couple of weeks from first conversation to decision. If it will take longer, we say so rather than leaving you waiting — being left without an answer is the most common complaint candidates have about any company, and it is entirely avoidable.'],
        ['q' => 'Can I apply when there is no open role?',
         'a' => 'Yes, and it is often the better time. Send something you have built along with what you want to work on. Speculative applications with real work attached get read properly; generic ones attached to a keyword-matched CV mostly do not.'],
    ],

    /* ---- Company: Process ------------------------------------------------------ */
    'process' => [
        ['q' => 'Why does the process start with a paid discovery?',
         'a' => 'Because a free estimate is a guess and both sides pay for it later. Discovery produces a scope, an architecture, the risks and a real number, and it is the single best predictor of whether a project lands. If you go ahead with us, its cost is credited against the build.'],
        ['q' => 'How long does discovery take?',
         'a' => 'One to three weeks for most projects, longer where several systems or business units are in scope. It ends with a document your own engineers can critique, which is the point — an estimate nobody can argue with is an estimate nobody has checked.'],
        ['q' => 'Do you work in sprints?',
         'a' => 'Two-week cycles with something demonstrable at the end of each, without the ceremony overhead. What matters is not the framework name but that you see working software fortnightly and can change direction on that evidence.'],
        ['q' => 'How involved do we need to be?',
         'a' => 'A few hours a week from someone empowered to decide. That is the real constraint on most projects — not engineering capacity but a decision waiting on a person who is in meetings. A nominated owner who can answer within a day is worth more to your timeline than an extra developer.'],
        ['q' => 'What happens when the scope changes?',
         'a' => 'It gets priced and scheduled rather than absorbed silently. Scope change is normal and usually correct — you learn things once the software exists. What is not normal is a change queue that quietly consumes the timeline while everyone pretends the original date still holds.'],
        ['q' => 'How do you handle testing and quality?',
         'a' => 'Automated tests on the parts where a regression is expensive, review on everything, and a staging environment that matches production closely enough to be meaningful. We do not claim exhaustive coverage; we claim the coverage is where the risk is.'],
        ['q' => 'What does deployment look like?',
         'a' => 'Infrastructure as code, a pipeline that builds and deploys on merge, and a path back. A deployment you cannot reverse within minutes is the real problem, not the deployment frequency — being able to undo is what makes shipping often safe.'],
        ['q' => 'What happens after launch?',
         'a' => 'A defined warranty period, then either a support arrangement or a handover to your team. We would rather agree the ending at the start than have it arrive as a surprise, because a vague post-launch relationship is where most client frustration comes from.'],
        ['q' => 'How do you keep us informed?',
         'a' => 'A weekly written update, direct access to the team, and the board you can look at yourself. We do not run a status meeting whose purpose is producing a status, and you should never have to ask what happened last week.'],
        ['q' => 'What if the project is going badly?',
         'a' => 'You hear it from us before you work it out. That is the single commitment that matters most in this process and the one most often broken across the industry: a slipping project is recoverable when it is raised in week four, and usually not when it is raised in week fourteen.'],
    ],

    /* ---- ReactJS Development ---------------------------------------------------- */
    'reactjs-development' => [
        ['q' => 'When is React the right choice?',
         'a' => 'When the interface has genuine state — dashboards, editors, multi-step flows, anything a user works inside rather than reads. For a marketing site or a content page it is frequently the wrong tool, and a server-rendered or static site will be faster and cheaper to run.'],
        ['q' => 'React or Next.js?',
         'a' => 'Next.js for anything public-facing that needs to be found, because server rendering and routing come built in and SEO on a purely client-rendered app is a fight you do not need. Plain React remains right for an application behind a login, where crawlability is irrelevant and a build step is simpler.'],
        ['q' => 'Can you improve an existing React application rather than rebuild it?',
         'a' => 'Usually yes, and usually we should. Most React codebases we are asked to rebuild have three real problems — state management sprawl, a bundle nobody has looked at, and no tests — and each is fixable in place. A rebuild restarts the bug count from zero and that is rarely a bargain.'],
        ['q' => 'How do you handle state management?',
         'a' => 'With the smallest thing that works: local state first, then context, then a server-state library for anything that comes from an API, and a global store only where genuinely shared client state exists. Most state bugs come from data that lives in a store when it should have been a cached server query.'],
        ['q' => 'What about performance on low-end Android devices?',
         'a' => 'It is designed for rather than tested at the end, because that is the device most Indian users actually have. Budgeting the bundle, splitting routes, avoiding heavy dependencies for small jobs, and measuring on a real mid-range phone instead of a developer laptop is most of the work.'],
        ['q' => 'Do you write tests?',
         'a' => 'Yes, weighted to where failure is expensive: business logic, form validation, anything touching money or permissions. We do not chase a coverage percentage, because a suite that tests whether a heading renders gives confidence without providing it.'],
        ['q' => 'How do you handle accessibility?',
         'a' => 'Semantic markup, keyboard operation and focus management as part of building rather than an audit afterwards. Retrofitting accessibility into a React app built entirely from divs and click handlers costs several times what doing it correctly the first time does.'],
        ['q' => 'Can you integrate with our existing backend?',
         'a' => 'Yes — REST, GraphQL or whatever you have, including an older system with an unusual interface. Where the API is awkward we would rather put a thin layer in front of it than have every component work around its quirks individually.'],
        ['q' => 'How long does a React project take?',
         'a' => 'Four to eight weeks for a substantial application interface, less for a contained feature. The variable is almost never React — it is how settled the design is and how many exceptions the business logic has.'],
        ['q' => 'Will we be able to maintain it?',
         'a' => 'That is an explicit goal. Conventional structure, current stable versions, documented decisions and no clever abstractions that only their author understands. If your team cannot read the codebase, we built the wrong thing however well it runs.'],
    ],
];
