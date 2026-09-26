<?php
declare(strict_types=1);
// Site search over page names, titles and descriptions. Small index, so a linear scan is fine.
// Each item carries a category (type), its jurisdiction label and verification date for the results list.
function site_search_index(): array {
  $reg = site_registry(); $idx = [];
  $cat = [];
  foreach (require __DIR__.'/../content/knowledge-hub.php' as $c) foreach ($c['slugs'] as $s) $cat['resources/'.$s] = $c['label'];
  $typeOf = function (array $p) use ($cat): string {
    if ($p['kind'] === 'resource') return match ($cat[$p['slug']] ?? '') { 'Checklists' => 'Checklist', 'Glossary' => 'Glossary', 'Business Structures' => 'Structure', 'Comparisons' => 'Comparison', default => str_contains($p['slug'], '-faq') ? 'FAQ' : 'Guide' };
    return ['topic' => 'Checklist', 'service' => 'Service', 'guide' => 'Guide', 'contact' => 'Page'][$p['kind']] ?? 'Page';
  };
  foreach (site_data() as $slug => $p) {
    if ($p['kind'] === 'legal') continue;
    $j = $p['jurisdiction'] ?? null;
    $idx[] = ['url' => path_url($slug), 'name' => $p['name'], 'desc' => $p['description'], 'type' => $typeOf($p), 'jur' => $j ? $reg['sources'][$j]['label'] : '', 'date' => $p['verified'] ?? null, 'noindex' => !empty($p['noindex'])];
  }
  foreach (require __DIR__.'/../content/services.php' as $k => $s) $idx[] = ['url' => '/services/'.$k.'/', 'name' => $s['name'], 'desc' => $s['summary'], 'type' => 'Service', 'jur' => '', 'date' => null, 'noindex' => false];
  foreach ($reg['sources'] as $k => $s) $idx[] = ['url' => path_url($k), 'name' => 'Company incorporation in '.$s['label'], 'desc' => $s['note'], 'type' => 'Jurisdiction', 'jur' => $s['label'], 'date' => $s['verified'] ?? null, 'noindex' => false];
  foreach ($reg['pending'] as $k => $s) $idx[] = ['url' => path_url($k), 'name' => 'Company incorporation in '.$s['label'], 'desc' => 'Guide in preparation. Enquire and we will confirm the official requirements with '.$s['authority'].'.', 'type' => 'Jurisdiction', 'jur' => $s['label'], 'date' => null, 'noindex' => true];
  foreach ([['/jurisdictions/', 'Compare jurisdictions', 'Authorities, filing routes, officers, registered office, tax, visa and compliance side by side.', 'Comparison'], ['/resources/', 'Knowledge Hub', 'Guides, checklists, comparisons and glossaries.', 'Page'], ['/about/', 'About INCORPSYS', 'Who we are, leadership and how we work.', 'Page'], ['/about/methodology/', 'Methodology', 'How our guides are researched and verified.', 'Page'], ['/about/source-policy/', 'Source policy', 'Which sources we accept for regulatory facts.', 'Page'], ['/get-started/', 'Get started', 'Guided enquiry for company setup.', 'Page']] as [$u, $n, $d, $t]) $idx[] = ['url' => $u, 'name' => $n, 'desc' => $d, 'type' => $t, 'jur' => '', 'date' => null, 'noindex' => false];
  return $idx;
}
/** Result categories offered as filters on the search page. */
const SEARCH_TYPES = ['Jurisdiction', 'Service', 'Structure', 'Guide', 'FAQ', 'Checklist', 'Comparison', 'Glossary'];
function site_search(string $q, int $limit = 30, string $type = ''): array {
  $terms = array_filter(preg_split('/[^\p{L}\p{N}]+/u', strtolower($q)) ?: [], fn($t) => strlen($t) > 1);
  if (!$terms) return [];
  $hits = [];
  foreach (site_search_index() as $item) {
    if ($type !== '' && $item['type'] !== $type) continue;
    $name = strtolower($item['name']); $desc = strtolower($item['desc']); $jur = strtolower($item['jur']); $score = 0;
    foreach ($terms as $t) { $score += (str_contains($name, $t) ? 5 : 0) + (str_contains($desc, $t) ? 1 : 0) + (str_contains($jur, $t) ? 2 : 0); }
    if ($score === 0) continue;
    if (str_contains($name, strtolower(trim($q)))) $score += 5;
    if ($item['noindex']) $score -= 2; // prefer in-depth pages over topic checklists
    $hits[] = $item + ['score' => $score];
  }
  usort($hits, fn($a, $b) => $b['score'] <=> $a['score'] ?: strcmp($a['name'], $b['name']));
  return array_slice($hits, 0, $limit);
}
