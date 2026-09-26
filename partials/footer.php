<?php $footSources=site_registry()['sources']+site_registry()['pending']; ?>
<footer class="site-footer on-dark">
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        <a class="footer-logo" href="/" aria-label="INCORPSYS home"><picture><source type="image/webp" srcset="<?=e(asset('img/logo-reverse-96.webp'))?> 1x, <?=e(asset('img/logo-reverse-144.webp'))?> 1.5x"><img src="<?=e(asset('img/logo-reverse-96.png'))?>" alt="INCORPSYS — Global Company Incorporation" width="240" height="48" loading="lazy"></picture></a>
        <p>Company incorporation, licensing, banking readiness and compliance support across global jurisdictions, organised around official government sources and delivered by one team from enquiry to ongoing compliance.</p>
        <ul class="footer-contact">
          <li><a href="<?=e(wa_url())?>" target="_blank" rel="noopener"><?=icon('message-circle')?>WhatsApp</a></li>
          <li><a href="/contact/"><?=icon('send')?>Contact us</a></li>
        </ul>
        <ul class="footer-social" aria-label="INCORPSYS on social media"><?php foreach(SOCIAL_LINKS as $name=>$href):?><li><a href="<?=e($href)?>" target="_blank" rel="noopener me" aria-label="INCORPSYS on <?=e($name)?> (opens in a new tab)" title="<?=e($name)?>"><?=social_icon($name)?></a></li><?php endforeach;?></ul>
      </div>
      <div class="footer-cols">
        <div><h2>Company</h2><ul><li><a href="/about/">About Us</a></li><li><a href="/about/why-choose-us/">Why Choose Us?</a></li><li><a href="/about/vision-mission/">Vision &amp; Mission</a></li><li><a href="/about/leadership/">Leadership</a></li><li><a href="/careers/">Careers</a></li><li><a href="/contact/">Contact</a></li></ul></div>
        <div><h2>Services</h2><ul><li><a href="/services/company-incorporation/">Company incorporation</a></li><li><a href="/services/business-licensing/">Business licensing</a></li><li><a href="/services/corporate-banking/">Corporate banking</a></li><li><a href="/services/compliance-documentation/">Compliance</a></li><li><a href="/services/visa-residency/">Visa &amp; residency</a></li><li><a href="/services/">All services</a></li></ul></div>
        <div><h2>Jurisdictions</h2><ul><?php foreach($footSources as $k=>$s):?><li><a href="<?=e(path_url($k))?>"><?=e($s['label'])?></a></li><?php endforeach;?><li><a href="/jurisdictions/">Compare jurisdictions</a></li></ul></div>
        <div><h2>Resources</h2><ul><li><a href="/resources/">Guides</a></li><li><a href="/resources/company-incorporation-faq/">FAQs</a></li><li><a href="/resources/documents-master-checklist/">Checklists</a></li><li><a href="/resources/official-sources-directory/">Official sources</a></li><li><a href="/about/methodology/">Methodology</a></li><li><a href="/about/source-policy/">Source policy</a></li><li><a href="/search/">Search</a></li></ul></div><div><h2>Legal &amp; Support</h2><ul><li><a href="/legal/">Legal &amp; Support</a></li><li><a href="/legal/privacy/">Privacy Policy</a></li><li><a href="/legal/data-policy/">Data Policy</a></li><li><a href="/legal/service-terms/">Service Terms</a></li><li><a href="/legal/filing-quality-commitment/">Filing Quality Commitment</a></li><li><a href="/legal/payment-policy/">Payment Policy</a></li><li><a href="/legal/refund-policy/">Refund Policy</a></li><li><a href="/legal/cancellation-policy/">Cancellation Policy</a></li><li><a href="/legal/hiring-policy/">Hiring Policy</a></li><li><a href="/legal/grievance-redressal/">Grievance Redressal</a></li><li><a href="/support/">Support</a></li></ul></div>
      </div>
    </div>
    <p class="footer-notice"><strong>Official source methodology.</strong> INCORPSYS guides summarise official government and registry guidance and link to it. They are not legal, tax or immigration advice and do not replace the competent authority. Fees, timelines and requirements change: verify them with the authority before filing or payment. INCORPSYS does not guarantee incorporation, licensing, banking or visa outcomes. <a href="/about/methodology/">How we build our guides</a>.</p>
    <div class="footer-bottom">
      <span>© <?=date('Y')?> INCORPSYS. All rights reserved.<?php if(is_provided(LEGAL_ENTITY_NAME)):?> INCORPSYS is operated by <?=e(LEGAL_ENTITY_NAME)?>.<?php endif;?></span>
      <ul aria-label="Legal"><li><a href="/legal/terms/">Terms of Use</a></li><li><a href="/legal/service-terms/">Service Terms</a></li><li><a href="/legal/disclaimer/">Disclaimer</a></li><li><a href="/legal/cookies/">Cookie Policy</a></li><li><a href="/sitemap/">Sitemap</a></li><li><button class="footer-link-btn" type="button" data-cookie-settings>Cookie settings</button></li></ul>
    </div>
  </div>
</footer>
<section class="cookie-banner" id="cookie-banner" aria-label="Cookie consent" data-ga="<?=e(ga_id())?>" hidden>
  <p>We use cookies to run essential features and, with your consent, to measure traffic (Google Analytics). You can browse the site either way. See our <a href="/legal/cookies/">Cookie Policy</a> &amp; <a href="/legal/privacy/">Privacy Policy</a>.</p>
  <div class="cookie-actions"><button class="btn btn-secondary btn-sm" type="button" data-consent="essential">Essential only</button><button class="btn btn-primary btn-sm" type="button" data-consent="all">Accept analytics</button></div>
</section>
<div class="assist" id="assist" data-countries="<?=e(json_encode(array_map(fn($s)=>$s['label'],$footSources)))?>" data-wa="<?=e(WHATSAPP_NUMBER)?>">
  <button class="assist-toggle" type="button" aria-expanded="false" aria-controls="assist-panel"><?=icon('message-circle')?><span class="assist-label">INCORPSYS Assist</span><span class="visually-hidden"> — open</span></button>
  <div class="assist-panel" id="assist-panel" role="dialog" aria-modal="false" aria-labelledby="assist-title" hidden>
    <div class="assist-head"><div><b id="assist-title">INCORPSYS Assist</b><small>Guided setup assistance from the INCORPSYS team.</small></div><button class="assist-close" type="button"><?=icon('x')?><span class="visually-hidden">Close INCORPSYS Assist</span></button></div>
    <div class="assist-body" aria-live="polite">
      <p class="assist-msg">Hello. What would you like help with?</p>
      <div class="assist-options assist-static">
        <a class="assist-option" href="/get-started/?need=incorporation">Start a Company<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/jurisdictions/">Compare Jurisdictions<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/get-started/?need=licensing">Business Licence<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/get-started/?need=banking">Corporate Banking<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/get-started/?need=visa">Visa &amp; Residency<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/get-started/?need=compliance">Compliance<?=icon('chevron-right')?></a>
        <a class="assist-option" href="/contact/">Speak to an Expert<?=icon('chevron-right')?></a>
      </div>
    </div>
    <ul class="assist-contact" aria-label="Contact INCORPSYS">
      <li><a class="assist-contact-primary" href="/get-started/"><?=icon('send')?><span>Enquiry Now</span></a></li>
      <li><a href="<?=e(wa_url())?>" target="_blank" rel="noopener"><?=icon('message-circle')?><span>WhatsApp</span></a></li>
      <li><a href="<?=e(tel_url())?>"><?=icon('phone')?><span>Call</span></a></li>
      <li><a href="mailto:<?=e(SITE_EMAIL)?>"><?=icon('mail')?><span>Email</span></a></li>
    </ul>
  </div>
</div>
<?php if(($page['slug']??'')!=='get-started'):?>
<nav class="mobile-cta" aria-label="Quick actions"><a class="btn btn-cta" href="/get-started/">Enquiry Now<?=icon('arrow-right')?></a><a class="btn btn-secondary" href="<?=e(wa_url())?>" target="_blank" rel="noopener"><?=icon('message-circle')?>WhatsApp</a></nav>
<?php endif;?>
<?=site_schema($page??[],$crumbs??null)?>
<script src="<?=e(asset('js/site.js'))?>" defer></script>
</body></html>
