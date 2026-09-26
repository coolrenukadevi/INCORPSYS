<?php
require_once __DIR__.'/../includes/config.php';
$services=require __DIR__.'/../content/services.php';$pages=site_data();$reg=site_registry();
$key=substr(trim((string)($GLOBALS['PAGE_SLUG']??''),'/'),strlen('services/'));
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Services','slug'=>'services']];

if($key===''||$key===false):
  $page=['slug'=>'services','title'=>'Services | INCORPSYS','description'=>'Company incorporation, business licensing, corporate banking readiness, compliance, visa and ongoing corporate support across six jurisdictions.'];
  include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Services','Corporate services, organized around the authority','Every INCORPSYS service starts the same way: identify the authority that controls the step, confirm its current requirements, then prepare and coordinate the work.',$crumbs)?>
<section class="section-tight"><div class="container grid grid-3"><?php foreach($services as $k=>$s):?><a class="card card-link" href="/services/<?=e($k)?>/"><span class="card-icon"><?=icon($s['icon'])?></span><h2 class="h3"><?=e($s['name'])?></h2><p><?=e($s['summary'])?></p><span class="link-arrow card-foot">Explore<?=icon('arrow-right')?></span></a><?php endforeach;?></div></section>
<?=cta_band()?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('services'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema([['name'=>'Home','slug'=>''],['name'=>'Services','slug'=>'services']])])?>
<?php include __DIR__.'/../partials/footer.php';return; endif;

$s=$services[$key]??null;
if(!$s){require __DIR__.'/../404.php';return;}
$crumbs[]=['name'=>$s['name'],'slug'=>'services/'.$key];
$page=['slug'=>'services/'.$key,'title'=>$s['name'].' | INCORPSYS','description'=>$s['summary']];
// Per-country pages for this service, where they exist.
$byCountry=[];foreach($reg['sources'] as $k=>$src){ if(isset($pages[$k.'/'.$key])) $byCountry[$k]=$src; }
$guides=array_filter(array_map(fn($g)=>$pages[$g]??null,$s['guides']));
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Service',$s['name'],$s['summary'],$crumbs)?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <?=answer_block($s['answer'])?>
    <section class="content-section" aria-labelledby="scope"><h2 id="scope">What INCORPSYS organizes</h2><ul class="check-list"><?php foreach($s['scope'] as $b):?><li><?=icon('check')?><span><?=e($b)?></span></li><?php endforeach;?></ul></section>
    <section class="content-section" aria-labelledby="provide"><h2 id="provide">What you provide</h2><ul><?php foreach($s['provide'] as $b):?><li><?=e($b)?></li><?php endforeach;?></ul><p>We ask for identity and company documents only when a specific step needs them.</p></section>
    <?php if($guides):?><section class="content-section" aria-labelledby="guides"><h2 id="guides">Guides for this service</h2><ul class="link-list"><?php foreach($guides as $g):?><li><a href="<?=e(path_url($g['slug']))?>"><?=icon('chevron-right')?><?=e($g['name'])?></a></li><?php endforeach;?></ul></section><?php endif;?>
    <section class="content-section" aria-labelledby="where"><h2 id="where">Where we provide it</h2>
      <p>INCORPSYS supports this service in the jurisdictions below. Each country's rules come from its own authority; where a guide is still in preparation, we confirm the requirements for your case first.</p>
      <div class="grid grid-2 mt-4"><?php foreach($reg['sources'] as $k=>$src):?><a class="card card-link card-compact" href="<?=e(isset($byCountry[$k])?path_url($k.'/'.$key):path_url($k))?>"><h3 class="h4"><?=e($s['name'].' — '.$src['label'])?></h3><p class="small"><?=e($src['authority'])?></p></a><?php endforeach;?><?php foreach($reg['pending'] as $k=>$src):?><a class="card card-link card-compact" href="<?=e(path_url($k))?>"><h3 class="h4"><?=e($s['name'].' — '.$src['label'])?></h3><p class="small"><span class="badge badge-warning"><?=icon('clock-4')?>Guide in preparation</span></p></a><?php endforeach;?></div>
    </section>
    <section class="content-section" aria-labelledby="cost"><h2 id="cost">Costs and timelines</h2><div class="alert alert-warning"><?=icon('triangle-alert')?><div><strong>No invented figures</strong>Government fees and processing times are set by each authority and change. We quote only after confirming your requirements, and show the official source for every government fee.</div></div></section>
    <?=faq_accordion($s['faqs'])?>
  </div>
  <aside class="source-rail"><div class="source-card"><span class="eyebrow">Start this service</span><h2 class="mt-2">Get a structured plan</h2><p>Tell us the jurisdiction, activity and timeline. We reply with the route and next steps.</p><p class="mt-4"><a class="btn btn-primary btn-block" href="/get-started/?need=<?=e(['company-incorporation'=>'incorporation','business-licensing'=>'licensing','corporate-banking'=>'banking','visa-residency'=>'visa','compliance-documentation'=>'compliance','ongoing-support'=>'support','business-expansion'=>'expansion'][$key]??'other')?>">Get started<?=icon('arrow-right')?></a></p></div><?=contact_card()?></aside>
</div></section>
<section class="section-tight section-subtle"><div class="container"><h2 class="h3">Other services</h2><ul class="link-list mt-4"><?php foreach($services as $k=>$o): if($k===$key) continue;?><li><a href="/services/<?=e($k)?>/"><?=icon('chevron-right')?><?=e($o['name'])?></a></li><?php endforeach;?></ul></div></section>
<?=cta_band()?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'Service','name'=>$s['name'],'serviceType'=>$s['name'],'description'=>$s['summary'],'url'=>page_url('services/'.$key),'provider'=>publisher(),'areaServed'=>array_values(array_map(fn($src)=>['@type'=>'Country','name'=>$src['label']],$reg['sources']))])?>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'WebPage','name'=>$page['title'],'url'=>page_url($page['slug']),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?=json_ld(faq_schema($s['faqs']))?>
<?php include __DIR__.'/../partials/footer.php';?>
