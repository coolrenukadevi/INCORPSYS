<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'sitemap','title'=>'Sitemap | INCORPSYS','description'=>'Every INCORPSYS page in one place: jurisdiction guides, in-depth guides, services, resources, company pages and legal information.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'Sitemap','slug'=>'sitemap']];
$reg=site_registry();$pages=site_data();$services=require __DIR__.'/../content/services.php';
$link=fn(string $url,string $label)=>'<li><a href="'.e($url).'">'.icon('chevron-right').e($label).'</a></li>';
$list=fn(array $items)=>'<ul class="link-list">'.implode('',$items).'</ul>';
$main=[$link('/','Home'),$link('/get-started/','Get started'),$link('/jurisdictions/','Compare jurisdictions'),$link('/search/','Search'),$link('/support/','Support'),$link('/contact/','Contact')];
$company=[$link('/about/','About Us'),$link('/about/why-choose-us/','Why Choose Us?'),$link('/about/vision-mission/','Vision & Mission'),$link('/about/leadership/','Leadership'),$link('/careers/','Careers'),$link('/about/methodology/','Methodology'),$link('/about/source-policy/','Source policy'),$link('/about/editorial-policy/','Editorial policy')];
$serv=[$link('/services/','All services')];foreach($services as $k=>$s)$serv[]=$link('/services/'.$k.'/',$s['name']);
$res=[$link('/resources/','Resource library')];foreach($pages as $p){if($p['kind']==='resource')$res[]=$link(path_url($p['slug']),$p['name']);}
$legal=[$link('/legal/','Legal & Support')];foreach($pages as $p){if($p['kind']==='legal')$legal[]=$link(path_url($p['slug']),$p['name']);}$legal[]=$link('/support/','Support');
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Sitemap','Sitemap','Every page on the INCORPSYS website, grouped by section.',$crumbs)?>
<section class="content-body"><div class="container sitemap-page">
  <div class="grid grid-3">
    <section class="card" aria-labelledby="sm-main"><h2 id="sm-main" class="h3">Main pages</h2><?=$list($main)?></section>
    <section class="card" aria-labelledby="sm-company"><h2 id="sm-company" class="h3">About INCORPSYS</h2><?=$list($company)?></section>
    <section class="card" aria-labelledby="sm-services"><h2 id="sm-services" class="h3">Services</h2><?=$list($serv)?></section>
  </div>
  <h2 class="mt-10">Jurisdictions</h2>
  <div class="grid grid-3 mt-6"><?php foreach($reg['sources'] as $k=>$s): $guides=array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$k&&$p['kind']==='guide');?>
    <section class="card" aria-labelledby="sm-<?=e($k)?>"><h3 id="sm-<?=e($k)?>"><a href="<?=e(path_url($k))?>">Company formation in <?=e($s['label'])?></a></h3><?=$list(array_map(fn($p)=>$link(path_url($p['slug']),$p['name']),$guides))?></section>
  <?php endforeach;?></div>
  <div class="grid grid-2 mt-10">
    <section class="card" aria-labelledby="sm-res"><h2 id="sm-res" class="h3">Resources</h2><?=$list($res)?></section>
    <section class="card" aria-labelledby="sm-legal"><h2 id="sm-legal" class="h3">Legal &amp; Support</h2><?=$list($legal)?><p class="small muted mt-6">Search engines: see the <a href="/sitemap.xml">XML sitemap</a>.</p></section>
  </div>
</div></section>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'WebPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('sitemap'),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?php include __DIR__.'/../partials/footer.php';?>
