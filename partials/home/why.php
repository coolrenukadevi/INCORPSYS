<?php // "Why INCORPSYS" — four cards. Expects $home. ?>
<section class="section section-subtle hs-why" aria-labelledby="why-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Why INCORPSYS</p><h2 id="why-title">Trust built on transparency.</h2></div><p>Four commitments that shape every guide, plan and filing.</p></div>
  <ul class="why"><?php foreach($home['why'] as $i=>[$t,$d,$ic]):?><li><span class="why-num"><?=sprintf('%02d',$i+1)?></span><span class="why-ic"><?=icon($ic)?></span><h3><?=e($t)?></h3><p><?=e($d)?></p></li><?php endforeach;?></ul>
</div></section>
