<?php
require_once __DIR__.'/../includes/config.php';
$noindex=true;
$page=['slug'=>'login','title'=>'Client Login | INCORPSYS','description'=>'INCORPSYS client portal access.'];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<section class="content-body"><div class="container auth-grid">
  <div class="wizard-card">
    <p class="eyebrow">Client portal</p><h1 class="h2 mt-2">Log in</h1>
    <div class="alert alert-info mt-6"><?=icon('info')?><div><strong>The client portal is not open yet</strong>Online accounts are being prepared. Existing clients should continue to use email, phone or WhatsApp with their INCORPSYS contact.</div></div>
    <form class="stack mt-6" aria-describedby="portal-status">
      <div class="field"><label for="l-email">Email</label><input class="input" id="l-email" type="email" autocomplete="email" disabled></div>
      <div class="field"><label for="l-pass">Password</label><input class="input" id="l-pass" type="password" autocomplete="current-password" disabled></div>
      <button class="btn btn-primary btn-block" type="submit" disabled>Log in</button>
      <p id="portal-status" class="small muted">Sign-in is disabled until the portal launches.</p>
    </form>
    <div class="cluster mt-6"><a class="btn btn-secondary" href="mailto:<?=e(SITE_EMAIL)?>"><?=icon('mail')?>Email your contact</a><a class="btn btn-ghost" href="/account/">Preview the portal</a></div>
  </div>
  <div class="auth-aside on-dark"><p class="eyebrow">Coming to the portal</p><h2 class="mt-2">Your company setup in one place</h2><ul class="check-list mt-6"><li><?=icon('check')?><span>Enquiries, quotes and applications</span></li><li><?=icon('check')?><span>Secure document exchange</span></li><li><?=icon('check')?><span>Company setup progress and messages</span></li><li><?=icon('check')?><span>Renewal reminders and support</span></li></ul></div>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
