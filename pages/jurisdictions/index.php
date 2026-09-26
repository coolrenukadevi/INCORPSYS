<?php
require_once __DIR__.'/../../includes/config.php';
$reg=site_registry();$pages=site_data();
$page=['slug'=>'jurisdictions','title'=>'Compare Company Setup Jurisdictions | INCORPSYS','description'=>'Compare company setup in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia: authorities, filing routes, officers, registered office, tax, visa and compliance, with sources.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Compare jurisdictions','slug'=>'jurisdictions']];
$faqs=[
  ['q'=>'Which jurisdiction is best for my company?','a'=>'There is no single best jurisdiction. The right choice depends on where you will operate and sell, your activity and any licences it needs, who will own and run the company, visa needs, banking and tax. Start from your business objective, then check each shortlisted jurisdiction\'s official rules.'],
  ['q'=>'Why do some cells say "Not yet verified"?','a'=>'We only show a value when it comes from the authority\'s published guidance. Where we have not verified a figure — especially fees and processing times — we mark it for verification instead of estimating.'],
  ['q'=>'Can I compare fees here?','a'=>'Not yet. Government fees change and differ by structure, activity and route. We show a fee only with its official source and the date it was checked.'],
];
include __DIR__.'/../../partials/header.php';?>
<main id="main">
<?=page_hero('Compare jurisdictions','Compare company setup across jurisdictions','What each authority publishes about filing routes, officers, registered office, tax, visas and compliance — side by side, with the source behind every value.',$crumbs)?>
<section class="content-body"><div class="container">
  <?=answer_block('Choose a jurisdiction by your business objective first — where you will operate, sell and hire — then compare each shortlisted country\'s official rules for structure, officers, licensing, visas and banking. This table summarises what each authority publishes; it does not rank jurisdictions.')?>
  <div class="mt-8"><?=compare_table('jurisdictions',null,true)?></div>
  <p class="small muted mt-4">Each value links to the guide that cites the official source and its verification date. "Not yet verified" means we have not yet confirmed that value from the authority — we leave it open rather than estimate.</p>
</div></section>
<section class="section-tight section-subtle"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Jurisdiction guides</p><h2>Official authority for each country</h2></div><p>Open a country guide for its setup path and in-depth guides.</p></div>
  <div class="grid grid-3"><?php foreach($reg['sources']+$reg['pending'] as $k=>$s): $pend=isset($reg['pending'][$k]); $s['url']=$s['url']??$s['links'][0]['url']; $s['note']=$s['note']??'Guide in preparation. Enquire and we will confirm the current official requirements for your case.';?><div class="card"><h3><a href="<?=e(path_url($k))?>"><?=e($s['label'])?></a></h3><p class="small"><?=e($s['authority'])?></p><p><?=e($s['note'])?></p><div class="cluster mt-4"><a class="link-arrow" href="<?=e(path_url($k))?>">Country guide<?=icon('arrow-right')?></a><a class="link-arrow" href="<?=e($s['url'])?>" target="_blank" rel="noopener noreferrer">Official source<?=icon('external-link')?></a></div></div><?php endforeach;?></div>
</div></section>
<section class="section-tight"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Structures</p><h2>Company, branch, subsidiary or representative office</h2></div><p>General concepts; verify the local rules before choosing.</p></div>
  <?=compare_table('structures')?>
</div></section>
<section class="section-tight"><div class="container-narrow">
  <div class="card card-subtle"><h2 class="h3">How to choose</h2><p>Use our framework to weigh market access, activity rules, ownership, people, banking and tax — without assuming one jurisdiction fits every business.</p><div class="cluster mt-4"><a class="btn btn-secondary" href="/resources/choose-jurisdiction-framework/">Jurisdiction framework</a><a class="btn btn-ghost" href="/resources/jurisdiction-faq/">Jurisdiction FAQ</a></div></div>
  <div class="mt-10"><?=faq_accordion($faqs)?></div>
</div></section>
<?=cta_band('','','Not sure which jurisdiction fits?')?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'WebPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('jurisdictions'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs),'mainEntity'=>jurisdiction_item_list()])?>
<?=json_ld(faq_schema($faqs))?>
<?php include __DIR__.'/../../partials/footer.php';?>
