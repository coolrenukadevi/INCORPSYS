<?php
declare(strict_types=1);
const SITE_NAME = 'INCORPSYS';
const SITE_URL = 'https://www.incorpsys.com';
const SITE_EMAIL = 'hello@incorpsys.com';
const SITE_PHONE = '+91 78448 19819';
const WHATSAPP_NUMBER = '917844819819';
const DEFAULT_TITLE = 'INCORPSYS | Global Company Incorporation';
const DEFAULT_DESCRIPTION = 'Technology-driven global company incorporation and business setup information structured around official source material and clear next steps.';
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
function url(string $path=''): string { return rtrim(SITE_URL,'/').'/'.ltrim($path,'/'); }
function asset(string $path): string { return url('assets/'.ltrim($path,'/')); }
function page_url(string $slug): string { return url(trim($slug,'/').'/'); }
function wa_url(string $message='Hello INCORPSYS, I would like to discuss company incorporation.'): string { return 'https://wa.me/'.WHATSAPP_NUMBER.'?text='.rawurlencode($message); }
