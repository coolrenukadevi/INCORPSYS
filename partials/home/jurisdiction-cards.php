<?php
// Stats (computed from data — never typed) + six primary jurisdiction cards + slim row for guides in preparation.
// Card images: assets/img/jurisdictions/{key}.webp (supplied by INCORPSYS); the SVG line-art is the fallback when a file is missing.
// Expects $reg, $pages, $cmp (comparison data), $services.
$guides = array_filter($pages, fn($p) => $p['kind'] === 'guide' && isset($reg['sources'][$p['jurisdiction'] ?? '']));
$officialPages = array_sum(array_map(fn($s) => count($s['links'] ?? [1]), $reg['sources']));
$stats = [
  [count($reg['sources']), 'Jurisdictions with published guides', 'map-pin'],
  [count($guides), 'Source-backed in-depth guides', 'book-open-text'],
  [$officialPages, 'Official authority pages linked', 'landmark'],
  [count($services), 'Service areas, one team', 'layers'],
];
$profiles = require __DIR__.'/../../content/jurisdiction-profiles.php';
$codes = ['uae' => 'AE', 'singapore' => 'SG', 'hong-kong' => 'HK', 'uk' => 'UK', 'usa' => 'US', 'malaysia' => 'MY'];
?>
<section class="hs-stats" aria-label="INCORPSYS at a glance"><div class="container"><ul class="stats">
  <?php foreach($stats as [$n,$l,$ic]):?><li><span class="stats-ic"><?=icon($ic)?></span><span><b><?=e((string)$n)?></b><?=e($l)?></span></li><?php endforeach;?>
</ul></div></section>

<section class="section hs-dest" id="jurisdictions" aria-labelledby="dest-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Jurisdictions</p><h2 id="dest-title">One platform. Multiple global business destinations.</h2></div><p>Each guide starts from the authority that controls the rules: official route, structures and the in-depth guides behind them. <a class="link-arrow" href="/jurisdictions/">View all jurisdictions<?=icon('arrow-right')?></a></p></div>
  <ul class="jcards">
  <?php foreach($reg['sources'] as $k=>$s): $row=$cmp['rows'][$k]??[]; $struct=null; foreach($profiles[$k]['sections']['structures']??[] as $g){ if(isset($pages[$g])){$struct=$pages[$g];break;} }
    $count=count(array_filter($guides,fn($p)=>$p['jurisdiction']===$k));?>
    <li class="jcard">
      <?php $img=is_file(__DIR__.'/../../assets/img/jurisdictions/'.$k.'.webp')?'img/jurisdictions/'.$k.'.webp':null; [$iw,$ih]=$img?getimagesize(__DIR__.'/../../assets/'.$img):[0,0];?>
      <div class="jcard-art<?=$img?' has-photo':''?>"><?php if($img):?><img src="<?=e(asset($img))?>" alt="" width="<?=$iw?>" height="<?=$ih?>" loading="lazy" decoding="async"><?php else:?><?=art_jurisdiction($k)?><?php endif;?><span class="jcard-code"><?=e($codes[$k])?></span></div>
      <div class="jcard-body">
        <h3><a href="<?=e(path_url($k))?>"><?=e($s['label']==='UK'?'United Kingdom':($s['label']==='USA'?'United States':$s['label']))?></a></h3>
        <p class="jcard-auth"><?=icon('landmark')?><?=e($s['authority'])?></p>
        <dl class="jcard-dl">
          <?php if(!empty($row['route'])):?><div><dt>Filing route</dt><dd><?=e($row['route']['value'])?></dd></div><?php endif;?>
          <?php if($struct):?><div><dt>Structures</dt><dd><a href="<?=e(path_url($struct['slug']))?>"><?=e($struct['name'])?></a></dd></div><?php endif;?>
          <div><dt>Coverage</dt><dd><?=$count?> source-backed guides</dd></div>
        </dl>
        <p class="jcard-status"><?=icon('badge-check')?>Source checked <?=e(fmt_date($s['verified']??null))?></p>
        <a class="jcard-cta" href="<?=e(path_url($k))?>" aria-label="Explore company setup in <?=e($s['label'])?>">Explore<?=icon('arrow-right')?></a>
      </div>
    </li>
  <?php endforeach;?>
  </ul>
  <section class="jmore" aria-labelledby="jmore-title">
    <p class="jmore-title" id="jmore-title">More jurisdictions — guides in preparation</p>
    <ul><?php foreach($reg['pending'] as $k=>$s):?><li><span class="jmore-name"><a href="<?=e(path_url($k))?>"><?=e($s['label'])?></a><small><span class="jmore-dot" aria-hidden="true"></span>Guide in preparation</small></span><a class="link-arrow" href="/get-started/?country=<?=e($k)?>" aria-label="Enquire about company setup in <?=e($s['label'])?>">Enquire<?=icon('arrow-right')?></a></li><?php endforeach;?></ul>
  </section>
</div></section>
