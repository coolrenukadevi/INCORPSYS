<?php // Closing CTA band (before the footer). Expects $home. The map is decorative; each jurisdiction is linked in the cards above. ?>
<section class="hs-cta on-dark" aria-labelledby="fcta-title"><div class="container fcta">
  <div class="fcta-copy">
    <p class="eyebrow"><?=e($home['cta']['kicker'])?></p>
    <h2 id="fcta-title"><?=e($home['cta']['title'])?></h2>
    <p><?=e($home['cta']['text'])?></p>
    <div class="fcta-actions"><a class="btn btn-cta" href="/get-started/">Launch Your Entity<?=icon('arrow-right')?></a><a class="btn btn-on-dark" href="<?=e(tel_url())?>"><?=icon('phone')?>Talk to Our Expert</a></div>
  </div>
  <div class="fcta-map" aria-hidden="true">
    <img src="<?=e(asset('img/world-dots.svg'))?>" alt="" width="700" height="268" loading="lazy" decoding="async">
    <?php foreach($home['cta']['pins'] as [$label,$key]):?><span class="wm-pin wm-pin--<?=e($key)?>"><span class="wm-mark"></span><span class="wm-label"><?=e($label)?></span></span><?php endforeach;?>
  </div>
  <ul class="fcta-feats">
    <?php foreach($home['cta']['features'] as [$ic,$t,$d]):?><li><span class="fcta-ic"><?=icon($ic)?></span><span><strong><?=e($t)?></strong><?=e($d)?></span></li><?php endforeach;?>
  </ul>
</div></section>
