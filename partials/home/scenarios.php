<?php // Business scenarios linking to existing guides and services. Expects $home. ?>
<section class="section section-subtle hs-scen" aria-labelledby="scen-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Business scenarios</p><h2 id="scen-title">Start from your situation.</h2></div><p>Common starting points and the guides that apply to each.</p></div>
  <ul class="scen"><?php foreach($home['scenarios'] as $i=>[$t,$d,$links]):?><li><span class="scen-num"><?=sprintf('%02d',$i+1)?></span><h3><?=e($t)?></h3><p><?=e($d)?></p><ul><?php foreach($links as [$lt,$lu]):?><li><a href="<?=e($lu)?>"><?=icon('chevron-right')?><?=e($lt)?></a></li><?php endforeach;?></ul></li><?php endforeach;?></ul>
</div></section>
