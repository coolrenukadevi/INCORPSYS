<?php // "Global Business Intelligence" — authority-driven knowledge interface. Expects $home, $pages. ?>
<section class="section section-subtle hs-know" aria-labelledby="know-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Knowledge Hub</p><h2 id="know-title">Global Business Intelligence.</h2></div><p>Guides, comparisons and checklists that answer founders' real questions — each pointing to the official source.</p></div>
  <ul class="know-cats"><?php foreach($home['knowledge']['categories'] as [$t,$c]):?><li><a href="/resources/#cat-<?=e($c)?>"><?=e($t)?><?=icon('arrow-right')?></a></li><?php endforeach;?></ul>
  <ul class="know-tiles">
    <?php foreach($home['knowledge']['tiles'] as $i=>[$label,$slug]):
      if($slug==='@hub'){ $t='Browse the Knowledge Hub'; $d='Guides, checklists, comparisons and glossaries across company formation, tax, banking, compliance and visas.'; $u='/resources/'; }
      elseif($slug==='@compare'){ $t='Compare jurisdictions'; $d='Authorities, filing routes, officers, registered office, tax, visa and compliance side by side.'; $u='/jurisdictions/'; }
      else { $p=$pages[$slug]; $t=$p['name']; $d=$p['description']; $u=path_url($slug); }?>
      <li class="<?=$i===0?'know-feature':''?>"><a href="<?=e($u)?>"><span class="eyebrow"><?=e($label)?></span><h3><?=e($t)?></h3><p><?=e($d)?></p><span class="link-arrow">Read<?=icon('arrow-right')?></span></a></li>
    <?php endforeach;?>
  </ul>
</div></section>
