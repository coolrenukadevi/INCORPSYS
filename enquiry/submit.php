<?php
declare(strict_types=1);
require_once __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /'); exit; }

function enquiry_response(int $status, string $heading, string $text): never {
    http_response_code($status);
    $noindex = true;
    $page = ['slug' => 'enquiry', 'title' => $heading . ' | INCORPSYS', 'description' => 'INCORPSYS enquiry.'];
    include __DIR__ . '/../partials/header.php';
    echo '<main id="main"><section class="section"><div class="container"><article class="article"><div class="eyebrow">INCORPSYS ENQUIRY</div><h1>' . e($heading) . '</h1><p>' . e($text) . '</p>'
        . '<p>You can also reach us at <a href="mailto:' . e(SITE_EMAIL) . '">' . e(SITE_EMAIL) . '</a>, <a href="' . e(tel_url()) . '">' . e(SITE_PHONE) . '</a> or <a href="' . e(wa_url()) . '" target="_blank" rel="noopener">WhatsApp</a>.</p>'
        . '<p><a class="btn primary" href="/">Return to INCORPSYS</a></p></article></div></section></main>';
    include __DIR__ . '/../partials/footer.php';
    exit;
}
// UTF-8 safe truncation without requiring the mbstring extension.
function cut(string $v, int $max): string { return preg_match('/^.{0,' . $max . '}/us', $v, $m) ? $m[0] : substr($v, 0, $max); }
// Single-line fields must not carry line breaks or control characters.
function clean_line(string $v, int $max): string { return cut(trim((string)preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $v)), $max); }

$name = clean_line((string)($_POST['name'] ?? ''), 120);
$email = clean_line((string)($_POST['email'] ?? ''), 190);
$phone = clean_line((string)($_POST['phone'] ?? ''), 40);
$jurisdiction = clean_line((string)($_POST['jurisdiction'] ?? ''), 80);
$message = cut(trim((string)($_POST['message'] ?? '')), 4000);

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

if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    enquiry_response(422, 'Please check your enquiry', 'Please go back and provide your name, a valid email address and a short description of what you need.');
}

$recent[] = time();
@file_put_contents($rateFile, implode("\n", $recent), LOCK_EX);

$subject = 'INCORPSYS Website Enquiry' . ($jurisdiction !== '' ? ' - ' . $jurisdiction : '');
$body = "Name: $name\nEmail: $email\nPhone: $phone\nJurisdiction: $jurisdiction\n\n$message";
$headers = "From: INCORPSYS Website <" . MAIL_FROM . ">\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
// -f sets the envelope sender so SPF/DKIM for incorpsys.com can align. Production should use authenticated SMTP or a CRM webhook.
$sent = @mail(SITE_EMAIL, $subject, $body, $headers, '-f' . MAIL_FROM);

if ($sent) {
    enquiry_response(200, 'Thank you, ' . $name . '.', 'Your enquiry has been sent to the INCORPSYS team. We will reply to ' . $email . '.');
}
enquiry_response(503, 'Enquiry not delivered', 'Sorry, ' . $name . ', our mail service could not send your enquiry just now. Please contact us directly so we do not miss your request.');
