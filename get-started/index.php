<?php
require_once __DIR__.'/../includes/config.php';
$page=['slug'=>'get-started','title'=>'Get Started | INCORPSYS','description'=>'Tell INCORPSYS what you need, where and when. A short guided enquiry for company incorporation, licensing, banking, visa and compliance support.'];
$reg=site_registry();
$countries=array_map(fn($s)=>$s['label'],$reg['sources'])+['undecided'=>'Not decided yet'];
// Pre-fill from the setup finder or INCORPSYS Assist; only allow-listed values are accepted.
$pre=[];
foreach(['need','activity','structure','ownership','visa','timeline'] as $k){ $v=(string)($_GET[$k]??''); if(isset(ENQUIRY_OPTIONS[$k][$v])) $pre[$k]=$v; }
$c=(string)($_GET['country']??''); if(isset($countries[$c])) $pre['country']=$c;
$choices=function(string $name,array $opts,bool $required=true) use($pre){
  $h='<div class="choices">';$first=true;
  foreach($opts as $k=>$label){ $h.='<label class="choice"><input type="radio" name="'.e($name).'" value="'.e($k).'"'.(($pre[$name]??null)===$k?' checked':'').($required&&$first?' required':'').'><span>'.e($label).'</span></label>'; $first=false; }
  return $h.'</div>';
};
$startStep=0;foreach(['need','country','activity','ownership','visa','timeline'] as $i=>$k){ if(!isset($pre[$k])){ $startStep=$i; break; } $startStep=$i+1; }
$steps=['What you need','Country','Business activity','Ownership','Visa','Timeline','Your details','Documents'];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<?=page_hero('Get started','Tell us about your setup','Eight short steps. Your answers let us reply with the right authority, route and next steps — not a generic brochure.',[['name'=>'Home','slug'=>''],['name'=>'Get started','slug'=>'get-started']])?>
<section class="content-body"><div class="container wizard">
  <ol class="wizard-progress" aria-label="Enquiry steps"><?php foreach($steps as $i=>$s):?><li class="<?=$i===$startStep?'is-current':($i<$startStep?'is-done':'')?>"><span><?=e($s)?></span></li><?php endforeach;?></ol>
  <form class="wizard-card" method="post" action="/enquiry/submit.php" data-wizard novalidate>
    <input type="hidden" name="form" value="wizard"><input type="hidden" name="token" value="<?=e(form_token())?>">
    <div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
    <p class="no-js-only alert alert-info"><?=icon('info')?><span>Complete each section below, then send your enquiry.</span></p>

    <fieldset class="wizard-step<?=0===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 1 of 8</span>What do you need help with?</legend><p class="step-help">Choose the closest match. You can add detail later.</p><?=$choices('need',ENQUIRY_OPTIONS['need'])?></fieldset>
    <fieldset class="wizard-step<?=1===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 2 of 8</span>Which jurisdiction?</legend><p class="step-help">Not decided? Choose "Not decided yet" and we will help you compare.</p><?=$choices('country',$countries)?></fieldset>
    <fieldset class="wizard-step<?=2===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 3 of 8</span>What will the business do?</legend><p class="step-help">Activity decides licences and approvals, so this matters.</p><?=$choices('activity',ENQUIRY_OPTIONS['activity'])?>
      <div class="field mt-6"><label for="activity_detail">Describe the activity <span class="optional">(optional)</span></label><input type="text" class="input" id="activity_detail" name="activity_detail" maxlength="200" placeholder="For example: B2B software for logistics companies"></div></fieldset>
    <fieldset class="wizard-step<?=3===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 4 of 8</span>Who will own the business?</legend><p class="step-help">Ownership can change which structures and rules apply.</p><?=$choices('ownership',ENQUIRY_OPTIONS['ownership'])?>
      <p class="label mt-6">Structure in mind <span class="optional">(optional)</span></p><?=$choices('structure',ENQUIRY_OPTIONS['structure'],false)?></fieldset>
    <fieldset class="wizard-step<?=4===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 5 of 8</span>Will anyone need a visa or residency?</legend><p class="step-help">Immigration is a separate process from incorporation, decided by the immigration authority.</p><?=$choices('visa',ENQUIRY_OPTIONS['visa'])?></fieldset>
    <fieldset class="wizard-step<?=5===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 6 of 8</span>When do you want to start?</legend><p class="step-help">This helps us prioritise. It is not a promise of processing time.</p><?=$choices('timeline',ENQUIRY_OPTIONS['timeline'])?></fieldset>
    <fieldset class="wizard-step<?=6===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 7 of 8</span>How can we reach you?</legend><p class="step-help">We use these details only to reply to this enquiry.</p>
      <div class="form-grid">
        <div class="field"><label for="w-name">Full name</label><input type="text" class="input" id="w-name" name="name" required maxlength="120" autocomplete="name"></div>
        <div class="field"><label for="w-email">Email</label><input class="input" id="w-email" name="email" type="email" required maxlength="190" autocomplete="email"></div>
        <div class="field"><label for="w-phone">Phone or WhatsApp <span class="optional">(optional)</span></label><input class="input" id="w-phone" name="phone" type="tel" maxlength="40" autocomplete="tel"></div>
        <div class="field"><label for="w-company">Company <span class="optional">(optional)</span></label><input type="text" class="input" id="w-company" name="company" maxlength="120" autocomplete="organization"></div>
      </div>
      <p class="label mt-6">Preferred contact method</p><?php $pre['contact_method']='email';?><?=$choices('contact_method',ENQUIRY_OPTIONS['contact_method'],false)?></fieldset>
    <fieldset class="wizard-step<?=7===$startStep?' is-active':''?>"><legend><span class="wizard-count">Step 8 of 8</span>Documents and anything else</legend>
      <div class="alert alert-info mt-4"><?=icon('lock')?><div><strong>Do not upload documents here</strong>We ask for passports, company records or financial documents only when a specific step needs them, through a channel agreed with you. Never send passwords or payment card details.</div></div>
      <div class="field mt-6"><label for="w-message">Anything else we should know? <span class="optional">(optional)</span></label><textarea class="textarea" id="w-message" name="message" maxlength="4000"></textarea></div>
      <label class="check-field mt-6"><input type="checkbox" name="consent" value="1" required><span>I agree that INCORPSYS may use these details to reply to my enquiry, as described in the <a href="/legal/privacy/">privacy policy</a>.</span></label>
    </fieldset>

    <div class="wizard-nav"><button class="btn btn-secondary" type="button" data-wizard-back hidden><?=icon('chevron-right','flip')?>Back</button><button class="btn btn-primary" type="button" data-wizard-next>Continue<?=icon('arrow-right')?></button><button class="btn btn-cta" type="submit" data-wizard-submit hidden>Send enquiry<?=icon('send')?></button></div>
    <div class="no-js-only mt-8"><button class="btn btn-primary btn-lg" type="submit">Send enquiry</button></div>
    <p class="wizard-preparing" role="status"><span class="spinner" aria-hidden="true"></span>Your enquiry is being prepared…</p>
  </form>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
