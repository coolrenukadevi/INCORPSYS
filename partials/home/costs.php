<?php
// "Know What You Are Paying For." Cost architecture — categories, never invented amounts. Expects $home.
?>
<section class="section section-dark on-dark hs-costs" aria-labelledby="cost-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Cost architecture</p><h2 id="cost-title">Know What You Are Paying For.</h2></div><p>Every setup cost belongs to one of three categories. We keep them separate, and we show an amount only when it is verified against the official source.</p></div>
  <div class="cost-arch">
    <div class="cost-bar" aria-hidden="true"><?php foreach($home['costs'] as [$k,$t]):?><span class="cost-seg cost-<?=e($k)?>"><?=e($t)?></span><?php endforeach;?></div>
    <p class="cost-caption">Segments show cost categories, not amounts.</p>
    <ul class="cost-cards">
      <?php foreach($home['costs'] as [$k,$t,$sub,$d,$status,$note]):?>
      <li class="cost-card cost-<?=e($k)?>"><span class="cost-key" aria-hidden="true"></span><h3><?=e($t)?></h3><p class="cost-sub"><?=e($sub)?></p><p><?=e($d)?></p>
        <dl><div><dt>Amount</dt><dd class="cost-status"><?=e($status)?></dd></div><div><dt>Depends on</dt><dd><?=e($note)?></dd></div></dl>
        <?php if($k==='incorpsys'):?><a class="btn btn-cta btn-sm" href="/get-started/">Contact for Service Fee<?=icon('arrow-right')?></a><?php elseif($k==='government'):?><a class="link-arrow" href="/resources/fee-verification/">How to verify government fees<?=icon('arrow-right')?></a><?php else:?><a class="link-arrow" href="/resources/service-provider-due-diligence/">Checking third-party providers<?=icon('arrow-right')?></a><?php endif;?>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div></section>
