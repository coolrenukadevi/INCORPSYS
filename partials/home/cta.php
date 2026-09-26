<?php // Closing CTA. Expects $home. ?>
<section class="hs-cta on-dark" aria-labelledby="fcta-title"><div class="container fcta">
  <div>
    <p class="eyebrow"><?=e($home['cta']['kicker'])?></p>
    <h2 id="fcta-title"><?=e($home['cta']['title'])?></h2>
    <p><?=e($home['cta']['text'])?></p>
    <div class="cluster mt-6"><a class="btn btn-cta btn-lg" href="/get-started/">Launch Your Entity<?=icon('arrow-right')?></a><a class="btn btn-on-dark btn-lg" href="/jurisdictions/">Compare Jurisdictions</a></div>
    <ul class="fcta-contact"><li><a href="mailto:<?=e(SITE_EMAIL)?>"><?=icon('mail')?><?=e(SITE_EMAIL)?></a></li><li><a href="<?=e(tel_url())?>"><?=icon('phone')?><?=e(SITE_PHONE)?></a></li><li><a href="<?=e(wa_url())?>" target="_blank" rel="noopener"><?=icon('message-circle')?>WhatsApp</a></li></ul>
  </div>
  <div class="fcta-art"><?=art_network()?></div>
</div></section>
