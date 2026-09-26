<?php
// Per-server secrets. Copy this file to includes/secrets.php on the server and fill in the values.
// includes/ is blocked from the web by .htaccess; secrets.php is ignored by git.
// Business settings (contact, legal entity, GA4 ID) live in includes/settings.php.
const FORM_SECRET = 'replace-with-a-long-random-string';   // signs enquiry-form tokens
