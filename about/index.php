<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'about','title'=>'About INCORPSYS | Incorporation System','description'=>'INCORPSYS (Incorporation System) replaces complex, manual company registration with an intelligent, end-to-end digital workflow. Meet the leadership team.'];
$crumbs=[['name'=>'Home','slug'=>''],['name'=>'About','slug'=>'about']];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('About us','About INCORPSYS','Smart Technology. Seamless Incorporation. Global Growth.',$crumbs)?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <div class="prose">
      <p class="lead">'Incorpsys' (Incorporation System) is a modern corporate infrastructure platform that replaces complex, manual registration processes with an intelligent, end-to-end digital workflow.</p>
      <p>Designed for founders and legal teams who prioritize speed and accuracy, IncorpSYS streamlines entity setup, document verification, and government filings into a single, seamless system designed to minimize errors.</p>
    </div>
    <section class="content-section" aria-labelledby="leadership"><h2 id="leadership">Leadership</h2>
      <?=team_grid()?><p class="mt-4"><a class="link-arrow" href="/about/leadership/">Meet the leadership team<?=icon('arrow-right')?></a></p>
    </section>
    <section class="content-section" aria-labelledby="where"><h2 id="where">Where we work</h2><p>INCORPSYS supports company setup and corporate services in the UAE, Singapore, Hong Kong, the United Kingdom, the United States and Malaysia.</p>
      <ul class="link-list"><?php foreach(site_registry()['sources'] as $k=>$s):?><li><a href="<?=e(path_url($k))?>"><?=icon('chevron-right')?><?=e($s['label'])?></a></li><?php endforeach;?></ul></section>
    <section class="content-section" aria-labelledby="how"><h2 id="how">How we work</h2><p>Every guide and every client workflow starts from the official authority: the registry, licensing body, tax authority or immigration authority that controls the step. We link to that source, record when we checked it, and never publish fees, timelines or approval promises the authority has not published.</p>
      <ul class="link-list"><li><a href="/about/why-choose-us/"><?=icon('chevron-right')?>Why choose us</a></li><li><a href="/about/vision-mission/"><?=icon('chevron-right')?>Vision &amp; mission</a></li><li><a href="/about/methodology/"><?=icon('chevron-right')?>Methodology</a></li><li><a href="/about/source-policy/"><?=icon('chevron-right')?>Source policy</a></li><li><a href="/about/editorial-policy/"><?=icon('chevron-right')?>Editorial policy</a></li></ul></section>
  </div>
  <aside class="source-rail"><?=contact_card()?><div class="source-card"><span class="eyebrow">Follow INCORPSYS</span><ul class="source-list"><?php foreach(SOCIAL_LINKS as $n=>$h):?><li><a href="<?=e($h)?>" target="_blank" rel="noopener me"><?=e($n)?><?=icon('external-link')?></a></li><?php endforeach;?></ul></div></aside>
</div></section>
<?=cta_band()?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'AboutPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url('about'),'breadcrumb'=>breadcrumb_schema($crumbs),'mainEntity'=>organization_schema()+['employee'=>team_schema()]])?>
<?php include __DIR__.'/../partials/footer.php';?>
