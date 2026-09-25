<?php
require_once __DIR__.'/../includes/config.php';
$pages=site_data();$reg=site_registry();
$hub=trim((string)($GLOBALS['PAGE_SLUG']??''),'/');

/* ---------- Resource library hub ---------- */
if($hub==='resources'){
  $page=['slug'=>'resources','title'=>'Company Incorporation Resources & Checklists | INCORPSYS','description'=>'Cross-jurisdiction guides, checklists, FAQs and glossaries for planning company incorporation, with links to each jurisdiction\'s official authority.'];
  $crumbs=[['name'=>'Home','slug'=>''],['name'=>'Resources','slug'=>'resources']];
  $items=array_filter($pages,fn($p)=>$p['kind']==='resource');
  $groups=['Plan'=>['start-company-abroad','choose-jurisdiction-framework','source-first-research','how-to-read-official-guidance','cross-border-expansion','branch-vs-subsidiary','legal-form-decision','business-activity-mapping','licence-and-approval-mapping','local-agent-concepts','foreign-founder-preparation','visa-vs-incorporation','tax-authority-handoff','banking-readiness'],
    'Checklists'=>['documents-master-checklist','startup-global-setup-checklist','company-name-checklist','registered-office-checklist','director-shareholder-prep','enquiry-preparation','service-provider-due-diligence'],
    'Verify and comply'=>['fee-verification','timeline-verification','authority-vs-provider','source-freshness','post-incorporation-calendar','compliance-evidence','document-version-control','filing-proof','official-sources-directory'],
    'FAQs and glossaries'=>['company-incorporation-faq','jurisdiction-faq','incorporation-glossary','registration-glossary','compliance-glossary']];
  include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Resource library','Company incorporation resources','Guides, checklists, FAQs and glossaries that apply across jurisdictions. Each one points you to the official authority for the country you choose.',$crumbs)?>
<section class="content-body"><div class="container">
<?php $shown=[]; foreach($groups as $g=>$slugs): $list=array_filter(array_map(fn($s)=>$pages['resources/'.$s]??null,$slugs)); if(!$list) continue;?>
  <h2 class="mt-10"><?=e($g)?></h2><div class="grid grid-3 mt-6"><?php foreach($list as $p): $shown[]=$p['slug'];?><a class="card card-link" href="<?=e(path_url($p['slug']))?>"><h3 class="h4"><?=e($p['name'])?></h3><p class="small"><?=e($p['description'])?></p></a><?php endforeach;?></div>
<?php endforeach; $rest=array_diff_key($items,array_flip($shown)); if($rest):?>
  <h2 class="mt-10">More guides</h2><div class="grid grid-3 mt-6"><?php foreach($rest as $p):?><a class="card card-link" href="<?=e(path_url($p['slug']))?>"><h3 class="h4"><?=e($p['name'])?></h3><p class="small"><?=e($p['description'])?></p></a><?php endforeach;?></div>
<?php endif;?>
</div></section>
<?=cta_band()?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('resources'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?php include __DIR__.'/../partials/footer.php';return;}

/* ---------- Jurisdiction hub ---------- */
$src=$reg['sources'][$hub]??null;
if(!$src){require __DIR__.'/../404.php';return;}
$profiles=require __DIR__.'/../content/jurisdiction-profiles.php';
$journeys=require __DIR__.'/../content/journeys.php';
$services=require __DIR__.'/../content/services.php';
$pr=$profiles[$hub];$label=$src['label'];$auth=$src['authority'];$verified=$src['verified']??null;
$short=['uae'=>'UAE Government','singapore'=>'ACRA','hong-kong'=>'Companies Registry','uk'=>'GOV.UK','usa'=>'SBA','malaysia'=>'SSM'][$hub]??$auth;
$page=['slug'=>$hub,'title'=>'Company Formation in '.$label.' | INCORPSYS','description'=>'Company formation in '.$label.': structures, requirements, documents, registration steps and licensing, sourced from '.$short.' guidance.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>$label,'slug'=>$hub]];
$facts=function(array $slugs) use($pages){ $h='<ul class="fact-list">'; $n=0; foreach($slugs as $s){ if(!isset($pages[$s])) continue; $n++; $h.='<li><p>'.e($pages[$s]['answer']).'</p><a class="link-arrow small" href="'.e(path_url($s)).'">'.e($pages[$s]['name']).icon('arrow-right').'</a></li>'; } return $n?$h.'</ul>':''; };
$pending=fn(string $topic,array $links=[])=>'<div class="alert alert-warning">'.icon('triangle-alert').'<div><strong>Pending verification</strong>We have not yet verified '.e($topic).' for '.e($label).' from an official source. Check with the competent authority, or ask us to confirm it for your case.'.($links?' See also: '.implode(', ',array_map(fn($s)=>isset($pages[$s])?'<a href="'.e(path_url($s)).'">'.e($pages[$s]['name']).'</a>':'',$links)).'.':'').'</div></div>';
$sections=[
  'overview'=>'Overview','who'=>'Who can register','structures'=>'Available business structures',
  'zones'=>'Mainland, free zone and offshore','requirements'=>'Requirements','documents'=>'Documents',
  'process'=>'Registration process','authorities'=>'Government authorities','licensing'=>'Licensing',
  'banking'=>'Banking','tax'=>'Tax considerations','visa'=>'Visa and residency','compliance'=>'Compliance after registration',
  'costs'=>'Costs','timeline'=>'Timeline','compare'=>'Compare with other jurisdictions','mistakes'=>'Common mistakes','faq'=>'Frequently asked questions','sources'=>'Official sources',
];
if(!array_key_exists('zones',$pr['sections'])) unset($sections['zones']);
$byKind=fn($k)=>array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$hub&&$p['kind']===$k);
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Jurisdiction guide','Company formation in '.$label,'Structures, requirements, documents and registration steps, sourced from '.$auth.' guidance.',$crumbs,verified_badge($verified).'<span class="badge">'.icon('landmark').e($auth).'</span>')?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <?=answer_block($pr['answer'])?>

    <section class="content-section" id="overview"><h2>Overview</h2><p><?=e($src['note'])?></p><p>This guide summarises what <?=e($auth)?> publishes and links to the official pages. Each statement below links to the in-depth guide that cites it.</p></section>

    <?php foreach(['who'=>'who can register','structures'=>'the available business structures'] as $k=>$topic):?>
    <section class="content-section" id="<?=$k?>"><h2><?=e($sections[$k])?></h2><?=$facts($pr['sections'][$k])?:$pending($topic,['resources/legal-form-decision','resources/foreign-founder-preparation'])?></section>
    <?php endforeach;?>

    <?php if(isset($sections['zones'])):?>
    <section class="content-section" id="zones"><h2>Mainland, free zone and offshore</h2><p>Mainland, free-zone and offshore routes follow different rules and are administered by different authorities. This guide covers the mainland route described by the UAE Government.</p><?=$pending('free-zone and offshore rules',['resources/choose-jurisdiction-framework'])?></section>
    <?php endif;?>

    <section class="content-section" id="requirements"><h2>Requirements</h2><?=$facts($pr['sections']['requirements'])?:$pending('the core requirements')?></section>
    <section class="content-section" id="documents"><h2>Documents</h2><?=$facts($pr['sections']['documents'])?:$pending('the document list',['resources/documents-master-checklist'])?><p class="small muted">Separate the documents the authority asks for from those a service provider or bank asks for. <a href="/resources/authority-vs-provider/">Why it matters</a>.</p></section>

    <section class="content-section" id="process"><h2>Registration process</h2><ol class="process-list"><?php foreach($journeys['steps'] as $k=>$step): $links=array_filter(array_map(fn($s)=>$pages[$s]??null,$journeys['paths'][$hub][$k]??[])); if(!$links) continue;?><li><h3><?=e($step['title'])?></h3><p><?=e($step['text'])?></p><ul class="link-list"><?php foreach($links as $l):?><li><a href="<?=e(path_url($l['slug']))?>"><?=icon('chevron-right')?><?=e($l['name'])?></a></li><?php endforeach;?></ul></li><?php endforeach;?></ol>
      <p><a class="btn btn-secondary" href="/explore/?country=<?=e($hub)?>">Get a personalised setup path<?=icon('arrow-right')?></a></p></section>

    <section class="content-section" id="authorities"><h2>Government authorities</h2><p><strong><?=e($auth)?></strong> is the primary authority for the guidance on this page. Other authorities can be involved for licensing, tax and immigration, depending on the activity.</p><ul class="source-list"><?php foreach($src['links']??[['title'=>$src['title'],'url'=>$src['url']]] as $l):?><li><a href="<?=e($l['url'])?>" target="_blank" rel="noopener noreferrer"><?=e($l['title'])?><?=icon('external-link')?></a></li><?php endforeach;?></ul></section>

    <section class="content-section" id="licensing"><h2>Licensing</h2><?=$facts($pr['sections']['licensing'])?:$pending('licensing requirements',['resources/licence-and-approval-mapping','resources/business-activity-mapping'])?></section>
    <section class="content-section" id="banking"><h2>Banking</h2><?=$facts($pr['sections']['banking'])?:''?><p>Banks set and apply their own account-opening requirements, separately from the registry. <a href="/resources/banking-readiness/">Prepare for corporate banking</a> · <a href="/services/corporate-banking/">Banking support</a>.</p></section>
    <section class="content-section" id="tax"><h2>Tax considerations</h2><?=$facts($pr['sections']['tax'])?:$pending('tax registration and rates',['resources/tax-authority-handoff'])?></section>
    <section class="content-section" id="visa"><h2>Visa and residency</h2><p>Company formation and immigration are separate processes decided by different authorities.</p><?=$facts($pr['sections']['visa'])?:$pending('visa and residency routes',['resources/visa-vs-incorporation'])?></section>
    <section class="content-section" id="compliance"><h2>Compliance after registration</h2><?=$facts($pr['sections']['compliance'])?:$pending('post-registration obligations',['resources/post-incorporation-calendar'])?></section>

    <section class="content-section" id="costs"><h2>Costs</h2><?=price_table($hub,$auth)?></section>
    <section class="content-section" id="timeline"><h2>Timeline</h2><p>Processing times are set by <?=e($auth)?> and depend on the route, the activity and the completeness of the application. We do not estimate timelines the authority has not published. <a href="/resources/timeline-verification/">How to verify registration timelines</a>.</p></section>

    <section class="content-section" id="compare"><h2>Compare with other jurisdictions</h2><?=compare_table('jurisdictions',[$hub])?><ul class="link-list mt-4"><?php foreach($reg['sources'] as $k=>$o): if($k===$hub) continue;?><li><a href="<?=e(path_url($k))?>"><?=icon('git-compare-arrows')?><?=e('Company formation in '.$o['label'])?></a></li><?php endforeach;?><li><a href="/jurisdictions/"><?=icon('git-compare-arrows')?>All six side by side</a></li></ul></section>

    <section class="content-section" id="mistakes"><h2>Common mistakes</h2><ul class="check-list mistakes"><?php foreach($pr['mistakes'] as $m):?><li><?=icon('triangle-alert')?><span><?=e($m)?></span></li><?php endforeach;?></ul></section>

    <?=faq_accordion($pr['faqs'])?>

    <section class="content-section" id="sources"><h2>Official sources</h2><p>Sources last checked: <strong><?=e(fmt_date($verified))?></strong>. Official pages change; re-check the authority immediately before filing or payment. See our <a href="/about/source-policy/">source policy</a>.</p><?=source_card($src,$verified)?></section>

    <section class="content-section" id="guides"><h2>All <?=e($label)?> guides</h2>
      <?php foreach(['guide'=>'In-depth guides','service'=>'Services','topic'=>'Topic checklists'] as $k=>$h): $list=$byKind($k); if(!$list) continue;?><h3 class="mt-6"><?=e($h)?></h3><ul class="link-list mt-2"><?php foreach($list as $p):?><li><a href="<?=e(path_url($p['slug']))?>"><?=icon('chevron-right')?><?=e($p['name'])?></a></li><?php endforeach;?></ul><?php endforeach;?>
    </section>
  </div>
  <aside class="source-rail" aria-label="On this page">
    <nav class="toc source-card" aria-label="On this page"><span class="eyebrow">On this page</span><ol><?php foreach($sections as $id=>$t):?><li><a href="#<?=e($id)?>"><?=e($t)?></a></li><?php endforeach;?></ol></nav>
    <div class="source-card"><span class="eyebrow">Start in <?=e($label)?></span><h2 class="mt-2">Get a structured plan</h2><p>Tell us your activity, ownership and timeline.</p><p class="mt-4"><a class="btn btn-primary btn-block" href="/get-started/?country=<?=e($hub)?>">Get started<?=icon('arrow-right')?></a></p></div>
    <div class="source-card"><span class="eyebrow">Popular services</span><ul class="source-list"><?php foreach(array_slice($services,0,5,true) as $k=>$s):?><li><a href="/services/<?=e($k)?>/"><?=e($s['name'])?><?=icon('chevron-right')?></a></li><?php endforeach;?></ul></div>
  </aside>
</div></section>
<?=cta_band($hub,$label)?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'Article','headline'=>'Company formation in '.$label,'description'=>$page['description'],'url'=>page_url($hub),'mainEntityOfPage'=>page_url($hub),'dateModified'=>$verified,'author'=>publisher(),'publisher'=>publisher(),'image'=>url('assets/img/og-default.png'),'about'=>['@type'=>'Country','name'=>$label],'citation'=>array_values(array_map(fn($l)=>$l['url'],$src['links']??[['url'=>$src['url']]])),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?=json_ld(faq_schema($pr['faqs']))?>
<?php include __DIR__.'/../partials/footer.php';?>
