<?php
declare(strict_types=1);
/*
 * Jurisdiction hub profiles (/{jurisdiction}/).
 * 'sections' maps each template section to guide slugs. The template shows each guide's registered
 * statement (its 'answer'), attributed to the guide and the jurisdiction's official source.
 * A section with no guides renders a "pending verification" notice — never filler.
 * 'answer', 'mistakes' and 'faqs' must restate registered statements or give process advice; no new facts.
 */
return [
  'uae' => [
    'answer' => 'For a UAE mainland company, the UAE Government\'s steps cover choosing the business activity, selecting the legal form, determining the licence type, registering a trade name, obtaining initial approval, securing a physical business location and obtaining any additional approvals, before the licence is collected. Premises requirements are governed locally and licence pathways can vary by emirate, so confirm each step with the relevant emirate authority.',
    'sections' => [
      'who' => [],
      'structures' => ['uae/legal-form-selection', 'uae/business-activity-selection'],
      'zones' => [],
      'requirements' => ['uae/business-location', 'uae/memorandum-and-service-agent'],
      'documents' => ['uae/memorandum-and-service-agent', 'uae/licence-document-collection'],
      'licensing' => ['uae/trade-licence-categories', 'uae/additional-government-approvals', 'uae/initial-approval'],
      'banking' => [],
      'tax' => [],
      'visa' => [],
      'compliance' => ['uae/additional-government-approvals'],
    ],
    'mistakes' => [
      'Choosing a legal form before the business activity is confirmed — the official guidance ties both the legal form and licence type to the activity.',
      'Treating initial approval as permission to trade — the UAE Government describes it as a no-objection step, not authority to conduct the activity.',
      'Assuming premises rules are the same in every emirate — the mainland guidance says premises requirements are governed locally.',
      'Relying on third-party fee lists instead of the authority\'s current fee and service page.',
    ],
    'faqs' => [
      ['q' => 'What is the first step to set up a mainland company in the UAE?', 'a' => 'Choose the business activity. The UAE Government says the activity is the basis for selecting the legal form and the licence type.'],
      ['q' => 'Does initial approval let me start trading?', 'a' => 'No. The UAE Government describes initial approval as a no-objection step that allows progress to the next setup steps; it is not itself authority to conduct the business activity.'],
      ['q' => 'Do I need a physical office?', 'a' => 'The official mainland guidance states that businesses need a physical operating address, and that premises requirements are governed locally. Confirm the rule with the relevant emirate authority.'],
      ['q' => 'Can foreigners own a UAE mainland company?', 'a' => 'Ownership conditions can depend on the legal form and activity. Check the ownership-specific conditions for your chosen form with the relevant emirate authority before you apply.'],
      ['q' => 'What about free zones and offshore companies?', 'a' => 'Free-zone and offshore routes follow different rules and authorities from the mainland route. We have not yet published verified guidance on them; ask us and we will confirm the current rules with the relevant authority.'],
    ],
  ],
  'singapore' => [
    'answer' => 'To register a company in Singapore, ACRA\'s guidance runs from choosing a business structure, to choosing and reserving a name, to registering through Bizfile, followed by post-registration requirements. Foreign founders face additional rules, including local-residency requirements and, in certain cases, the use of a corporate service provider.',
    'sections' => [
      'who' => ['singapore/eligibility-and-foreigners', 'singapore/foreign-founder-workflow'],
      'structures' => ['singapore/business-structure'],
      'requirements' => ['singapore/business-address', 'singapore/ssic-business-activity-code'],
      'documents' => ['singapore/registration-readiness'],
      'licensing' => ['singapore/ssic-business-activity-code'],
      'banking' => [],
      'tax' => [],
      'visa' => ['singapore/foreign-founder-workflow'],
      'compliance' => ['singapore/post-registration'],
    ],
    'mistakes' => [
      'Registering a different entity type from the one selected when the name was reserved.',
      'Letting a name reservation expire — ACRA allows up to 120 days.',
      'Using a P.O. Box as the main business address, which ACRA does not allow.',
      'Mixing business-registration and work-pass requirements for overseas founders.',
    ],
    'faqs' => [
      ['q' => 'How long can a company name be reserved in Singapore?', 'a' => 'ACRA states that an approved business name can be reserved for up to 120 days, and the registration must match the reserved entity type.'],
      ['q' => 'Can foreigners register a company in Singapore?', 'a' => 'ACRA sets out additional rules for foreigners, including local-residency requirements and the use of a corporate service provider in certain cases. Check the current eligibility rules before you apply.'],
      ['q' => 'What is an SSIC code?', 'a' => 'ACRA requires applicants to select the most relevant Singapore Standard Industrial Classification (SSIC) code for the business activity when applying for a business name.'],
    ],
  ],
  'hong-kong' => [
    'answer' => 'To incorporate a local company in Hong Kong, choose the company type, check the name against the Companies Registry\'s name index, prepare the incorporation form and articles, and file electronically or in hard copy. The registered office must be in Hong Kong, and sector licences are separate from incorporation.',
    'sections' => [
      'who' => ['hong-kong/directors-and-secretary'],
      'structures' => ['hong-kong/company-types-and-name', 'hong-kong/non-hong-kong-company'],
      'requirements' => ['hong-kong/registered-office-rules', 'hong-kong/directors-and-secretary'],
      'documents' => ['hong-kong/incorporation-documents', 'hong-kong/certificates'],
      'licensing' => ['hong-kong/business-licences'],
      'banking' => [],
      'tax' => [],
      'visa' => [],
      'compliance' => ['hong-kong/e-services-and-protected-information'],
    ],
    'mistakes' => [
      'Skipping the official name search before preparing documents.',
      'Assuming incorporation covers sector permits — the Registry directs applicants to separate licensing information.',
      'Treating a service provider\'s document preferences as statutory requirements.',
    ],
    'faqs' => [
      ['q' => 'Where must a Hong Kong company\'s registered office be?', 'a' => 'The Companies Registry states that the registered office of a local limited company must be situated in Hong Kong.'],
      ['q' => 'Can I incorporate online?', 'a' => 'The Companies Registry supports electronic filing through its e-Services as well as hard-copy filing routes.'],
      ['q' => 'Can an overseas company operate in Hong Kong without a new company?', 'a' => 'A company incorporated outside Hong Kong that establishes a place of business there may have a separate registration route with the Companies Registry.'],
    ],
  ],
  'uk' => [
    'answer' => 'To set up a UK private limited company, GOV.UK guides you to choose the company type, appoint at least one director, identify shareholders and people with significant control, prepare constitutional documents, choose a name, registered office and SIC code, then register online. The certificate of incorporation confirms the company exists.',
    'sections' => [
      'who' => ['uk/directors-and-secretary', 'uk/shareholders', 'uk/people-with-significant-control'],
      'structures' => ['uk/private-limited-company-type'],
      'requirements' => ['uk/registered-office-and-sic', 'uk/company-name-and-trademark'],
      'documents' => ['uk/constitutional-documents', 'uk/certificate-of-incorporation'],
      'licensing' => [],
      'banking' => [],
      'tax' => ['uk/online-registration', 'uk/post-registration'],
      'visa' => [],
      'compliance' => ['uk/post-registration'],
    ],
    'mistakes' => [
      'Confusing company-name availability with trademark clearance — GOV.UK treats them as separate checks.',
      'Leaving PSC information incomplete at registration.',
      'Assuming a company secretary is mandatory for a private company — GOV.UK treats it as optional.',
    ],
    'faqs' => [
      ['q' => 'How many directors does a UK private company need?', 'a' => 'At least one. Under the GOV.UK formation guidance, a company secretary is optional for a private company.'],
      ['q' => 'What is a PSC?', 'a' => 'A person with significant control. UK incorporation requires companies to identify them, including relevant ownership or voting control information.'],
      ['q' => 'Does registering set up Corporation Tax?', 'a' => 'GOV.UK\'s online registration route may set up Corporation Tax at the same time, unless the company is dormant.'],
    ],
  ],
  'usa' => [
    'answer' => 'In the USA, registration depends on the business structure and location and often involves a state-level filing agency. The SBA advises choosing a business location and structure first, because they affect taxes, liability and filing obligations, then registering with the state filing agency, appointing a registered agent where required, obtaining federal and state tax IDs, and checking state and local licences.',
    'sections' => [
      'who' => [],
      'structures' => ['usa/business-structure', 'usa/business-location'],
      'requirements' => ['usa/registered-agent', 'usa/business-name'],
      'documents' => ['usa/state-registration'],
      'licensing' => ['usa/licenses-and-permits', 'usa/local-agencies'],
      'banking' => [],
      'tax' => ['usa/tax-ids'],
      'visa' => [],
      'compliance' => ['usa/ongoing-state-reports', 'usa/foreign-qualification'],
    ],
    'mistakes' => [
      'Choosing a state without considering where the business will actually operate — location affects taxes, zoning and licensing.',
      'Forgetting foreign qualification when operating in more than one state.',
      'Assuming state registration covers city or county licences.',
    ],
    'faqs' => [
      ['q' => 'Do I need a registered agent?', 'a' => 'For LLCs, corporations, partnerships and nonprofits, the SBA notes that a registered agent is needed in the state where the entity registers.'],
      ['q' => 'Is registration federal or state-level?', 'a' => 'SBA guidance explains that registration depends on the business structure and location and often involves the state-level filing authority.'],
      ['q' => 'What if I operate in several states?', 'a' => 'The SBA explains that an entity active in more than one state may need foreign qualification in the additional states.'],
    ],
  ],
  'malaysia' => [
    'answer' => 'To incorporate a company in Malaysia, SSM requires name approval and the incorporation particulars through MyCoID — either direct incorporation or name reservation first. Directors must meet SSM\'s eligibility rules, including ordinary residence in Malaysia; a company secretary must be appointed within the stated period; and annual submissions follow.',
    'sections' => [
      'who' => ['malaysia/director-requirements', 'malaysia/basic-incorporation-requirements'],
      'structures' => ['malaysia/company-types'],
      'requirements' => ['malaysia/registered-office-rules', 'malaysia/company-secretary'],
      'documents' => ['malaysia/incorporation-particulars'],
      'licensing' => [],
      'banking' => [],
      'tax' => [],
      'visa' => [],
      'compliance' => ['malaysia/annual-submission', 'malaysia/company-secretary'],
    ],
    'mistakes' => [
      'Missing the filing window after name approval — SSM expects the application within 30 days unless the Registrar allows longer.',
      'Appointing a director who is not ordinarily resident in Malaysia.',
      'Forgetting the deadline for appointing the first company secretary.',
    ],
    'faqs' => [
      ['q' => 'Who can be a director of a Malaysian company?', 'a' => 'SSM states that a director must be a natural person, at least 18, ordinarily resident in Malaysia, and meet the other published eligibility conditions.'],
      ['q' => 'What company types can I register?', 'a' => 'SSM lists company limited by shares, company limited by guarantee and unlimited company as company types under the Companies Act 2016.'],
      ['q' => 'Can I reserve a name and incorporate at the same time?', 'a' => 'SSM permits an online direct-incorporation method that combines name reservation and incorporation, alongside a separate name-reservation route.'],
    ],
  ],
];
