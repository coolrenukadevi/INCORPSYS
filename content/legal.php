<?php
declare(strict_types=1);
/*
 * Legal & Support policies (/legal/{slug}/). DRAFTS pending legal review: pages are noindex and show a draft notice.
 * Business-specific terms (amounts, timelines, officer details, governing law) are marked "[To be confirmed: …]"
 * and must be supplied by INCORPSYS — never invented. Search for "[To be confirmed" to find every open item.
 * Entries here override same-slug entries in content/phase2.php.
 */
$tbc = fn(string $what) => '[To be confirmed: '.$what.']';
$legal = function (string $slug, string $name, string $description, string $answer, array $sections, array $faqs = []) {
  return ['slug' => 'legal/'.$slug, 'jurisdiction' => null, 'kind' => 'legal', 'name' => $name, 'title' => $name.' | INCORPSYS', 'h1' => $name,
    'eyebrow' => 'LEGAL & SUPPORT', 'description' => $description, 'answer' => $answer, 'sections' => $sections, 'faqs' => $faqs, 'source' => null, 'verified' => null];
};
$contact = 'Contact INCORPSYS through the Contact page or email '.SITE_EMAIL.'.';

return [
  'legal/privacy' => $legal('privacy', 'Privacy Policy',
    'How INCORPSYS collects, uses, shares and protects personal information submitted through its website and services.',
    'We collect only the information needed to respond to enquiries and deliver our services, we do not sell personal information, and you can ask us to access, correct or delete your information.',
    [
      ['title' => 'Who we are', 'body' => 'INCORPSYS (Incorporation System) operates this website. Legal entity name and registered address: '.$tbc('legal entity name and registered address').'.'],
      ['title' => 'Information we collect', 'bullets' => ['Enquiry details you submit: name, email, phone or WhatsApp number, company name, jurisdiction, business activity, ownership, visa needs, timeline and your message.', 'Documents you share with us during an engagement, only when a specific step requires them.', 'Technical information such as server logs, used for security and to operate the site.', 'With your consent only: website usage measured by Google Analytics (see the Cookie Policy).']],
      ['title' => 'How we use it', 'bullets' => ['To reply to your enquiry and prepare a quote or plan.', 'To deliver the services you engage us for, including preparing filings with the relevant authorities.', 'To meet legal, accounting and record-keeping obligations.', 'To keep the website secure and prevent abuse.']],
      ['title' => 'Who we share it with', 'bullets' => ['Government registries, licensing, tax or immigration authorities, when a filing you asked for requires it.', 'Service providers that help us operate (for example email and hosting), under confidentiality obligations.', 'Professional advisers or partners in the relevant jurisdiction, only when needed for your engagement and with your knowledge.', 'We do not sell personal information.']],
      ['title' => 'How long we keep it', 'body' => 'Enquiries that do not become engagements: '.$tbc('retention period').'. Client records: as long as needed for the engagement and to meet legal and record-keeping obligations, '.$tbc('retention period').'.'],
      ['title' => 'Your rights', 'body' => 'You can ask to access, correct or delete your personal information, or withdraw consent for analytics at any time using "Cookie settings" in the footer. '.$contact],
      ['title' => 'Complaints', 'body' => 'If you are not satisfied with how we handle your information, use our Grievance Redressal process.'],
      ['title' => 'Updates', 'body' => 'Last updated: '.$tbc('effective date').'. Material changes will be shown on this page.'],
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
    'Government fees paid to an authority can be refunded only if that authority refunds them. Refunds of INCORPSYS service fees depend on how much work has been completed, as set out below.',
    [
      ['title' => 'Government and authority fees', 'body' => 'Once a government or authority fee has been paid on your behalf, INCORPSYS cannot refund it; any refund depends on the authority\'s own rules. If an authority refunds a fee to us, we pass it on to you.'],
      ['title' => 'INCORPSYS service fees', 'bullets' => ['Before any work starts: '.$tbc('refund amount or percentage').'.', 'After work has started but before filing: '.$tbc('refund amount or percentage').'.', 'After a filing has been submitted: '.$tbc('refund position').'.']],
      ['title' => 'Outcomes decided by authorities or banks', 'body' => 'Registries, licensing authorities, banks and immigration authorities make their own decisions. A rejection by an authority or bank is handled under this policy as follows: '.$tbc('position on refunds after a rejection').'.'],
      ['title' => 'How to request a refund', 'body' => 'Email '.SITE_EMAIL.' with your name, invoice number and the reason for the request. We acknowledge requests within '.$tbc('number of working days').' and process approved refunds within '.$tbc('number of working days').' to the original payment method.'],
      ['title' => 'Related policies', 'body' => 'See the Cancellation Policy for how to cancel an engagement, and Grievance Redressal if you disagree with a refund decision.'],
    ]),

  'legal/cancellation-policy' => $legal('cancellation-policy', 'Cancellation Policy',
    'How clients can cancel an INCORPSYS engagement, and how cancellation affects fees already paid.',
    'You can cancel an engagement at any time by writing to us. What happens to fees depends on how far the work has progressed and whether government fees have already been paid.',
    [
      ['title' => 'How to cancel', 'body' => 'Email '.SITE_EMAIL.' from the address used for the engagement, with your name and invoice or reference number. Cancellation takes effect when we confirm receipt.'],
      ['title' => 'Cancellation stages', 'bullets' => ['Before work starts: '.$tbc('charges, if any').'.', 'After work starts, before any filing: '.$tbc('charges, e.g. for work completed').'.', 'After a filing or payment to an authority: filings already submitted cannot be withdrawn by INCORPSYS unless the authority allows it; '.$tbc('charges').'.']],
      ['title' => 'Cancellation by INCORPSYS', 'body' => 'We may decline or stop an engagement if requirements cannot be met lawfully, information provided is false or incomplete, or payment is not received. In that case: '.$tbc('refund position').'.'],
      ['title' => 'Refunds after cancellation', 'body' => 'Any refund is handled under the Refund Policy.'],
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
    ]),

  'legal/grievance-redressal' => $legal('grievance-redressal', 'Grievance Redressal',
    'How to raise a complaint with INCORPSYS, who handles it, and how it is escalated and resolved.',
    'Raise a complaint by email with your details and reference number. The Grievance Officer acknowledges it, investigates and replies with a resolution, and you can escalate if you are not satisfied.',
    [
      ['title' => 'Grievance Officer', 'bullets' => ['Name: '.$tbc('name'), 'Designation: '.$tbc('designation'), 'Email: '.$tbc('grievance email address'), 'Address: '.$tbc('postal address'), 'Working hours: '.$tbc('days and hours')]],
      ['title' => 'How to raise a grievance', 'bullets' => ['Email the Grievance Officer with your name, contact details, invoice or reference number, and a clear description of the issue.', 'Attach any relevant correspondence. Do not send passwords or payment card details.', 'Complaints about this website\'s content can also be raised with the page address and the official source you are relying on.']],
      ['title' => 'What happens next', 'bullets' => ['Acknowledgement within '.$tbc('timeframe, e.g. 48 hours').'.', 'Investigation and a written response within '.$tbc('timeframe').'.', 'If more time is needed, we tell you why and when to expect a reply.']],
      ['title' => 'Escalation', 'body' => 'If you are not satisfied with the response, escalate to '.$tbc('escalation contact, e.g. a Director').'. You may also have the right to approach the relevant consumer or regulatory forum under applicable law.'],
      ['title' => 'What is covered', 'body' => 'Service quality, billing and refunds, data and privacy concerns, website content, and conduct of anyone acting for INCORPSYS.'],
    ]),
];
