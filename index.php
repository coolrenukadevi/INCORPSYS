<?php
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/setup-path.php';
$page=['slug'=>'','title'=>'Global Company Incorporation & Business Setup | INCORPSYS','description'=>'Build your business beyond borders. Company incorporation, licensing, banking readiness and compliance support in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia, organised around official sources.'];
$reg=site_registry();$pages=site_data();$services=require __DIR__.'/content/services.php';
$cmp=(require __DIR__.'/content/comparisons.php')['jurisdictions'];
$guideCount=fn($k)=>count(array_filter($pages,fn($p)=>($p['jurisdiction']??null)===$k&&$p['kind']==='guide'));
$codes=['uae'=>'AE','singapore'=>'SG','hong-kong'=>'HK','uk'=>'UK','usa'=>'US','malaysia'=>'MY'];
$all=$reg['sources']+$reg['pending'];
$setup=setup_path_data();
$sample=$pages['singapore/name-reservation-120-days']??null;
$homeFaqs=[
  ['q'=>'What does INCORPSYS do?','a'=>'INCORPSYS helps founders and companies set up and run businesses in the UAE, Singapore, Hong Kong, the UK, the USA and Malaysia, and is preparing guidance for Saudi Arabia, the Philippines and Thailand. We map each step to the authority that controls it, prepare the information and documents it asks for, and coordinate filings, licences, banking readiness and ongoing compliance.'],
  ['q'=>'Does INCORPSYS guarantee approval?','a'=>'No. Registries, licensing authorities, banks and immigration authorities make their own decisions. We prepare applications against their published requirements so avoidable problems are caught early.'],
  ['q'=>'How much does company setup cost?','a'=>'Government fees depend on the jurisdiction, structure, activity and services selected, and they change. We only show a fee when it comes from the official source, with the date it was checked, and we quote after confirming your requirements.'],
  ['q'=>'Can foreigners set up a company?','a'=>'It depends on the jurisdiction, structure and activity. Some jurisdictions set residency conditions for directors or require a local agent or secretary. Each country guide links to the official eligibility rules, and the comparison summarises what the authorities publish.'],
  ['q'=>'How long does registration take?','a'=>'Processing times are set by each authority and depend on the route and the completeness of the application. We do not estimate timelines unless the authority publishes them.'],
  ['q'=>'Is the setup path legal advice?','a'=>'No. The setup path is an information pathway built from official guidance. A recommendation for your case comes from our team after they review your answers, and the authority always makes the final decision.'],
];
$pillars=[
  ['Source First','Every regulatory claim is tied to the relevant authority, with a link and the date it was checked.'],
  ['No Invented Numbers','No fabricated fees, timelines or approval promises. Where a value is not verified, we say so.'],
  ['Structured Workflow','Statutory requirements are kept separate from service-provider and bank processes.'],
  ['One Point of Contact','One team from enquiry through incorporation and ongoing support.'],
];
$method=[
  ['Authority requirement','What the registry, licensing or immigration authority publishes.'],
  ['INCORPSYS interpretation','What it means for your structure, activity and ownership.'],
  ['Preparation','Documents built from the authority\'s own list, not a generic template.'],
  ['Submission','Filed through the official channel, with proof of submission kept.'],
  ['Evidence','Approvals, certificates and filings stored as a defensible record.'],
  ['Ongoing compliance','Renewals and recurring filings on a managed calendar.'],
];
$lifecycle=[['Research','/resources/'],['Decide','/jurisdictions/'],['Prepare','/resources/documents-master-checklist/'],['Incorporate','/services/company-incorporation/'],['Operate','/services/corporate-banking/'],['Comply','/services/compliance-documentation/']];
$radio=function(string $name,array $opts,bool $req=false,string $cls=''){
  $h='<div class="gs-options'.($cls?' '.$cls:'').'">';$first=true;
  foreach($opts as $k=>$o){ [$label,$sub]=is_array($o)?$o:[$o,'']; $h.='<label class="gs-option"><input type="radio" name="'.e($name).'" value="'.e($k).'"'.($req&&$first?' required':'').'><span>'.($sub!==''?'<b>'.e($sub).'</b>':'').e($label).'</span></label>'; $first=false; }
  return $h.'</div>';
};
include __DIR__.'/partials/header.php';?>
<main id="main">
<section class="hero"><div class="container hero-grid">
  <div class="hero-copy">
    <p class="eyebrow">Global company incorporation</p>
    <h1>Build your business <span>beyond borders.</span></h1>
    <p class="lead">Company incorporation, licensing, banking readiness and compliance support across global jurisdictions — organised around official government sources.</p>
    <div class="hero-actions"><a class="btn btn-cta btn-lg" href="/get-started/">Get Started<?=icon('arrow-right')?></a><a class="btn btn-secondary btn-lg" href="/jurisdictions/">Compare Jurisdictions</a></div>
    <p class="hero-tertiary"><a class="link-arrow" href="#jurisdictions">Explore Jurisdictions<?=icon('arrow-right')?></a></p>
    <ul class="hero-trust" aria-label="How we work"><li><?=icon('check')?>Source-first guidance</li><li><?=icon('check')?>No invented fees or timelines</li><li><?=icon('check')?>Human team, not a bot</li></ul>
  </div>

  <div class="selector gs" id="setup-finder">
    <div class="selector-head"><div><h2>Find the right setup</h2><p>Four questions. An information pathway from official guidance.</p></div><span class="selector-step" data-gs-count aria-hidden="true">No sign-up</span></div>
    <div class="gs-progress" aria-hidden="true"><span></span><span></span><span></span><span></span></div>
    <form class="gs-form" action="/explore/" method="get" data-guided-setup>
      <fieldset class="gs-step"><legend><span class="gs-num">Step 1</span>Where do you want to establish?</legend>
        <?=$radio('country',array_map(fn($k)=>[$all[$k]['label'],$codes[$k]??$all[$k]['code']],array_combine(array_keys($all),array_keys($all))),true,'gs-grid-3')?></fieldset>
      <fieldset class="gs-step"><legend><span class="gs-num">Step 2</span>What will your business do?</legend><?=$radio('activity',ENQUIRY_OPTIONS['activity'],false,'gs-grid-2')?></fieldset>
      <fieldset class="gs-step"><legend><span class="gs-num">Step 3</span>Who will own it?</legend><?=$radio('ownership',ENQUIRY_OPTIONS['ownership'])?></fieldset>
      <fieldset class="gs-step"><legend><span class="gs-num">Step 4</span>Do you need residency or visa support?</legend><?=$radio('visa',ENQUIRY_OPTIONS['visa'])?></fieldset>
      <div class="gs-nav"><button class="btn btn-ghost btn-sm" type="button" data-gs-back hidden><?=icon('arrow-right','icon-flip')?>Back</button><button class="btn btn-primary" type="button" data-gs-next hidden>Next<?=icon('arrow-right')?></button><button class="btn btn-cta btn-block" type="submit" data-gs-submit>Show my setup path<?=icon('arrow-right')?></button></div>
      <p class="selector-note"><?=icon('lock')?>No contact details needed for this step.</p>
    </form>
    <div class="gs-result" data-gs-result tabindex="-1" hidden>
      <p class="eyebrow">Your setup path</p>
      <h3 data-r="title"></h3>
      <dl class="gs-dl">
        <div><dt>Official authority</dt><dd data-r="authority"></dd></div>
        <div data-r-wrap="structure"><dt>Possible structure</dt><dd data-r="structure"></dd></div>
        <div data-r-wrap="route"><dt>Filing route</dt><dd data-r="route"></dd></div>
        <div data-r-wrap="requirements"><dt>Key requirements</dt><dd><ul data-r="requirements"></ul></dd></div>
        <div><dt>Relevant services</dt><dd data-r="services"></dd></div>
        <div><dt>Needs verification</dt><dd data-r="verify"></dd></div>
      </dl>
      <p class="gs-disclaimer"><?=icon('info')?><span><strong>Information pathway, not advice.</strong> Built from official guidance. A recommendation for your case comes from our team, and the authority makes the final decision.</span></p>
      <div class="gs-actions"><a class="btn btn-cta btn-block" data-r="plan" href="/get-started/">Get My Setup Plan<?=icon('arrow-right')?></a><div class="cluster"><a class="link-arrow" data-r="full" href="/explore/">See the full setup path<?=icon('arrow-right')?></a><button class="footer-link-btn gs-restart" type="button" data-gs-restart>Start over</button></div></div>
    </div>
    <script type="application/json" id="setup-data"><?=json_encode($setup,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP)?></script>
  </div>
</div></section>

<section class="trust-bar" aria-labelledby="trust-title"><div class="container">
  <div class="trust-bar-head"><h2 id="trust-title">Built on official sources.</h2><p>Every jurisdiction guide cites the authority that controls the rule. These are sources we read, not partners or endorsers.</p></div>
  <ul class="authority-cards"><?php foreach($reg['sources'] as $k=>$s):?><li><a href="<?=e($s['url'])?>" target="_blank" rel="noopener noreferrer"><span class="authority-kicker"><?=icon('landmark')?>Official source</span><b><?=e(authority_short($k))?></b><span class="authority-country"><?=e($s['label'])?></span><span class="visually-hidden"> (opens official site)</span></a></li><?php endforeach;?></ul>
</div></section>

<section class="section" id="jurisdictions"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Jurisdiction explorer</p><h2>Where do you want to build?</h2></div><p>Each guide starts from the authority that controls the rules: official route, structures and the in-depth guides behind them.</p></div>
  <div class="explorer"><?php foreach($all as $k=>$s): $pend=isset($reg['pending'][$k]); $row=$cmp['rows'][$k]??[];?>
    <article class="explorer-card<?=$pend?' is-pending':''?>">
      <div class="explorer-top"><span class="dest-code"><?=e($codes[$k]??$s['code'])?></span><?=$pend?'<span class="badge badge-warning">'.icon('clock-4').'Guide in preparation</span>':verified_badge($s['verified']??null)?></div>
      <h3><a href="<?=e(path_url($k))?>"><?=e($s['label'])?></a></h3>
      <p class="explorer-auth"><?=icon('landmark')?><?=e($s['authority'])?></p>
      <?php if(!$pend):?>
      <dl class="explorer-dl">
        <?php if(!empty($row['route'])):?><div><dt>Incorporation route</dt><dd><?=e($row['route']['value'])?></dd></div><?php endif;?>
        <div><dt>Coverage</dt><dd><?=$guideCount($k)?> in-depth guides · incorporation, licensing, banking, compliance</dd></div>
      </dl>
      <?php else:?>
      <p class="explorer-note">Enquiries open. We confirm the official requirements for your case before recommending anything.</p>
      <?php endif;?>
      <a class="link-arrow explorer-cta" href="<?=e(path_url($k))?>"><?=$pend?'Enquire about '.e($s['label']):'Explore '.e($s['label'])?><?=icon('arrow-right')?></a>
    </article>
  <?php endforeach;?></div>
</div></section>

<section class="section section-subtle" id="compare"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Compare jurisdictions</p><h2>What each authority publishes, side by side.</h2></div><p>Filter by topic or jurisdiction. Every value links to its source guide; anything we have not verified is marked, never estimated.</p></div>
  <?=compare_table('jurisdictions',null,true)?>
  <p class="mt-6"><a class="link-arrow" href="/jurisdictions/">Open the full comparison<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section" id="why"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Why INCORPSYS</p><h2>Trust built on transparency.</h2></div><p>Four commitments that shape every guide, plan and filing.</p></div>
  <ol class="pillars"><?php foreach($pillars as $i=>[$t,$d]):?><li><span class="pillar-num"><?=sprintf('%02d',$i+1)?></span><h3><?=e($t)?></h3><p><?=e($d)?></p></li><?php endforeach;?></ol>
</div></section>

<section class="section section-dark on-dark" id="method"><div class="container">
  <div class="section-head"><div><p class="eyebrow">The INCORPSYS method</p><h2>Know what the authority requires.</h2></div><p>A source-first workflow from the official requirement to ongoing compliance — so you always know which step is the law and which is our work.</p></div>
  <div class="method">
    <ol class="method-flow"><?php foreach($method as $i=>[$t,$d]):?><li><span class="method-num"><?=$i+1?></span><div><h3><?=e($t)?></h3><p><?=e($d)?></p></div></li><?php endforeach;?></ol>
    <?php if($sample):?>
    <figure class="source-record">
      <figcaption><span class="eyebrow">Example source record</span></figcaption>
      <blockquote><p><?=e($sample['answer'])?></p></blockquote>
      <dl>
        <div><dt>Official authority</dt><dd><?=e($sample['source']['authority'])?></dd></div>
        <div><dt>Source checked</dt><dd><a href="<?=e($sample['source']['url'])?>" target="_blank" rel="noopener noreferrer"><?=e($sample['source']['title'])?><?=icon('external-link')?><span class="visually-hidden"> (opens official site)</span></a></dd></div>
        <div><dt>Last verified</dt><dd><?=e(fmt_date($sample['verified']))?></dd></div>
      </dl>
      <a class="link-arrow" href="<?=e(path_url($sample['slug']))?>">Read the guide<?=icon('arrow-right')?></a>
    </figure>
    <?php endif;?>
  </div>
</div></section>

<section class="section" id="services"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Core services</p><h2>From first question to a running company.</h2></div><p>Each service follows the same discipline: identify the authority, confirm its current requirements, then prepare and coordinate the work.</p></div>
  <ol class="lifecycle" aria-label="The company setup lifecycle"><?php foreach($lifecycle as [$t,$u]):?><li><a href="<?=e($u)?>"><?=e($t)?></a></li><?php endforeach;?></ol>
  <div class="grid grid-3 mt-8"><?php foreach(array_slice($services,0,6,true) as $k=>$s):?><a class="card card-link" href="/services/<?=e($k)?>/"><span class="card-icon"><?=icon($s['icon'])?></span><h3><?=e($s['name'])?></h3><p><?=e($s['summary'])?></p><span class="link-arrow card-foot">Explore<?=icon('arrow-right')?></span></a><?php endforeach;?></div>
  <p class="mt-8"><a class="link-arrow" href="/services/">All services<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section section-subtle"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Business structures</p><h2>Company, branch, subsidiary or representative office?</h2></div><p>The general concepts below apply widely, but the legal detail differs by jurisdiction. Verify locally before you choose.</p></div>
  <?=compare_table('structures')?>
</div></section>

<section class="section"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Compliance and support</p><h2>Incorporation is the start, not the finish line.</h2></div><p>Renewals, annual filings and records keep a company in good standing. We help you plan them from day one.</p></div>
  <div class="grid grid-3">
    <a class="card card-link" href="/resources/post-incorporation-calendar/"><span class="card-icon"><?=icon('clock-4')?></span><h3>Compliance calendar</h3><p>Turn post-incorporation obligations into a managed calendar.</p></a>
    <a class="card card-link" href="/resources/compliance-evidence/"><span class="card-icon"><?=icon('file-check-2')?></span><h3>Evidence file</h3><p>Keep filings, approvals and certificates in a defensible record.</p></a>
    <a class="card card-link" href="/services/ongoing-support/"><span class="card-icon"><?=icon('shield-check')?></span><h3>Ongoing support</h3><p>Renewals, registers and authority correspondence handled in one place.</p></a>
  </div>
</div></section>

<section class="section section-subtle" id="resources"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Knowledge hub</p><h2>Guides that answer the real questions.</h2></div><p>Cross-jurisdiction guides, checklists and glossaries, each pointing to the official source.</p></div>
  <div class="grid grid-3"><?php foreach(['resources/choose-jurisdiction-framework','resources/start-company-abroad','resources/documents-master-checklist','resources/fee-verification','resources/visa-vs-incorporation','resources/banking-readiness'] as $s): $p=$pages[$s];?><a class="card card-link" href="<?=e(path_url($s))?>"><span class="eyebrow">Guide</span><h3 class="mt-2"><?=e($p['name'])?></h3><p><?=e($p['description'])?></p></a><?php endforeach;?></div>
  <p class="mt-8"><a class="link-arrow" href="/resources/">Browse the knowledge hub<?=icon('arrow-right')?></a></p>
</div></section>

<section class="section-tight"><div class="container-narrow"><?=faq_accordion($homeFaqs,'Questions founders ask','home-faq')?></div></section>
<?=cta_band('','','Tell us where you want to build.')?>
</main>
<?=json_ld(['@context'=>'https://schema.org','@graph'=>[organization_schema(),['@type'=>'WebSite','@id'=>SITE_URL.'/#website','url'=>SITE_URL,'name'=>'INCORPSYS','publisher'=>['@id'=>SITE_URL.'/#organization'],'inLanguage'=>'en','potentialAction'=>['@type'=>'SearchAction','target'=>['@type'=>'EntryPoint','urlTemplate'=>url('search/').'?q={search_term_string}'],'query-input'=>'required name=search_term_string']],jurisdiction_item_list()]])?>
<?=json_ld(faq_schema($homeFaqs))?>
<?php include __DIR__.'/partials/footer.php';?>
