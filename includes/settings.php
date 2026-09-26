<?php
declare(strict_types=1);
/*
 * INCORPSYS site settings — the single place to update business information.
 *
 * Values shown as "[TO BE PROVIDED]" have not been supplied yet. They are never replaced with invented
 * or another company's details. Pages check is_provided() before using a value publicly (schema, footer);
 * the draft policy pages show the placeholder, highlighted, until it is filled in.
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

// Legal entity — SUBJECT TO LEGAL REVIEW. Supply the registered details; do not guess them.
const PLACEHOLDER = '[TO BE PROVIDED]';
const LEGAL_ENTITY_NAME = PLACEHOLDER;
const REGISTRATION_NUMBER = PLACEHOLDER;
const REGISTERED_ADDRESS = PLACEHOLDER;
const TAX_ID = PLACEHOLDER;
const LEGAL_JURISDICTION = PLACEHOLDER;

// Analytics: Google Analytics 4 measurement ID, e.g. 'G-XXXXXXXXXX'. Empty = GA never loads.
// It also loads only after a visitor accepts analytics cookies. The INCORPSYS_GA_ID environment variable overrides this.
const GA4_MEASUREMENT_ID = '';

// Commercial: INCORPSYS service fees are not published until supplied. Pages show "Get a Quote" instead.
const SERVICE_FEES_PUBLISHED = false;

function is_provided(string $value): bool { return $value !== '' && $value !== PLACEHOLDER; }
