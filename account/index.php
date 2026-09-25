<?php
require_once __DIR__.'/../includes/config.php';
$noindex=true;
$page=['slug'=>'account','title'=>'Client Portal Preview | INCORPSYS','description'=>'Preview of the planned INCORPSYS client portal.'];
$modules=[['file-text','My enquiries','Track enquiries and replies from the team.'],['banknote','Quotes','Review quotes with official fee sources shown separately.'],['briefcase-business','Applications','Follow each filing with its authority and status.'],['file-check-2','Documents','Exchange documents through a secure channel.'],['banknote','Payments','Invoices and payment records.'],['message-circle','Messages','One conversation thread with your INCORPSYS contact.'],['list-checks','Setup progress','Step-by-step progress for your company setup.'],['clock-4','Renewals','Upcoming licence renewals and recurring filings.'],['circle-help','Support','Help with your account and services.']];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Client portal preview','Your INCORPSYS workspace','This is a preview of the planned client portal. None of these features are live yet, and no account data is shown.',[['name'=>'Home','slug'=>''],['name'=>'Client portal','slug'=>'account']],'<span class="badge badge-soon">Preview — not yet available</span>')?>
<section class="content-body"><div class="container">
  <div class="dash">
    <ul class="dash-nav" aria-label="Portal sections (preview)"><li class="is-current">Dashboard</li><?php foreach($modules as $m):?><li><?=e($m[1])?><span class="badge badge-soon">Soon</span></li><?php endforeach;?></ul>
    <div class="dash-main">
      <h2 class="h3">Dashboard</h2><p class="muted mt-2">When the portal launches, this page will summarise your active work.</p>
      <div class="grid grid-3 mt-6"><?php foreach($modules as $m):?><div class="card card-compact card-subtle"><span class="card-icon"><?=icon($m[0])?></span><h3 class="h4"><?=e($m[1])?></h3><p class="small"><?=e($m[2])?></p><span class="badge badge-soon mt-4">Not yet available</span></div><?php endforeach;?></div>
    </div>
  </div>
  <div class="cluster mt-8"><a class="btn btn-primary" href="/get-started/">Start an enquiry<?=icon('arrow-right')?></a><a class="btn btn-secondary" href="/contact/">Contact the team</a></div>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
