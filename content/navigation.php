<?php
declare(strict_types=1);
// Site navigation. Only link pages that exist: the QA crawl fails on dead links.
// Wrapped in a closure so its variables do not leak into the template that includes the header.
return (function (): array {
$jur = [];
foreach (site_registry()['sources'] as $key => $src) {
  $jur[] = ['label' => $src['label'], 'desc' => $src['authority'], 'url' => '/'.$key.'/'];
}
return [
  'setup' => [
    'label' => 'Company Setup',
    'cols' => [
      ['title' => 'Jurisdictions', 'links' => array_slice($jur, 0, 3), 'icon' => 'map-pin'],
      ['title' => '&nbsp;', 'links' => array_slice($jur, 3), 'icon' => 'map-pin'],
    ],
    'all' => ['label' => 'Compare all jurisdictions', 'url' => '/jurisdictions/'],
    'feature' => ['title' => 'Not sure where to start?', 'text' => 'Answer four questions and get a setup path built from the official guidance for your country.', 'cta' => 'Find the right setup', 'url' => '/#setup-finder'],
  ],
  'structures' => [
    'label' => 'Business Structures',
    'cols' => [
      ['title' => 'Choosing a structure', 'icon' => 'layers', 'links' => [
        ['label' => 'Legal form decision framework', 'desc' => 'Compare structures without assumptions', 'url' => '/resources/legal-form-decision/'],
        ['label' => 'Branch vs subsidiary', 'desc' => 'Questions to verify before choosing', 'url' => '/resources/branch-vs-subsidiary/'],
        ['label' => 'Local agent requirements', 'desc' => 'Resident agents and representatives', 'url' => '/resources/local-agent-concepts/'],
      ]],
      ['title' => 'By jurisdiction', 'icon' => 'building-2', 'links' => [
        ['label' => 'UAE mainland legal forms', 'desc' => 'Legal form selection', 'url' => '/uae/legal-form-selection/'],
        ['label' => 'UK private limited company', 'desc' => 'Company types', 'url' => '/uk/private-limited-company-type/'],
        ['label' => 'USA business structures', 'desc' => 'Structures described by the SBA', 'url' => '/usa/business-structure/'],
      ]],
      ['title' => '&nbsp;', 'icon' => 'building-2', 'links' => [
        ['label' => 'Singapore business structures', 'desc' => 'Structures registered with ACRA', 'url' => '/singapore/business-structure/'],
        ['label' => 'Hong Kong company types', 'desc' => 'Types and name selection', 'url' => '/hong-kong/company-types-and-name/'],
        ['label' => 'Malaysia company types', 'desc' => 'Companies Act 2016 types', 'url' => '/malaysia/company-types/'],
      ]],
    ],
    'feature' => ['title' => 'Expanding an existing company?', 'text' => 'Hong Kong\'s Companies Registry has a separate registration route for non-Hong Kong companies.', 'cta' => 'Read the guide', 'url' => '/hong-kong/non-hong-kong-company/'],
  ],
  'services' => [
    'label' => 'Services',
    'cols' => [
      ['title' => 'Business setup', 'icon' => 'briefcase-business', 'links' => [
        ['label' => 'Company Incorporation', 'desc' => 'Registry route, name, documents, filing', 'url' => '/services/company-incorporation/'],
        ['label' => 'Business Licensing', 'desc' => 'Activity licences and approvals', 'url' => '/services/business-licensing/'],
        ['label' => 'Corporate Banking', 'desc' => 'Account-opening readiness', 'url' => '/services/corporate-banking/'],
      ]],
      ['title' => 'Ongoing support', 'icon' => 'shield-check', 'links' => [
        ['label' => 'Compliance & Documentation', 'desc' => 'Filings, records, evidence', 'url' => '/services/compliance-documentation/'],
        ['label' => 'Visa & Residency', 'desc' => 'Routed to the immigration authority', 'url' => '/services/visa-residency/'],
        ['label' => 'Corporate Support', 'desc' => 'Renewals, calendar, records', 'url' => '/services/ongoing-support/'],
      ]],
    ],
    'all' => ['label' => 'All services', 'url' => '/services/'],
    'feature' => ['title' => 'Get a structured plan', 'text' => 'Tell us what you need and where. We map every step to the authority that controls it.', 'cta' => 'Get started', 'url' => '/get-started/'],
  ],
  'resources' => [
    'label' => 'Resources',
    'cols' => [
      ['title' => 'Learn', 'icon' => 'book-open-text', 'links' => [
        ['label' => 'Guides', 'desc' => 'All resource guides', 'url' => '/resources/'],
        ['label' => 'Comparisons', 'desc' => 'Jurisdictions side by side', 'url' => '/jurisdictions/'],
        ['label' => 'FAQs', 'desc' => 'Company incorporation questions', 'url' => '/resources/company-incorporation-faq/'],
      ]],
      ['title' => 'Prepare', 'icon' => 'list-checks', 'links' => [
        ['label' => 'Checklists', 'desc' => 'Master documents checklist', 'url' => '/resources/documents-master-checklist/'],
        ['label' => 'Startup setup checklist', 'desc' => 'Plan an international setup', 'url' => '/resources/startup-global-setup-checklist/'],
        ['label' => 'Official sources', 'desc' => 'Government and registry directory', 'url' => '/resources/official-sources-directory/'],
      ]],
    ],
    'feature' => ['title' => 'Source-first research', 'text' => 'How to separate what the authority requires from what a provider asks for.', 'cta' => 'Read the method', 'url' => '/resources/source-first-research/'],
  ],
  'about' => [
    'label' => 'About',
    'cols' => [
      ['title' => 'Company', 'icon' => 'building-2', 'links' => [
        ['label' => 'About INCORPSYS', 'desc' => 'Who we are and what we do', 'url' => '/about/'],
        ['label' => 'Contact', 'desc' => 'Email, phone and WhatsApp', 'url' => '/contact/'],
      ]],
      ['title' => 'Trust', 'icon' => 'badge-check', 'links' => [
        ['label' => 'Methodology', 'desc' => 'How our guides are built', 'url' => '/about/methodology/'],
        ['label' => 'Source policy', 'desc' => 'Which sources we accept', 'url' => '/about/source-policy/'],
        ['label' => 'Editorial policy', 'desc' => 'Independence and corrections', 'url' => '/about/editorial-policy/'],
      ]],
    ],
    'feature' => ['title' => 'Verified, not assumed', 'text' => 'We never publish invented fees, timelines or approval promises.', 'cta' => 'Read our source policy', 'url' => '/about/source-policy/'],
  ],
];
})();
