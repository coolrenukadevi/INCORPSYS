<?php
// Jurisdiction in preparation: no published regulatory guidance yet. Included by _hub_template.php with $hub and $pend set.
$noindex=true;
$label=$pend['label'];$pages=site_data();
$page=['slug'=>$hub,'title'=>'Company Formation in '.$label.' | INCORPSYS','description'=>'INCORPSYS is preparing source-verified guidance for company formation in '.$label.'. Enquire now and our team will confirm the current official requirements for your case.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Jurisdictions','slug'=>'jurisdictions'],['name'=>$label,'slug'=>$hub]];
$first=$pend['links'][0];
$related=['resources/choose-jurisdiction-framework','resources/legal-form-decision','resources/foreign-founder-preparation','resources/documents-master-checklist','resources/licence-and-approval-mapping','resources/visa-vs-incorporation','resources/banking-readiness','resources/fee-verification'];
$steps=[
  ['Confirm the route','We identify the authority and registration route for your structure and activity.'],
  ['Check current requirements','We read the authority\'s current published rules for your case before any preparation starts.'],
  ['Prepare and coordinate','Documents are prepared against the authority\'s own list, and submissions are coordinated with you.'],
];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Jurisdiction guide · In preparation','Company formation in '.$label,'We are preparing a source-verified guide for '.$label.'. Until it is published, our team confirms the official requirements for your case directly with the authority\'s current guidance.',$crumbs,'<span class="badge badge-warning">'.icon('clock-4').'Guide in preparation</span><span class="badge">'.icon('landmark').e($pend['authority']).'</span>')?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <?=answer_block('INCORPSYS accepts enquiries for company formation in '.$label.'. We have not yet published verified guidance for this jurisdiction, so we do not state its fees, timelines, ownership rules or document lists here. Tell us about your plans and we will confirm the current official requirements for your case.')?>

    <section class="content-section" id="status"><h2>Verification status</h2>
      <?=verification_status('The '.e($label).' requirements have not yet been confirmed in the INCORPSYS source registry. This is preferable to publishing information that could be wrong. Check the authority directly, or ask us to confirm the rules for your structure and activity.',$first)?>
    </section>

    <section class="content-section" id="authorities"><h2>Official starting points</h2>
      <p>These are the authorities we will verify first for <?=e($label)?>. Other authorities can be involved for licensing, tax and immigration depending on the activity.</p>
      <ul class="source-list"><?php foreach($pend['links'] as $l):?><li><a href="<?=e($l['url'])?>" target="_blank" rel="noopener noreferrer"><?=e($l['title'])?><?=icon('external-link')?><span class="visually-hidden"> (opens official site)</span></a></li><?php endforeach;?></ul>
      <p class="small muted">Links to official home pages. INCORPSYS has not yet checked these pages for company-formation requirements.</p>
    </section>

    <section class="content-section" id="how"><h2>How we work on <?=e($label)?> enquiries</h2>
      <ol class="process-list"><?php foreach($steps as [$t,$d]):?><li><h3><?=e($t)?></h3><p><?=e($d)?></p></li><?php endforeach;?></ol>
    </section>

    <section class="content-section" id="prepare"><h2>Prepare while we verify</h2>
      <p>These cross-jurisdiction guides apply wherever you incorporate and help you arrive with the right questions.</p>
      <ul class="link-list"><?php foreach($related as $s): if(!isset($pages[$s])) continue;?><li><a href="<?=e(path_url($s))?>"><?=icon('chevron-right')?><?=e($pages[$s]['name'])?></a></li><?php endforeach;?></ul>
    </section>

    <section class="content-section" id="compare"><h2>Jurisdictions with published guides</h2>
      <ul class="link-list"><?php foreach(site_registry()['sources'] as $k=>$o):?><li><a href="<?=e(path_url($k))?>"><?=icon('git-compare-arrows')?><?=e('Company formation in '.$o['label'])?></a></li><?php endforeach;?><li><a href="/jurisdictions/"><?=icon('git-compare-arrows')?>Compare jurisdictions</a></li></ul>
    </section>
  </div>
  <aside class="source-rail">
    <div class="source-card"><span class="eyebrow">Start in <?=e($label)?></span><h2 class="mt-2">Get a setup plan</h2><p>Tell us your activity, ownership and visa needs. We confirm the official route before recommending anything.</p><p class="mt-4"><a class="btn btn-cta btn-block" href="/get-started/?country=<?=e($hub)?>">Get a Setup Plan<?=icon('arrow-right')?></a></p></div>
    <?=contact_card()?>
  </aside>
</div></section>
<?=cta_band($hub,$label)?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'WebPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url($hub),'publisher'=>publisher(),'about'=>['@type'=>'Country','name'=>$label],'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?php include __DIR__.'/../partials/footer.php';
