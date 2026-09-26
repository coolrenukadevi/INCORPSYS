<?php
// Regenerates page stub files and sitemap.xml from the content registry.
// Run after adding, removing or renaming pages: php tools/build.php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require_once __DIR__.'/../includes/config.php';
$root = dirname(__DIR__);
$pages = site_data();
$hubs = array_merge(array_keys(site_registry()['sources']), ['resources']);

// Stubs: pages/<slug>/index.php for content and hub pages; legal pages live at /legal/<name>/.
$written = 0; $expected = [];
$stub = function (string $dir, string $slug, string $template) use ($root, &$written, &$expected) {
  $code = "<?php \$GLOBALS['PAGE_SLUG']='".$slug."'; require __DIR__.'".str_repeat('/..', substr_count($dir, '/') + 1)."/pages/".$template."'; ?>\n";
  $file = "$root/$dir/index.php";
  $expected[] = $dir;
  if (!is_dir("$root/$dir")) mkdir("$root/$dir", 0755, true);
  if (!is_file($file) || file_get_contents($file) !== $code) { file_put_contents($file, $code); $written++; }
};
foreach ($pages as $slug => $page) { $stub(str_starts_with($slug, 'legal/') ? $slug : 'pages/'.$slug, $slug, '_page_template.php'); }
foreach ($hubs as $hub) { $stub('pages/'.$hub, $hub, '_hub_template.php'); }
// Jurisdictions in preparation: pages exist (noindex) but stay out of the sitemap until verified content is added.
foreach (array_keys(site_registry()['pending']) as $hub) { $stub('pages/'.$hub, $hub, '_hub_template.php'); }
$services = require __DIR__.'/../content/services.php';
$stub('pages/services', 'services', '_service_template.php');
foreach (array_keys($services) as $sk) { $stub('pages/services/'.$sk, 'services/'.$sk, '_service_template.php'); }
$expected[] = 'pages/jurisdictions'; // hand-written page, not a generated stub

// Report stub folders with no matching registry entry (they would render the 404 page).
$orphans = [];
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/pages", FilesystemIterator::SKIP_DOTS)) as $f) {
  $dir = substr($f->getPath(), strlen($root) + 1);
  if ($f->getFilename() === 'index.php' && !in_array($dir, $expected, true)) $orphans[] = $dir;
}

// Sitemap: indexable pages only (legal pages and Phase A topic/service pages are noindex).
$entries = [[page_url(''), null, 'weekly', '1.0'], [page_url('jurisdictions'), null, 'monthly', '0.9'], [page_url('get-started'), null, 'monthly', '0.8'], [page_url('services'), null, 'monthly', '0.8']];
foreach (['about', 'about/why-choose-us', 'about/vision-mission', 'about/leadership', 'about/methodology', 'about/source-policy', 'about/editorial-policy', 'careers', 'support', 'sitemap', 'legal'] as $p) { $entries[] = [page_url($p), null, 'monthly', '0.6']; }
foreach ($hubs as $hub) { $entries[] = [page_url($hub), site_registry()['sources'][$hub]['verified'] ?? null, 'monthly', '0.9']; }
foreach (array_keys($services) as $sk) { $entries[] = [page_url('services/'.$sk), null, 'monthly', '0.8']; }
foreach ($pages as $slug => $page) {
  if ($page['kind'] === 'legal' || !empty($page['noindex'])) continue;
  $entries[] = [page_url($slug), $page['verified'] ?? null, 'monthly', '0.8'];
}
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<?xml-stylesheet type=\"text/xsl\" href=\"/assets/sitemap.xsl\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($entries as [$loc, $lastmod, $freq, $prio]) {
  $xml .= '<url><loc>'.e($loc).'</loc>'.($lastmod ? "<lastmod>$lastmod</lastmod>" : '')."<changefreq>$freq</changefreq><priority>$prio</priority></url>\n";
}
file_put_contents("$root/sitemap.xml", $xml."</urlset>\n");

// Source registry export for review (docs/ is not web-accessible).
$fh = fopen("$root/docs/source-registry.csv", 'w');
fputcsv($fh, ['id', 'jurisdiction', 'fact', 'source', 'url', 'verified', 'notes', 'status'], ',', '"', '');
foreach (source_registry() as $row) { fputcsv($fh, array_values($row), ',', '"', ''); }
fclose($fh);

echo count($pages)." content pages, ".count($hubs)." hubs; $written stub files written; ".count($entries)." sitemap URLs\n";
if ($orphans) echo "Stub folders with no content entry (delete them):\n  ".implode("\n  ", $orphans)."\n";
