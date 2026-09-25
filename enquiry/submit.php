<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /get-started/'); exit; }

function enquiry_response(int $status, string $heading, string $text, array $summary = [], bool $ok = false): never {
    http_response_code($status);
    $noindex = true;
    $page = ['slug' => 'enquiry', 'title' => $heading . ' | INCORPSYS', 'description' => 'INCORPSYS enquiry.'];
    include __DIR__ . '/../partials/header.php';
    echo '<main id="main"><section class="content-body"><div class="container-narrow"><div class="wizard-card">'
        . '<div class="alert ' . ($ok ? 'alert-success' : 'alert-warning') . '">' . icon($ok ? 'circle-check-big' : 'triangle-alert') . '<div><strong>' . e($heading) . '</strong>' . e($text) . '</div></div>';
    if ($summary) {
        echo '<h2 class="mt-8">Your answers</h2><dl class="summary-list mt-4">';
        foreach ($summary as $k => $v) { if ($v !== '') echo '<dt>' . e($k) . '</dt><dd>' . e($v) . '</dd>'; }
        echo '</dl>';
    }
    echo '<div class="cluster mt-8">' . ($ok ? '' : '<a class="btn btn-primary" href="/get-started/">Back to the enquiry</a>')
        . '<a class="btn btn-secondary" href="' . e(wa_url()) . '" target="_blank" rel="noopener">' . icon('message-circle') . 'WhatsApp</a>'
        . '<a class="btn btn-secondary" href="' . e(tel_url()) . '">' . icon('phone') . 'Call</a>'
        . '<a class="btn btn-ghost" href="/">Return home</a></div></div></div></section></main>';
    include __DIR__ . '/../partials/footer.php';
    exit;
}
// UTF-8 safe truncation without requiring the mbstring extension.
function cut(string $v, int $max): string { return preg_match('/^.{0,' . $max . '}/us', $v, $m) ? $m[0] : substr($v, 0, $max); }
// Single-line fields must not carry line breaks or control characters.
function clean_line(string $v, int $max): string { return cut(trim((string)preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $v)), $max); }
function pick(string $field, array $allowed): string { $v = (string)($_POST[$field] ?? ''); return isset($allowed[$v]) ? $v : ''; }

// CSRF: browsers send Origin on cross-site POSTs; reject any that is not this site.
$origin = (string)($_SERVER['HTTP_ORIGIN'] ?? '');
if ($origin !== '') {
    $host = parse_url($origin, PHP_URL_HOST);
    $sameSite = strcasecmp((string)$host, (string)parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST)) === 0 || strcasecmp((string)$host, (string)parse_url(SITE_URL, PHP_URL_HOST)) === 0;
    if ($host === null || !$sameSite) {
        enquiry_response(403, 'Enquiry not sent', 'This form can only be submitted from the INCORPSYS website.');
    }
}

// Spam checks: hidden honeypot field, signed form token, minimum fill time and token age.
[$ts, $sig] = array_pad(explode('.', (string)($_POST['token'] ?? ''), 2), 2, '');
$age = time() - (int)$ts;
$tokenOk = ctype_digit($ts) && hash_equals(hash_hmac('sha256', $ts, form_secret()), $sig);
if (($_POST['website'] ?? '') !== '' || !$tokenOk || $age < 3 || $age > 86400) {
    enquiry_response(400, 'Enquiry not sent', 'Your form session could not be verified. Please go back, reload the page and submit the form again.');
}

// Basic per-IP rate limit: at most 5 enquiries per hour.
$ip = (string)($_SERVER['REMOTE_ADDR'] ?? 'unknown');
$rateFile = sys_get_temp_dir() . '/incorpsys-enquiry-' . hash('sha256', $ip . form_secret());
$recent = array_filter(array_map('intval', is_file($rateFile) ? (array)file($rateFile, FILE_IGNORE_NEW_LINES) : []), fn($t) => $t > time() - 3600);
if (count($recent) >= 5) {
    enquiry_response(429, 'Too many enquiries', 'We have received several enquiries from your connection in the last hour. Please try again later or contact us directly.');
}

$wizard = ($_POST['form'] ?? '') === 'wizard';
$countries = array_map(fn($s) => $s['label'], site_registry()['sources']) + ['undecided' => 'Not decided yet'];
$in = [
    'name' => clean_line((string)($_POST['name'] ?? ''), 120),
    'email' => clean_line((string)($_POST['email'] ?? ''), 190),
    'phone' => clean_line((string)($_POST['phone'] ?? ''), 40),
    'company' => clean_line((string)($_POST['company'] ?? ''), 120),
    'message' => cut(trim((string)($_POST['message'] ?? '')), 4000),
    'activity_detail' => clean_line((string)($_POST['activity_detail'] ?? ''), 200),
];
foreach (['need', 'activity', 'structure', 'ownership', 'visa', 'timeline', 'contact_method'] as $f) { $in[$f] = pick($f, ENQUIRY_OPTIONS[$f]); }
$in['country'] = pick('country', $countries);
// The quick contact form sends a free-text jurisdiction; keep it as text.
$jurisdictionText = clean_line((string)($_POST['jurisdiction'] ?? ''), 80);

$errors = [];
if ($in['name'] === '') $errors[] = 'your name';
if (!filter_var($in['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'a valid email address';
if ($in['phone'] !== '' && !preg_match('/^[0-9+().\s-]{6,40}$/', $in['phone'])) $errors[] = 'a phone number using digits, spaces and + only';
if ($wizard) {
    foreach (['need' => 'what you need', 'country' => 'a jurisdiction', 'activity' => 'the business activity', 'ownership' => 'ownership', 'visa' => 'visa needs', 'timeline' => 'a timeline'] as $f => $label) { if ($in[$f] === '') $errors[] = $label; }
    if (($_POST['consent'] ?? '') !== '1') $errors[] = 'your consent to be contacted';
} elseif ($in['message'] === '') {
    $errors[] = 'a short description of what you need';
}
if ($errors) {
    enquiry_response(422, 'Please check your enquiry', 'Please go back and provide ' . implode(', ', $errors) . '.');
}

$recent[] = time();
@file_put_contents($rateFile, implode("\n", $recent), LOCK_EX);

$label = fn(string $f) => $in[$f] !== '' ? ENQUIRY_OPTIONS[$f][$in[$f]] : '';
$summary = [
    'Need' => $label('need'),
    'Jurisdiction' => $in['country'] !== '' ? $countries[$in['country']] : $jurisdictionText,
    'Activity' => trim($label('activity') . ($in['activity_detail'] !== '' ? ' — ' . $in['activity_detail'] : ''), ' —'),
    'Ownership' => $label('ownership'),
    'Structure' => $label('structure'),
    'Visa' => $label('visa'),
    'Timeline' => $label('timeline'),
    'Name' => $in['name'],
    'Email' => $in['email'],
    'Phone' => $in['phone'],
    'Company' => $in['company'],
    'Preferred contact' => $label('contact_method'),
];
// Lead qualification: priority from timeline and need; shown in the subject line for triage.
$priority = match ($in['timeline']) { 'asap', '1-3' => 'High', '3-6' => 'Medium', 'exploring' => 'Low', default => 'Unrated' };
if ($in['need'] === 'other' && $priority === 'High') $priority = 'Medium';

$subject = '[INCORPSYS][' . $priority . '] ' . ($summary['Need'] ?: 'Website enquiry') . ($summary['Jurisdiction'] !== '' ? ' - ' . $summary['Jurisdiction'] : '');
$body = "Priority: $priority\n\n";
foreach ($summary as $k => $v) { if ($v !== '') $body .= "$k: $v\n"; }
$body .= "\nMessage:\n" . ($in['message'] !== '' ? $in['message'] : '(none)') . "\n";
$headers = "From: INCORPSYS Website <" . MAIL_FROM . ">\r\nReply-To: " . $in['email'] . "\r\nContent-Type: text/plain; charset=UTF-8";
// -f sets the envelope sender so SPF/DKIM for incorpsys.com can align. Production should use authenticated SMTP or a CRM webhook.
$sent = @mail(SITE_EMAIL, $subject, $body, $headers, '-f' . MAIL_FROM);

if ($sent) {
    enquiry_response(200, 'Your enquiry is being prepared', 'Thank you, ' . $in['name'] . '. The team is reviewing your answers and will reply to ' . $in['email'] . ($label('contact_method') !== '' && $in['contact_method'] !== 'email' && $in['phone'] !== '' ? ' or by ' . strtolower($label('contact_method')) : '') . ' with the relevant route and next steps.', $summary, true);
}
enquiry_response(503, 'Enquiry not delivered', 'Sorry, ' . $in['name'] . ', our mail service could not send your enquiry just now. Please contact us directly so we do not miss your request.', $summary);
