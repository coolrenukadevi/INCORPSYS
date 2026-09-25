<?php
declare(strict_types=1);
// Site search over page names, titles and descriptions. Small index, so a linear scan is fine.
function site_search_index(): array {
  $idx = [];
  foreach (site_data() as $slug => $p) {
    if ($p['kind'] === 'legal') continue;
    $idx[] = ['url' => path_url($slug), 'name' => $p['name'], 'desc' => $p['description'], 'type' => ['topic' => 'Topic', 'service' => 'Service', 'guide' => 'Guide', 'resource' => 'Resource', 'contact' => 'Contact'][$p['kind']] ?? 'Page', 'noindex' => !empty($p['noindex'])];
  }
  foreach (require __DIR__.'/../content/services.php' as $k => $s) $idx[] = ['url' => '/services/'.$k.'/', 'name' => $s['name'], 'desc' => $s['summary'], 'type' => 'Service', 'noindex' => false];
  foreach (site_registry()['sources'] as $k => $s) $idx[] = ['url' => path_url($k), 'name' => 'Company incorporation in '.$s['label'], 'desc' => $s['note'], 'type' => 'Jurisdiction', 'noindex' => false];
  foreach ([['/jurisdictions/', 'Compare jurisdictions', 'Authorities, filing routes and officer rules side by side.'], ['/about/', 'About INCORPSYS', 'Who we are, leadership and how we work.'], ['/about/methodology/', 'Methodology', 'How our guides are researched and verified.'], ['/about/source-policy/', 'Source policy', 'Which sources we accept for regulatory facts.'], ['/get-started/', 'Get started', 'Guided enquiry for company setup.']] as [$u, $n, $d]) $idx[] = ['url' => $u, 'name' => $n, 'desc' => $d, 'type' => 'Page', 'noindex' => false];
  return $idx;
}
function site_search(string $q, int $limit = 30): array {
  $terms = array_filter(preg_split('/[^\p{L}\p{N}]+/u', strtolower($q)) ?: [], fn($t) => strlen($t) > 1);
  if (!$terms) return [];
  $hits = [];
  foreach (site_search_index() as $item) {
    $name = strtolower($item['name']); $desc = strtolower($item['desc']); $score = 0;
    foreach ($terms as $t) { $score += (str_contains($name, $t) ? 5 : 0) + (str_contains($desc, $t) ? 1 : 0); }
    if ($score === 0) continue;
    if (str_contains($name, strtolower(trim($q)))) $score += 5;
    if ($item['noindex']) $score -= 2; // prefer in-depth pages over topic checklists
    $hits[] = $item + ['score' => $score];
  }
  usort($hits, fn($a, $b) => $b['score'] <=> $a['score'] ?: strcmp($a['name'], $b['name']));
  return array_slice($hits, 0, $limit);
}
