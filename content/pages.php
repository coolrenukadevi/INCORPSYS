<?php
declare(strict_types=1);
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
$topicLenses=[
 'company-incorporation-overview'=>'Use this page to establish the official starting point, identify the responsible authority, and map the incorporation route before selecting a service provider.',
 'company-registration'=>'Focus on the actual registration workflow, the information the registry asks for, and the official channel used to submit the application.',
 "business-name-approval"=>"Treat the proposed name as a verification step: check the authority's naming rules and the official availability/approval process before committing to branding or documents.",
 'legal-structures'=>'Compare the structure options only after checking the official definitions, ownership rules and filing consequences that apply in the jurisdiction.',
 'licensing-permits'=>'Start with the business activity and then verify whether an additional licence, permit or approval is required before operations begin.',
 'registered-office'=>'Verify the official address rules, eligibility and documentary evidence required for the registered or operating address where applicable.',
 'directors-governance'=>'Map directors, members, shareholders or other governance roles against the exact requirements published by the relevant authority.',
 'documents-checklist'=>'Use this page as a document-control checklist: distinguish documents explicitly requested by the authority from supporting material requested by a service provider.',
 'post-incorporation'=>'Treat incorporation as the start of the corporate lifecycle: verify registrations, filings, licences and ongoing obligations that follow the initial setup.',
 'official-sources'=>'Use the cited authority as the final verification point and keep the source page, filing evidence and update date with the case file.'
];
$serviceLenses=[
 'company-incorporation'=>'Organize incorporation around the official registry route, with structure, name, documents and submission checkpoints visible before execution.',
 'business-licensing'=>'Start with activity classification, then map any licence or approval pathway to the issuing authority and current application guidance.',
 'corporate-banking'=>'Treat banking support as a separate readiness workflow: corporate documents, authorized persons and bank-specific requirements must be checked with the bank.',
 'compliance-documentation'=>'Build a controlled document trail with source references, version dates and clear ownership of each filing or supporting document.',
 'visa-residency'=>'Keep immigration and residency guidance separate from incorporation rules and verify every visa condition with the relevant official authority.',
 'ongoing-support'=>'Use post-incorporation support to track recurring filings, licence renewals, corporate records and authority communications.',
 'registered-office-solutions'=>'Verify the address rules with the relevant authority before selecting any registered-office arrangement or service.',
 'tax-registration'=>'Treat tax registration as jurisdiction- and activity-specific; confirm the exact authority, registration triggers and deadlines from official tax guidance.',
 'due-diligence'=>'Use due diligence to validate source documents, authority records, ownership information and transaction readiness before relying on a business setup decision.',
 'business-expansion'=>'For expansion, separate incorporation decisions from operational requirements in the target market and verify each stage with the applicable local authority.'
];

$pages=[];
foreach($sources as $key=>$src){
  foreach($topics as $slugTopic=>$topicName){
    $slug=$key.'/'.$slugTopic;
    $pages[$slug]=[
      'slug'=>$slug,'jurisdiction'=>$key,'title'=>$src['label'].' '.$topicName.' | INCORPSYS','h1'=>$topicName.' in '.$src['label'],
      'eyebrow'=>'SOURCE-BACKED JURISDICTION GUIDE',
      'description'=>'A source-backed INCORPSYS guide to '.strtolower($topicName).' in '.$src['label'].', with official-source verification and next-step guidance.',
      'answer'=>'Use the official authority cited on this page as the controlling source for current rules in '.$src['label'].'. INCORPSYS structures the information into practical steps so requirements can be verified before submitting or paying.',
      'sections'=>[
        ['title'=>'What this page covers','body'=>'This guide focuses on which authority controls the step, what the official guidance asks for, what can vary by activity or structure, and what should be verified before filing.'],
        ['title'=>'Official guidance first','body'=>$src['note']],
        ['title'=>'Practical focus for this page','body'=>$topicLenses[$slugTopic]],
        ['title'=>'How INCORPSYS helps','body'=>'INCORPSYS can organize source-backed information into a practical checklist, workflow and enquiry. We do not replace the official registry, licensing authority, tax authority or immigration authority.'],
        ['title'=>'Verification checklist','bullets'=>['Confirm the legal form or registration path with the official authority.','Check the latest forms, supporting documents and identification requirements.','Verify government fees and statutory timelines on the official source before payment.','Check whether the business activity requires an additional licence, permit or approval.','Keep a record of the official page used for the application and any updates published after review.']],
        ['title'=>'Before you start','body'=>'Requirements can depend on business activity, ownership, structure, place of business and the applicant profile. This page therefore avoids presenting third-party assumptions as law and points to the source that should be checked immediately before an application.'],
      ],
      'source'=>$src,
      'faqs'=>[
        ['q'=>'Is this page the legal authority for the process?','a'=>'No. The linked official authority is the controlling source. INCORPSYS presents a structured guide and directs you to the official source for verification.'],
        ['q'=>'Can requirements change after I read this page?','a'=>'Yes. Government forms, fees, procedures and requirements can change. Re-check the official source immediately before filing or payment.'],
        ['q'=>'Can INCORPSYS help with the next step?','a'=>'Yes. Use the enquiry options on this page to request assistance with the relevant incorporation or business setup workflow.']
      ]
    ];
  }
  foreach($services as $serviceSlug=>$serviceName){
    $slug=$key.'/'.$serviceSlug;
    $pages[$slug]=[
      'slug'=>$slug,'jurisdiction'=>$key,'title'=>$serviceName.' in '.$src['label'].' | INCORPSYS','h1'=>$serviceName.' in '.$src['label'],
      'eyebrow'=>'GLOBAL BUSINESS SETUP',
      'description'=>$serviceName.' in '.$src['label'].' with official-source verification, structured workflows and practical next steps from INCORPSYS.',
      'answer'=>'Start with the official authority for '.$src['label'].' and verify which registration, licensing or compliance obligations apply to the exact structure and activity. INCORPSYS can then organize the information into an execution-ready workflow.',
      'sections'=>[
        ['title'=>'Service scope','body'=>$serviceName.' is presented as a structured support workflow rather than a one-size-fits-all outcome. Applicable requirements depend on the business, ownership, activity and local rules described by the relevant authority.'],
        ['title'=>'Source-backed foundation','body'=>$src['note']],
        ['title'=>'Practical service focus','body'=>$serviceLenses[$serviceSlug]],
        ['title'=>'Typical workflow','bullets'=>['Clarify the intended business activity, ownership and operating model.','Identify the applicable authority and official registration route.','Collect the information and documents requested in the official guidance.','Review licences, approvals, tax or post-registration obligations that may apply.','Submit through the official channel and retain evidence of the filing and outcome.']],
        ['title'=>'What INCORPSYS can organize','bullets'=>['Requirement mapping and source verification','Document and information checklist','Application workflow coordination','Follow-up tracking and communication support','Post-incorporation handover and compliance calendar setup']],
        ['title'=>'Important note','body'=>'No pricing, approval time, tax outcome or immigration result is represented here unless supported by a current official source. This keeps the page focused on verifiable information and avoids fabricated claims.']
      ],
      'source'=>$src,
      'faqs'=>[
        ['q'=>'Does every business follow the same process?','a'=>'No. The process can vary by structure, activity, ownership and local rules. Always verify the applicable route with the official authority.'],
        ['q'=>'Where should I confirm current fees?','a'=>'Use the official authority linked on this page and verify the live fee or filing table before payment.'],
        ['q'=>'Can the process include additional approvals?','a'=>'Yes. Depending on the activity, the official authority may require additional licences or approvals.']
      ]
    ];
  }
}
return $pages;
