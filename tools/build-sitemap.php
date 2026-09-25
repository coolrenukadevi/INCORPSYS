<?php
// Regenerates sitemap.xml from the content registry: php tools/build-sitemap.php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__.'/../includes/config.php';
$entries = [[page_url(''), 'weekly', '1.0']];
foreach (site_registry()['sources'] as $key => $src) { $entries[] = [page_url($key), 'monthly', '0.9']; }
foreach (site_data() as $slug => $page) { $entries[] = [page_url($slug), 'monthly', '0.8']; }
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($entries as [$loc, $freq, $prio]) { $xml .= '<url><loc>'.e($loc)."</loc><changefreq>$freq</changefreq><priority>$prio</priority></url>\n"; }
$xml .= "</urlset>\n";
file_put_contents(__DIR__.'/../sitemap.xml', $xml);
echo count($entries)." URLs written to sitemap.xml\n";
