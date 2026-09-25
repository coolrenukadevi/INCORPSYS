<?php
declare(strict_types=1);
/*
 * Comparison engine data.
 * Each cell is either null (renders "Verify") or:
 *   ['value' => short text, 'guide' => page slug holding the sourced statement]
 * The guide page carries the official source URL and verification date. Never fill a cell with an estimate.
 * Unknown or unverified values must stay null.
 */
return [
  'jurisdictions' => [
    'title' => 'Jurisdictions at a glance',
    'caption' => 'Company setup across six jurisdictions, from each authority\'s published guidance',
    'columns' => [
      'authority' => 'Primary authority',
      'route' => 'Official filing route',
      'name' => 'Company name step',
      'officers' => 'Directors and officers',
      'local' => 'Local agent or secretary',
      'fees' => 'Government fees',
      'timeline' => 'Processing time',
    ],
    'rows' => [
      'uae' => [
        'route' => ['value' => 'Emirate authority; online routes such as Basher are described by the UAE Government', 'guide' => 'uae/online-startup-route'],
        'name' => ['value' => 'Trade name registration is a formal step in the mainland process', 'guide' => 'uae/trade-name-registration'],
        'officers' => null,
        'local' => ['value' => 'A local service-agent agreement may apply, depending on legal form', 'guide' => 'uae/memorandum-and-service-agent'],
        'fees' => null, 'timeline' => null,
      ],
      'singapore' => [
        'route' => ['value' => 'Bizfile, after reserving the business name', 'guide' => 'singapore/local-company-bizfile'],
        'name' => ['value' => 'Approved names can be reserved for up to 120 days', 'guide' => 'singapore/name-reservation-120-days'],
        'officers' => ['value' => 'Additional rules for foreigners, including local-residency requirements', 'guide' => 'singapore/eligibility-and-foreigners'],
        'local' => ['value' => 'A corporate service provider is required in certain cases for foreigners', 'guide' => 'singapore/eligibility-and-foreigners'],
        'fees' => null, 'timeline' => null,
      ],
      'hong-kong' => [
        'route' => ['value' => 'e-Services filing or hard-copy filing', 'guide' => 'hong-kong/electronic-incorporation'],
        'name' => ['value' => 'Check the public company-name index and naming rules', 'guide' => 'hong-kong/company-types-and-name'],
        'officers' => ['value' => 'Director and company-secretary requirements are set out in the Registry FAQ', 'guide' => 'hong-kong/directors-and-secretary'],
        'local' => null,
        'fees' => null, 'timeline' => null,
      ],
      'uk' => [
        'route' => ['value' => 'Online registration through GOV.UK', 'guide' => 'uk/online-registration'],
        'name' => ['value' => 'Name and trademark checks before registering', 'guide' => 'uk/company-name-and-trademark'],
        'officers' => ['value' => 'At least one director; company secretary optional for a private company', 'guide' => 'uk/directors-and-secretary'],
        'local' => null,
        'fees' => null, 'timeline' => null,
      ],
      'usa' => [
        'route' => ['value' => 'State-level filing agency; depends on structure and location', 'guide' => 'usa/state-registration'],
        'name' => null,
        'officers' => null,
        'local' => ['value' => 'Registered agent needed in the state of registration for LLCs and corporations', 'guide' => 'usa/registered-agent'],
        'fees' => null, 'timeline' => null,
      ],
      'malaysia' => [
        'route' => ['value' => 'MyCoID: direct incorporation, or name reservation first', 'guide' => 'malaysia/direct-incorporation'],
        'name' => ['value' => 'Apply for incorporation within 30 days of name approval, unless the Registrar allows longer', 'guide' => 'malaysia/name-reservation-window'],
        'officers' => ['value' => 'Directors must be natural persons, at least 18 and ordinarily resident in Malaysia', 'guide' => 'malaysia/director-requirements'],
        'local' => ['value' => 'First company secretary must be appointed within the stated period', 'guide' => 'malaysia/company-secretary'],
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
