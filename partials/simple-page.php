<?php
// Shared shell for policy pages. Expects $page, $crumbs, $eyebrow, $lead, $body (trusted HTML written in the page file); optional $faqs.
include __DIR__.'/header.php';?>
<main id="main">
<?=page_hero($eyebrow,$page['h1'],$lead,$crumbs)?>
<section class="content-body"><div class="container layout-aside">
  <div class="content-main prose"><?=$body?><?=faq_accordion($faqs??[])?></div>
  <aside class="source-rail"><div class="source-card"><span class="eyebrow">Trust and transparency</span><ul class="source-list"><li><a href="/about/methodology/">Methodology</a></li><li><a href="/about/source-policy/">Source policy</a></li><li><a href="/about/editorial-policy/">Editorial policy</a></li><li><a href="/resources/official-sources-directory/">Official source directory</a></li></ul></div><?=contact_card()?></aside>
</div></section>
<?=cta_band()?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@type'=>'WebPage','name'=>$page['title'],'description'=>$page['description'],'url'=>page_url($page['slug']),'publisher'=>publisher(),'breadcrumb'=>breadcrumb_schema($crumbs)])?>
<?php if(!empty($faqs)) echo json_ld(faq_schema($faqs));?>
<?php include __DIR__.'/footer.php';?>
