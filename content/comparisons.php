<?php
declare(strict_types=1);
/*
 * Comparison engine data.
 * Each cell is either null (renders "Not yet verified") or:
 *   ['value' => short text, 'guide' => page slug holding the sourced statement]
 * The guide page carries the official source URL and verification date. Never fill a cell with an estimate.
 * Unknown or unverified values must stay null.
 */
return [
  'jurisdictions' => [
    'title' => 'Jurisdictions at a glance',
    'caption' => 'Company setup by jurisdiction, from each authority\'s published guidance',
    'columns' => [
      'authority' => 'Primary authority',
      'route' => 'Official filing route',
      'name' => 'Company name step',
      'officers' => 'Directors and officers',
      'local' => 'Local agent or secretary',
      'office' => 'Registered office',
      'tax' => 'Tax registration',
      'visa' => 'Visa and residency',
      'banking' => 'Corporate banking',
      'compliance' => 'Ongoing compliance',
      'fees' => 'Government fees',
      'timeline' => 'Processing time',
    ],
    // Column groups for the comparison filter (the authority column is always shown).
    'groups' => [
      'formation' => ['label' => 'Formation', 'cols' => ['route', 'name', 'officers', 'local', 'office']],
      'operating' => ['label' => 'Operating', 'cols' => ['tax', 'visa', 'banking', 'compliance']],
      'cost' => ['label' => 'Cost and time', 'cols' => ['fees', 'timeline']],
    ],
    'rows' => [
      'uae' => [
        'route' => ['value' => 'Emirate authority; online routes such as Basher are described by the UAE Government', 'guide' => 'uae/online-startup-route'],
        'name' => ['value' => 'Trade name registration is a formal step in the mainland process', 'guide' => 'uae/trade-name-registration'],
        'officers' => null,
        'local' => ['value' => 'A local service-agent agreement may apply, depending on legal form', 'guide' => 'uae/memorandum-and-service-agent'],
        'office' => ['value' => 'Physical operating address; premises rules are set locally', 'guide' => 'uae/business-location'],
        'tax' => null, 'visa' => null, 'banking' => null,
        'compliance' => ['value' => 'Some activities need approvals from specialised government entities', 'guide' => 'uae/additional-government-approvals'],
        'fees' => null, 'timeline' => null,
      ],
      'singapore' => [
        'route' => ['value' => 'Bizfile, after reserving the business name', 'guide' => 'singapore/local-company-bizfile'],
        'name' => ['value' => 'Approved names can be reserved for up to 120 days', 'guide' => 'singapore/name-reservation-120-days'],
        'officers' => ['value' => 'Additional rules for foreigners, including local-residency requirements', 'guide' => 'singapore/eligibility-and-foreigners'],
        'local' => ['value' => 'A corporate service provider is required in certain cases for foreigners', 'guide' => 'singapore/eligibility-and-foreigners'],
        'office' => ['value' => 'Business address required; a P.O. Box cannot be the main address', 'guide' => 'singapore/business-address'],
        'tax' => null,
        'visa' => ['value' => 'Work-pass requirements are separate from business registration', 'guide' => 'singapore/foreign-founder-workflow'],
        'banking' => null,
        'compliance' => ['value' => 'ACRA publishes post-registration requirements', 'guide' => 'singapore/post-registration'],
        'fees' => null, 'timeline' => null,
      ],
      'hong-kong' => [
        'route' => ['value' => 'e-Services filing or hard-copy filing', 'guide' => 'hong-kong/electronic-incorporation'],
        'name' => ['value' => 'Check the public company-name index and naming rules', 'guide' => 'hong-kong/company-types-and-name'],
        'officers' => ['value' => 'Director and company-secretary requirements are set out in the Registry FAQ', 'guide' => 'hong-kong/directors-and-secretary'],
        'local' => null,
        'office' => ['value' => 'Registered office of a local limited company must be in Hong Kong', 'guide' => 'hong-kong/registered-office-rules'],
        'tax' => null, 'visa' => null, 'banking' => null,
        'compliance' => ['value' => 'Filings through Registry e-services; public inspection rules apply', 'guide' => 'hong-kong/e-services-and-protected-information'],
        'fees' => null, 'timeline' => null,
      ],
      'uk' => [
        'route' => ['value' => 'Online registration through GOV.UK', 'guide' => 'uk/online-registration'],
        'name' => ['value' => 'Name and trademark checks before registering', 'guide' => 'uk/company-name-and-trademark'],
        'officers' => ['value' => 'At least one director; company secretary optional for a private company', 'guide' => 'uk/directors-and-secretary'],
        'local' => null,
        'office' => ['value' => 'Official registered office and SIC code required', 'guide' => 'uk/registered-office-and-sic'],
        'tax' => ['value' => 'Corporation Tax can be set up during online registration, unless dormant', 'guide' => 'uk/online-registration'],
        'visa' => null, 'banking' => null,
        'compliance' => ['value' => 'GOV.UK lists follow-up steps after incorporation', 'guide' => 'uk/post-registration'],
        'fees' => null, 'timeline' => null,
      ],
      'usa' => [
        'route' => ['value' => 'State-level filing agency; depends on structure and location', 'guide' => 'usa/state-registration'],
        'name' => null,
        'officers' => null,
        'local' => ['value' => 'Registered agent needed in the state of registration for LLCs and corporations', 'guide' => 'usa/registered-agent'],
        'office' => ['value' => 'Location affects registration, tax, zoning and licensing', 'guide' => 'usa/business-location'],
        'tax' => ['value' => 'Federal and state tax IDs are separate from registration', 'guide' => 'usa/tax-ids'],
        'visa' => null, 'banking' => null,
        'compliance' => ['value' => 'Some states require reports soon after registration', 'guide' => 'usa/ongoing-state-reports'],
        'fees' => null, 'timeline' => null,
      ],
      'malaysia' => [
        'route' => ['value' => 'MyCoID: direct incorporation, or name reservation first', 'guide' => 'malaysia/direct-incorporation'],
        'name' => ['value' => 'Apply for incorporation within 30 days of name approval, unless the Registrar allows longer', 'guide' => 'malaysia/name-reservation-window'],
        'officers' => ['value' => 'Directors must be natural persons, at least 18 and ordinarily resident in Malaysia', 'guide' => 'malaysia/director-requirements'],
        'local' => ['value' => 'First company secretary must be appointed within the stated period', 'guide' => 'malaysia/company-secretary'],
        'office' => ['value' => 'Registered office in Malaysia required', 'guide' => 'malaysia/registered-office-rules'],
        'tax' => null, 'visa' => null, 'banking' => null,
        'compliance' => ['value' => 'Annual submissions, including an annual return', 'guide' => 'malaysia/annual-submission'],
        'fees' => null, 'timeline' => null,
      ],
    ],
  ],
  // Business structure concepts: general definitions only, with local verification. No jurisdiction-specific claims.
  'structures' => [
    'title' => 'Common business structures',
    'caption' => 'General concepts — the legal detail differs by jurisdiction and must be verified locally',
    'columns' => ['entity' => 'Legal status', 'liability' => 'Owner liability', 'use' => 'Typically used for', 'check' => 'Verify locally'],
    'rows' => [
      'Company (private limited / LLC)' => ['entity' => 'A legal person separate from its owners', 'liability' => 'Generally limited to the owners\' investment', 'use' => 'Most new operating businesses', 'check' => 'Minimum officers, local residency, ownership limits for the activity', 'guide' => 'resources/legal-form-decision'],
      'Branch of a foreign company' => ['entity' => 'An extension of the parent company, not a new company', 'liability' => 'The parent company is generally responsible', 'use' => 'Existing companies entering a new market', 'check' => 'Whether a branch is permitted for the activity, and its registration route', 'guide' => 'resources/branch-vs-subsidiary'],
      'Subsidiary' => ['entity' => 'A separate company owned by an existing company', 'liability' => 'Generally limited to the subsidiary', 'use' => 'Groups that want local separation of risk', 'check' => 'Foreign-ownership rules and licensing for the activity', 'guide' => 'resources/branch-vs-subsidiary'],
      'Representative office' => ['entity' => 'A presence of a foreign company, where the jurisdiction allows it', 'liability' => 'Depends on local law', 'use' => 'Market research and liaison, where permitted', 'check' => 'Whether it exists locally and which activities it may carry out', 'guide' => 'resources/cross-border-expansion'],
    ],
  ],
];
