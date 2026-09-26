<?php // Global business ecosystem: INCORPSYS at the centre, nodes link to existing service pages. Expects $home. ?>
<section class="section hs-eco" aria-labelledby="eco-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Global business ecosystem</p><h2 id="eco-title">More than a registration agency.</h2></div><p>Incorporation is one step. INCORPSYS connects the services a company needs to start, operate and expand — each mapped to the authority or institution that decides it.</p></div>
  <div class="eco">
    <?=art_ecosystem_lines()?>
    <ul class="eco-grid">
      <?php foreach($home['ecosystem'] as $i=>[$t,$u,$ic]): if($i===4):?><li class="eco-core"><img src="<?=e(asset('icons/favicon.svg'))?>" width="44" height="44" alt=""><b>INCORPSYS</b><small>Global business platform</small></li><?php endif;?>
      <li class="eco-node"><a href="<?=e($u)?>"><span class="eco-ic"><?=icon($ic)?></span><?=e($t)?></a></li>
      <?php endforeach;?>
    </ul>
  </div>
</div></section>
