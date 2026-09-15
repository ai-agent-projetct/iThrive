/**
 * Applies the page-one pattern to the other fifteen AI service pages.
 *
 *     node tools/wire-service-pages.mjs          # patch
 *     node tools/wire-service-pages.mjs --check  # report only, change nothing
 *
 * All sixteen pages share a structure — a six-card discipline grid, a five-card
 * benefits grid, a five-phase steps grid and a flat pill list for the stack — so
 * the wiring is mechanical and belongs in a script rather than in sixteen
 * near-identical hand edits.
 *
 * It adds, per page:
 *   - six image slots in section 3 and five in section 5
 *   - a 3D roadmap host plus three image slots in section 6
 *   - the interactive tech-stack component in place of the pill list
 *
 * Every image slot goes through svc_img(), which returns null until the file
 * exists, so a page is complete and correct before any picture is generated.
 *
 * The script is idempotent: a page already carrying the markers is skipped, so
 * it can be re-run after new pages are added without doubling anything.
 */

import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const ROOT = path.resolve(fileURLToPath(new URL('..', import.meta.url)));
const CHECK = process.argv.includes('--check');

/**
 * Per page: [number, slug, three stack groups].
 *
 * Only logos that actually exist in assets/img/tech are listed. A tile whose
 * svg is missing renders without an image and reads as a mistake, so the stack
 * names a real equivalent rather than a product we have no mark for.
 */
const G = (slug, title, icon, blurb, items) => ({ slug, title, icon, blurb, items });
const T = (name, logo) => ({ name, logo });

const PAGES = [
  ['02', 'gen-ai-development', [
    G('models', 'Models & Frameworks', 'brain', 'What the generation runs on, and the harness around it.',
      [T('PyTorch','pytorch'), T('OpenAI','openai'), T('Anthropic','anthropic'), T('TensorFlow','tensorflow'), T('LangChain','langchain'), T('Python','python')]),
    G('data', 'Grounding & Data', 'database', 'The corpus a generated answer is checked against.',
      [T('PostgreSQL','postgresql'), T('OpenSearch','opensearch'), T('Redis','redis'), T('pandas','pandas')]),
    G('platform', 'Platform & Operations', 'cloud', 'Where it runs and what proves it still works.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('AWS','amazonwebservices'), T('Grafana','grafana')])]],

  ['03', 'ai-chatbot-development', [
    G('models', 'Models & Retrieval', 'brain', 'What answers, and what it answers from.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('Python','python')]),
    G('channels', 'Channels & Interface', 'message', 'Web, in-app and messaging, off one backend.',
      [T('FastAPI','fastapi'), T('Node.js','nodedotjs'), T('React','react'), T('TypeScript','typescript')]),
    G('platform', 'Platform & Operations', 'cloud', 'Session state, deployment and the metrics that matter.',
      [T('Redis','redis'), T('PostgreSQL','postgresql'), T('Docker','docker'), T('Grafana','grafana')])]],

  ['04', 'ai-copilot-development', [
    G('surface', 'Product Surface', 'monitor', 'The screen the copilot lives inside.',
      [T('React','react'), T('TypeScript','typescript'), T('Next.js','nextdotjs'), T('Tailwind','tailwindcss')]),
    G('models', 'Models & Context', 'brain', 'What it suggests, grounded in what the user is looking at.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('Python','python')]),
    G('platform', 'Services & Operations', 'cloud', 'The API behind the panel, and its cost per seat.',
      [T('FastAPI','fastapi'), T('PostgreSQL','postgresql'), T('Redis','redis'), T('Docker','docker')])]],

  ['05', 'rag-development', [
    G('retrieval', 'Retrieval & Index', 'search', 'Hybrid search over your own corpus, reranked.',
      [T('OpenSearch','opensearch'), T('PostgreSQL','postgresql'), T('pandas','pandas'), T('Python','python')]),
    G('models', 'Models & Embeddings', 'brain', 'What reads the passage once it has been found.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('PyTorch','pytorch')]),
    G('platform', 'Pipelines & Operations', 'cloud', 'Ingestion on a schedule, and re-indexing on change.',
      [T('FastAPI','fastapi'), T('Celery','celery'), T('Redis','redis'), T('Docker','docker')])]],

  ['06', 'computer-vision-development', [
    G('vision', 'Vision & Training', 'search', 'Detection, classification and the training loop behind them.',
      [T('PyTorch','pytorch'), T('TensorFlow','tensorflow'), T('scikit-learn','scikitlearn'), T('Python','python')]),
    G('data', 'Data & Labelling', 'database', 'The labelled set, drawn from your own cameras.',
      [T('pandas','pandas'), T('PostgreSQL','postgresql'), T('OpenSearch','opensearch'), T('Redis','redis')]),
    G('platform', 'Edge & Operations', 'cloud', 'Inference next to the camera, monitored centrally.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('Google Cloud','googlecloud'), T('Grafana','grafana')])]],

  ['07', 'agentic-ai-strategy', [
    G('analysis', 'Measurement & Analysis', 'bar-chart', 'Timing the process before proposing to automate it.',
      [T('Python','python'), T('pandas','pandas'), T('scikit-learn','scikitlearn'), T('PostgreSQL','postgresql')]),
    G('models', 'Models & Evaluation', 'brain', 'Benchmarked on your tasks, not on a public leaderboard.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('PyTorch','pytorch')]),
    G('platform', 'Target Platform', 'cloud', 'Where the recommendation would actually be deployed.',
      [T('Docker','docker'), T('AWS','amazonwebservices'), T('Azure','azure'), T('Grafana','grafana')])]],

  ['08', 'custom-agent-development', [
    G('agents', 'Agent Runtime', 'bot', 'Tools, state and the loop that decides the next step.',
      [T('LangChain','langchain'), T('OpenAI','openai'), T('Anthropic','anthropic'), T('Python','python')]),
    G('services', 'Services & State', 'database', 'What the agent calls, and what it remembers.',
      [T('FastAPI','fastapi'), T('Celery','celery'), T('Redis','redis'), T('PostgreSQL','postgresql')]),
    G('platform', 'Platform & Operations', 'cloud', 'Deployment, traces and a costed run.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('Terraform','terraform'), T('Grafana','grafana')])]],

  ['09', 'ai-agent-solutions', [
    G('agents', 'Archetype Runtime', 'rocket', 'The proven agent, configured against your systems.',
      [T('LangChain','langchain'), T('OpenAI','openai'), T('Anthropic','anthropic'), T('Python','python')]),
    G('data', 'Your Data', 'database', 'Pointed at your records, your terminology, your thresholds.',
      [T('PostgreSQL','postgresql'), T('Redis','redis'), T('OpenSearch','opensearch'), T('MongoDB','mongodb')]),
    G('platform', 'Deployment', 'cloud', 'Live in days because the build is already done.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('AWS','amazonwebservices'), T('Grafana','grafana')])]],

  ['10', 'multi-agent-orchestration', [
    G('orchestration', 'Orchestration', 'network', 'The state machine that owns a run, and can halt it.',
      [T('LangChain','langchain'), T('Python','python'), T('Celery','celery'), T('Airflow','apacheairflow')]),
    G('models', 'Models per Role', 'brain', 'A different model per role where that earns its cost.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('PyTorch','pytorch'), T('TensorFlow','tensorflow')]),
    G('platform', 'Runtime & Traces', 'cloud', 'Replayable runs, because the system is not deterministic.',
      [T('Kubernetes','kubernetes'), T('Docker','docker'), T('Redis','redis'), T('Grafana','grafana')])]],

  ['11', 'agentic-ai-integration', [
    G('integration', 'Contract Layer', 'workflow', 'One typed surface in front of every system.',
      [T('FastAPI','fastapi'), T('Node.js','nodedotjs'), T('GraphQL','graphql'), T('Python','python')]),
    G('systems', 'Systems of Record', 'database', 'The ERP, CRM and databases the agent reaches.',
      [T('PostgreSQL','postgresql'), T('MySQL','mysql'), T('MongoDB','mongodb'), T('Redis','redis')]),
    G('platform', 'Delivery & Operations', 'cloud', 'Scoped credentials, idempotent writes, a full trail.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('Terraform','terraform'), T('GitHub Actions','githubactions')])]],

  ['12', 'ai-integration', [
    G('gateway', 'Gateway & Serving', 'layers', 'One route every AI call passes through.',
      [T('FastAPI','fastapi'), T('Node.js','nodedotjs'), T('GraphQL','graphql'), T('Python','python')]),
    G('data', 'Pipelines', 'database', 'Turning operational records into something a model can use.',
      [T('Airflow','apacheairflow'), T('dbt','dbt'), T('PostgreSQL','postgresql'), T('OpenSearch','opensearch')]),
    G('platform', 'Platform & Cost', 'cloud', 'Quotas, attribution and a bill you can read.',
      [T('Kubernetes','kubernetes'), T('Docker','docker'), T('Terraform','terraform'), T('Grafana','grafana')])]],

  ['13', 'autonomous-workflow-automation', [
    G('workflow', 'Workflow Engine', 'workflow', 'Intake to resolution, with people on the exceptions.',
      [T('Python','python'), T('Celery','celery'), T('Airflow','apacheairflow'), T('FastAPI','fastapi')]),
    G('models', 'Decisioning', 'brain', 'The judgement step, bounded by rules kept in version control.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('scikit-learn','scikitlearn')]),
    G('platform', 'State & Reporting', 'cloud', 'Case state, throughput and the exception queue.',
      [T('PostgreSQL','postgresql'), T('Redis','redis'), T('Docker','docker'), T('Grafana','grafana')])]],

  ['14', 'agent-operations-support', [
    G('observability', 'Observability', 'gauge', 'What tells you accuracy slipped before a customer does.',
      [T('Grafana','grafana'), T('OpenSearch','opensearch'), T('Python','python'), T('PostgreSQL','postgresql')]),
    G('models', 'Models & Evaluation', 'brain', 'The golden set, re-run on every upstream change.',
      [T('OpenAI','openai'), T('Anthropic','anthropic'), T('LangChain','langchain'), T('PyTorch','pytorch')]),
    G('platform', 'Release & Rollback', 'cloud', 'A defined stop and a tested way back.',
      [T('Kubernetes','kubernetes'), T('Docker','docker'), T('Terraform','terraform'), T('GitHub Actions','githubactions')])]],

  ['15', 'rpa-development', [
    G('automation', 'Automation Runtime', 'cpu', 'Driving systems that were never given an API.',
      [T('Python','python'), T('Celery','celery'), T('Node.js','nodedotjs'), T('FastAPI','fastapi')]),
    G('systems', 'Target Systems', 'database', 'The ERPs, portals and databases the robots work against.',
      [T('PostgreSQL','postgresql'), T('MySQL','mysql'), T('MongoDB','mongodb'), T('Redis','redis')]),
    G('platform', 'Scheduling & Operations', 'cloud', 'Queues, retries and an auditable run history.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('Jenkins','jenkins'), T('GitHub Actions','githubactions')])]],

  ['16', 'hire-agentic-ai-developers', [
    G('languages', 'Languages', 'code', 'What our engineers write in your repository.',
      [T('Python','python'), T('TypeScript','typescript'), T('Go','go'), T('Java','openjdk')]),
    G('ai', 'AI Specialisms', 'brain', 'Retrieval, orchestration, evaluation and inference cost.',
      [T('LangChain','langchain'), T('OpenAI','openai'), T('Anthropic','anthropic'), T('PyTorch','pytorch')]),
    G('platform', 'Delivery', 'cloud', 'Your pipeline, your review process, your accounts.',
      [T('Docker','docker'), T('Kubernetes','kubernetes'), T('PostgreSQL','postgresql'), T('GitHub Actions','githubactions')])]],
];

const NL = '\r\n';
const J = (...a) => a.join(NL);

function stackPhp(groups) {
  const out = ['$pageStack = ['];
  for (const g of groups) {
    out.push(`    ['slug' => '${g.slug}', 'title' => '${g.title}', 'icon' => '${g.icon}',`);
    out.push(`     'blurb' => '${g.blurb.replace(/'/g, "\\'")}',`);
    out.push("     'items' => [");
    for (const it of g.items) out.push(`         ['name' => '${it.name}', 'logo' => '${it.logo}'],`);
    out.push('     ]],');
  }
  out.push('];');
  return out.join(NL);
}

let patched = 0, skipped = 0, failed = [];

for (const [num, slug, groups] of PAGES) {
  const file = path.join(ROOT, 'services', `${slug}.php`);
  if (!fs.existsSync(file)) { failed.push(`${slug}: missing`); continue; }
  let s = fs.readFileSync(file, 'utf8');

  if (s.includes('svc_img(')) { skipped++; console.log(`skip  ${slug} (already wired)`); continue; }

  const before = s;

  // --- section 3 ---------------------------------------------------------
  s = s.replace(
    J('        <?php foreach ($disciplines as [$num, $dTitle, $dDesc]): ?>',
      '          <article class="svc-card">'),
    J('        <?php foreach ($disciplines as $i => [$num, $dTitle, $dDesc]): ?>',
      `          <?php $fig = svc_img('${num}', 3, $i + 1); ?>`,
      '          <article class="svc-card<?= $fig ? \' svc-card--figured\' : \'\' ?>">',
      '            <?php if ($fig): ?>',
      '              <figure class="svc-card-fig">',
      '                <img src="<?= e($fig) ?>" width="800" height="450" alt=""',
      '                     loading="lazy" decoding="async">',
      '              </figure>',
      '            <?php endif; ?>'));

  // --- section 5 ---------------------------------------------------------
  s = s.replace(
    J('        <?php foreach ($benefits as [$num, $bTitle, $bDesc]): ?>',
      '          <div class="svc-benefit-card">'),
    J('        <?php foreach ($benefits as $i => [$num, $bTitle, $bDesc]): ?>',
      `          <?php $fig = svc_img('${num}', 5, $i + 1); ?>`,
      '          <div class="svc-benefit-card<?= $fig ? \' svc-benefit-card--figured\' : \'\' ?>">',
      '            <?php if ($fig): ?>',
      '              <figure class="svc-card-fig">',
      '                <img src="<?= e($fig) ?>" width="800" height="450" alt=""',
      '                     loading="lazy" decoding="async">',
      '              </figure>',
      '            <?php endif; ?>'));

  // --- section 6: roadmap + three stills ---------------------------------
  s = s.replace(
    '      <div class="svc-steps-grid">',
    J('      <?php $GLOBALS[\'ithrive_needs_roadmap\'] = true; ?>',
      '      <div class="svc-roadmap" data-roadmap aria-hidden="true">',
      '        <?php foreach ($steps as $idx => [$num, $sTitle]): ?>',
      '          <span data-roadmap-node="<?= $idx ?>" data-label="<?= e($sTitle) ?>"></span>',
      '        <?php endforeach; ?>',
      '      </div>',
      '',
      '      <?php',
      `      $s6 = array_filter([svc_img('${num}', 6, 1), svc_img('${num}', 6, 2), svc_img('${num}', 6, 3)]);`,
      '      ?>',
      '      <?php if ($s6): ?>',
      '        <div class="svc-s6-strip">',
      '          <?php foreach ($s6 as $src): ?>',
      '            <figure><img src="<?= e($src) ?>" width="800" height="450" alt=""',
      '                         loading="lazy" decoding="async"></figure>',
      '          <?php endforeach; ?>',
      '        </div>',
      '      <?php endif; ?>',
      '',
      '      <div class="svc-steps-grid">'));

  s = s.replace('          <div class="svc-step-card">',
                '          <div class="svc-step-card" data-roadmap-step="<?= $idx ?>">');

  // --- tech stack --------------------------------------------------------
  s = s.replace(
    J('      <ul class="svc-stack-pills">',
      '        <?php foreach ($techStack as $tech): ?>',
      '          <li><?= e($tech) ?></li>',
      '        <?php endforeach; ?>',
      '      </ul>'),
    "      <?php component('tech-stack', ['groups' => $pageStack]); ?>");

  // the stack data, dropped in beside the existing $techStack line
  s = s.replace(/^(\$techStack = \[[^\]]*\];)/m, `$1${NL}${NL}${stackPhp(groups)}`);

  const checks = [
    ['section 3', s.includes(`svc_img('${num}', 3,`)],
    ['section 5', s.includes(`svc_img('${num}', 5,`)],
    ['section 6', s.includes(`svc_img('${num}', 6,`)],
    ['roadmap',   s.includes('data-roadmap')],
    ['stack',     s.includes("component('tech-stack'")],
    ['stackData', s.includes('$pageStack = [')],
  ];
  const missing = checks.filter(([, ok]) => !ok).map(([n]) => n);

  if (missing.length) { failed.push(`${slug}: ${missing.join(', ')}`); continue; }
  if (s === before)   { failed.push(`${slug}: no change`); continue; }

  if (!CHECK) fs.writeFileSync(file, s, 'utf8');
  patched++;
  console.log(`${CHECK ? 'would patch' : 'patched'}  ${slug}`);
}

console.log(`\n${patched} patched, ${skipped} skipped, ${failed.length} failed`);
if (failed.length) { console.log('FAILED:'); failed.forEach((f) => console.log('  ' + f)); process.exitCode = 1; }
