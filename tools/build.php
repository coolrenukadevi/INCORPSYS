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

// Report stub folders with no matching registry entry (they would render the 404 page).
$orphans = [];
foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator("$root/pages", FilesystemIterator::SKIP_DOTS)) as $f) {
  $dir = substr($f->getPath(), strlen($root) + 1);
  if ($f->getFilename() === 'index.php' && !in_array($dir, $expected, true)) $orphans[] = $dir;
}

// Sitemap: indexable pages only (legal pages are noindex until final text is approved).
$entries = [[page_url(''), null, 'weekly', '1.0'], [page_url('about'), null, 'monthly', '0.7']];
foreach ($hubs as $hub) { $entries[] = [page_url($hub), null, 'monthly', '0.9']; }
foreach ($pages as $slug => $page) {
  if ($page['kind'] === 'legal') continue;
  $entries[] = [page_url($slug), $page['verified'] ?? null, 'monthly', '0.8'];
}
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
foreach ($entries as [$loc, $lastmod, $freq, $prio]) {
  $xml .= '<url><loc>'.e($loc).'</loc>'.($lastmod ? "<lastmod>$lastmod</lastmod>" : '')."<changefreq>$freq</changefreq><priority>$prio</priority></url>\n";
}
file_put_contents("$root/sitemap.xml", $xml."</urlset>\n");

echo count($pages)." content pages, ".count($hubs)." hubs; $written stub files written; ".count($entries)." sitemap URLs\n";
if ($orphans) echo "Stub folders with no content entry (delete them):\n  ".implode("\n  ", $orphans)."\n";
