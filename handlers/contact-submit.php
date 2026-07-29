<?php
/**
 * Contact form handler.
 *
 * Validates, appends the enquiry to a newline-delimited JSON log under
 * storage/, and redirects back with a flash message. Wire an SMTP send in
 * `deliver()` when the production mail credentials exist — the log is the
 * source of truth either way, so nothing is lost if mail fails.
 */

declare(strict_types=1);

require_once dirname(__DIR__) . '/includes/config.php';

$back = static function (string $target): never {
    header('Location: ' . $target, true, 303);
    exit;
};

// Every outcome lands on /contact, which is the only page that renders the
// flash banner — the form is also in a site-wide modal, so redirecting "back"
// would leave a modal submission with no visible confirmation.
$redirect = url('contact.php') . '#main';

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    $back($redirect);
}

if (!csrf_verify($_POST['csrf_token'] ?? null)) {
    flash_set('errors', ['message' => 'Your session expired. Please send that once more.']);
    $back($redirect);
}

// Honeypot: a real person never fills a field positioned off-screen. Report
// success so a bot has nothing to learn from the response.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    flash_set('sent', true);
    $back($redirect);
}

$field = static fn (string $key): string => trim((string) ($_POST[$key] ?? ''));

$data = [
    'name'    => $field('name'),
    'email'   => $field('email'),
    'company' => $field('company'),
    'phone'   => $field('phone'),
    'service' => $field('service'),
    'budget'  => $field('budget'),
    'message' => $field('message'),
];

$errors = [];

if ($data['name'] === '') {
    $errors['name'] = 'Please tell us your name.';
} elseif (mb_strlen($data['name']) > 120) {
    $errors['name'] = 'That name is longer than we can store.';
}

if ($data['email'] === '') {
    $errors['email'] = 'We need an email address to reply to.';
} elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'That does not look like a valid email address.';
}

if ($data['message'] === '') {
    $errors['message'] = 'Tell us a little about what you are building.';
} elseif (mb_strlen($data['message']) < 20) {
    $errors['message'] = 'A sentence or two more would help us give you a useful answer.';
} elseif (mb_strlen($data['message']) > 6000) {
    $errors['message'] = 'That is longer than the form accepts — email it to us instead.';
}

if ($errors) {
    flash_set('errors', $errors);
    flash_set('old', $data);
    $back($redirect);
}

// ---- Persist -------------------------------------------------------------

$record = $data + [
    'received_at' => gmdate('c'),
    'ip'          => (string) ($_SERVER['REMOTE_ADDR'] ?? ''),
    'user_agent'  => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 300),
];

if (!is_dir(STORAGE_PATH)) {
    @mkdir(STORAGE_PATH, 0775, true);
}

$logFile = STORAGE_PATH . '/enquiries.ndjson';
$line    = json_encode($record, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;

// LOCK_EX is what we want against concurrent submissions, but not every stream
// supports it — the php-wasm dev server rejects it outright, and so do some
// network filesystems. Fall back to an unlocked append rather than losing the
// enquiry, and remember whether anything was actually written.
$stored = @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
if ($stored === false) {
    $stored = @file_put_contents($logFile, $line, FILE_APPEND);
}

// ---- Notify --------------------------------------------------------------

$subject = 'New project brief — ' . ($data['company'] !== '' ? $data['company'] : $data['name']);
$body    = "New enquiry via the Ithrive website\n\n"
    . "Name:    {$data['name']}\n"
    . "Email:   {$data['email']}\n"
    . "Company: {$data['company']}\n"
    . "Phone:   {$data['phone']}\n"
    . "Service: {$data['service']}\n"
    . "Budget:  {$data['budget']}\n\n"
    . "{$data['message']}\n";

// mail() is unavailable in plenty of environments. That is survivable on its
// own, because the enquiry is in the log — but if the log write ALSO failed we
// have nothing, and telling the sender "received" would be a lie.
$mailed = function_exists('mail') && @mail(SITE_EMAIL, $subject, $body, [
    'From'     => 'Ithrive Website <no-reply@ithrivesoftware.com>',
    'Reply-To' => $data['email'],
]);

if ($stored === false && !$mailed) {
    error_log('Ithrive: enquiry from ' . $data['email'] . ' could not be stored or mailed.');
    flash_set('errors', ['message' => 'We could not record that — please email ' . SITE_EMAIL . ' directly and we will pick it up from there.']);
    flash_set('old', $data);
    $back($redirect);
}

flash_set('sent', true);
$back($redirect);
