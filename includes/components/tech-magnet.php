<?php
/**
 * Always Building, Always Growing — the stack that follows the cursor.
 *
 * The same section as the one on the Mobile App Development page, brought over
 * so the home page carries it too. The motion is that component's, ported to
 * assets/js/tech-magnet.js; this file supplies the list and the frame.
 *
 * The technologies go out as JSON on the element, each already carrying the URL
 * of its icon, so the script never has to work out a base path and the list has
 * exactly one home. The same list is also written out as real text, hidden but
 * present — fifty logos painted into a canvas are fifty things a crawler and a
 * screen reader cannot see, and this is the page that claims the stack.
 */

declare(strict_types=1);

/**
 * Every stack we ship with, and the colour each mark is drawn in.
 *
 * Copied from the React component so the two sections cannot drift; the hexes
 * are each project's own brand colour, because a Simple Icons path ships with
 * no fill and would otherwise rasterise black on a black plate.
 */
$stack = [
    ['flutter', '#54C5F8'], ['react', '#61DAFB'], ['swift', '#F05138'], ['kotlin', '#A97BFF'],
    ['typescript', '#3178C6'], ['nodedotjs', '#5FA04E'], ['python', '#FFD845'], ['firebase', '#FFCA28'],
    ['graphql', '#E10098'], ['postgresql', '#4169E1'], ['mongodb', '#47A248'], ['redis', '#FF4438'],
    ['docker', '#2496ED'], ['stripe', '#635BFF'], ['tailwindcss', '#38BDF8'], ['amazonwebservices', '#FF9900'],
    ['kubernetes', '#326CE5'], ['django', '#44B78B'], ['fastapi', '#009688'], ['nextdotjs', '#FFFFFF'],
    ['vuedotjs', '#4FC08D'], ['angular', '#DD0031'], ['php', '#777BB4'], ['laravel', '#FF2D20'],
    ['mysql', '#00758F'], ['googlecloud', '#4285F4'], ['azure', '#0078D4'], ['terraform', '#844FBA'],
    ['githubactions', '#2088FF'], ['jenkins', '#D33833'], ['grafana', '#F46800'], ['express', '#FFFFFF'],
    ['tensorflow', '#FF6F00'], ['pytorch', '#EE4C2C'], ['openai', '#FFFFFF'], ['langchain', '#FFFFFF'],
    ['pandas', '#E70488'], ['scikitlearn', '#F7931E'], ['celery', '#37814A'], ['apacheairflow', '#017CEE'],
    ['dbt', '#FF694B'], ['opensearch', '#005EB8'], ['shopify', '#7AB55C'], ['woocommerce', '#96588A'],
    ['razorpay', '#0C2451'], ['upi', '#5F259F'], ['vite', '#646CFF'], ['threedotjs', '#FFFFFF'],
    ['openjdk', '#FFFFFF'], ['dotnet', '#512BD4'],
];

// A name with no icon on disk would draw an empty plate, so it is dropped here
// rather than left as a hole in the chain.
$magnet = [];
foreach ($stack as [$name, $colour]) {
    if (is_file(ROOT_PATH . '/assets/img/tech/' . $name . '.svg')) {
        $magnet[] = [$name, $colour, asset('assets/img/tech/' . $name . '.svg')];
    }
}
?>
<section class="section tmagnet" id="tech-magnet">
  <div class="shell">

    <?php /* Not section-head: the heading is two-tone, and that component
             escapes its title, as it should. */ ?>
    <div class="tmagnet-head">
      <p class="eyebrow" data-reveal>Our Stack</p>
      <h2 class="section-title" data-reveal style="--d:1">
        Always Building, <span class="tmagnet-accent">Always Growing.</span>
      </h2>
      <p class="section-lead" data-reveal style="--d:2">
        Fifty technologies in active use across the work. Move your cursor through
        them and the stack follows; click to let it settle back.
      </p>
    </div>

    <div class="tmagnet-stage" data-tech-magnet aria-hidden="true"
         data-stack='<?= e(json_encode($magnet, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) ?>'></div>

    <?php /* The real list, for anyone without canvas and for search engines. */ ?>
    <ul class="sr-only">
      <?php foreach ($magnet as [$name]): ?><li><?= e($name) ?></li><?php endforeach; ?>
    </ul>

  </div>
</section>
