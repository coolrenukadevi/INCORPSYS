<?php
declare(strict_types=1);
// Setup paths for /explore/: ordered steps per jurisdiction, each pointing to existing guides.
// Missing slugs are skipped at render time, so a step never links to a page that does not exist.
return [
  'steps' => [
    'structure' => ['title' => 'Choose the legal structure', 'text' => 'The structure decides which laws, filings and ownership rules apply.'],
    'activity' => ['title' => 'Confirm the activity and any licences', 'text' => 'Classify the activity the way the authority does, then check for extra approvals.'],
    'name' => ['title' => 'Choose and check the company name', 'text' => 'Check naming rules and availability through the official channel before branding.'],
    'people' => ['title' => 'Prepare directors, owners and officers', 'text' => 'Confirm who can act as director, owner, secretary or agent under local rules.'],
    'address' => ['title' => 'Confirm the address requirement', 'text' => 'Check the registered office or business location rule for your structure.'],
    'register' => ['title' => 'Register through the official route', 'text' => 'File through the authority\'s channel and keep the evidence of submission.'],
    'banking' => ['title' => 'Prepare for corporate banking', 'text' => 'Banks apply their own requirements, separate from the registry\'s.'],
    'after' => ['title' => 'Plan post-registration obligations', 'text' => 'Tax registration, annual filings and renewals follow incorporation.'],
  ],
  'paths' => [
    'uae' => ['structure' => ['uae/legal-form-selection'], 'activity' => ['uae/business-activity-selection', 'uae/trade-licence-categories'], 'name' => ['uae/trade-name-registration'], 'people' => ['uae/memorandum-and-service-agent'], 'address' => ['uae/business-location'], 'register' => ['uae/initial-approval', 'uae/online-startup-route', 'uae/licence-document-collection'], 'banking' => ['resources/banking-readiness'], 'after' => ['uae/additional-government-approvals', 'resources/post-incorporation-calendar']],
    'singapore' => ['structure' => ['singapore/business-structure'], 'activity' => ['singapore/ssic-business-activity-code'], 'name' => ['singapore/business-name-choice', 'singapore/name-reservation-120-days'], 'people' => ['singapore/eligibility-and-foreigners'], 'address' => ['singapore/business-address'], 'register' => ['singapore/registration-readiness', 'singapore/local-company-bizfile'], 'banking' => ['resources/banking-readiness'], 'after' => ['singapore/post-registration']],
    'hong-kong' => ['structure' => ['hong-kong/company-types-and-name'], 'activity' => ['hong-kong/business-licences'], 'name' => ['hong-kong/company-name-search'], 'people' => ['hong-kong/directors-and-secretary'], 'address' => ['hong-kong/registered-office-rules'], 'register' => ['hong-kong/incorporation-documents', 'hong-kong/electronic-incorporation', 'hong-kong/certificates'], 'banking' => ['resources/banking-readiness'], 'after' => ['hong-kong/e-services-and-protected-information', 'resources/post-incorporation-calendar']],
    'uk' => ['structure' => ['uk/private-limited-company-type'], 'activity' => ['uk/registered-office-and-sic'], 'name' => ['uk/company-name-and-trademark'], 'people' => ['uk/directors-and-secretary', 'uk/shareholders', 'uk/people-with-significant-control'], 'address' => ['uk/registered-office-and-sic'], 'register' => ['uk/constitutional-documents', 'uk/online-registration', 'uk/certificate-of-incorporation'], 'banking' => ['resources/banking-readiness'], 'after' => ['uk/post-registration']],
    'usa' => ['structure' => ['usa/business-structure', 'usa/business-location'], 'activity' => ['usa/licenses-and-permits', 'usa/local-agencies'], 'name' => ['usa/business-name'], 'people' => ['usa/registered-agent'], 'address' => ['usa/business-location'], 'register' => ['usa/state-registration'], 'banking' => ['resources/banking-readiness'], 'after' => ['usa/tax-ids', 'usa/ongoing-state-reports']],
    'malaysia' => ['structure' => ['malaysia/company-types', 'malaysia/basic-incorporation-requirements'], 'activity' => ['resources/licence-and-approval-mapping'], 'name' => ['malaysia/company-name-approval', 'malaysia/name-reservation-window'], 'people' => ['malaysia/director-requirements', 'malaysia/company-secretary'], 'address' => ['malaysia/registered-office-rules'], 'register' => ['malaysia/incorporation-particulars', 'malaysia/direct-incorporation'], 'banking' => ['resources/banking-readiness'], 'after' => ['malaysia/annual-submission']],
  ],
  // Extra reading added by answer.
  'extras' => [
    'ownership:foreign-individual' => ['resources/foreign-founder-preparation', 'singapore/foreign-founder-workflow'],
    'ownership:corporate' => ['resources/branch-vs-subsidiary', 'resources/cross-border-expansion', 'hong-kong/non-hong-kong-company', 'usa/foreign-qualification'],
    'visa:founders' => ['resources/visa-vs-incorporation'],
    'visa:employees' => ['resources/visa-vs-incorporation'],
    'activity:regulated' => ['resources/licence-and-approval-mapping', 'resources/business-activity-mapping'],
    'activity:holding' => ['resources/legal-form-decision', 'resources/branch-vs-subsidiary'],
  ],
];
