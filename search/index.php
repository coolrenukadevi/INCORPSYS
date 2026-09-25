<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/search.php';
$noindex=true;
$q=trim(substr((string)($_GET['q']??''),0,100));
$results=$q!==''?site_search($q):[];
$page=['slug'=>'search','title'=>($q!==''?'Search: '.$q:'Search').' | INCORPSYS','description'=>'Search INCORPSYS guides, services and jurisdictions.'];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Search','Search INCORPSYS','Guides, services and jurisdictions.',[['name'=>'Home','slug'=>''],['name'=>'Search','slug'=>'search']])?>
<section class="content-body"><div class="container-narrow">
  <form class="search-form" action="/search/" method="get" role="search"><label class="visually-hidden" for="q">Search the site</label><input class="input" id="q" name="q" type="search" value="<?=e($q)?>" placeholder="For example: name reservation, registered agent, Bizfile" maxlength="100"><button class="btn btn-primary" type="submit"><?=icon('search')?>Search</button></form>
  <?php if($q!==''):?><p class="muted mt-6" role="status"><?=count($results)?> result<?=count($results)===1?'':'s'?> for “<?=e($q)?>”</p>
    <ul class="search-results"><?php foreach($results as $r):?><li><a class="card card-link card-compact" href="<?=e($r['url'])?>"><span class="badge"><?=e($r['type'])?></span><h2 class="h4 mt-2"><?=e($r['name'])?></h2><p class="small"><?=e($r['desc'])?></p></a></li><?php endforeach;?></ul>
    <?php if(!$results):?><div class="alert alert-info mt-6"><?=icon('info')?><div><strong>No matches</strong>Try a shorter term, browse the <a href="/resources/">resource library</a>, or <a href="/get-started/">ask us directly</a>.</div></div><?php endif;?>
  <?php endif;?>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
