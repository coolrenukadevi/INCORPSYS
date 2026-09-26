<?php
declare(strict_types=1);
const SITE_NAME = 'INCORPSYS';
const SITE_URL = 'https://www.incorpsys.com';
const SITE_EMAIL = 'hello@incorpsys.com';
const SITE_PHONE = '+91 78448 19819';
const SITE_PHONE_TEL = '+917844819819';
const WHATSAPP_NUMBER = '917844819819';
const MAIL_FROM = 'noreply@incorpsys.com';
// Official social profiles: footer links and Organization schema sameAs.
const SOCIAL_LINKS = [
  'Facebook' => 'https://www.facebook.com/incorpsys',
  'X' => 'https://x.com/incorpsys',
  'Instagram' => 'https://www.instagram.com/incorpsys',
  'LinkedIn' => 'https://in.linkedin.com/company/incorpsys',
  'YouTube' => 'https://www.youtube.com/@incorpsys',
];
// Allowed answers for the setup finder, INCORPSYS Assist and the enquiry wizard (validated server-side against these keys).
const ENQUIRY_OPTIONS = [
  'need' => ['incorporation' => 'Company incorporation', 'licensing' => 'Business licence', 'banking' => 'Corporate banking', 'visa' => 'Visa & residency', 'compliance' => 'Compliance & documentation', 'support' => 'Ongoing corporate support', 'expansion' => 'International expansion', 'other' => 'Something else'],
  'activity' => ['undecided' => 'Not sure yet', 'trading' => 'Trading / import-export', 'professional' => 'Professional or consulting services', 'technology' => 'Technology / software', 'ecommerce' => 'E-commerce', 'holding' => 'Holding company', 'regulated' => 'Financial or other regulated activity', 'other' => 'Something else'],
  'structure' => ['undecided' => 'Not sure yet', 'new-company' => 'A new company', 'branch' => 'A branch of an existing company'],
  'ownership' => ['undecided' => 'Not sure yet', 'foreign-individual' => 'Individual(s) based abroad', 'local-individual' => 'Individual(s) based in that country', 'corporate' => 'An existing company'],
  'visa' => ['undecided' => 'Not sure yet', 'founders' => 'Yes, for founders', 'employees' => 'Yes, for employees', 'no' => 'No visa needed'],
  'timeline' => ['asap' => 'Within a month', '1-3' => 'In 1–3 months', '3-6' => 'In 3–6 months', 'exploring' => 'Just exploring'],
  'contact_method' => ['email' => 'Email', 'phone' => 'Phone call', 'whatsapp' => 'WhatsApp'],
];
const DEFAULT_TITLE = 'INCORPSYS | Global Company Incorporation';
const DEFAULT_DESCRIPTION = 'Technology-driven global company incorporation and business setup information structured around official source material and clear next steps.';
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
// Absolute URLs: canonical, Open Graph, sitemap and JSON-LD only.
function url(string $path=''): string { return rtrim(SITE_URL,'/').'/'.ltrim($path,'/'); }
function page_url(string $slug): string { $slug=trim($slug,'/'); return url($slug===''?'':$slug.'/'); }
// Root-relative asset URLs so the site renders on any host (staging, local, live).
// The ?v= file timestamp busts the long-lived browser cache whenever a file changes.
function asset(string $path): string {
  $path = ltrim($path,'/');
  $file = __DIR__.'/../assets/'.$path;
  return '/assets/'.$path.(is_file($file) ? '?v='.filemtime($file) : '');
}
function path_url(string $slug): string { $slug=trim($slug,'/'); return '/'.($slug===''?'':$slug.'/'); }
function tel_url(): string { return 'tel:'.SITE_PHONE_TEL; }
function wa_url(string $message='Hello INCORPSYS, I would like to discuss company incorporation.'): string { return 'https://wa.me/'.WHATSAPP_NUMBER.'?text='.rawurlencode($message); }
// Optional per-server settings (not in version control): copy includes/secrets.example.php to includes/secrets.php.
if (is_file(__DIR__.'/secrets.php')) require_once __DIR__.'/secrets.php';
// Shared secret for signing enquiry-form tokens: INCORPSYS_FORM_SECRET (environment) or FORM_SECRET (secrets.php).
function form_secret(): string { return (string)(getenv('INCORPSYS_FORM_SECRET') ?: (defined('FORM_SECRET') ? FORM_SECRET : hash('sha256', __DIR__.php_uname()))); }
function form_token(): string { $t=(string)time(); return $t.'.'.hash_hmac('sha256',$t,form_secret()); }
function site_data(): array { static $d=null; return $d ??= require __DIR__.'/data.php'; }
function site_registry(): array { static $r=null; return $r ??= require __DIR__.'/../content/registry.php'; }
// Every jurisdiction a visitor can choose: guides published (sources) plus those in preparation (pending).
function jurisdiction_labels(): array { $r=site_registry(); return array_map(fn($s)=>$s['label'],$r['sources']+$r['pending']); }
function enquiry_countries(): array { return jurisdiction_labels()+['undecided'=>'Not decided yet']; }
require_once __DIR__.'/../partials/icons.php';
require_once __DIR__.'/../partials/components.php';
require_once __DIR__.'/../content/source-registry.php';
// Swaps <html class="no-js"> to "js" before first paint; allowed by hash in the CSP below.
const JS_FLAG_SCRIPT = "document.documentElement.classList.replace('no-js','js')";
// Google Analytics 4 measurement ID (e.g. G-XXXXXXXXXX), set in the server environment. Empty = analytics off.
// Analytics loads only after the visitor accepts analytics cookies in the consent banner.
function ga_id(): string { $id = (string)(getenv('INCORPSYS_GA_ID') ?: (defined('GA_MEASUREMENT_ID') ? GA_MEASUREMENT_ID : '')); return preg_match('/^G-[A-Z0-9]{4,20}$/', $id) ? $id : ''; }
function send_security_headers(): void {
  if (PHP_SAPI === 'cli' || headers_sent()) return;
  $hash = base64_encode(hash('sha256', JS_FLAG_SCRIPT, true));
  $ga = ga_id() !== '';
  $script = "'self' 'sha256-$hash'".($ga ? ' https://www.googletagmanager.com' : '');
  $connect = "'self'".($ga ? ' https://*.google-analytics.com https://*.analytics.google.com https://*.googletagmanager.com' : '');
  $img = "'self' data:".($ga ? ' https://*.google-analytics.com https://*.googletagmanager.com' : '');
  header("Content-Security-Policy: default-src 'self'; script-src $script; style-src 'self'; img-src $img; font-src 'self'; connect-src $connect; form-action 'self'; frame-ancestors 'self'; base-uri 'self'; object-src 'none'");
}
send_security_headers();
