<?php
declare(strict_types=1);
// Service hubs (/services/{slug}/). Describes the INCORPSYS workflow only: no prices, timelines or outcome promises.
// 'guides' lists existing page slugs; missing slugs are skipped at render time.
return [
  'company-incorporation' => [
    'name' => 'Company Incorporation', 'icon' => 'building-2',
    'summary' => 'Plan and prepare a company registration around the official registry route for your jurisdiction, from structure and name through to filing.',
    'answer' => 'Company incorporation support means mapping your structure, name, people and documents to what the registry actually asks for, then preparing a filing that matches it. The registry decides the outcome; INCORPSYS organizes the work so nothing is missed or assumed.',
    'scope' => ['Confirm the registry route and legal form that fit your activity and ownership', 'Check name rules and availability through the official channel', 'Prepare a document and information checklist tied to the registry\'s own list', 'Coordinate signatures, submissions and follow-up questions', 'Hand over incorporation records and the next compliance steps'],
    'provide' => ['Planned business activity and where you will operate', 'Details of shareholders, directors and other officers', 'Proposed company names in order of preference', 'Identity documents when the registry or provider requests them'],
    'guides' => ['resources/start-company-abroad', 'resources/choose-jurisdiction-framework', 'resources/legal-form-decision', 'resources/company-name-checklist', 'resources/documents-master-checklist', 'uae/legal-form-selection', 'singapore/local-company-bizfile', 'hong-kong/electronic-incorporation', 'uk/online-registration', 'usa/state-registration', 'malaysia/direct-incorporation'],
    'faqs' => [
      ['q' => 'Can INCORPSYS guarantee my company will be registered?', 'a' => 'No. Registration decisions are made by the registry. INCORPSYS prepares the application against the registry\'s published requirements to reduce avoidable rejections and queries.'],
      ['q' => 'How much does incorporation cost?', 'a' => 'Government fees vary by jurisdiction, structure and filing route, and they change. We quote only after confirming your requirements and verifying the current official fee schedule, which we show you with its source.'],
      ['q' => 'Do I need to travel to register a company?', 'a' => 'It depends on the jurisdiction and route. Several registries offer online filing; the relevant guide for each country links to the official channel so you can confirm what applies to you.'],
    ],
  ],
  'business-licensing' => [
    'name' => 'Business Licensing', 'icon' => 'stamp',
    'summary' => 'Identify whether your activity needs a licence, permit or approval in addition to registration, and which authority issues it.',
    'answer' => 'Many activities need a licence or approval on top of company registration, and the issuing authority is often different from the registry. Licensing support starts with classifying your activity correctly, then mapping each approval to its official issuer.',
    'scope' => ['Classify your activity using the authority\'s own activity codes or categories', 'Identify sector licences, permits and external approvals that may apply', 'Map each approval to its issuing authority and official application channel', 'Prepare supporting documents and track each application separately', 'Record renewal dates for your compliance calendar'],
    'provide' => ['A plain description of what the business will sell or do', 'Where the business will operate and serve customers', 'Any existing licences held by you or a parent company'],
    'guides' => ['resources/business-activity-mapping', 'resources/licence-and-approval-mapping', 'uae/business-activity-selection', 'uae/trade-licence-categories', 'uae/additional-government-approvals', 'singapore/ssic-business-activity-code', 'hong-kong/business-licences', 'usa/licenses-and-permits', 'usa/local-agencies'],
    'faqs' => [
      ['q' => 'Is a business licence the same as company registration?', 'a' => 'Not necessarily. In some jurisdictions the licence is part of the setup route; in others, registration and licensing are separate processes handled by different authorities. Each country guide explains which applies.'],
      ['q' => 'How do I know if my activity is regulated?', 'a' => 'Start from the authority\'s activity classification and check whether a sector regulator is named for it. Our activity mapping guide shows the method; we confirm it for your specific activity.'],
    ],
  ],
  'corporate-banking' => [
    'name' => 'Corporate Banking Support', 'icon' => 'landmark',
    'summary' => 'Prepare the corporate documents and information banks typically review, kept separate from your incorporation file.',
    'answer' => 'Corporate banking support is readiness work: assembling the company records, ownership information and business explanation a bank reviews. Each bank sets and applies its own requirements, and account-opening decisions belong to the bank alone.',
    'scope' => ['Separate incorporation documents from bank-specific requests', 'Prepare an ownership and control summary', 'Organize a clear description of business activity and expected transactions', 'Track each bank\'s own document list and follow-up questions'],
    'provide' => ['Company registration documents once issued', 'Ownership and management details', 'A description of your customers, suppliers and expected account activity'],
    'guides' => ['resources/banking-readiness', 'resources/authority-vs-provider', 'resources/foreign-founder-preparation'],
    'faqs' => [
      ['q' => 'Can INCORPSYS guarantee a bank account?', 'a' => 'No. Banks make their own decisions under their own policies. We help you prepare a complete, consistent application so the bank can assess it.'],
      ['q' => 'Why do banks ask for documents the registry did not?', 'a' => 'Banks apply their own customer due-diligence requirements. Our banking readiness guide explains how to keep those requests separate from statutory filing requirements.'],
    ],
  ],
  'compliance-documentation' => [
    'name' => 'Compliance & Documentation', 'icon' => 'file-check-2',
    'summary' => 'Build a controlled record of filings, approvals, certificates and the official sources behind them.',
    'answer' => 'Compliance and documentation support keeps a verifiable trail: what was filed, when, with which authority, and on what official basis. It turns incorporation into a managed record rather than scattered files.',
    'scope' => ['Set up a document register with version control', 'Record each filing, approval and certificate with its evidence', 'Keep the official source and verification date for each requirement', 'Flag recurring obligations for the compliance calendar'],
    'provide' => ['Existing company documents and filing receipts', 'Access to official correspondence you want tracked'],
    'guides' => ['resources/compliance-evidence', 'resources/document-version-control', 'resources/filing-proof', 'resources/post-incorporation-calendar', 'singapore/post-registration', 'uk/post-registration', 'usa/ongoing-state-reports', 'malaysia/annual-submission'],
    'faqs' => [
      ['q' => 'What records should a new company keep?', 'a' => 'Record requirements are set by each jurisdiction. As a baseline, keep filings, approvals, certificates and the official guidance you relied on. The country guides link to the authority\'s current rules.'],
      ['q' => 'Can you file annual returns for us?', 'a' => 'We can organize and coordinate recurring filings. The exact filings, deadlines and who may submit them depend on the jurisdiction and are confirmed from the official source.'],
    ],
  ],
  'visa-residency' => [
    'name' => 'Visa & Residency Support', 'icon' => 'id-card',
    'summary' => 'Keep immigration questions separate from incorporation and route each one to the official immigration authority.',
    'answer' => 'Forming a company and obtaining a visa or residency are separate processes, decided by different authorities under different rules. INCORPSYS helps you see which immigration route may be relevant and prepares information for it; the immigration authority makes every decision.',
    'scope' => ['Separate company-formation steps from immigration steps', 'Identify the official immigration authority for your jurisdiction', 'Prepare information the immigration route asks for', 'Coordinate timing between company setup and any visa application'],
    'provide' => ['Nationality and current residence of each applicant', 'The role each person will hold in the company', 'Whether family members are included'],
    'guides' => ['resources/visa-vs-incorporation', 'resources/foreign-founder-preparation', 'singapore/eligibility-and-foreigners', 'singapore/foreign-founder-workflow'],
    'faqs' => [
      ['q' => 'Does setting up a company give me a visa?', 'a' => 'Not automatically. Company formation and immigration are separate processes. Any visa or residency is granted by the immigration authority under its own criteria.'],
      ['q' => 'Can INCORPSYS guarantee a visa?', 'a' => 'No. Immigration decisions are made solely by the competent authority.'],
      ['q' => 'Is the service fee refunded if a visa is rejected?', 'a' => 'No. If a visa or residency application is rejected, no refund of INCORPSYS service fees is provided. See our Refund Policy.'],
    ],
  ],
  'ongoing-support' => [
    'name' => 'Ongoing Corporate Support', 'icon' => 'shield-check',
    'summary' => 'Stay on top of renewals, recurring filings, corporate records and authority communications after incorporation.',
    'answer' => 'Incorporation is the start of a company\'s obligations, not the end. Ongoing support means a maintained calendar of renewals and filings, current corporate records and a single point of contact for authority correspondence.',
    'scope' => ['Build a post-incorporation compliance calendar', 'Track licence renewals and recurring filings', 'Keep registers and corporate records current', 'Coordinate responses to authority correspondence'],
    'provide' => ['Incorporation documents and licences', 'Changes in shareholders, directors or address as they happen'],
    'guides' => ['resources/post-incorporation-calendar', 'resources/compliance-evidence', 'uk/post-registration', 'singapore/post-registration', 'usa/ongoing-state-reports', 'malaysia/annual-submission'],
    'faqs' => [
      ['q' => 'What happens after my company is registered?', 'a' => 'Most jurisdictions have follow-on obligations such as tax registration, annual filings and licence renewals. Each country\'s post-registration guide links to the official requirements.'],
    ],
  ],
  'registered-office-solutions' => [
    'name' => 'Registered Office Solutions', 'icon' => 'map-pin',
    'summary' => 'Check the official address rules for your jurisdiction before choosing a registered office or business address arrangement.',
    'answer' => 'Address rules differ by jurisdiction: some require a local registered office, some a physical business location tied to the licence, and some a registered agent. Confirm the rule with the authority first, then choose an arrangement that meets it.',
    'scope' => ['Confirm the address requirement for your structure and activity', 'Check what evidence of address the authority asks for', 'Compare arrangements against the official rule'],
    'provide' => ['Where the business will actually operate', 'Any address you already hold in the jurisdiction'],
    'guides' => ['resources/registered-office-checklist', 'uae/business-location', 'singapore/business-address', 'hong-kong/registered-office-rules', 'uk/registered-office-and-sic', 'usa/registered-agent', 'malaysia/registered-office-rules'],
    'faqs' => [
      ['q' => 'Can I use a virtual office as a registered office?', 'a' => 'It depends on the jurisdiction and, in some cases, the activity or licence. Check the authority\'s address rules first; the country guides link to them.'],
    ],
  ],
  'tax-registration' => [
    'name' => 'Tax Registration & Setup', 'icon' => 'calculator',
    'summary' => 'Coordinate the handoff from incorporation to tax registration with the competent tax authority.',
    'answer' => 'Tax registration is a separate workstream from incorporation, run by the tax authority rather than the registry. Registration triggers, deadlines and rates depend on the jurisdiction and activity and must come from official tax guidance.',
    'scope' => ['Identify the tax authority and which registrations may apply', 'Confirm registration triggers from official tax guidance', 'Coordinate with your tax adviser on filings and positions'],
    'provide' => ['Company registration details', 'Expected activity, revenue sources and locations'],
    'guides' => ['resources/tax-authority-handoff', 'usa/tax-ids'],
    'faqs' => [
      ['q' => 'Does INCORPSYS give tax advice?', 'a' => 'No. We coordinate tax registration steps and point to official guidance. Tax positions and planning should be confirmed by a qualified tax adviser.'],
      ['q' => 'What tax rate will my company pay?', 'a' => 'Rates depend on the jurisdiction, the type of income and applicable rules, and they change. We do not publish rates unless they are verified from the tax authority.'],
    ],
  ],
  'due-diligence' => [
    'name' => 'Corporate Due Diligence', 'icon' => 'scale',
    'summary' => 'Check official records, source documents and provider claims before relying on a setup decision or partner.',
    'answer' => 'Due diligence tests what you have been told against official records and primary sources: registry details, authority guidance and the documents behind a claim.',
    'scope' => ['Check registry records and official guidance behind a claim', 'Separate statutory requirements from provider preferences', 'Review service-provider proposals against official sources'],
    'provide' => ['The documents, claims or proposals you want checked'],
    'guides' => ['resources/service-provider-due-diligence', 'resources/authority-vs-provider', 'resources/source-first-research', 'resources/how-to-read-official-guidance'],
    'faqs' => [
      ['q' => 'Is this a legal opinion?', 'a' => 'No. Due diligence support checks information against official sources. Legal opinions must come from a qualified lawyer in the relevant jurisdiction.'],
    ],
  ],
  'business-expansion' => [
    'name' => 'International Business Expansion', 'icon' => 'git-compare-arrows',
    'summary' => 'Plan a second-country or multi-country setup, separating entity decisions from operating requirements in each market.',
    'answer' => 'Expansion means repeating setup decisions in a new legal system: structure, branch or subsidiary, licences, tax and people. Each market\'s rules are checked with its own authority rather than copied from the first country.',
    'scope' => ['Compare entity options such as branch or subsidiary where both exist', 'Map operating requirements market by market', 'Sequence setup steps across jurisdictions'],
    'provide' => ['Details of the existing company and group structure', 'Target markets and planned activities'],
    'guides' => ['resources/cross-border-expansion', 'resources/branch-vs-subsidiary', 'resources/choose-jurisdiction-framework', 'hong-kong/non-hong-kong-company', 'usa/foreign-qualification'],
    'faqs' => [
      ['q' => 'Should I open a branch or a subsidiary?', 'a' => 'It depends on liability, tax, licensing and what the local law allows. Our branch vs subsidiary guide lists the questions to verify with the local authority and your advisers.'],
    ],
  ],
];
