<?php
/*
 * INCORPSYS quality gate: crawls a running copy of the site and checks SEO, indexability, links,
 * schema and content depth. Read-only; it never changes files.
 *
 *   php tools/qa.php                          # local copy at http://127.0.0.1:8080
 *   php tools/qa.php https://incorpsys.com    # live site
 *
 * Exit code 0 = all hard checks passed, 1 = at least one failure (warnings do not fail).
 */
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__.'/../includes/config.php';

$base = rtrim($argv[1] ?? 'http://127.0.0.1:8080', '/');
$canonicalBase = rtrim(SITE_URL, '/');
$minWords = 250; // main-content words below which an indexable page is reported as thin

function fetch(string $url): array {
  if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => false, CURLOPT_TIMEOUT => 20, CURLOPT_USERAGENT => 'INCORPSYS-QA/1.0', CURLOPT_HEADER => true]);
    $raw = (string)curl_exec($ch); $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE); $hs = (int)curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    curl_close($ch);
    return [$code, substr($raw, $hs), substr($raw, 0, $hs)];
  }
  // Fallback without the curl extension (needs allow_url_fopen).
  $ctx = stream_context_create(['http' => ['ignore_errors' => true, 'follow_location' => 0, 'timeout' => 20, 'user_agent' => 'INCORPSYS-QA/1.0']]);
  $body = (string)@file_get_contents($url, false, $ctx);
  $headers = implode("\n", $http_response_header ?? []);
  $code = preg_match('/^HTTP\/\S+\s+(\d{3})/', $headers, $m) ? (int)$m[1] : 0;
  return [$code, $body, $headers];
}
function attr(string $html, string $re): ?string { return preg_match($re, $html, $m) ? html_entity_decode($m[1], ENT_QUOTES) : null; }

$fail = []; $warn = [];
$queue = ['/']; $seen = []; $pages = []; $inbound = [];
while ($queue) {
  $path = array_pop($queue);
  if (isset($seen[$path])) continue;
  [$code, $body, $headers] = fetch($base.$path); $seen[$path] = $code;
  if ($code !== 200) continue;
  if (!preg_match('/content-type:\s*text\/html/i', $headers)) continue;
  if (!str_contains($body, '</html>')) $fail[] = "Truncated page (render error): $path";
  $robots = attr($body, '/<meta name="robots" content="([^"]+)"/') ?? '';
  $main = preg_match('/<main[^>]*>(.*)<\/main>/s', $body, $m) ? $m[1] : '';
  $text = trim(preg_replace('/\s+/', ' ', strip_tags(preg_replace('/<(script|style|nav|aside)[^>]*>.*?<\/\1>/s', ' ', $main))));
  $types = [];
  foreach (preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $body, $mm) ? $mm[1] : [] as $json) {
    $d = json_decode($json, true);
    if ($d === null) { $fail[] = "Invalid JSON-LD: $path"; continue; }
    array_walk_recursive($d, function ($v, $k) use (&$types) { if ($k === '@type' && is_string($v)) $types[$v] = true; });
  }
  $pages[$path] = [
    'index' => !str_contains($robots, 'noindex'),
    'title' => attr($body, '/<title>(.*?)<\/title>/s'),
    'desc' => attr($body, '/<meta name="description" content="([^"]*)"/'),
    'canonical' => attr($body, '/<link rel="canonical" href="([^"]+)"/'),
    'h1' => preg_match_all('/<h1[\s>]/', $body),
    'crumbs' => str_contains($body, 'class="breadcrumbs"'),
    'faq' => isset($types['FAQPage']) || str_contains($body, 'faq-list'),
    'types' => $types,
    'words' => str_word_count($text),
    'og' => str_contains($body, 'property="og:title"') && str_contains($body, 'name="twitter:card"'),
  ];
  if (preg_match_all('/href="(\/[^"#]*)(?:#[^"]*)?"/', $body, $lm)) foreach ($lm[1] as $href) {
    $href = html_entity_decode($href);
    if (str_starts_with($href, '//') || str_starts_with($href, '/assets/') || str_ends_with($href, '.webmanifest') || str_ends_with($href, '.ico')) continue;
    $inbound[strtok($href, '?')][$path] = true;
    $queue[] = $href;
  }
}

// Links and status codes
foreach ($seen as $p => $c) if ($c !== 200 && $p !== '/nope/') $fail[] = "Broken internal link target ($c): $p";

// Metadata, canonical, headings, schema, depth — indexable pages
// Parameter variants (e.g. /get-started/?country=uk) canonicalise to their base URL, so they are checked once.
$indexable = array_filter($pages, fn($p, $path) => $p['index'] && !str_contains($path, '?'), ARRAY_FILTER_USE_BOTH);
foreach ($pages as $path => $p) if (str_contains($path, '?') && $p['index'] && $p['canonical'] !== $canonicalBase.strtok($path, '?')) $fail[] = "Parameter URL not canonicalised to its base: $path";
$webPageTypes = ['WebPage', 'CollectionPage', 'AboutPage', 'ContactPage', 'FAQPage', 'SearchResultsPage', 'ItemPage', 'ProfilePage'];
$faqExempt = ['/sitemap/']; // navigation page: no FAQ intended
$dupT = []; $dupD = [];
foreach ($indexable as $path => $p) {
  $dupT[$p['title']][] = $path; $dupD[$p['desc']][] = $path;
  $want = $canonicalBase.strtok($path, '?');
  if ($p['canonical'] !== $want) $fail[] = "Canonical mismatch: $path → ".($p['canonical'] ?? 'none');
  if ($p['h1'] !== 1) $fail[] = "H1 count {$p['h1']}: $path";
  if (!$p['desc'] || strlen($p['desc']) < 50) $fail[] = "Missing/short meta description: $path";
  if (!$p['og']) $fail[] = "Missing Open Graph / X metadata: $path";
  foreach (['Organization', 'WebSite'] as $t) if (empty($p['types'][$t])) $fail[] = "Schema missing $t: $path";
  if (!array_intersect_key($p['types'], array_flip($webPageTypes))) $fail[] = "Schema missing WebPage (or subtype): $path";
  if ($path !== '/' && empty($p['types']['BreadcrumbList'])) $fail[] = "Schema missing BreadcrumbList: $path";
  if ($path !== '/' && !$p['crumbs']) $fail[] = "No visible breadcrumbs: $path";
  if (!$p['faq'] && !in_array($path, $faqExempt, true)) $warn[] = "No FAQ section: $path";
  if ($p['words'] < $minWords) $warn[] = "Thin main content ({$p['words']} words): $path";
  if (count($inbound[strtok($path, '?')] ?? []) === 0 && $path !== '/') $fail[] = "Orphan (no internal links): $path";
}
foreach ($dupT as $t => $ps) if (count($ps) > 1) $fail[] = 'Duplicate title "'.$t.'": '.implode(', ', $ps);
foreach ($dupD as $d => $ps) if (count($ps) > 1) $fail[] = 'Duplicate description: '.implode(', ', $ps);

// Sitemap and robots
[$sc, $sm] = fetch($base.'/sitemap.xml');
preg_match_all('/<loc>([^<]+)<\/loc>/', $sm, $locs);
$smPaths = array_map(fn($u) => substr($u, strlen($canonicalBase)), $locs[1]);
foreach ($locs[1] as $u) if (!str_starts_with($u, $canonicalBase.'/')) $fail[] = "Sitemap URL not on canonical host: $u";
foreach ($smPaths as $p) if (!isset($indexable[$p])) $fail[] = "Sitemap URL not an indexable 200 page: $p";
foreach (array_keys($indexable) as $p) if (!in_array($p, $smPaths, true)) $fail[] = "Indexable page missing from sitemap: $p";
[, $robots] = fetch($base.'/robots.txt');
if (!str_contains($robots, 'Sitemap: '.$canonicalBase.'/sitemap.xml')) $fail[] = 'robots.txt does not point to the canonical sitemap';
foreach (preg_match_all('/^Disallow:\s*(\S+)/m', $robots, $dm) ? $dm[1] : [] as $dis) foreach ($smPaths as $p) if (str_starts_with($p, $dis)) $fail[] = "robots.txt blocks sitemap URL: $p";

// Business-information safeguards
if (ga_id() === '') $info[] = 'GA4: not configured (no analytics loads) — expected until an ID is supplied';
foreach (['LEGAL_ENTITY_NAME', 'REGISTRATION_NUMBER', 'REGISTERED_ADDRESS', 'TAX_ID', 'LEGAL_JURISDICTION'] as $c) if (!is_provided(constant($c))) $info[] = "$c: [TO BE PROVIDED]";
[, $home] = fetch($base.'/');
foreach (['/get-started/' => 'Enquiry Now', 'mailto:'.SITE_EMAIL => 'Email', 'https://wa.me/'.WHATSAPP_NUMBER => 'WhatsApp', 'tel:'.SITE_PHONE_TEL => 'Call', '/login/' => 'Login', '/signup/' => 'Sign Up', '/favicon.ico' => 'favicon'] as $needle => $label)
  if (!str_contains($home, $needle)) $fail[] = "Homepage is missing $label ($needle)";

printf("Crawled %d URLs from %s: %d HTML pages, %d indexable, %d in sitemap\n", count($seen), $base, count($pages), count($indexable), count($smPaths));
foreach ($info ?? [] as $i) echo "  info  $i\n";
foreach ($warn as $w) echo "  warn  $w\n";
foreach ($fail as $f) echo "  FAIL  $f\n";
echo $fail ? count($fail)." failure(s)\n" : "All hard checks passed (".count($warn)." warning(s))\n";
exit($fail ? 1 : 0);
