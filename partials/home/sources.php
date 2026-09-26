<?php // "Built on Official Sources." Engine diagram + authority tiles with real verification dates. Expects $reg. ?>
<section class="section hs-sources" aria-labelledby="src-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Source-first engine</p><h2 id="src-title">Built on Official Sources.</h2></div><p>Every regulatory statement starts with the authority that controls it. These are sources we read and link to — not partners or endorsers.</p></div>
  <ol class="engine">
    <li><span class="engine-ic"><?=icon('landmark')?></span><b>Official authority</b><small>Registry, licensing, tax or immigration authority</small></li>
    <li><span class="engine-ic"><?=icon('badge-check')?></span><b>Verified requirement</b><small>Statement recorded with its source and date</small></li>
    <li><span class="engine-ic"><?=icon('layers')?></span><b>INCORPSYS knowledge layer</b><small>Guides, comparisons and checklists</small></li>
    <li><span class="engine-ic"><?=icon('user-round')?></span><b>Founder decision</b><small>Your structure, route and next step</small></li>
  </ol>
  <ul class="src-tiles">
    <?php foreach($reg['sources'] as $k=>$s):?><li><p class="src-kicker"><?=icon('landmark')?>Official source</p><p class="src-name"><?=e(authority_short($k))?></p><p class="src-country"><?=e($s['label'])?></p><p class="src-date">Verified <?=e(fmt_date($s['verified']??null))?></p><a class="link-arrow" href="<?=e($s['url'])?>" target="_blank" rel="noopener noreferrer">View official source<?=icon('external-link')?><span class="visually-hidden">: <?=e($s['authority'])?> (opens official site)</span></a></li><?php endforeach;?>
  </ul>
  <p class="small muted mt-6">Dates show when each jurisdiction's official pages were last checked for our guides. Read our <a href="/about/source-policy/">source policy</a> and <a href="/about/methodology/">methodology</a>.</p>
</div></section>
