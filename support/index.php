<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'support','h1'=>'Support','title'=>'Support | INCORPSYS','description'=>'Get help from INCORPSYS: start a new enquiry, contact the team as an existing client, find answers in our guides, or report a correction.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Support','slug'=>'support']];
$eyebrow='Support';$lead='Find the fastest way to get help.';
ob_start();?>
<h2>Planning a new company setup</h2>
<p>Use the <a href="/get-started/">guided enquiry</a> so we can reply with the right authority, route and next steps. You can also open <strong>INCORPSYS Assist</strong> at the bottom of any page.</p>
<h2>Existing clients</h2>
<p>Contact your INCORPSYS team on WhatsApp, by phone or by email — the same channels you used during setup. The online <a href="/account/">client portal</a> is not open yet.</p>
<h2>Find an answer yourself</h2>
<ul><li><a href="/resources/company-incorporation-faq/">Company incorporation FAQ</a></li><li><a href="/jurisdictions/">Compare jurisdictions</a></li><li><a href="/resources/">Guides and checklists</a></li><li><a href="/search/">Search the site</a></li></ul>
<h2>Report an error</h2>
<p>If a guide does not match the official source, email <a href="mailto:<?=e(SITE_EMAIL)?>"><?=e(SITE_EMAIL)?></a> with the page address and the official link. See our <a href="/about/editorial-policy/">editorial policy</a>.</p>
<h2>Security</h2>
<p>INCORPSYS will never ask for passwords or payment card details by email or through website forms.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../partials/simple-page.php';
