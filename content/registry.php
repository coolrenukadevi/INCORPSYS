<?php
declare(strict_types=1);
// Shared registry: jurisdictions, topic guides and service pages.
$sources=require __DIR__.'/sources.php';
$topics=[
  'company-incorporation-overview'=> 'Company Incorporation Overview',
  'company-registration'=> 'Company Registration',
  'business-name-approval'=> 'Business Name & Name Approval',
  'legal-structures'=> 'Legal Structures',
  'licensing-permits'=> 'Licensing & Permits',
  'registered-office'=> 'Registered Office & Business Address',
  'directors-governance'=> 'Directors, Owners & Governance',
  'documents-checklist'=> 'Documents & Filing Checklist',
  'post-incorporation'=> 'Post-Incorporation Requirements',
  'official-sources'=> 'Official Sources & Verification'
];
$services=[
 'company-incorporation'=>'Company Incorporation','business-licensing'=>'Business Licensing','corporate-banking'=>'Corporate Banking Support','compliance-documentation'=>'Compliance & Documentation','visa-residency'=>'Visa & Residency Support','ongoing-support'=>'Ongoing Corporate Support','registered-office-solutions'=>'Registered Office Solutions','tax-registration'=>'Tax Registration & Setup','due-diligence'=>'Corporate Due Diligence','business-expansion'=>'International Business Expansion'];
return ['sources'=>$sources,'topics'=>$topics,'services'=>$services];
