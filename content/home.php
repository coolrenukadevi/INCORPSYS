<?php
declare(strict_types=1);
/*
 * Homepage content (single source for index.php and partials/home/*).
 * Rules: no invented numbers, fees, timelines, testimonials or affiliations. FAQ answers restate
 * statements from the source registry (content/phase2.php guides) and link to the guide that cites them.
 */
return [
  'hero' => [
    'eyebrow' => 'Global Company Incorporation',
    'h1' => ['Launch Your Global Business', 'With Confidence.'],
    'lead' => 'Incorporation, licensing, banking readiness and ongoing corporate support across major global jurisdictions — with every step mapped to the official authority that controls it.',
    'trust' => ['Source-first', 'Transparent costs', 'Authority-linked information', 'Human support'],
  ],

  // "From Idea to Incorporated Business."
  'process' => [
    ['Choose Jurisdiction', 'Compare what each authority publishes for your activity, ownership and market.', '/jurisdictions/'],
    ['Select Structure', 'Company, branch or subsidiary — confirmed against the local rules.', '/resources/legal-form-decision/'],
    ['Prepare Documents', 'A checklist built from the authority\'s own list, not a generic template.', '/resources/documents-master-checklist/'],
    ['File / Coordinate', 'Submission through the official channel, with evidence of filing kept.', '/services/company-incorporation/'],
    ['Incorporate', 'Registration confirmed by the authority; certificates and records organised.', '/resources/filing-proof/'],
    ['Operate & Stay Compliant', 'Banking readiness, licences, renewals and annual filings on a calendar.', '/resources/post-incorporation-calendar/'],
  ],

  // "Know What You Are Paying For." — categories only; amounts appear only when verified.
  'costs' => [
    ['government', 'Government', 'Official registry and government fees', 'Set by the authority for your structure and activity. Shown only with the official source, currency and verification date.', 'Not yet verified', 'Authority-dependent · USA: state-dependent · UAE: emirate / free-zone dependent'],
    ['incorpsys', 'INCORPSYS', 'Professional service fees', 'Preparation, coordination and follow-up by the INCORPSYS team, quoted for your jurisdiction and scope.', 'Contact for service fee', 'Quoted separately from government fees'],
    ['third', 'Third party', 'Registered office, agent, secretary, licence, visa', 'Charged by providers or other authorities where your route needs them — for example a registered agent or company secretary.', 'Provider-dependent', 'Listed separately in your quote'],
  ],

  // "Why INCORPSYS"
  'why' => [
    ['Source-first', 'Regulatory information mapped to the authoritative source, with a link and the date it was checked.', 'landmark'],
    ['Transparent', 'Government, INCORPSYS and third-party costs kept separate — nothing is presented as official unless it is.', 'layers'],
    ['Technology-driven', 'Digital tools that turn complex setup decisions into a clear, structured workflow.', 'git-compare-arrows'],
    ['Global', 'One platform and one team across multiple business destinations.', 'map-pin'],
  ],

  // Ecosystem nodes: existing service pages only.
  'ecosystem' => [
    ['Company Incorporation', '/services/company-incorporation/', 'briefcase-business'],
    ['Business Licensing', '/services/business-licensing/', 'stamp'],
    ['Banking Readiness', '/services/corporate-banking/', 'landmark'],
    ['Visa & Residency', '/services/visa-residency/', 'id-card'],
    ['Corporate Compliance', '/services/compliance-documentation/', 'shield-check'],
    ['Tax Registration', '/services/tax-registration/', 'calculator'],
    ['Registered Office & Documents', '/services/registered-office-solutions/', 'file-text'],
    ['Global Expansion', '/services/business-expansion/', 'git-compare-arrows'],
  ],

  // Business scenarios → existing verified guides and services.
  'scenarios' => [
    ['Startup', 'Launch your first international company.', [['Start a company abroad', '/resources/start-company-abroad/'], ['Global setup checklist', '/resources/startup-global-setup-checklist/']]],
    ['Global Expansion', 'Enter a new market with an existing business.', [['Cross-border expansion', '/resources/cross-border-expansion/'], ['Expansion support', '/services/business-expansion/']]],
    ['Holding Structure', 'Explore appropriate holding structures.', [['Legal form decision', '/resources/legal-form-decision/'], ['Branch vs subsidiary', '/resources/branch-vs-subsidiary/']]],
    ['Trading Business', 'Establish a cross-border trading operation.', [['Business activity mapping', '/resources/business-activity-mapping/'], ['Licence and approval mapping', '/resources/licence-and-approval-mapping/']]],
    ['Regional Office', 'Explore branch or subsidiary options.', [['Branch vs subsidiary', '/resources/branch-vs-subsidiary/'], ['Local agent requirements', '/resources/local-agent-concepts/']]],
  ],

  // Founder decision module: markets by region (geography only — not a recommendation).
  'regions' => [
    'middle-east' => ['label' => 'Middle East', 'jurisdictions' => ['uae']],
    'asia' => ['label' => 'Asia', 'jurisdictions' => ['singapore', 'hong-kong', 'malaysia']],
    'europe' => ['label' => 'Europe', 'jurisdictions' => ['uk']],
    'americas' => ['label' => 'Americas', 'jurisdictions' => ['usa']],
    'global' => ['label' => 'Several regions / online', 'jurisdictions' => ['uae', 'singapore', 'hong-kong', 'uk', 'usa', 'malaysia']],
  ],

  // Global Business Intelligence (Knowledge Hub) — categories map to content/knowledge-hub.php.
  'knowledge' => [
    'categories' => [['Company Formation', 'formation'], ['Tax', 'tax'], ['Banking', 'banking'], ['Compliance', 'compliance'], ['Visa', 'visa'], ['Global Expansion', 'comparisons']],
    'tiles' => [
      ['Featured guide', 'resources/choose-jurisdiction-framework'],
      ['Jurisdiction comparison', '@compare'],
      ['Founder guide', 'resources/foreign-founder-preparation'],
      ['Official source', 'resources/official-sources-directory'],
      ['Knowledge Hub', '@hub'],
    ],
  ],

  // FAQ — answers restate registry statements; the guide that cites each one is linked on the page.
  'faqs' => [
    ['q' => 'Can a non-resident establish a company in Singapore?', 'a' => 'ACRA sets out additional rules for foreigners, including local-residency requirements and the use of a corporate service provider in certain cases. Check ACRA\'s eligibility rules for your situation, and treat any work pass as a separate immigration step.', 'guide' => 'singapore/eligibility-and-foreigners'],
    ['q' => 'How much does UK company incorporation cost?', 'a' => 'INCORPSYS has not yet verified the current GOV.UK registration fee, so we do not state it here. Check the fee on GOV.UK at the point of registration. INCORPSYS professional fees are quoted separately — contact us for the service fee.', 'guide' => 'resources/fee-verification'],
    ['q' => 'What is the difference between UAE mainland and free zone?', 'a' => 'Mainland, free-zone and offshore routes follow different rules and are administered by different authorities. INCORPSYS guidance currently covers the mainland route described by the UAE Government; free-zone rules are set by each free-zone authority and are pending verification.', 'guide' => 'uae/business-location'],
    ['q' => 'Do I need a local director?', 'a' => 'It depends on the jurisdiction. SSM states that a Malaysian company director must be ordinarily resident in Malaysia; ACRA\'s rules for foreigners include local-residency requirements; GOV.UK requires a UK private company to appoint at least one director. Check the rule for your jurisdiction and structure.', 'guide' => 'resources/foreign-founder-preparation'],
    ['q' => 'How long does incorporation take?', 'a' => 'Processing times are set by each authority and vary with the filing route, referral reviews and document quality. INCORPSYS does not estimate timelines the authority has not published; use the authority\'s current service information.', 'guide' => 'resources/timeline-verification'],
    ['q' => 'What documents are normally required?', 'a' => 'The exact list comes from the authority and varies by entity type, activity and applicant profile. For example, the Hong Kong Companies Registry identifies the incorporation form, articles of association and a notice to the Business Registration Office.', 'guide' => 'resources/documents-master-checklist'],
    ['q' => 'Can INCORPSYS guarantee government approval?', 'a' => 'No. Registries, licensing authorities, banks and immigration authorities make their own decisions. INCORPSYS prepares applications carefully against their published requirements under its Filing Quality Commitment.', 'guide' => null],
    ['q' => 'What costs are government fees versus professional fees?', 'a' => 'Government fees are charged by the registry or authority and are shown only with their official source. INCORPSYS professional fees cover preparation and coordination and are quoted separately. Third-party costs, such as a registered agent or company secretary, are listed separately too.', 'guide' => 'resources/fee-verification'],
  ],

  // Testimonials: real clients only, published with their approval (quote approved by the client, 26 September 2026).
  'testimonials' => [
    ['quote' => 'INCORPSYS made our incorporation journey smooth and transparent. Their team provided clear guidance with official sources, which gave us confidence.', 'name' => 'Mr. Prem Giri', 'org' => 'M/S P. Prakash Consultancy FZE LLC', 'photo' => 'img/testimonials/prem-giri.webp'],
  ],

  'cta' => [
    'kicker' => 'Build Your Business Beyond Borders',
    'title' => 'Your Global Business Starts Here',
    'text' => 'Get expert guidance, source-linked information and end-to-end support for your international expansion.',
    // Map pins: [label, key]. Positions live in site.css (.wm-pin--<key>, CSP forbids inline styles).
    'pins' => [['USA', 'usa'], ['UK', 'uk'], ['UAE', 'uae'], ['Hong Kong', 'hong-kong'], ['Singapore', 'singapore'], ['Malaysia', 'malaysia']],
    'features' => [
      ['globe', 'Global Reach', 'Six key jurisdictions'],
      ['badge-check', 'Expert Guidance', 'From setup to compliance'],
      ['shield-check', 'Transparent Process', 'Clear information and support'],
      ['handshake', 'Long-Term Partnership', 'Support beyond incorporation'],
    ],
  ],
];
