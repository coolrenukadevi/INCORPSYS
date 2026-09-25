<?php
declare(strict_types=1);
const SITE_NAME = 'INCORPSYS';
const SITE_URL = 'https://www.incorpsys.com';
const SITE_EMAIL = 'hello@incorpsys.com';
const SITE_PHONE = '+91 78448 19819';
const SITE_PHONE_TEL = '+917844819819';
const WHATSAPP_NUMBER = '917844819819';
const MAIL_FROM = 'noreply@incorpsys.com';
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
// Shared secret for signing enquiry-form tokens. Set INCORPSYS_FORM_SECRET in the server environment.
function form_secret(): string { return (string)(getenv('INCORPSYS_FORM_SECRET') ?: hash('sha256', __DIR__.php_uname())); }
function form_token(): string { $t=(string)time(); return $t.'.'.hash_hmac('sha256',$t,form_secret()); }
function site_data(): array { static $d=null; return $d ??= require __DIR__.'/data.php'; }
function site_registry(): array { static $r=null; return $r ??= require __DIR__.'/../content/registry.php'; }
