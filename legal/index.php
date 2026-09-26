<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'legal','title'=>'Legal & Support | INCORPSYS','description'=>'INCORPSYS policies and support in one place: privacy, data, payments, refunds, cancellations, service terms, filing quality, hiring, cookies, terms and grievance redressal.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Legal & Support','slug'=>'legal']];
$pages=site_data();
$faqs=[['q'=>'When do these policies take effect?','a'=>'The published policies are effective from '.fmt_date(POLICIES_EFFECTIVE_DATE).'. Any highlighted details are being finalised and will be added to the relevant policy.'],['q'=>'How do I raise a complaint?','a'=>'Use the Grievance Redressal process, which explains who handles complaints and how they are escalated.'],['q'=>'Where are the terms for INCORPSYS services?','a'=>'In the Service Terms and your quotation or service order. The Filing Quality Commitment explains how we prepare and check filings.']];
$groups=[
  'Privacy and data'=>[['legal/privacy','shield-check'],['legal/data-policy','lock'],['legal/cookies','info']],
  'Payments and engagements'=>[['legal/payment-policy','banknote'],['legal/refund-policy','banknote'],['legal/cancellation-policy','x']],
  'Services'=>[['legal/service-terms','briefcase-business'],['legal/filing-quality-commitment','badge-check']],
  'Website and people'=>[['legal/terms','file-text'],['legal/disclaimer','triangle-alert'],['legal/hiring-policy','user-round']],
];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Legal & Support','Legal & Support','Our policies, how to get help, and how to raise a concern.',$crumbs)?>
<section class="content-body"><div class="container">
  <div class="grid grid-2">
    <a class="card card-link" href="/support/"><span class="card-icon"><?=icon('circle-help')?></span><h2 class="h3">Support</h2><p>Start an enquiry, get help as an existing client, find answers or report an error.</p></a>
    <a class="card card-link" href="/legal/grievance-redressal/"><span class="card-icon"><?=icon('scale')?></span><h2 class="h3">Grievance Redressal</h2><p>How to raise a complaint, who handles it and how it is escalated.</p></a>
  </div>
  <?php foreach($groups as $g=>$items):?>
  <h2 class="mt-10"><?=e($g)?></h2>
  <div class="grid grid-3 mt-6"><?php foreach($items as [$s,$ic]): if(!isset($pages[$s])) continue; $p=$pages[$s];?><a class="card card-link" href="<?=e(path_url($s))?>"><span class="card-icon"><?=icon($ic)?></span><h3><?=e($p['name'])?></h3><p><?=e($p['description'])?></p></a><?php endforeach;?></div>
  <?php endforeach;?>
  <div class="alert alert-info mt-10"><?=icon('info')?><div><strong>Effective <?=e(fmt_date(POLICIES_EFFECTIVE_DATE))?></strong>INCORPSYS is operated by <?=e(LEGAL_ENTITY_NAME)?>. Questions about any policy: <a href="/contact/">contact us</a>.</div></div>
<div class="container-narrow mt-10"><?=faq_accordion($faqs)?></div>
</div></section>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('legal'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?=json_ld(faq_schema($faqs))?>
<?php include __DIR__.'/../partials/footer.php';?>
