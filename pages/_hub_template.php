<?php require_once __DIR__.'/../includes/config.php';$pages=site_data();$reg=site_registry();$hub=trim((string)($GLOBALS['PAGE_SLUG']??''),'/');
if($hub==='resources'){
  $src=null;$label='Resources';
  $groups=['Resource guides'=>array_filter($pages,fn($p)=>$p['kind']==='resource')];
  $page=['slug'=>'resources','title'=>'Company Incorporation Resources & Checklists | INCORPSYS','description'=>'Cross-jurisdiction guides, checklists and glossaries for planning company incorporation, with links to each jurisdiction\'s official authority.'];
  $h1='Company incorporation resources';$eyebrow='RESOURCE LIBRARY';
}else{
  $src=$reg['sources'][$hub]??null;if(!$src){require __DIR__.'/../404.php';return;}
  $label=$src['label'];$list=array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$hub);$groups=[];
  foreach(['topic'=>'Guides','guide'=>'In-depth guides','service'=>'Services'] as $k=>$heading){ $items=array_filter($list,fn($p)=>$p['kind']===$k); if($items) $groups[$heading]=$items; }
  $page=['slug'=>$hub,'title'=>$label.' Company Incorporation & Business Setup | INCORPSYS','description'=>'INCORPSYS guides and services for company incorporation and business setup in '.$label.', each linked to '.$src['authority'].' for verification.'];
  $h1='Company incorporation in '.$label;$eyebrow='JURISDICTION';
}
include __DIR__.'/../partials/header.php';?>
<main id="main"><section class="page-hero"><div class="container"><nav class="breadcrumbs" aria-label="Breadcrumb"><a href="/">Home</a> <span>›</span> <span aria-current="page"><?=e($label)?></span></nav><div class="eyebrow"><?=e($eyebrow)?></div><h1><?=e($h1)?></h1><p class="page-sub"><?=e($page['description'])?></p></div></section>
<section class="section" style="padding-top:26px"><div class="container"><div class="content-grid"><div><?php foreach($groups as $heading=>$items):?><h2 class="hub-h2"><?=e($heading)?></h2><div class="grid2"><?php foreach($items as $p):?><a class="card hub-card" href="<?=e(path_url($p['slug']))?>"><h3><?=e($p['name'])?></h3><p><?=e($p['description'])?></p></a><?php endforeach;?></div><?php endforeach;?></div>
<aside class="source"><?php if($src):?><div class="tag">OFFICIAL SOURCE</div><h3><?=e($src['authority'])?></h3><p><strong><?=e($src['title'])?></strong></p><p><?=e($src['note'])?></p><a class="source-main" href="<?=e($src['url'])?>" target="_blank" rel="noopener noreferrer">Open official source ↗</a><?php if(!empty($src['links'])):?><div class="tag" style="margin-top:18px">SOURCE LIBRARY</div><div class="source-links"><?php foreach($src['links'] as $link):?><a href="<?=e($link['url'])?>" target="_blank" rel="noopener noreferrer"><?=e($link['title'])?> ↗</a><?php endforeach;?></div><?php endif;?><small>Source pages can change. Re-check before filing, payment or relying on a rule.</small>
<?php else:?><div class="tag">GUIDES BY JURISDICTION</div><h3>Country guides</h3><div class="source-links"><?php foreach($reg['sources'] as $k=>$s):?><a href="<?=e(path_url($k))?>"><b><?=e($s['label'])?></b> · <?=e($s['authority'])?></a><?php endforeach;?></div><?php endif;?></aside></div></div></section>
<section class="section" style="padding-top:0"><div class="container enquiry" id="enquiry"><div><div class="eyebrow" style="color:#8fc1ff">GET STARTED</div><h2><?=e($src?'Planning a company in '.$label.'?':'Ready to plan your company setup?')?></h2><p>Tell us your structure and business objective and we will organize the next step around the official source.</p></div><?php $formJurisdiction=$src?$label:'';include __DIR__.'/../partials/enquiry-form.php';?></div></section></main>
<script type="application/ld+json"><?=json_encode(['@context'=>'https://schema.org','@type'=>'CollectionPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url($hub),'breadcrumb'=>['@type'=>'BreadcrumbList','itemListElement'=>[['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>page_url('')],['@type'=>'ListItem','position'=>2,'name'=>$label,'item'=>page_url($hub)]]]],JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE)?></script>
<?php include __DIR__.'/../partials/footer.php';?>
