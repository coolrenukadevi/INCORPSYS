<?php
require_once __DIR__.'/../includes/config.php';
$pages=site_data();$reg=site_registry();
$slug=trim((string)($GLOBALS['PAGE_SLUG']??''),'/');
$page=$pages[$slug]??null;
if(!$page){require __DIR__.'/../404.php';return;}
if(in_array($page['kind'],['topic','service'],true)){require_once __DIR__.'/../includes/phase-a.php';$page=phase_a_enrich($page);}
$kind=$page['kind'];$jKey=$page['jurisdiction']??null;$jLabel=$jKey?$reg['sources'][$jKey]['label']:null;
$draftPolicy=$kind==='legal'&&POLICIES_EFFECTIVE_DATE==='';
if($draftPolicy||!empty($page['noindex'])) $noindex=true;
$crumbs=[['name'=>'Home','slug'=>'']];
if($jKey) $crumbs[]=['name'=>$jLabel,'slug'=>$jKey];
elseif($kind==='resource') $crumbs[]=['name'=>'Knowledge Hub','slug'=>'resources'];
elseif($kind==='legal') $crumbs[]=['name'=>'Legal & Support','slug'=>'legal'];
$crumbs[]=['name'=>$page['name'],'slug'=>$slug];
// Related links: this jurisdiction's other pages, the same topic elsewhere, or the rest of the resource library.
$related=[];$sameName=[];
if($jKey){
  $siblings=array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$jKey&&$p['slug']!==$slug);
  foreach(['guide'=>'In-depth guides','topic'=>'Topic checklists','service'=>'Services'] as $k=>$heading){ $list=array_filter($siblings,fn($p)=>$p['kind']===$k); if($list) $related[$heading]=$list; }
  $rest=substr($slug,strlen($jKey)+1);
  $sameName=array_filter($pages,fn($p)=>($p['jurisdiction']??null)!==null&&$p['jurisdiction']!==$jKey&&$p['slug']===$p['jurisdiction'].'/'.$rest);
}elseif($kind==='resource'){
  $related['Resource guides']=array_filter($pages,fn($p)=>$p['kind']==='resource'&&$p['slug']!==$slug);
}elseif($kind==='legal'){
  $related['Legal & Support']=array_map(fn($s,$n)=>['slug'=>$s,'name'=>$n],array_keys(legal_links($slug)),legal_links($slug));
}
$services=require __DIR__.'/../content/services.php';
$verified=$page['verified']??null;
$eyebrow=$page['eyebrow']??'INCORPSYS';
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero($eyebrow,$page['h1']??$page['title'],$page['description']??'',$crumbs,in_array($kind,['guide','resource'],true)?verified_badge($verified):'')?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main">
    <?php if($kind==='legal'&&!$draftPolicy):?><p class="policy-meta"><?=icon('badge-check')?>Effective <?=e(fmt_date(POLICIES_EFFECTIVE_DATE))?>. Questions about this policy: <a href="/contact/">contact us</a>.</p><?php if(str_contains(json_encode($page['sections']),'[To be confirmed')||str_contains(json_encode($page['sections']),PLACEHOLDER)):?><p class="policy-meta policy-pending"><mark class="tbc">Highlighted</mark> details are being finalised and will be added to this page.</p><?php endif;?><?php endif;?>
    <?php if($draftPolicy):?><div class="alert alert-warning"><?=icon('triangle-alert')?><div><strong>Draft — subject to legal review</strong>This policy is being finalised and has not yet been approved by legal counsel. Items marked <mark class="tbc">[To be confirmed]</mark> or <mark class="tbc">[TO BE PROVIDED]</mark> will be completed before the policy takes effect. Questions: <a href="/contact/">contact us</a>.</div></div><?php endif;?>
    <?=answer_block($page['answer']??'Use the official source linked on this page to verify current requirements.')?>
    <?php foreach(($page['sections']??[]) as $i=>$section): $bullets=array_filter($section['bullets']??[],fn($b)=>trim($b)!==''); ?>
    <section class="content-section" aria-labelledby="s<?=$i?>"><h2 id="s<?=$i?>"><?=e($section['title'])?></h2><?php if(!empty($section['body'])):?><p><?=rich_text($section['body'])?></p><?php endif;?><?php if(!empty($section['html'])):?><?=$section['html']?><?php endif;?><?php if($bullets):?><ul><?php foreach($bullets as $b):?><li><?=rich_text($b)?></li><?php endforeach;?></ul><?php endif;?></section>
    <?php endforeach;?>
    <?php if($kind==='contact'):?><?php include __DIR__.'/../partials/enquiry-form.php';?><?php endif;?>
    <?=faq_accordion($page['faqs']??[])?>
    <?php if($kind!=='legal'):?><div class="alert alert-info"><?=icon('info')?><div><strong>How we write our guides</strong>We summarise official guidance and link to it. We do not publish fees, timelines or approval promises unless the authority does. <a href="/about/methodology/">Read our methodology</a>.</div></div><?php endif;?>
  </div>
  <aside class="source-rail" aria-label="Sources and contact">
    <?php if(!empty($page['source'])):?><?=source_card($page['source'],$verified)?>
    <?php elseif($kind==='resource'):?><div class="source-card"><span class="eyebrow">Official sources by jurisdiction</span><h2 class="mt-2">Find the controlling authority</h2><p>This guide applies across jurisdictions. Confirm the rules with the authority for the country you choose.</p><ul class="source-list"><?php foreach($reg['sources'] as $src):?><li><a href="<?=e($src['url'])?>" target="_blank" rel="noopener noreferrer"><?=e($src['label'].' — '.$src['authority'])?><?=icon('external-link')?></a></li><?php endforeach;?></ul></div>
    <?php endif;?>
    <?php if($kind==='legal'):?><nav class="source-card" aria-label="Legal and support"><span class="eyebrow">Legal &amp; Support</span><ul class="source-list"><?php foreach(legal_links($slug) as $ls=>$ln):?><li><a href="<?=e(path_url($ls))?>"><?=e($ln)?><?=icon('chevron-right')?></a></li><?php endforeach;?></ul></nav><?php endif;?>
    <?=contact_card()?>
  </aside>
</div></section>
<?php if($related||$sameName):?>
<section class="section-tight section-subtle"><div class="container related-grid">
  <div class="card related-block"><h2><?=e($jKey?'More for '.$jLabel:($kind==='legal'?'Legal & Support':'More resource guides'))?></h2><?php foreach($related as $heading=>$list):?><?php if($jKey):?><h3><?=e($heading)?></h3><?php endif;?><ul class="link-list"><?php foreach($list as $p):?><li><a href="<?=e(path_url($p['slug']))?>"><?=icon('chevron-right')?><?=e($p['name'])?></a></li><?php endforeach;?></ul><?php endforeach;?></div>
  <div class="stack">
    <?php if($sameName):?><div class="card related-block"><h2>Compare with</h2><ul class="link-list"><?php foreach($sameName as $p):?><li><a href="<?=e(path_url($p['slug']))?>"><?=icon('chevron-right')?><?=e($p['name'].' — '.$reg['sources'][$p['jurisdiction']]['label'])?></a></li><?php endforeach;?></ul></div><?php endif;?>
    <?php if(!$jKey):?><div class="card related-block"><h2>Guides by jurisdiction</h2><ul class="link-list"><?php foreach($reg['sources'] as $k=>$src):?><li><a href="<?=e(path_url($k))?>"><?=icon('chevron-right')?><?=e($src['label'])?></a></li><?php endforeach;?></ul></div><?php endif;?>
    <div class="card related-block"><h2>Popular services</h2><ul class="link-list"><?php foreach(array_slice($services,0,6,true) as $sk=>$sv):?><li><a href="/services/<?=e($sk)?>/"><?=icon('chevron-right')?><?=e($sv['name'])?></a></li><?php endforeach;?></ul></div>
    <div class="card related-block"><h2>Next steps</h2><ul class="link-list"><?php if($jKey):?><li><a href="<?=e(path_url($jKey))?>"><?=icon('chevron-right')?>All <?=e($jLabel)?> guides</a></li><?php endif;?><li><a href="/jurisdictions/"><?=icon('chevron-right')?>Compare jurisdictions</a></li><li><a href="/get-started/<?=$jKey?'?country='.e($jKey):''?>"><?=icon('chevron-right')?>Start your enquiry</a></li></ul></div>
  </div>
</div></section>
<?php endif;?>
<?php if($kind!=='legal'):?><?=cta_band($jKey??'',$jLabel??'')?><?php endif;?>
</main>
<?php if(!($noindex??false)):
  $isArticle=in_array($kind,['guide','resource'],true);
  $schema=['@context'=>'https://schema.org','@type'=>$kind==='contact'?'ContactPage':($isArticle?'Article':'WebPage'),($isArticle?'headline':'name')=>$page['h1']??$page['title'],'description'=>$page['description'],'url'=>page_url($slug),'mainEntityOfPage'=>page_url($slug),'inLanguage'=>'en','publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)];
  if($verified){$schema['dateModified']=$verified;}
  if($isArticle){$schema['author']=publisher();$schema['image']=url('assets/img/og-default.png');}
  echo json_ld($schema);
  if(!empty($page['faqs'])) echo json_ld(faq_schema($page['faqs']));
endif;?>
<?php include __DIR__.'/../partials/footer.php';?>
