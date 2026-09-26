<?php
declare(strict_types=1);
/*
 * Legal & Support policies (/legal/{slug}/). Approved for publication by INCORPSYS on 26 September 2026
 * (POLICIES_EFFECTIVE_DATE in includes/settings.php). Clear that date to return them to draft (noindex + notice).
 * Business-specific terms (amounts, timelines, officer details, governing law) are marked "[To be confirmed: …]"
 * and must be supplied by INCORPSYS — never invented. Search for "[To be confirmed" to find every open item.
 * Entries here override same-slug entries in content/phase2.php.
 *
 * Any change to this text needs legal review before it is published. Legal entity details come from
 * includes/settings.php and read "[TO BE PROVIDED]" until supplied.
 */
$tbc = fn(string $what) => '[To be confirmed: '.$what.']';
$effective = POLICIES_EFFECTIVE_DATE !== '' ? date('j F Y', strtotime(POLICIES_EFFECTIVE_DATE)) : $tbc('effective date');
$legal = function (string $slug, string $name, string $description, string $answer, array $sections, array $faqs = []) {
  return ['slug' => 'legal/'.$slug, 'jurisdiction' => null, 'kind' => 'legal', 'name' => $name, 'title' => $name.' | INCORPSYS', 'h1' => $name,
    'eyebrow' => 'LEGAL & SUPPORT', 'description' => $description, 'answer' => $answer, 'sections' => $sections, 'faqs' => $faqs, 'source' => null, 'verified' => null];
};
$contact = 'Contact INCORPSYS through the Contact page or email '.SITE_EMAIL.'.';
$entity = 'Legal entity: '.LEGAL_ENTITY_NAME.'. Registration number: '.REGISTRATION_NUMBER.'. Registered address: '.REGISTERED_ADDRESS.'.';

return [
  'legal/privacy' => $legal('privacy', 'Privacy Policy',
    'How INCORPSYS collects, uses, shares and protects personal information submitted through its website and services.',
    'We collect only the information needed to respond to enquiries and deliver our services, we do not sell personal information, and you can ask us to access, correct or delete your information.',
    [
      ['title' => 'Who we are', 'body' => 'INCORPSYS (Incorporation System) operates this website. '.$entity],
      ['title' => 'Information we collect', 'bullets' => ['Enquiry details you submit: name, email, phone or WhatsApp number, company name, jurisdiction, business activity, ownership, visa needs, timeline and your message.', 'Documents you share with us during an engagement, only when a specific step requires them.', 'Technical information such as server logs, used for security and to operate the site.', 'With your consent only: website usage measured by Google Analytics (see the Cookie Policy).']],
      ['title' => 'How we use it', 'bullets' => ['To reply to your enquiry and prepare a quote or plan.', 'To deliver the services you engage us for, including preparing filings with the relevant authorities.', 'To meet legal, accounting and record-keeping obligations.', 'To keep the website secure and prevent abuse.']],
      ['title' => 'Who we share it with', 'bullets' => ['Government registries, licensing, tax or immigration authorities, when a filing you asked for requires it.', 'Service providers that help us operate (for example email and hosting), under confidentiality obligations.', 'Professional advisers or partners in the relevant jurisdiction, only when needed for your engagement and with your knowledge.', 'We do not sell personal information.']],
      ['title' => 'How long we keep it', 'body' => 'Enquiries that do not become engagements: '.$tbc('retention period').'. Client records: as long as needed for the engagement and to meet legal and record-keeping obligations, '.$tbc('retention period').'.'],
      ['title' => 'Your rights', 'body' => 'You can ask to access, correct or delete your personal information, or withdraw consent for analytics at any time using "Cookie settings" in the footer. '.$contact],
      ['title' => 'Complaints', 'body' => 'If you are not satisfied with how we handle your information, use our Grievance Redressal process.'],
      ['title' => 'Updates', 'body' => 'Last updated: '.$effective.'. Material changes will be shown on this page.'],
    ],
    [['q' => 'Does INCORPSYS sell my data?', 'a' => 'No. We use your information to respond to you and deliver services, and share it only as described in this policy.']]),

  'legal/data-policy' => $legal('data-policy', 'Data Policy',
    'How INCORPSYS handles, secures, stores and deletes client data and documents during company setup and corporate services.',
    'We ask for identity and company documents only when a specific step needs them, through a channel agreed with you; we never ask for passwords or payment card details through website forms.',
    [
      ['title' => 'Scope', 'body' => 'This policy covers personal and company data INCORPSYS handles when you enquire or engage our services, including documents such as passports, company records and proof of address. It works alongside the Privacy Policy.'],
      ['title' => 'Data minimisation', 'bullets' => ['We collect only what an authority, bank or service step actually requires.', 'Website forms do not accept document uploads.', 'We separate what an authority requires from what a service provider or bank asks for, so you know why each item is needed.']],
      ['title' => 'How documents are shared', 'body' => 'Documents are exchanged through a channel agreed with you for each engagement: '.$tbc('approved secure channel(s), e.g. encrypted email or client portal').'. Never send passwords or payment card details.'],
      ['title' => 'Security', 'bullets' => ['Access is limited to team members working on your engagement.', 'The website uses a strict Content-Security-Policy and does not store enquiry data in a public database.', 'Security controls for stored client files: '.$tbc('storage and access controls').'.']],
      ['title' => 'Transfers to authorities and partners', 'body' => 'Filings require us to submit information to the competent authority in the jurisdiction you choose. Where a local professional or partner is involved, we tell you before sharing your information.'],
      ['title' => 'Retention and deletion', 'body' => 'Client files are kept for '.$tbc('retention period').' after an engagement ends, unless the law requires longer, then securely deleted. You can request deletion earlier where the law allows. '.$contact],
      ['title' => 'Data incidents', 'body' => 'If we become aware of a security incident affecting your data, we will inform you without undue delay and explain the steps taken.'],
    ],
    [
      ['q' => 'Can I upload documents through the website?', 'a' => 'No. Website forms do not accept document uploads. Documents are exchanged through a channel agreed with you for each engagement.'],
      ['q' => 'Who can access my documents?', 'a' => 'Access is limited to team members working on your engagement. Where a local professional or partner is involved, we tell you before sharing your information.'],
      ['q' => 'What happens if there is a data incident?', 'a' => 'If we become aware of a security incident affecting your data, we will inform you without undue delay and explain the steps taken.']
    ]),

  'legal/payment-policy' => $legal('payment-policy', 'Payment Policy',
    'How INCORPSYS quotes, invoices and collects payment, and how government fees are kept separate from service fees.',
    'Every quote separates government fees, which are set by the authority and shown with their official source, from INCORPSYS service fees. Work starts once the agreed payment is received.',
    [
      ['title' => 'Quotes', 'bullets' => ['We quote after confirming your jurisdiction, structure, activity and scope.', 'Government and authority fees are listed separately, with the official source and the date they were checked.', 'INCORPSYS service fees are listed separately and never presented as government charges.', 'Quote validity: '.$tbc('number of days').'.']],
      ['title' => 'Invoices and currency', 'body' => 'Invoices are issued in '.$tbc('invoice currency or currencies').'. Applicable taxes: '.$tbc('taxes charged, e.g. GST, and registration details').'.'],
      ['title' => 'Payment methods', 'body' => 'Accepted methods: '.$tbc('bank transfer, card, payment gateway, etc.').'. INCORPSYS will never ask you to pay into a personal account or through a website form.'],
      ['title' => 'When payment is due', 'body' => 'Payment terms: '.$tbc('e.g. advance, milestone-based, or on invoice').'. Government fees are usually collected before filing because they are paid to the authority when the application is submitted.'],
      ['title' => 'Changes in government fees', 'body' => 'Authorities can change their fees without notice. If an official fee changes before it is paid, we will show you the new official figure before proceeding.'],
      ['title' => 'Third-party charges', 'body' => 'Bank charges, currency conversion and courier or attestation costs charged by third parties are passed through at cost, where they apply, and shown on the invoice.'],
    ],
    [['q' => 'Are government fees included in the service fee?', 'a' => 'No. Government fees are listed separately with their official source, because they are set and collected by the authority.']]),

  'legal/refund-policy' => $legal('refund-policy', 'Refund Policy',
    'When INCORPSYS can refund payments, how government fees are treated, and how to request a refund.',
    'Government fees paid to an authority can be refunded only if that authority refunds them. INCORPSYS service fees are non-refundable (0% refund) at every stage.',
    [
      ['title' => 'Government and authority fees', 'body' => 'Once a government or authority fee has been paid on your behalf, INCORPSYS cannot refund it; any refund depends on the authority\'s own rules. If an authority refunds a fee to us, we pass it on to you.'],
      ['title' => 'INCORPSYS service fees', 'bullets' => ['Before any work starts: 0% refund (non-refundable).', 'After work has started but before filing: 0% refund (non-refundable).', 'After a filing has been submitted: 0% refund (non-refundable).']],
      ['title' => 'Outcomes decided by authorities or banks', 'body' => 'Registries, licensing authorities, banks and immigration authorities make their own decisions. INCORPSYS service fees are not refunded (0%) if an application is rejected by an authority or bank. Any refund of a government fee depends on that authority\'s own rules.'],
      ['title' => 'How to request a refund', 'body' => 'Email '.SITE_EMAIL.' with your name, invoice number and the reason for the request. We acknowledge requests within '.$tbc('number of working days').' and process approved refunds within '.$tbc('number of working days').' to the original payment method.'],
      ['title' => 'Related policies', 'body' => 'See the Cancellation Policy for how to cancel an engagement, and Grievance Redressal if you disagree with a refund decision.'],
    ],
    [
      ['q' => 'Are INCORPSYS service fees refundable?', 'a' => 'No. INCORPSYS service fees are non-refundable (0% refund) at every stage, including when an authority or bank rejects an application.'],
      ['q' => 'Are government fees refundable?', 'a' => 'Only if the authority refunds them. Once a government fee has been paid on your behalf, INCORPSYS cannot refund it; if an authority refunds a fee to us, we pass it on to you.'],
      ['q' => 'How do I request a refund?', 'a' => 'Email hello@incorpsys.com with your name, invoice number and the reason for the request.'],
      ['q' => 'What if I disagree with a refund decision?', 'a' => 'Use our Grievance Redressal process.']
    ]),

  'legal/cancellation-policy' => $legal('cancellation-policy', 'Cancellation Policy',
    'How clients can cancel an INCORPSYS engagement, and how cancellation affects fees already paid.',
    'You can cancel an engagement at any time by writing to us. What happens to fees depends on how far the work has progressed and whether government fees have already been paid.',
    [
      ['title' => 'How to cancel', 'body' => 'Email '.SITE_EMAIL.' from the address used for the engagement, with your name and invoice or reference number. Cancellation takes effect when we confirm receipt.'],
      ['title' => 'Cancellation stages', 'bullets' => ['Before work starts: '.$tbc('charges, if any').'.', 'After work starts, before any filing: '.$tbc('charges, e.g. for work completed').'.', 'After a filing or payment to an authority: filings already submitted cannot be withdrawn by INCORPSYS unless the authority allows it; '.$tbc('charges').'.']],
      ['title' => 'Cancellation by INCORPSYS', 'body' => 'We may decline or stop an engagement if requirements cannot be met lawfully, information provided is false or incomplete, or payment is not received. In that case: '.$tbc('refund position').'.'],
      ['title' => 'Refunds after cancellation', 'body' => 'Any refund is handled under the Refund Policy.'],
    ],
    [
      ['q' => 'How do I cancel an engagement?', 'a' => 'Email hello@incorpsys.com from the address used for the engagement, with your name and invoice or reference number. Cancellation takes effect when we confirm receipt.'],
      ['q' => 'Can a filing be withdrawn after it is submitted?', 'a' => 'Filings already submitted cannot be withdrawn by INCORPSYS unless the authority allows it.'],
      ['q' => 'Will I get a refund if I cancel?', 'a' => 'Any refund after cancellation is handled under the Refund Policy.']
    ]),

  'legal/hiring-policy' => $legal('hiring-policy', 'Hiring Policy',
    'How INCORPSYS recruits: fair selection, candidate data, and how to recognise recruitment scams.',
    'INCORPSYS recruits on merit, treats candidate information confidentially, and never asks candidates to pay any fee at any stage of recruitment.',
    [
      ['title' => 'Equal opportunity', 'body' => 'We select candidates on skills, experience and fit for the role, without discrimination on grounds such as gender, religion, caste, disability, age or background.'],
      ['title' => 'How to apply', 'body' => 'Send your CV and a short note about the role or area you are interested in to '.SITE_EMAIL.' with the subject "Careers at INCORPSYS". See the Careers page.'],
      ['title' => 'Selection process', 'body' => 'Typical stages: '.$tbc('e.g. CV review, interview(s), assessment, offer').'. We aim to update applicants within '.$tbc('number of days').'.'],
      ['title' => 'No fees, ever', 'body' => 'INCORPSYS never asks candidates for money — for applications, training, equipment or visas. Offers come only from official INCORPSYS email addresses. Report any suspicious request to '.SITE_EMAIL.'.'],
      ['title' => 'Candidate data', 'body' => 'We use candidate information only for recruitment and keep it for '.$tbc('retention period').' unless you ask us to delete it sooner. Do not send identity documents until an offer stage requires them.'],
    ],
    [
      ['q' => 'Does INCORPSYS charge candidates any fee?', 'a' => 'No. INCORPSYS never asks candidates for money — for applications, training, equipment or visas. Report any such request to hello@incorpsys.com.'],
      ['q' => 'How do I know an offer is genuine?', 'a' => 'Offers come only from official INCORPSYS email addresses.'],
      ['q' => 'When should I send identity documents?', 'a' => 'Only when an offer stage requires them. Do not send identity documents with your application.']
    ]),

  'legal/grievance-redressal' => $legal('grievance-redressal', 'Grievance Redressal',
    'How to raise a complaint with INCORPSYS, who handles it, and how it is escalated and resolved.',
    'Raise a complaint by email with your details and reference number. The Grievance Officer acknowledges it, investigates and replies with a resolution, and you can escalate if you are not satisfied.',
    [
      ['title' => 'Grievance Officer', 'bullets' => ['Name: '.GRIEVANCE_OFFICER_NAME, 'Designation: Grievance Officer', 'Email: '.GRIEVANCE_OFFICER_EMAIL, 'Phone: '.GRIEVANCE_OFFICER_PHONE, 'Address: '.$tbc('postal address'), 'Working hours: '.$tbc('days and hours')]],
      ['title' => 'How to raise a grievance', 'bullets' => ['Email the Grievance Officer at '.GRIEVANCE_OFFICER_EMAIL.' with your name, contact details, invoice or reference number, and a clear description of the issue.', 'Attach any relevant correspondence. Do not send passwords or payment card details.', 'Complaints about this website\'s content can also be raised with the page address and the official source you are relying on.']],
      ['title' => 'What happens next', 'bullets' => ['Acknowledgement within '.$tbc('timeframe, e.g. 48 hours').'.', 'Investigation and a written response within '.$tbc('timeframe').'.', 'If more time is needed, we tell you why and when to expect a reply.']],
      ['title' => 'Escalation', 'body' => 'If you are not satisfied with the response, escalate to '.$tbc('escalation contact, e.g. a Director').'. You may also have the right to approach the relevant consumer or regulatory forum under applicable law.'],
      ['title' => 'What is covered', 'body' => 'Service quality, billing and refunds, data and privacy concerns, website content, and conduct of anyone acting for INCORPSYS.'],
    ],
    [
      ['q' => 'How do I raise a grievance?', 'a' => 'Email the Grievance Officer at '.GRIEVANCE_OFFICER_EMAIL.' with your name, contact details, invoice or reference number and a clear description of the issue, with any relevant correspondence.'],
      ['q' => 'What does the grievance process cover?', 'a' => 'Service quality, billing and refunds, data and privacy concerns, website content, and the conduct of anyone acting for INCORPSYS.'],
      ['q' => 'What if I am not satisfied with the response?', 'a' => 'You can escalate it as described on this page, and you may also have the right to approach the relevant consumer or regulatory forum under applicable law.']
    ]),
  'legal/terms' => $legal('terms', 'Terms of Use',
    'The terms that apply when you use the INCORPSYS website: informational content, enquiries, intellectual property, third-party links and acceptable use.',
    'The INCORPSYS website provides information and enquiry pathways. It is not legal, tax or immigration advice, official sources control over our summaries, and INCORPSYS services are governed separately by our Service Terms and your quotation.',
    [
      ['title' => 'About these terms', 'body' => 'These terms apply to your use of this website, operated by INCORPSYS (Incorporation System). '.$entity.' By using the website you agree to these terms.'],
      ['title' => 'Information, not advice', 'bullets' => ['Content on this website summarises official government and registry guidance and links to it. It is general information, not legal, tax, accounting or immigration advice.', 'Official sources control. Requirements, fees, processing times and eligibility can change without notice; verify them with the competent authority before acting.', 'Where a value is marked "Not yet verified" or "Verification required", we have not confirmed it from an official source.']],
      ['title' => 'Enquiries and accounts', 'bullets' => ['Information you submit must be accurate and yours to share.', 'Sending an enquiry does not create a client engagement. Services start only under a quotation or engagement confirmation, governed by our Service Terms.', 'Keep any account credentials confidential.']],
      ['title' => 'Intellectual property', 'body' => 'Website text, design and the INCORPSYS name and logo belong to INCORPSYS unless stated otherwise. Official source material belongs to the relevant authority. You may link to our pages and quote short extracts with attribution.'],
      ['title' => 'Third-party websites', 'body' => 'Links to government, registry and other websites are provided for reference. Those websites have their own terms and INCORPSYS is not responsible for their content or availability.'],
      ['title' => 'Acceptable use', 'bullets' => ['Do not misuse the website, attempt to gain unauthorised access, or interfere with its operation.', 'Do not submit false, misleading or unlawful information through the enquiry forms.', 'Do not use automated tools in a way that places an unreasonable load on the website.']],
      ['title' => 'Liability', 'body' => 'To the extent permitted by law, INCORPSYS is not liable for decisions made on the basis of website content without verifying current requirements with the competent authority. '.$tbc('liability wording to be approved by legal counsel').'.'],
      ['title' => 'Changes and governing law', 'body' => 'We may update these terms; the current version is always on this page. Governing law and jurisdiction: '.LEGAL_JURISDICTION.'. Last updated: '.$effective.'.'],
    ],
    [['q' => 'Is website content legal advice?', 'a' => 'No. It is general information that summarises official guidance and links to it. Verify current requirements with the competent authority, or ask us to confirm them for your case.'],
     ['q' => 'Does sending an enquiry make me a client?', 'a' => 'No. Services start only under a quotation or engagement confirmation, governed by our Service Terms.']]),

  'legal/service-terms' => $legal('service-terms', 'Service Terms',
    'The terms that apply to INCORPSYS company incorporation, business setup and related professional support services.',
    'INCORPSYS provides company incorporation, business setup and related support within the scope you select. Authorities, regulators, banks and licensing bodies make their own decisions, so INCORPSYS cannot guarantee approvals, account opening, visas, licences or processing times. Fees, refunds, exclusions and deliverables are set out in your quotation or service order.',
    [
      ['title' => 'Our services', 'body' => 'INCORPSYS provides company incorporation, business setup and related professional support services based on the scope selected by the client. Service provider: '.LEGAL_ENTITY_NAME.' (registration number '.REGISTRATION_NUMBER.').'],
      ['title' => 'Decisions by authorities and institutions', 'body' => 'Government, regulatory, banking and licensing decisions remain subject to the relevant authority or institution. INCORPSYS cannot guarantee approval, account opening, visa issuance, licensing or a specific processing time where such decisions are outside our control.'],
      ['title' => 'Your responsibilities', 'body' => 'Clients are responsible for providing accurate, complete and valid information and documentation, and for telling us promptly about any change that affects an application.'],
      ['title' => 'Quotation and service order', 'body' => 'Specific services, fees, refunds, exclusions and deliverables will be governed by the applicable quotation, engagement confirmation or service order. Government and authority fees are shown separately from INCORPSYS professional fees, with their official source.'],
      ['title' => 'Related policies', 'bullets' => ['Filing Quality Commitment — how we prepare and check filings.', 'Payment, Refund and Cancellation policies.', 'Privacy Policy and Data Policy — how we handle your information and documents.']],
      ['title' => 'Governing law', 'body' => 'Governing law and jurisdiction: '.LEGAL_JURISDICTION.'. Last updated: '.$effective.'.'],
    ],
    [['q' => 'Can INCORPSYS guarantee my company, licence, bank account or visa?', 'a' => 'No. Those decisions belong to the relevant authority, bank or institution. We prepare applications carefully against their published requirements.'],
     ['q' => 'Where are my fees and deliverables set out?', 'a' => 'In your quotation, engagement confirmation or service order. INCORPSYS service fees are quoted after we confirm your requirements.']]),

  'legal/filing-quality-commitment' => $legal('filing-quality-commitment', 'Filing Quality Commitment',
    'How INCORPSYS prepares incorporation and business setup documentation: document checks, completeness reviews and coordination of the filing requirements for your jurisdiction.',
    'INCORPSYS is committed to preparing incorporation and business setup documentation carefully and systematically, based on the information and documents you provide. Approval remains at the discretion of the relevant authority, regulator, bank or licensing body.',
    [
      ['title' => 'Our commitment', 'body' => 'INCORPSYS is committed to preparing incorporation and business setup documentation carefully and systematically based on the information and documents provided by the client. Our process includes document checks, completeness reviews and coordination of filing requirements applicable to the selected jurisdiction.'],
      ['title' => 'What the process includes', 'bullets' => ['Document checks against the requirements applicable to the selected jurisdiction.', 'Completeness reviews before submission.', 'Coordination of the filing requirements with you and, where relevant, the authority.']],
      ['title' => 'What we cannot guarantee', 'body' => 'INCORPSYS does not guarantee approval where approval is subject to the discretion of a government authority, regulator, bank, licensing authority or other third party.'],
      ['title' => 'Changes to requirements', 'body' => 'Requirements, government fees, processing timelines and eligibility criteria may change without prior notice. We re-check the official source before filing.'],
    ],
    [['q' => 'Does the Filing Quality Commitment guarantee approval?', 'a' => 'No. It describes how we prepare and check documentation. Approval remains at the discretion of the relevant authority or institution.']]),

  'legal/disclaimer' => $legal('disclaimer', 'Website Disclaimer',
    'Important limits on the information published by INCORPSYS: not the government authority, not legal advice, requirements and fees change, and no outcome is guaranteed.',
    'INCORPSYS is not a government authority. Our guides summarise official sources and link to them, but requirements, fees, processing times and eligibility change; verify current information with the competent authority before filing, payment or operation. No incorporation, licensing, banking or visa outcome is guaranteed.',
    [
      ['title' => 'Not the authority', 'body' => 'INCORPSYS is a private service provider. It is not a government registry, regulator, licensing, tax or immigration authority, and does not act on behalf of one. Authorities make the final decisions.'],
      ['title' => 'Not legal, tax or immigration advice', 'body' => 'Website content is general information. For advice on your circumstances, consult a qualified professional or ask us to confirm the official requirements for your case.'],
      ['title' => 'Sources and verification', 'bullets' => ['Jurisdiction content cites the official source and the date it was last checked.', 'Official pages change; re-check the authority immediately before filing or payment.', 'Values marked "Not yet verified" or "Verification required" have not been confirmed from an official source.']],
      ['title' => 'Fees and timelines', 'body' => 'We show a government fee or processing time only when it comes from the official source. INCORPSYS professional fees are quoted separately after we confirm your requirements.'],
      ['title' => 'No guaranteed outcomes', 'body' => 'INCORPSYS does not guarantee incorporation, licensing, bank account opening, visa issuance or any processing time.'],
    ],
    [['q' => 'Is INCORPSYS a government agency?', 'a' => 'No. INCORPSYS is a private service provider. We link to the official authority for every rule we summarise.']]),
];
