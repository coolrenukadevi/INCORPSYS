<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/search.php';
$noindex=true;
$q=trim(substr((string)($_GET['q']??''),0,100));
$type=(string)($_GET['type']??''); if(!in_array($type,SEARCH_TYPES,true)) $type='';
$results=$q!==''?site_search($q,40,$type):[];
$counts=[];if($q!==''){foreach(site_search($q,500) as $r) $counts[$r['type']]=($counts[$r['type']]??0)+1;}
$page=['slug'=>'search','title'=>($q!==''?'Search: '.$q:'Search').' | INCORPSYS','description'=>'Search INCORPSYS jurisdictions, services, guides, checklists, FAQs and glossaries.'];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Search','Search INCORPSYS','Jurisdictions, services, business structures, guides, FAQs, checklists and glossary terms.',[['name'=>'Home','slug'=>''],['name'=>'Search','slug'=>'search']])?>
<section class="content-body"><div class="container-narrow">
  <form class="search-form" action="/search/" method="get" role="search"><label class="visually-hidden" for="q">Search the site</label><input class="input" id="q" name="q" type="search" value="<?=e($q)?>" placeholder="For example: name reservation, registered agent, Bizfile" maxlength="100"><?php if($type!==''):?><input type="hidden" name="type" value="<?=e($type)?>"><?php endif;?><button class="btn btn-primary" type="submit"><?=icon('search')?>Search</button></form>
  <?php if($q!==''):?>
    <?php if($counts):?><nav class="hub-filter" aria-label="Filter results by category"><a class="chip" href="/search/?<?=e(http_build_query(['q'=>$q]))?>"<?=$type===''?' aria-current="page"':''?>>All <span class="chip-count"><?=array_sum($counts)?></span></a><?php foreach(SEARCH_TYPES as $t): if(empty($counts[$t])) continue;?><a class="chip" href="/search/?<?=e(http_build_query(['q'=>$q,'type'=>$t]))?>"<?=$type===$t?' aria-current="page"':''?>><?=e($t)?> <span class="chip-count"><?=$counts[$t]?></span></a><?php endforeach;?></nav><?php endif;?>
    <p class="muted mt-6" role="status"><?=count($results)?> result<?=count($results)===1?'':'s'?> for “<?=e($q)?>”<?=$type!==''?' in '.e($type):''?></p>
    <ul class="search-results"><?php foreach($results as $r):?><li><a class="card card-link card-compact" href="<?=e($r['url'])?>"><div class="result-meta"><span class="badge"><?=e($r['type'])?></span><?php if($r['jur']!==''):?><span class="badge badge-info"><?=icon('map-pin')?><?=e($r['jur'])?></span><?php endif;?><?php if($r['date']):?><span class="result-date">Verified <?=e(fmt_date($r['date']))?></span><?php endif;?></div><h2 class="h4 mt-2"><?=e($r['name'])?></h2><p class="small"><?=e($r['desc'])?></p></a></li><?php endforeach;?></ul>
    <?php if(!$results):?><div class="alert alert-info mt-6"><?=icon('info')?><div><strong>No matches</strong>Try a shorter term, browse the <a href="/resources/">Knowledge Hub</a>, or <a href="/get-started/">ask us directly</a>.</div></div><?php endif;?>
  <?php endif;?>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
