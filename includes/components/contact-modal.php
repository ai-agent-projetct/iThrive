<?php
/**
 * Site-wide enquiry overlay, opened by any `[data-modal-open]` trigger.
 */

declare(strict_types=1);
?>
<div class="modal" id="projectModal" role="dialog" aria-modal="true" aria-labelledby="projectModalTitle" hidden>
  <div class="modal-panel">
    <div class="modal-head">
      <div>
        <h2 id="projectModalTitle">Start Your Project</h2>
        <p>Tell us what you are trying to build. A senior engineer reads every brief that comes through here.</p>
      </div>
      <button class="modal-close" type="button" data-modal-close aria-label="Close dialog"><?= icon('close') ?></button>
    </div>

    <?php component('contact-form', ['idPrefix' => 'modal']); ?>
  </div>
</div>
