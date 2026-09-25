<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'careers','h1'=>'Careers at INCORPSYS','title'=>'Careers | INCORPSYS','description'=>'Work with INCORPSYS on company incorporation, compliance, client support and technology for founders building businesses across six jurisdictions.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Careers','slug'=>'careers']];
$eyebrow='We\'re hiring';$lead='Help founders build their business beyond borders.';
ob_start();?>
<h2>Work with us</h2>
<p>INCORPSYS helps founders and companies set up and run businesses in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia. Our work spans company formation, licensing, compliance, client support and the technology behind our digital workflow.</p>
<h2>How we work</h2>
<ul><li>Official sources first — accuracy matters more than speed alone.</li><li>Clear, honest communication with clients.</li><li>Structured, well-documented workflows.</li></ul>
<h2>How to apply</h2>
<p>Open positions are not listed on this page. If you would like to be considered, email your CV and a short note about the role and area you are interested in to <a href="mailto:<?=e(SITE_EMAIL)?>?subject=<?=rawurlencode('Careers at INCORPSYS')?>"><?=e(SITE_EMAIL)?></a> with the subject "Careers at INCORPSYS".</p>
<p class="small">Please do not send passport copies or other identity documents at this stage. INCORPSYS never asks candidates for any fee. See our <a href="/legal/hiring-policy/">Hiring Policy</a>.</p>
<?php $body=ob_get_clean(); include __DIR__.'/../partials/simple-page.php';
