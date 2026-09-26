<?php
// "Which Jurisdiction Fits Your Business?" — shows potentially relevant options by market region and matching guides.
// Never names a "best" jurisdiction. The region list below is plain HTML (works without JavaScript). Expects $home, $reg.
?>
<section class="section hs-decide" aria-labelledby="dec-title"><div class="container dec">
  <div class="dec-copy">
    <p class="eyebrow">Founder decision module</p><h2 id="dec-title">Which Jurisdiction Fits Your Business?</h2>
    <p>Answer five questions to see potentially relevant options and the guides to read next. There is no universal "best" jurisdiction — the right choice depends on your structure, activity, customers and people, and professional, legal or tax advice may be required.</p>
    <h3 class="h4 mt-6">Jurisdictions by market region</h3>
    <ul class="dec-regions"><?php foreach($home['regions'] as $rk=>$r): if($rk==='global') continue;?><li><b><?=e($r['label'])?></b><?php foreach($r['jurisdictions'] as $j):?> <a href="<?=e(path_url($j))?>"><?=e($reg['sources'][$j]['label'])?></a><?php endforeach;?></li><?php endforeach;?></ul>
  </div>
  <form class="dec-form" data-decision>
    <div class="field"><label for="dq-based">Where are you based?</label><select class="select" id="dq-based" name="based"><option value="outside">Outside the jurisdiction I am considering</option><option value="inside">In the jurisdiction I am considering</option></select></div>
    <div class="field"><label for="dq-activity">What is your business activity?</label><select class="select" id="dq-activity" name="activity"><?php foreach(ENQUIRY_OPTIONS['activity'] as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
    <div class="field"><label for="dq-market">Where will your customers be?</label><select class="select" id="dq-market" name="market"><?php foreach($home['regions'] as $rk=>$r):?><option value="<?=e($rk)?>"><?=e($r['label'])?></option><?php endforeach;?></select></div>
    <div class="field"><label for="dq-ops">Do you need local operations (office, staff)?</label><select class="select" id="dq-ops" name="ops"><option value="unsure">Not sure yet</option><option value="yes">Yes</option><option value="no">No</option></select></div>
    <div class="field"><label for="dq-res">Are the founders resident or non-resident?</label><select class="select" id="dq-res" name="residency"><option value="foreign-individual">Non-resident</option><option value="local-individual">Resident</option><option value="undecided">Not sure yet</option></select></div>
    <button class="btn btn-primary btn-block js-only" type="submit">Show potentially relevant options<?=icon('arrow-right')?></button>
    <div class="dec-out" data-dec-out aria-live="polite" hidden>
      <h3>Your next step</h3>
      <p class="dec-label">Potentially relevant options</p><ul class="dec-j" data-dec-j></ul>
      <p class="dec-label">Guides for your answers</p><ul class="dec-g" data-dec-g></ul>
      <p class="cfg-note"><?=icon('info')?><span>An information pathway, not a recommendation. Professional, legal or tax advice may be required for your case.</span></p>
      <a class="btn btn-cta btn-block" data-dec-cta href="/get-started/">Launch Your Entity<?=icon('arrow-right')?></a>
    </div>
  </form>
</div></section>
