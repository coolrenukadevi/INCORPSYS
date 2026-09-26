<?php
// Homepage hero: headline first; the setup configurator is a lighter, secondary bar. Expects $home, $reg.
$h = $home['hero']; $all = $reg['sources'] + $reg['pending'];
$residency = ['foreign-individual' => 'Non-resident', 'local-individual' => 'Resident', 'corporate' => 'Existing company', 'undecided' => 'Not sure yet'];
$structures = ['new-company' => 'New company', 'branch' => 'Branch of a company', 'undecided' => 'Not sure yet'];
?>
<section class="hx" aria-labelledby="hx-title">
  <div class="container hx-grid">
    <div class="hx-copy">
      <p class="hx-eyebrow"><?=e($h['eyebrow'])?></p>
      <h1 id="hx-title"><?=e($h['h1'][0])?> <span><?=e($h['h1'][1])?></span></h1>
      <p class="hx-lead"><?=e($h['lead'])?></p>
      <div class="hx-actions"><a class="btn btn-cta btn-lg" href="/get-started/">Launch Your Entity<?=icon('arrow-right')?></a><a class="btn btn-on-dark btn-lg" href="/jurisdictions/">Compare Jurisdictions</a></div>
      <ul class="hx-trust" aria-label="How INCORPSYS works"><?php foreach($h['trust'] as $t):?><li><?=icon('check')?><?=e($t)?></li><?php endforeach;?></ul>
    </div>
    <figure class="hx-visual">
      <?=art_hero()?>
      <figcaption class="visually-hidden">INCORPSYS platform: incorporation connects to licensing, banking readiness and compliance, leading to global expansion across the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia.</figcaption>
    </figure>
  </div>
  <div class="container">
    <div class="hx-config" id="setup-finder">
      <form class="cfg" action="/explore/" method="get" data-configurator>
        <div class="cfg-head"><h2>Find your ideal setup</h2><p>Three questions. An information pathway from official guidance.</p></div>
        <div class="cfg-field"><label for="cfg-country">Jurisdiction</label><select class="select" id="cfg-country" name="country" required><option value="">Select jurisdiction</option><optgroup label="Jurisdiction guides"><?php foreach($reg['sources'] as $k=>$s):?><option value="<?=e($k)?>"><?=e($s['label'])?></option><?php endforeach;?></optgroup><optgroup label="Guides in preparation"><?php foreach($reg['pending'] as $k=>$s):?><option value="<?=e($k)?>"><?=e($s['label'])?></option><?php endforeach;?></optgroup></select></div>
        <div class="cfg-field"><label for="cfg-structure">Business structure</label><select class="select" id="cfg-structure" name="structure"><?php foreach($structures as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
        <div class="cfg-field"><label for="cfg-owner">Founder</label><select class="select" id="cfg-owner" name="ownership"><?php foreach($residency as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
        <button class="btn btn-primary cfg-go" type="submit">Explore Setup<?=icon('arrow-right')?></button>
      </form>
      <div class="cfg-result" data-cfg-result tabindex="-1" hidden>
        <div class="cfg-result-head"><div><p class="eyebrow">Your setup path</p><h3 data-r="title">Company setup</h3></div><button class="footer-link-btn" type="button" data-cfg-close>Close</button></div>
        <dl class="cfg-dl">
          <div><dt>Official authority</dt><dd data-r="authority"></dd></div>
          <div data-r-wrap="structure"><dt>Structure guide</dt><dd data-r="structure"></dd></div>
          <div data-r-wrap="route"><dt>Filing route</dt><dd data-r="route"></dd></div>
          <div data-r-wrap="requirements"><dt>Key requirements</dt><dd><ul data-r="requirements"></ul></dd></div>
          <div data-r-wrap="extras"><dt>Also read</dt><dd><ul data-r="extras"></ul></dd></div>
          <div><dt>Needs verification</dt><dd data-r="verify"></dd></div>
        </dl>
        <p class="cfg-note"><?=icon('info')?><span><strong>Information pathway, not advice.</strong> Built from official guidance. A recommendation for your case comes from our team, and the authority makes the final decision.</span></p>
        <div class="cluster"><a class="btn btn-cta" data-r="plan" href="/get-started/">Launch Your Entity<?=icon('arrow-right')?></a><a class="link-arrow" data-r="full" href="/explore/">See the full setup path<?=icon('arrow-right')?></a></div>
      </div>
      <script type="application/json" id="setup-data"><?=json_encode(setup_path_data(),JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP)?></script>
    </div>
  </div>
</section>
