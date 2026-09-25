<?php
declare(strict_types=1);
/*
 * Source registry: every source-backed statement used on jurisdiction pages.
 * Fields: id, jurisdiction, fact, source, url, verified, notes, status.
 * status 'verified' = checked against the official page by INCORPSYS on the date given;
 * status 'supplied' = taken from the supplied Phase 2 content registry (verification date as supplied),
 * not re-checked in this build because official sites were unreachable from the build environment.
 * Exported to docs/source-registry.csv by tools/build.php.
 */
function source_registry(): array {
  static $rows = null;
  if ($rows !== null) return $rows;
  $rows = [];
  $sources = site_registry()['sources'];
  foreach (site_data() as $slug => $p) {
    if (($p['kind'] ?? '') !== 'guide' || empty($p['source'])) continue;
    $src = $p['source'];
    $rows[$slug] = [
      'id' => $slug,
      'jurisdiction' => $sources[$p['jurisdiction']]['label'],
      'fact' => $p['answer'],
      'source' => $src['authority'].' — '.$src['title'],
      'url' => $src['url'],
      'verified' => $p['verified'] ?? ($src['verified'] ?? ''),
      'notes' => 'Guide: '.page_url($slug),
      'status' => 'supplied',
    ];
  }
  return $rows;
}
