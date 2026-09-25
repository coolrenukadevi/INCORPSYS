<?php
declare(strict_types=1);
require __DIR__ . '/../includes/config.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: /'); exit; }
$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$phone = trim((string)($_POST['phone'] ?? ''));
$jurisdiction = trim((string)($_POST['jurisdiction'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $message === '') {
    http_response_code(422);
    echo 'Please provide a valid name, email and enquiry.';
    exit;
}
$subject = 'INCORPSYS Website Enquiry';
$body = "Name: $name\nEmail: $email\nPhone: $phone\nJurisdiction: $jurisdiction\n\n$message";
$headers = "From: noreply@incorpsys.com\r\nReply-To: $email\r\nContent-Type: text/plain; charset=UTF-8";
$sent = @mail(SITE_EMAIL, $subject, $body, $headers);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title>Enquiry received | INCORPSYS</title>
</head>
<body style="font-family:Arial,sans-serif;padding:48px;max-width:720px;margin:auto">
<h1>Thank you, <?= e($name) ?>.</h1>
<p>Your enquiry has been received by the website form.</p>
<p><?php echo $sent ? 'The server handed the message to its mail system.' : 'The server mail function is not configured; please contact us directly.'; ?></p>
<p><a href="mailto:<?= e(SITE_EMAIL) ?>"><?= e(SITE_EMAIL) ?></a> · <a href="https://wa.me/<?= e(WHATSAPP_NUMBER) ?>">WhatsApp</a></p>
<p><a href="/">Return to INCORPSYS</a></p>
</body>
</html>
