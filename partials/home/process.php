<?php // "From Idea to Incorporated Business." Horizontal on desktop, vertical on phones. Expects $home. ?>
<section class="section hs-process" aria-labelledby="proc-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">How it works</p><h2 id="proc-title">From Idea to Incorporated Business.</h2></div><p>A structured process with the authority at the centre — you always know which step is the law and which is our work.</p></div>
  <ol class="flow" data-reveal>
    <?php foreach($home['process'] as $i=>[$t,$d,$u]):?><li class="flow-step"><span class="flow-num" aria-hidden="true"><?=sprintf('%02d',$i+1)?></span><h3><a href="<?=e($u)?>"><?=e($t)?></a></h3><p><?=e($d)?></p></li><?php endforeach;?>
  </ol>
</div></section>
