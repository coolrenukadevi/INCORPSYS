<?php
declare(strict_types=1);
// Knowledge Hub categories (brief: Jurisdictions, Company Formation, Business Structures, Licensing, Compliance,
// Banking, Visa, Tax, Checklists, Comparisons, Glossary). Resource slugs are relative to /resources/.
// "Jurisdictions" lists the country guides and is built from the source registry.
return [
  'formation' => ['label' => 'Company Formation', 'slugs' => ['start-company-abroad', 'foreign-founder-preparation', 'business-activity-mapping', 'cross-border-expansion', 'source-first-research', 'how-to-read-official-guidance', 'authority-vs-provider', 'fee-verification', 'timeline-verification', 'source-freshness', 'official-sources-directory', 'enquiry-preparation', 'service-provider-due-diligence', 'company-incorporation-faq']],
  'structures' => ['label' => 'Business Structures', 'slugs' => ['legal-form-decision', 'branch-vs-subsidiary', 'local-agent-concepts']],
  'licensing' => ['label' => 'Licensing', 'slugs' => ['licence-and-approval-mapping']],
  'compliance' => ['label' => 'Compliance', 'slugs' => ['post-incorporation-calendar', 'compliance-evidence', 'document-version-control', 'filing-proof']],
  'banking' => ['label' => 'Banking', 'slugs' => ['banking-readiness']],
  'visa' => ['label' => 'Visa', 'slugs' => ['visa-vs-incorporation']],
  'tax' => ['label' => 'Tax', 'slugs' => ['tax-authority-handoff']],
  'checklists' => ['label' => 'Checklists', 'slugs' => ['documents-master-checklist', 'startup-global-setup-checklist', 'company-name-checklist', 'registered-office-checklist', 'director-shareholder-prep']],
  'comparisons' => ['label' => 'Comparisons', 'slugs' => ['choose-jurisdiction-framework', 'jurisdiction-faq']],
  'glossary' => ['label' => 'Glossary', 'slugs' => ['incorporation-glossary', 'registration-glossary', 'compliance-glossary']],
];
