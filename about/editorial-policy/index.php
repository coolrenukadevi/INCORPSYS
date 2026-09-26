<?php
require_once __DIR__.'/../../includes/config.php';
$page=['slug'=>'about/editorial-policy','h1'=>'Editorial policy','title'=>'Editorial Policy | INCORPSYS','description'=>'The editorial standards behind INCORPSYS guides: independence, accuracy, no invented claims, and how corrections are handled.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about'],['name'=>'Editorial policy','slug'=>'about/editorial-policy']];
$eyebrow='Editorial policy';$lead='Our guides exist to help business owners make informed decisions. These standards apply to every page on the site.';
$faqs=[['q'=>'Are INCORPSYS comparisons ranked or sponsored?','a'=>'No. Comparisons present what each authority publishes and do not declare a best jurisdiction, because the right choice depends on the business.'],['q'=>'Does INCORPSYS publish testimonials or client numbers?','a'=>'No. We do not publish invented testimonials, reviews, ratings, client numbers, awards, certifications, partnerships, offices or official affiliations.'],['q'=>'How are errors corrected?','a'=>'Report an error with the page address and the official source. Confirmed errors are corrected and the page\'s verification date is updated.']];
ob_start();?>
<h2>Useful first</h2>
<p>We publish a page only when it has a clear purpose for a business owner: a direct answer, a useful explanation, the official source and a sensible next step. We do not publish pages simply to target a search term, and we do not repeat the same text across countries with only the country name changed.</p>
<h2>Accuracy over completeness</h2>
<p>If we cannot verify something, we say so. A page that says "verify with the authority" is better than a page that guesses.</p>
<h2>No invented claims</h2>
<p>We do not publish invented testimonials, reviews, ratings, client numbers, awards, certifications, partnerships, offices or official affiliations. We do not claim search rankings or guaranteed outcomes.</p>
<h2>Independence</h2>
<p>Jurisdiction guides and comparisons are not ranked or sponsored. Comparisons present what each authority publishes; they do not declare a "best" jurisdiction, because the right choice depends on the business.</p>
<h2>Commercial transparency</h2>
<p>INCORPSYS provides paid corporate services. Service pages describe what we do and how we work; information pages explain official requirements whether or not you use our services.</p>
<h2>Corrections</h2>
<p>Report an error to <a href="mailto:<?=e(SITE_EMAIL)?>"><?=e(SITE_EMAIL)?></a> with the page address and the official source. Confirmed errors are corrected and the page's verification date is updated.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../../partials/simple-page.php';
