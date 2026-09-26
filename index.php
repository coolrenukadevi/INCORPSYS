<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/setup-path.php';
require_once __DIR__.'/partials/home/art.php';
$page=['slug'=>'','title'=>'Global Company Incorporation & Business Setup | INCORPSYS','description'=>'Launch your global business with confidence: company incorporation, licensing, banking readiness and compliance support in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia, mapped to official sources.'];
$home=require __DIR__.'/content/home.php';
$reg=site_registry();$pages=site_data();$services=require __DIR__.'/content/services.php';
$cmp=(require __DIR__.'/content/comparisons.php')['jurisdictions'];
include __DIR__.'/partials/header.php';?>
<main id="main" class="home-main">
<?php
include __DIR__.'/partials/home/hero.php';
include __DIR__.'/partials/home/jurisdiction-cards.php';
include __DIR__.'/partials/home/comparison.php';
include __DIR__.'/partials/home/process.php';
include __DIR__.'/partials/home/costs.php';
include __DIR__.'/partials/home/sources.php';
include __DIR__.'/partials/home/why.php';
include __DIR__.'/partials/home/ecosystem.php';
include __DIR__.'/partials/home/scenarios.php';
include __DIR__.'/partials/home/decision.php';
include __DIR__.'/partials/home/knowledge.php';
?>
<section class="section hs-faq" aria-labelledby="home-faq"><div class="container-narrow">
  <p class="eyebrow">FAQ</p>
  <h2 id="home-faq">Questions founders ask</h2>
  <div class="accordion faq-list mt-6">
    <?php foreach($home['faqs'] as $i=>$f):?><details<?=$i===0?' open':''?>><summary><?=e($f['q'])?><?=icon('chevron-down')?></summary><div class="accordion-body"><p><?=e($f['a'])?></p><?php if($f['guide']&&isset($pages[$f['guide']])):?><p class="faq-src"><a class="link-arrow" href="<?=e(path_url($f['guide']))?>">Source guide: <?=e($pages[$f['guide']]['name'])?><?=icon('arrow-right')?></a></p><?php elseif(!$f['guide']):?><p class="faq-src"><a class="link-arrow" href="/legal/filing-quality-commitment/">Filing Quality Commitment<?=icon('arrow-right')?></a></p><?php endif;?></div></details><?php endforeach;?>
  </div>
</div></section>
<?php include __DIR__.'/partials/home/cta.php';?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@graph'=>[organization_schema(),['@type'=>'WebSite','@id'=>SITE_URL.'/#website','url'=>SITE_URL,'name'=>'INCORPSYS','publisher'=>['@id'=>SITE_URL.'/#organization'],'inLanguage'=>'en','potentialAction'=>['@type'=>'SearchAction','target'=>['@type'=>'EntryPoint','urlTemplate'=>url('search/').'?q={search_term_string}'],'query-input'=>'required name=search_term_string']],jurisdiction_item_list()]])?>
<?=json_ld(faq_schema(array_map(fn($f)=>['q'=>$f['q'],'a'=>$f['a']],$home['faqs'])))?>
<?php include __DIR__.'/partials/footer.php';?>
