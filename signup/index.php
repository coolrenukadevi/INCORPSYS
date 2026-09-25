<?php
require_once __DIR__.'/../includes/config.php';
$noindex=true;
$page=['slug'=>'signup','title'=>'Create an Account | INCORPSYS','description'=>'INCORPSYS client portal registration.'];
include __DIR__.'/../partials/header.php';?>
<main id="main">
<section class="content-body"><div class="container auth-grid">
  <div class="wizard-card">
    <p class="eyebrow">Client portal</p><h1 class="h2 mt-2">Create an account</h1>
    <div class="alert alert-info mt-6"><?=icon('info')?><div><strong>Accounts open with the client portal</strong>Online registration is not available yet. Start with an enquiry — the team will set up your workspace when the portal launches.</div></div>
    <div class="cluster mt-6"><a class="btn btn-primary" href="/get-started/">Start an enquiry<?=icon('arrow-right')?></a><a class="btn btn-ghost" href="/account/">Preview the portal</a></div>
    <p class="small muted mt-6">Already a client? <a class="link-arrow" href="/login/">Log in</a></p>
  </div>
  <div class="auth-aside on-dark"><p class="eyebrow">Why an account</p><h2 class="mt-2">Track every step</h2><p class="mt-4">Follow your enquiry, quote, application and documents, and keep renewal dates in view after incorporation.</p></div>
</div></section>
</main>
<?php include __DIR__.'/../partials/footer.php';?>
