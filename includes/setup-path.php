<?php
declare(strict_types=1);
/*
 * Data for the homepage guided setup ("Your setup path"). Built only from registered material:
 * the comparison cells (each tied to a sourced guide), the jurisdiction profile's structures guides
 * and the source registry. Anything without a verified value is listed under "needs verification".
 */
function setup_path_data(): array {
  $reg = site_registry(); $pages = site_data();
  $cmp = (require __DIR__.'/../content/comparisons.php')['jurisdictions'];
  $profiles = require __DIR__.'/../content/jurisdiction-profiles.php';
  $services = require __DIR__.'/../content/services.php';
  $out = ['jurisdictions' => [], 'services' => []];
  foreach ($reg['sources'] as $k => $src) {
    $row = $cmp['rows'][$k] ?? []; $req = []; $verify = [];
    foreach ($cmp['columns'] as $ck => $label) {
      if ($ck === 'authority') continue;
      $cell = $row[$ck] ?? null;
      if ($cell && isset($pages[$cell['guide']])) { if (in_array($ck, ['officers', 'local', 'office'], true)) $req[] = ['text' => $cell['value'], 'url' => path_url($cell['guide'])]; }
      else $verify[] = $label;
    }
    $structure = null;
    foreach ($profiles[$k]['sections']['structures'] ?? [] as $s) { if (isset($pages[$s])) { $structure = ['text' => $pages[$s]['name'], 'url' => path_url($s)]; break; } }
    $route = $row['route'] ?? null;
    $out['jurisdictions'][$k] = [
      'label' => $src['label'], 'authority' => $src['authority'], 'authorityUrl' => $src['url'], 'hub' => path_url($k),
      'structure' => $structure, 'route' => $route && isset($pages[$route['guide']]) ? ['text' => $route['value'], 'url' => path_url($route['guide'])] : null,
      'requirements' => $req, 'verify' => $verify, 'verified' => fmt_date($src['verified'] ?? null), 'pending' => false,
    ];
  }
  foreach ($reg['pending'] as $k => $src) {
    $out['jurisdictions'][$k] = [
      'label' => $src['label'], 'authority' => $src['authority'], 'authorityUrl' => $src['links'][0]['url'], 'hub' => path_url($k),
      'structure' => null, 'route' => null, 'requirements' => [], 'verify' => ['All requirements — guide in preparation'], 'verified' => '', 'pending' => true,
    ];
  }
  foreach (['company-incorporation', 'business-licensing', 'corporate-banking', 'visa-residency', 'registered-office-solutions', 'business-expansion', 'compliance-documentation'] as $sk) {
    if (isset($services[$sk])) $out['services'][$sk] = ['text' => $services[$sk]['name'], 'url' => '/services/'.$sk.'/'];
  }
  return $out;
}
