<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'legal','title'=>'Legal & Support | INCORPSYS','description'=>'INCORPSYS policies and support in one place: privacy, data, payments, refunds, cancellations, hiring, cookies, terms and grievance redressal.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Legal & Support','slug'=>'legal']];
$pages=site_data();
$groups=[
  'Privacy and data'=>[['legal/privacy','shield-check'],['legal/data-policy','lock'],['legal/cookies','info']],
  'Payments and engagements'=>[['legal/payment-policy','banknote'],['legal/refund-policy','banknote'],['legal/cancellation-policy','x']],
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
  <div class="alert alert-info mt-10"><?=icon('info')?><div><strong>Policies under review</strong>These policies are drafts pending legal review. Questions about any policy: <a href="/contact/">contact us</a>.</div></div>
</div></section>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('legal'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?php include __DIR__.'/../partials/footer.php';?>
