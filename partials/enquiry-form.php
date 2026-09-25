<?php $formJurisdiction=$formJurisdiction??''; ?>
<form class="wizard-card" method="post" action="/enquiry/submit.php"><input type="hidden" name="token" value="<?=e(form_token())?>"><div class="hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
  <h2>Send a quick message</h2><p class="muted mt-2">Prefer a guided form? <a class="link-arrow" href="/get-started/">Use Get started<?=icon('arrow-right')?></a></p>
  <div class="form-grid mt-6">
    <div class="field"><label for="q-name">Full name</label><input type="text" class="input" id="q-name" name="name" required maxlength="120" autocomplete="name"></div>
    <div class="field"><label for="q-email">Email</label><input class="input" id="q-email" name="email" type="email" required maxlength="190" autocomplete="email"></div>
    <div class="field"><label for="q-phone">Phone or WhatsApp <span class="optional">(optional)</span></label><input class="input" id="q-phone" name="phone" type="tel" maxlength="40" autocomplete="tel"></div>
    <div class="field"><label for="q-jur">Jurisdiction <span class="optional">(optional)</span></label><input type="text" class="input" id="q-jur" name="jurisdiction" maxlength="80" value="<?=e($formJurisdiction)?>"></div>
    <div class="field full"><label for="q-msg">How can we help?</label><textarea class="textarea" id="q-msg" name="message" required maxlength="4000"></textarea><span class="field-help">Do not send passwords or payment card details.</span></div>
    <div class="full"><button class="btn btn-primary" type="submit">Send message<?=icon('send')?></button></div>
  </div>
</form>
