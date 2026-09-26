<?php
declare(strict_types=1);
/*
 * INCORPSYS site settings — the single place to update business information.
 *
 * Values shown as "[TO BE PROVIDED]" have not been supplied yet. They are never replaced with invented
 * or another company's details. Pages check is_provided() before using a value publicly (schema, footer);
 * the policy pages show the placeholder, highlighted, until it is filled in.
 *
 * Secrets (the form-signing key) do not belong here: see includes/secrets.example.php.
 */

// Brand
const SITE_NAME = 'INCORPSYS';
const SITE_TAGLINE = 'Global Company Incorporation';
const SITE_POSITIONING = 'Smart Technology. Seamless Incorporation. Global Growth.';

// Domain: canonical host is non-www (www redirects here in .htaccess).
const SITE_URL = 'https://incorpsys.com';

// Contact
const SITE_EMAIL = 'hello@incorpsys.com';
const SITE_PHONE = '+91 78448 19819';
const SITE_PHONE_TEL = '+917844819819';
const WHATSAPP_NUMBER = '917844819819';
const MAIL_FROM = 'noreply@incorpsys.com';

// Head office (HO). Shown on the Contact page, in the footer, the policies and the Organization schema.
const HEAD_OFFICE_ADDRESS = 'Flat 203, Sharda Mansion Apartment, Kailashpuri, Kankarbagh, Hanuman Nagar, Patna, Bihar 800020, India';
const HEAD_OFFICE = ['street' => 'Flat 203, Sharda Mansion Apartment, Kailashpuri, Kankarbagh, Hanuman Nagar', 'locality' => 'Patna', 'region' => 'Bihar', 'postcode' => '800020', 'country' => 'IN'];

// Legal entity. Supply the registered details; do not guess them.
// REGISTERED_ADDRESS is the registered office on record (confirmed the same as the head office).
const PLACEHOLDER = '[TO BE PROVIDED]';
const LEGAL_ENTITY_NAME = 'Paynancial Technology Private Limited';
const REGISTRATION_NUMBER = 'U66190BR2024PTC067929';   // CIN (Corporate Identification Number)
const REGISTERED_ADDRESS = HEAD_OFFICE_ADDRESS;   // registered office is the same as the head office
const TAX_ID = '10AAOCP5173C1ZO';                      // GSTIN
const LEGAL_JURISDICTION = PLACEHOLDER;

// Grievance Officer (Grievance Redressal policy)
const GRIEVANCE_OFFICER_NAME = 'Mrs. Anjali Sharma';
const GRIEVANCE_OFFICER_EMAIL = 'gro@incorpsys.com';
const GRIEVANCE_OFFICER_PHONE = '+91 78448 19819';

// Policies: date the approved policies take effect. Set = policies are published (indexable, in the sitemap,
// no draft notice). Empty = policies revert to drafts (noindex, "subject to legal review" notice).
// Approved for publication by INCORPSYS on 26 September 2026.
const POLICIES_EFFECTIVE_DATE = '2026-09-26';

// Analytics: Google Analytics 4 measurement ID, e.g. 'G-XXXXXXXXXX'. Empty = GA never loads.
// It also loads only after a visitor accepts analytics cookies. The INCORPSYS_GA_ID environment variable overrides this.
const GA4_MEASUREMENT_ID = '';

// Commercial: INCORPSYS service fees are not published until supplied. Pages show "Get a Quote" instead.
const SERVICE_FEES_PUBLISHED = false;

function is_provided(string $value): bool { return $value !== '' && $value !== PLACEHOLDER; }
