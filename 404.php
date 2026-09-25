<?php require_once __DIR__.'/includes/config.php';http_response_code(404);$noindex=true;$reg=site_registry();$services=require __DIR__.'/content/services.php';
$page=['slug'=>'','title'=>'Page Not Found | INCORPSYS','description'=>'The requested page could not be found.'];
include __DIR__.'/partials/header.php';?>
<main id="main">
<section class="page-hero"><div class="container-narrow"><p class="eyebrow">Error 404</p><h1>We could not find that page</h1><p class="lead">The address may be mistyped, or the page may have moved. Search the site or start from one of the pages below.</p>
  <form class="search-form mt-8" action="/search/" method="get" role="search"><label class="visually-hidden" for="q404">Search the site</label><input class="input" id="q404" name="q" type="search" placeholder="Search guides, services and jurisdictions" maxlength="100"><button class="btn btn-primary" type="submit"><?=icon('search')?>Search</button></form></div></section>
<section class="content-body"><div class="container grid grid-3">
  <div class="card"><h2 class="h3">Popular jurisdictions</h2><ul class="link-list mt-4"><?php foreach($reg['sources'] as $k=>$s):?><li><a href="<?=e(path_url($k))?>"><?=icon('chevron-right')?><?=e($s['label'])?></a></li><?php endforeach;?></ul></div>
  <div class="card"><h2 class="h3">Popular services</h2><ul class="link-list mt-4"><?php foreach(array_slice($services,0,6,true) as $k=>$s):?><li><a href="/services/<?=e($k)?>/"><?=icon('chevron-right')?><?=e($s['name'])?></a></li><?php endforeach;?></ul></div>
  <div class="card card-subtle"><h2 class="h3">Start from the beginning</h2><p>Go to the homepage, or tell us what you need and we will point you to the right route.</p><div class="cluster mt-6"><a class="btn btn-primary" href="/">Homepage</a><a class="btn btn-secondary" href="/get-started/">Get started</a></div></div>
</div></section>
</main>
<?php include __DIR__.'/partials/footer.php';?>
