<?php
require_once __DIR__.'/includes/config.php';
$page=['slug'=>'','title'=>'INCORPSYS | Global Company Incorporation & Business Setup','description'=>'Company incorporation, licensing, banking readiness and compliance support for the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia, built on official government sources.'];
$reg=site_registry();$pages=site_data();$services=require __DIR__.'/content/services.php';
$guideCount=fn($k)=>count(array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$k&&$p['kind']==='guide'));
$codes=['uae'=>'AE','singapore'=>'SG','hong-kong'=>'HK','uk'=>'UK','usa'=>'US','malaysia'=>'MY'];
$homeFaqs=[
  ['q'=>'What does INCORPSYS do?','a'=>'INCORPSYS helps founders and companies set up and run businesses in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia. We map each step to the authority that controls it, prepare the information and documents it asks for, and coordinate filings, licences, banking readiness and ongoing compliance.'],
  ['q'=>'Does INCORPSYS guarantee approval?','a'=>'No. Registries, licensing authorities, banks and immigration authorities make their own decisions. We prepare applications against their published requirements so avoidable problems are caught early.'],
  ['q'=>'How much does company setup cost?','a'=>'Government fees depend on the jurisdiction, structure, activity and services selected, and they change. We only show a fee when it comes from the official source, with the date it was checked, and we quote after confirming your requirements.'],
  ['q'=>'Can foreigners set up a company?','a'=>'It depends on the jurisdiction, structure and activity. Some jurisdictions set residency conditions for directors or require a local agent or secretary. Each country guide links to the official eligibility rules, and the comparison table summarises what the authorities publish.'],
  ['q'=>'How long does registration take?','a'=>'Processing times are set by each authority and depend on the route and the completeness of the application. We do not estimate timelines unless the authority publishes them.'],
  ['q'=>'What happens after I send an enquiry?','a'=>'The team reviews your answers about activity, ownership, visa needs and timeline, then replies by your preferred channel with the relevant route and next steps.'],
];
include __DIR__.'/partials/header.php';?>
<main id="main">
<section class="hero"><div class="container hero-grid">
  <div>
    <p class="eyebrow">Global company incorporation</p>
    <h1>Build your business <span>beyond borders.</span></h1>
    <p class="lead">Company incorporation, licensing, banking readiness and compliance in six jurisdictions — every step mapped to the official authority that controls it.</p>
    <div class="hero-actions"><a class="btn btn-primary btn-lg" href="/get-started/">Get started<?=icon('arrow-right')?></a><a class="btn btn-secondary btn-lg" href="/jurisdictions/">Compare jurisdictions</a></div>
    <ul class="hero-trust"><li><?=icon('check')?>Official sources on every guide</li><li><?=icon('check')?>No invented fees or timelines</li><li><?=icon('check')?>WhatsApp, call or email</li></ul>
  </div>
  <div class="selector" id="setup-finder">
    <h2>Find the right setup</h2>
    <p>Four questions. You get a setup path built from the official guidance for your country.</p>
    <form action="/explore/" method="get">
      <div class="field"><label for="sf-country">Country</label><select class="select" id="sf-country" name="country" required><option value="">Choose a jurisdiction</option><?php foreach($reg['sources'] as $k=>$s):?><option value="<?=e($k)?>"><?=e($s['label'])?></option><?php endforeach;?></select></div>
      <div class="field"><label for="sf-activity">Business activity</label><select class="select" id="sf-activity" name="activity"><?php foreach(ENQUIRY_OPTIONS['activity'] as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
      <div class="field"><label for="sf-ownership">Ownership</label><select class="select" id="sf-ownership" name="ownership"><?php foreach(ENQUIRY_OPTIONS['ownership'] as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
      <div class="field"><label for="sf-visa">Visa requirement</label><select class="select" id="sf-visa" name="visa"><?php foreach(ENQUIRY_OPTIONS['visa'] as $k=>$v):?><option value="<?=e($k)?>"><?=e($v)?></option><?php endforeach;?></select></div>
      <button class="btn btn-primary btn-block" type="submit">Explore options<?=icon('arrow-right')?></button>
      <p class="selector-note"><?=icon('lock')?>No contact details needed for this step.</p>
    </form>
  </div>
</div></section>

<section class="section-tight"><div class="container"><div class="source-band">
  <span class="card-icon"><?=icon('landmark')?></span>
  <div><h2>Built on official sources, not assumptions</h2><p>Every jurisdiction guide cites the authority that controls the rule and shows when the source was last checked.</p>
    <ul class="authority-list"><?php foreach($reg['sources'] as $s):?><li><span class="badge"><?=e($s['authority'])?></span></li><?php endforeach;?></ul></div>
  <a class="btn btn-secondary" href="/about/source-policy/">Our source policy</a>
</div></div></section>

<section class="section section-subtle" id="compare"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Jurisdiction comparison</p><h2>What each authority publishes, side by side.</h2></div><p>Values come from each authority's guidance. Where a figure is not yet verified, we say so instead of guessing.</p></div>
  <?=compare_table('jurisdictions')?>
  <p class="mt-6"><a class="link-arrow" href="/jurisdictions/">Open the full comparison<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section" id="services"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Core services</p><h2>From first question to a running company.</h2></div><p>Each service follows the same discipline: identify the authority, confirm its current requirements, then prepare and coordinate the work.</p></div>
  <div class="grid grid-3"><?php foreach(array_slice($services,0,6,true) as $k=>$s):?><a class="card card-link" href="/services/<?=e($k)?>/"><span class="card-icon"><?=icon($s['icon'])?></span><h3><?=e($s['name'])?></h3><p><?=e($s['summary'])?></p><span class="link-arrow card-foot">Explore<?=icon('arrow-right')?></span></a><?php endforeach;?></div>
  <p class="mt-8"><a class="link-arrow" href="/services/">All services<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section section-dark on-dark"><div class="container">
  <div class="section-head"><div><p class="eyebrow">How INCORPSYS works</p><h2>A clear process, with the authority at the centre.</h2></div></div>
  <ol class="steps">
    <li><h3>Tell us what you need</h3><p>Share your activity, ownership, visa needs and timeline through the enquiry or INCORPSYS Assist.</p></li>
    <li><h3>We map the official route</h3><p>We identify the registry, licensing and other authorities involved and check their current guidance.</p></li>
    <li><h3>Prepare and file</h3><p>We build the document checklist from the authority's own list and coordinate submissions and follow-up.</p></li>
    <li><h3>Stay compliant</h3><p>After incorporation we hand over records and a calendar of renewals and recurring filings.</p></li>
  </ol>
</div></section>

<section class="section"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Why INCORPSYS</p><h2>Trust built on transparency.</h2></div></div>
  <div class="grid grid-4">
    <div class="card card-subtle"><span class="card-icon"><?=icon('landmark')?></span><h3>Source first</h3><p>Rules come from the government or registry, with a link and a checked date.</p></div>
    <div class="card card-subtle"><span class="card-icon"><?=icon('shield-check')?></span><h3>No invented numbers</h3><p>We never publish fees, timelines or approval promises the authority has not published.</p></div>
    <div class="card card-subtle"><span class="card-icon"><?=icon('list-checks')?></span><h3>Structured work</h3><p>Checklists and workflows separate statutory requirements from provider preferences.</p></div>
    <div class="card card-subtle"><span class="card-icon"><?=icon('message-circle')?></span><h3>One point of contact</h3><p>WhatsApp, call or email the same team from enquiry to ongoing compliance.</p></div>
  </div>
</div></section>

<section class="section section-subtle" id="jurisdictions"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Popular destinations</p><h2>Six jurisdictions, each with its own rules.</h2></div><p>Start with the country guide: authority, official route, structures and the in-depth guides behind them.</p></div>
  <div class="grid grid-3"><?php foreach($reg['sources'] as $k=>$s):?><a class="card card-link dest-card" href="<?=e(path_url($k))?>"><div class="dest-top"><span class="dest-code"><?=e($codes[$k])?></span><span class="badge badge-info"><?=$guideCount($k)?> in-depth guides</span></div><h3><?=e($s['label'])?></h3><p class="meta"><?=e($s['authority'])?></p><p><?=e($s['note'])?></p><span class="link-arrow">Explore <?=e($s['label'])?><?=icon('arrow-right')?></span></a><?php endforeach;?></div>
</div></section>

<section class="section"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Business structures</p><h2>Company, branch, subsidiary or representative office?</h2></div><p>The general concepts below apply widely, but the legal detail differs by jurisdiction. Verify locally before you choose.</p></div>
  <?=compare_table('structures')?>
</div></section>

<section class="section section-subtle"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Compliance and support</p><h2>Incorporation is the start, not the finish line.</h2></div><p>Renewals, annual filings and records keep a company in good standing. We help you plan them from day one.</p></div>
  <div class="grid grid-3">
    <a class="card card-link" href="/resources/post-incorporation-calendar/"><span class="card-icon"><?=icon('clock-4')?></span><h3>Compliance calendar</h3><p>Turn post-incorporation obligations into a managed calendar.</p></a>
    <a class="card card-link" href="/resources/compliance-evidence/"><span class="card-icon"><?=icon('file-check-2')?></span><h3>Evidence file</h3><p>Keep filings, approvals and certificates in a defensible record.</p></a>
    <a class="card card-link" href="/services/ongoing-support/"><span class="card-icon"><?=icon('shield-check')?></span><h3>Ongoing support</h3><p>Renewals, registers and authority correspondence handled in one place.</p></a>
  </div>
</div></section>

<section class="section" id="resources"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Knowledge hub</p><h2>Guides that answer the real questions.</h2></div><p>Cross-jurisdiction guides, checklists and glossaries, each pointing to the official source.</p></div>
  <div class="grid grid-3"><?php foreach(['resources/choose-jurisdiction-framework','resources/start-company-abroad','resources/documents-master-checklist','resources/fee-verification','resources/visa-vs-incorporation','resources/banking-readiness'] as $s): $p=$pages[$s];?><a class="card card-link" href="<?=e(path_url($s))?>"><span class="eyebrow">Guide</span><h3 class="mt-2"><?=e($p['name'])?></h3><p><?=e($p['description'])?></p></a><?php endforeach;?></div>
  <p class="mt-8"><a class="link-arrow" href="/resources/">Browse all resources<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section-tight"><div class="container-narrow"><?=faq_accordion($homeFaqs,'Questions founders ask','home-faq')?></div></section>
<?=cta_band('','','Tell us where you want to build.')?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@graph'=>[organization_schema(),['@type'=>'WebSite','@id'=>SITE_URL.'/#website','url'=>SITE_URL,'name'=>'INCORPSYS','publisher'=>['@id'=>SITE_URL.'/#organization'],'inLanguage'=>'en','potentialAction'=>['@type'=>'SearchAction','target'=>['@type'=>'EntryPoint','urlTemplate'=>url('search/').'?q={search_term_string}'],'query-input'=>'required name=search_term_string']]]])?>
<?=json_ld(faq_schema($homeFaqs))?>
<?php include __DIR__.'/partials/footer.php';?>
