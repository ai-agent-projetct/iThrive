<?php
/**
 * The project enquiry form. Rendered both on /contact and inside the modal, so
 * every field id is namespaced by $idPrefix to keep labels unambiguous.
 *
 * @var string      $idPrefix  Unique per instance.
 * @var string|null $service   Pre-selects a service (service detail pages).
 * @var array       $old       Previously submitted values, on validation failure.
 * @var array       $errors    field => message
 */

declare(strict_types=1);

$idPrefix = $idPrefix ?? 'c';
$service  = $service  ?? null;
$old      = $old      ?? [];
$errors   = $errors   ?? [];

$value = static fn (string $key): string => (string) ($old[$key] ?? '');
$bad   = static fn (string $key): string => isset($errors[$key]) ? ' has-error' : '';

$selectedService = $value('service') !== '' ? $value('service') : (string) $service;
?>
<form class="enquiry-form" method="post" action="<?= e(url('handlers/contact-submit.php')) ?>" novalidate>
  <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">

  <div class="honeypot" aria-hidden="true">
    <label for="<?= e($idPrefix) ?>-website">Website</label>
    <input type="text" id="<?= e($idPrefix) ?>-website" name="website" tabindex="-1" autocomplete="off">
  </div>

  <div class="form-grid">
    <div class="field<?= $bad('name') ?>">
      <label for="<?= e($idPrefix) ?>-name">Your name <span class="req">*</span></label>
      <input type="text" id="<?= e($idPrefix) ?>-name" name="name" autocomplete="name"
             value="<?= e($value('name')) ?>" required>
      <?php if (isset($errors['name'])): ?><p class="field-error"><?= e($errors['name']) ?></p><?php endif; ?>
    </div>

    <div class="field<?= $bad('email') ?>">
      <label for="<?= e($idPrefix) ?>-email">Work email <span class="req">*</span></label>
      <input type="email" id="<?= e($idPrefix) ?>-email" name="email" autocomplete="email"
             value="<?= e($value('email')) ?>" required>
      <?php if (isset($errors['email'])): ?><p class="field-error"><?= e($errors['email']) ?></p><?php endif; ?>
    </div>

    <div class="field">
      <label for="<?= e($idPrefix) ?>-company">Company</label>
      <input type="text" id="<?= e($idPrefix) ?>-company" name="company" autocomplete="organization"
             value="<?= e($value('company')) ?>">
    </div>

    <div class="field">
      <label for="<?= e($idPrefix) ?>-phone">Phone</label>
      <input type="tel" id="<?= e($idPrefix) ?>-phone" name="phone" autocomplete="tel"
             value="<?= e($value('phone')) ?>">
    </div>

    <div class="field">
      <label for="<?= e($idPrefix) ?>-service">What do you need?</label>
      <select id="<?= e($idPrefix) ?>-service" name="service">
        <option value="">Select a service</option>
        <?php foreach (CONTACT_SERVICES as $option): ?>
          <option value="<?= e($option) ?>"<?= $selectedService === $option ? ' selected' : '' ?>><?= e($option) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field">
      <label for="<?= e($idPrefix) ?>-budget">Indicative budget</label>
      <select id="<?= e($idPrefix) ?>-budget" name="budget">
        <option value="">Select a range</option>
        <?php foreach (CONTACT_BUDGETS as $option): ?>
          <option value="<?= e($option) ?>"<?= $value('budget') === $option ? ' selected' : '' ?>><?= e($option) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="field field--full<?= $bad('message') ?>">
      <label for="<?= e($idPrefix) ?>-message">What are you trying to build or automate? <span class="req">*</span></label>
      <textarea id="<?= e($idPrefix) ?>-message" name="message" required
                placeholder="A paragraph is plenty — the workflow that is slowing you down, and what a good outcome looks like."><?= e($value('message')) ?></textarea>
      <?php if (isset($errors['message'])): ?><p class="field-error"><?= e($errors['message']) ?></p><?php endif; ?>
    </div>

    <div class="field field--full">
      <button class="btn btn-primary btn-block" type="submit">Send project brief<?= icon('arrow') ?></button>
      <p class="form-note">You will get a written build plan — scope, stack and timeline — within two working days. We do not share your details with anyone.</p>
    </div>
  </div>
</form>
