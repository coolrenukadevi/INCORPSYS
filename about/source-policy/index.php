<?php
require_once __DIR__.'/../../includes/config.php';
$page=['slug'=>'about/source-policy','h1'=>'Source policy','title'=>'Source Policy | INCORPSYS','description'=>'Which sources INCORPSYS accepts for regulatory facts, how each fact is recorded, and how unverified information is handled.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about'],['name'=>'Source policy','slug'=>'about/source-policy']];
$eyebrow='Source policy';$lead='Legal and regulatory statements on INCORPSYS come from official sources. This page explains which sources qualify and how we record them.';
ob_start();?>
<h2>Accepted sources for regulatory facts</h2>
<ol><li><strong>Legislation and official authority guidance</strong> — companies registries, licensing authorities, tax authorities and immigration authorities (for example ACRA, the Hong Kong Companies Registry, Companies House and GOV.UK, the U.S. Small Business Administration, the UAE Government portal and SSM).</li><li><strong>Official portals, fee schedules and FAQs</strong> published by those authorities.</li><li><strong>Official free-zone and emirate authority pages</strong> for UAE free-zone and emirate-specific rules.</li></ol>
<p>Blogs, provider articles, forums and search snippets are never used as the primary source for a legal, fee, tax, visa or timing statement.</p>
<h2>How each fact is recorded</h2>
<p>For every source-backed statement we keep:</p>
<ul><li>the statement itself;</li><li>the authority and the page it comes from, with its URL;</li><li>the date it was verified;</li><li>the jurisdiction it applies to; and</li><li>any notes on scope, such as "applies to private companies".</li></ul>
<h2>Unverified information</h2>
<p>If a value cannot be confirmed from an official source, it is omitted or clearly marked <strong>Verify</strong>. It is never filled with an estimate to complete a table or page.</p>
<h2>Fees and prices</h2>
<p>A government fee is shown only with its amount, currency, source, URL and verification date. Fees older than our review window are hidden automatically until they are re-checked. INCORPSYS service fees are quoted separately and are never presented as government charges.</p>
<h2>Freshness</h2>
<p>Official pages change without notice. Treat every "Sources checked" date as the point at which our summary was accurate, and re-check the authority immediately before filing or payment. <a href="/resources/source-freshness/">Read more about source freshness</a>.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../../partials/simple-page.php';
