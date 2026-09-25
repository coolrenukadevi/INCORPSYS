<?php
// Per-server settings. Copy this file to includes/secrets.php on the server and fill in the values.
// includes/ is blocked from the web by .htaccess; secrets.php is ignored by git.
const FORM_SECRET = 'replace-with-a-long-random-string';   // signs enquiry-form tokens
const GA_MEASUREMENT_ID = '';                               // e.g. 'G-XXXXXXXXXX'; empty = Google Analytics off
