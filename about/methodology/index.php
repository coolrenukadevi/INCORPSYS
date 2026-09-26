<?php
require_once __DIR__.'/../../includes/config.php';
$page=['slug'=>'about/methodology','h1'=>'How INCORPSYS builds its guides','title'=>'Methodology | INCORPSYS','description'=>'How INCORPSYS researches, writes, verifies and updates its company incorporation guides, and what it will not publish.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about'],['name'=>'Methodology','slug'=>'about/methodology']];
$eyebrow='Methodology';$lead='Every guide follows the same method: start from the authority, summarise only what it publishes, link to it, and record when it was checked.';
$faqs=[['q'=>'What does "Sources checked" mean?','a'=>'It is the date the jurisdiction\'s official pages were last checked for our guides. Official pages change, so it tells you how recent our reading is.'],['q'=>'What does "Not yet verified" mean?','a'=>'The value has not been confirmed from the authority, so we do not estimate it. Check the authority\'s current guidance or ask us to confirm it for your case.'],['q'=>'Is an INCORPSYS guide a substitute for the official source?','a'=>'No. Guides summarise the official page and link to it; the authority\'s own guidance is the final reference.']];
ob_start();?>
<h2>1. Start from the controlling authority</h2>
<p>For each step in a company setup — registration, naming, licensing, tax, immigration — we first identify the authority that controls it: the companies registry, licensing body, tax authority or immigration authority for that jurisdiction. That authority's own guidance is the starting point and the final reference.</p>
<h2>2. Summarise, then link</h2>
<p>Guides open with a direct answer, then explain the step, list what to check, and link to the official page they are based on. The link is part of the guide, not an afterthought: you should be able to confirm any statement yourself.</p>
<h2>3. Record the verification date</h2>
<p>Each jurisdiction's source library carries the date its official pages were last checked. That date is shown on the guides as "Sources checked". Official pages change, so the date tells you how recent our reading is.</p>
<h2>4. Mark what is not verified</h2>
<p>Where a value — a fee, a processing time, a threshold — has not been confirmed from the authority, we do not estimate it. Comparison tables show <strong>Not yet verified</strong>, and cost sections direct you to the authority's current fee schedule.</p>
<h2>5. What we will not publish</h2>
<ul><li>Government fees, tax rates or processing times that the authority has not published, or that we have not verified.</li><li>Approval, visa, licensing or bank-account guarantees.</li><li>Testimonials, client counts, awards, rankings or affiliations that cannot be substantiated.</li><li>Third-party articles presented as law.</li></ul>
<h2>6. Updates and corrections</h2>
<p>We re-check sources when authorities announce changes and when readers report a discrepancy. If you find an error, email <a href="mailto:<?=e(SITE_EMAIL)?>"><?=e(SITE_EMAIL)?></a> with the page and the official source, and we will review it.</p>
<h2>7. Not legal advice</h2>
<p>Our guides are general information. They are not legal, tax or immigration advice and do not replace the competent authority or a qualified professional in the relevant jurisdiction.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../../partials/simple-page.php';
