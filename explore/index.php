<?php
require_once __DIR__.'/../includes/config.php';
$reg=site_registry();$pages=site_data();$j=require __DIR__.'/../content/journeys.php';
$noindex=true;
$country=(string)($_GET['country']??'');
$answers=[];foreach(['activity','ownership','visa'] as $k){$v=(string)($_GET[$k]??'');$answers[$k]=isset(ENQUIRY_OPTIONS[$k][$v])?$v:'undecided';}
$src=$reg['sources'][$country]??null;
$page=['slug'=>'explore','title'=>($src?'Your setup path in '.$src['label']:'Find the right setup').' | INCORPSYS','description'=>'A setup path built from official guidance for your jurisdiction, activity, ownership and visa needs.'];
$link=fn($s)=>isset($pages[$s])?'<li><a href="'.e(path_url($s)).'">'.icon('chevron-right').e($pages[$s]['name']).'</a></li>':'';
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?php if(!$src):?>
<?=page_hero('Setup finder','Find the right setup','Choose a jurisdiction to see a setup path built from its official guidance.',[['name'=>'Home','slug'=>''],['name'=>'Setup finder','slug'=>'explore']])?>
<section class="content-body"><div class="container grid grid-3"><?php foreach($reg['sources'] as $k=>$s):?><a class="card card-link" href="/explore/?country=<?=e($k)?>"><h2 class="h3"><?=e($s['label'])?></h2><p><?=e($s['authority'])?></p></a><?php endforeach;?></div></section>
<?php else:
  $prefill=http_build_query(['country'=>$country]+array_filter($answers,fn($v)=>$v!=='undecided'));
  $extras=[];foreach($answers as $k=>$v){foreach($j['extras'][$k.':'.$v]??[] as $s){if(isset($pages[$s]))$extras[$s]=$pages[$s];}}
?>
<?=page_hero('Your setup path','Company setup in '.$src['label'],'A step-by-step path built from '.$src['authority'].' guidance and our in-depth guides. Each step links to the page that explains it and its official source.',[['name'=>'Home','slug'=>''],['name'=>$src['label'],'slug'=>$country],['name'=>'Setup path','slug'=>'explore']])?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <div class="card card-subtle"><h2 class="h4">Your answers</h2><dl class="summary-list mt-4"><dt>Jurisdiction</dt><dd><?=e($src['label'])?></dd><?php foreach(['activity'=>'Activity','ownership'=>'Ownership','visa'=>'Visa'] as $k=>$l):?><dt><?=e($l)?></dt><dd><?=e(ENQUIRY_OPTIONS[$k][$answers[$k]])?></dd><?php endforeach;?></dl><p class="mt-4"><a class="link-arrow" href="/#setup-finder">Change answers<?=icon('arrow-right')?></a></p></div>
    <?php if($answers['activity']==='regulated'):?><div class="alert alert-warning"><?=icon('triangle-alert')?><div><strong>Regulated activity</strong>Financial and other regulated activities may need approval from a sector regulator in addition to company registration. Confirm this before choosing a structure.</div></div><?php endif;?>
    <?php if(in_array($answers['visa'],['founders','employees'],true)):?><div class="alert alert-info"><?=icon('info')?><div><strong>Visa and residency are separate</strong>Company formation does not by itself grant a visa. Immigration decisions are made by the immigration authority under its own rules. <a href="/services/visa-residency/">How we help with visas</a>.</div></div><?php endif;?>
    <ol class="journey">
    <?php $n=0; foreach($j['steps'] as $key=>$step): $links=implode('',array_map($link,$j['paths'][$country][$key]??[])); if($links==='') continue; $n++;?>
      <li class="card"><p class="eyebrow">Step <?=$n?></p><h2 class="h3 mt-2"><?=e($step['title'])?></h2><p><?=e($step['text'])?></p><ul class="link-list mt-4"><?=$links?></ul></li>
    <?php endforeach;?>
    </ol>
    <?php if($extras):?><section class="content-section"><h2>Recommended for your answers</h2><ul class="link-list"><?php foreach($extras as $s=>$p):?><li><a href="<?=e(path_url($s))?>"><?=icon('chevron-right')?><?=e($p['name'])?></a></li><?php endforeach;?></ul></section><?php endif;?>
    <?=price_table($country,$src['authority'])?>
  </div>
  <aside class="source-rail"><?=source_card($src,$src['verified']??null)?><div class="source-card"><span class="eyebrow">Ready for the next step?</span><h2 class="mt-2">Get a structured plan</h2><p>We will pre-fill the enquiry with your answers.</p><p class="mt-4"><a class="btn btn-cta btn-block" href="/get-started/?<?=e($prefill)?>">Continue to enquiry<?=icon('arrow-right')?></a></p></div></aside>
</div></section>
<?php endif;?>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
