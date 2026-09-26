<?php
declare(strict_types=1);
// Reusable UI components. Each returns an HTML string; all dynamic text is escaped here.

function fmt_date(?string $ymd): string { return $ymd ? date('j F Y', strtotime($ymd)) : ''; }

function json_ld(array $data): string {
  ld_record($data);
  return '<script type="application/ld+json">'.json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG).'</script>';
}

/** Remembers which schema.org types a page has emitted, so site_schema() can add only what is missing. */
function ld_record(array $data): void {
  $GLOBALS['LD_TYPES'] ??= [];
  array_walk_recursive($data, function ($v, $k) { if ($k === '@type' && is_string($v)) $GLOBALS['LD_TYPES'][$v] = true; });
}

/**
 * Site-wide structured data, printed once per page from the footer: Organization and WebSite on every page,
 * plus a WebPage (with BreadcrumbList) when the template has not already emitted a page-level type.
 */
function site_schema(array $page, ?array $crumbs): string {
  $types = $GLOBALS['LD_TYPES'] ?? [];
  $graph = [];
  if (empty($types['Organization'])) $graph[] = organization_schema();
  if (empty($types['WebSite'])) $graph[] = ['@type' => 'WebSite', '@id' => SITE_URL.'/#website', 'url' => SITE_URL.'/', 'name' => SITE_NAME, 'publisher' => ['@id' => SITE_URL.'/#organization'], 'inLanguage' => 'en'];
  $pageTypes = ['WebPage', 'CollectionPage', 'AboutPage', 'ContactPage', 'SearchResultsPage', 'ItemPage', 'ProfilePage'];
  if (!array_intersect_key($types, array_flip($pageTypes))) {
    $slug = $page['slug'] ?? '';
    $crumbs ??= $slug === '' ? null : [['name' => 'Home', 'slug' => ''], ['name' => $page['h1'] ?? preg_replace('/\s*\|.*$/', '', $page['title'] ?? SITE_NAME), 'slug' => $slug]];
    $graph[] = ['@type' => 'WebPage', '@id' => page_url($slug).'#webpage', 'url' => page_url($slug), 'name' => $page['title'] ?? DEFAULT_TITLE, 'description' => $page['description'] ?? DEFAULT_DESCRIPTION,
      'isPartOf' => ['@id' => SITE_URL.'/#website'], 'publisher' => ['@id' => SITE_URL.'/#organization'], 'inLanguage' => 'en']
      + ($crumbs && empty($types['BreadcrumbList']) ? ['breadcrumb' => breadcrumb_schema($crumbs)] : []);
  }
  return $graph ? json_ld(['@context' => 'https://schema.org', '@graph' => $graph]) : '';
}

/** @param array<int,array{name:string,slug:string}> $crumbs */
function breadcrumbs(array $crumbs): string {
  $h = '<nav class="breadcrumbs" aria-label="Breadcrumb"><ol>';
  $last = count($crumbs) - 1;
  foreach ($crumbs as $i => $c) {
    $h .= '<li>'.($i < $last ? '<a href="'.e(path_url($c['slug'])).'">'.e($c['name']).'</a>' : '<span aria-current="page">'.e($c['name']).'</span>').'</li>';
  }
  return $h.'</ol></nav>';
}

function breadcrumb_schema(array $crumbs): array {
  return ['@type' => 'BreadcrumbList', 'itemListElement' => array_map(fn($c, $i) => ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $c['name'], 'item' => page_url($c['slug'])], $crumbs, array_keys($crumbs))];
}

function page_hero(string $eyebrow, string $h1, string $lead, array $crumbs, string $metaHtml = ''): string {
  return '<section class="page-hero"><div class="container">'.breadcrumbs($crumbs)
    .'<p class="eyebrow">'.e($eyebrow).'</p><h1>'.e($h1).'</h1>'
    .($lead !== '' ? '<p class="lead">'.e($lead).'</p>' : '')
    .($metaHtml !== '' ? '<div class="page-meta">'.$metaHtml.'</div>' : '')
    .'</div></section>';
}

function answer_block(string $text, string $label = 'Direct answer'): string {
  return '<div class="answer">'.icon('circle-check-big').'<div><p class="answer-label">'.e($label).'</p><p>'.e($text).'</p></div></div>';
}

/** @param array<int,array{q:string,a:string}> $faqs */
function faq_accordion(array $faqs, string $heading = 'Frequently asked questions', string $id = 'faq'): string {
  if (!$faqs) return '';
  $h = '<section class="content-section" aria-labelledby="'.e($id).'"><h2 id="'.e($id).'">'.e($heading).'</h2><div class="accordion faq-list">';
  foreach ($faqs as $i => $f) {
    $h .= '<details'.($i === 0 ? ' open' : '').'><summary>'.e($f['q']).icon('chevron-down').'</summary><div class="accordion-body"><p>'.e($f['a']).'</p></div></details>';
  }
  return $h.'</div></section>';
}

function faq_schema(array $faqs): array {
  return ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn($x) => ['@type' => 'Question', 'name' => $x['q'], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $x['a']]], $faqs)];
}

function verified_badge(?string $date): string {
  return $date ? '<span class="badge badge-verified">'.icon('badge-check').'Sources checked '.e(fmt_date($date)).'</span>' : '';
}

/** Marker for values that are not yet established from an official source (comparison and pricing engines). */
function verify_value(string $hint = 'Verify with the authority'): string {
  return '<span class="verify" data-tip="'.e($hint).'" tabindex="0">'.icon('triangle-alert').'Not yet verified<span class="visually-hidden">: '.e($hint).'</span></span>';
}

/**
 * Verification status: shown wherever an official requirement is not yet confirmed in the source registry.
 * $link is the authority page to check ([title, url]); omitted when no official page is registered.
 */
function verification_status(string $text, ?array $link = null, string $title = 'Verification required'): string {
  return '<div class="verify-status" role="note"><span class="verify-status-dot" aria-hidden="true"></span><div><p class="verify-status-title">'.e($title).'</p><p>'.$text.'</p>'
    .($link ? '<a class="verify-status-link" href="'.e($link['url']).'" target="_blank" rel="noopener noreferrer">Verify with '.e($link['title']).icon('external-link').'<span class="visually-hidden"> (opens official site)</span></a>' : '')
    .'</div></div>';
}

/** Short authority name for compact labels (trust bar, explorer cards, verify links). */
function authority_short(string $key): string {
  static $short = ['uae' => 'UAE Government', 'singapore' => 'ACRA', 'hong-kong' => 'Companies Registry', 'uk' => 'Companies House / GOV.UK', 'usa' => 'SBA', 'malaysia' => 'SSM', 'saudi-arabia' => 'MISA', 'philippines' => 'SEC Philippines', 'thailand' => 'DBD'];
  $r = site_registry();
  return $short[$key] ?? (($r['sources'][$key] ?? $r['pending'][$key] ?? [])['authority'] ?? '');
}

/** Official source card for the page rail. */
function source_card(array $src, ?string $verified = null): string {
  $h = '<div class="source-card"><div class="label-row"><span class="eyebrow">Official source</span>'.($verified ? verified_badge($verified) : '').'</div>'
    .'<h2>'.e($src['authority']).'</h2><p><strong>'.e($src['title']).'</strong></p><p>'.e($src['note']).'</p><ul class="source-list">';
  $links = $src['links'] ?? [['title' => $src['title'], 'url' => $src['url']]];
  if (!in_array($src['url'], array_column($links, 'url'), true)) array_unshift($links, ['title' => $src['title'], 'url' => $src['url']]);
  foreach ($links as $l) {
    $h .= '<li><a href="'.e($l['url']).'" target="_blank" rel="noopener noreferrer">'.e($l['title']).icon('external-link').'<span class="visually-hidden"> (opens official site)</span></a></li>';
  }
  return $h.'</ul><p class="source-note">Official pages change. Re-check the authority immediately before filing, payment or relying on a rule.</p></div>';
}

function contact_card(): string {
  return '<div class="source-card"><span class="eyebrow">Talk to INCORPSYS</span><h2 class="mt-2">Questions about your setup?</h2><ul class="source-list">'
    .'<li><a href="'.e(wa_url()).'" target="_blank" rel="noopener">WhatsApp'.icon('message-circle').'</a></li>'
    .'<li><a href="/contact/">Contact us'.icon('send').'</a></li></ul></div>';
}

/**
 * Commercial layer: "Need help with this setup?" band closing every major page.
 * The mini-form pre-fills the enquiry (GET /get-started/); an optional jurisdiction is pre-selected.
 */
function cta_band(string $countryKey = '', string $countryLabel = '', string $heading = ''): string {
  $heading = $heading !== '' ? $heading : ($countryLabel !== '' ? 'Planning a company in '.$countryLabel.'?' : 'Need help with this setup?');
  $select = function (string $name, string $label, array $opts, string $selected = '') {
    $h = '<div class="field"><label for="cta-'.e($name).'">'.e($label).'</label><select class="select" id="cta-'.e($name).'" name="'.e($name).'">';
    foreach ($opts as $k => $v) $h .= '<option value="'.e((string)$k).'"'.((string)$k === $selected ? ' selected' : '').'>'.e($v).'</option>';
    return $h.'</select></div>';
  };
  $countries = enquiry_countries();
  $countries = ['undecided' => $countries['undecided']] + array_diff_key($countries, ['undecided' => 1]);
  return '<section class="section-tight"><div class="container"><div class="cta-band on-dark"><div><p class="eyebrow">Next step</p><h2>'.e($heading).'</h2>'
    .'<p>Tell us four things. We confirm the official route for your case and reply with a structured setup plan — no obligation.</p>'
    .'<form class="cta-form" action="/get-started/" method="get">'
    .$select('country', 'Country', $countries, $countryKey)
    .$select('activity', 'Business activity', ENQUIRY_OPTIONS['activity'])
    .$select('ownership', 'Ownership', ENQUIRY_OPTIONS['ownership'])
    .$select('visa', 'Visa requirement', ENQUIRY_OPTIONS['visa'])
    .'<button class="btn btn-cta btn-lg" type="submit">Get a Setup Plan'.icon('arrow-right').'</button></form></div>'
    .'<div class="cta-side"><p class="cta-side-title">Speak to an Expert</p><ul class="cta-contact">'
    .'<li><a href="'.e(wa_url()).'" target="_blank" rel="noopener">'.icon('message-circle').'<span>WhatsApp<small>Chat with the team</small></span></a></li>'
    .'<li><a href="/contact/">'.icon('send').'<span>Contact us<small>Send a message</small></span></a></li>'
    .'</ul><p class="cta-side-note">Authorities make the final decisions. We never guarantee incorporation, licensing, banking or visa outcomes.</p></div></div></div></section>';
}

/** Standard page shell pieces for simple pages. */
function publisher(): array { return ['@type' => 'Organization', '@id' => SITE_URL.'/#organization', 'name' => 'INCORPSYS', 'url' => SITE_URL]; }
function organization_schema(): array {
  return ['@type' => 'Organization', '@id' => SITE_URL.'/#organization', 'name' => 'INCORPSYS', 'alternateName' => 'Incorporation System', 'url' => SITE_URL,
    'logo' => url('assets/img/logo-144.png'), 'slogan' => SITE_POSITIONING, 'description' => SITE_TAGLINE, 'email' => SITE_EMAIL, 'telephone' => SITE_PHONE, 'sameAs' => array_values(SOCIAL_LINKS)]
    // Legal details are added only once supplied in includes/settings.php.
    + (is_provided(LEGAL_ENTITY_NAME) ? ['legalName' => LEGAL_ENTITY_NAME] : [])
    + ['address' => ['@type' => 'PostalAddress', 'streetAddress' => HEAD_OFFICE['street'], 'addressLocality' => HEAD_OFFICE['locality'], 'addressRegion' => HEAD_OFFICE['region'], 'postalCode' => HEAD_OFFICE['postcode'], 'addressCountry' => HEAD_OFFICE['country']]]
    + (is_provided(TAX_ID) ? ['taxID' => TAX_ID] : [])
    + (is_provided(REGISTRATION_NUMBER) ? ['identifier' => ['@type' => 'PropertyValue', 'propertyID' => 'CIN', 'value' => REGISTRATION_NUMBER]] : []);
}

/** ItemList of published (indexable) jurisdiction guides, for the homepage and comparison page. */
function jurisdiction_item_list(): array {
  $items = []; $n = 0;
  foreach (site_registry()['sources'] as $k => $src) $items[] = ['@type' => 'ListItem', 'position' => ++$n, 'name' => 'Company formation in '.$src['label'], 'url' => page_url($k)];
  return ['@type' => 'ItemList', 'name' => 'INCORPSYS jurisdiction guides', 'itemListElement' => $items];
}

/**
 * Comparison engine: renders a table from content/comparisons.php; null cells show "Not yet verified".
 * $interactive adds the topic and jurisdiction filters and the sort control (site.js); without JavaScript every column shows.
 * Jurisdictions in preparation are added as rows with no verified values.
 */
function compare_table(string $id, ?array $only = null, bool $interactive = false): string {
  static $data = null; $data ??= require __DIR__.'/../content/comparisons.php';
  $t = $data[$id]; $reg = site_registry(); $pages = site_data();
  $cols = $t['columns']; $groupOf = [];
  foreach ($t['groups'] ?? [] as $g => $def) foreach ($def['cols'] as $c) $groupOf[$c] = $g;
  $rows = $t['rows'];
  if ($id === 'jurisdictions' && $only === null) foreach ($reg['pending'] as $k => $_) $rows[$k] = [];
  // One jurisdiction (its own guide page): a two-column facts list reads better than a one-row table.
  if ($id === 'jurisdictions' && $only !== null && count($only) === 1 && isset($rows[$only[0]])) {
    $key = $only[0]; $src = $reg['sources'][$key]; $h = '<dl class="facts-grid">';
    foreach ($cols as $ck => $label) {
      if ($ck === 'authority') { $v = '<a href="'.e($src['url']).'" target="_blank" rel="noopener noreferrer">'.e($src['authority']).'<span class="visually-hidden"> (opens official site)</span></a>'; }
      else { $cell = $rows[$key][$ck] ?? null; $v = $cell && isset($pages[$cell['guide']]) ? e($cell['value']).' <a class="cell-source" href="'.e(path_url($cell['guide'])).'">Source guide<span class="visually-hidden">: '.e($pages[$cell['guide']]['name']).'</span></a>' : verify_value('Not yet verified from '.$src['authority'].' — check the official source'); }
      $h .= '<div><dt>'.e($label).'</dt><dd>'.$v.'</dd></div>';
    }
    return $h.'</dl>';
  }
  $h = '';
  if ($interactive && $id === 'jurisdictions') {
    $h .= '<div class="compare-controls" data-compare-controls><div class="compare-filter" role="group" aria-label="Show topics"><span class="compare-filter-label">Topics</span>';
    foreach (['all' => 'All topics'] + array_map(fn($g) => $g['label'], $t['groups']) as $g => $label) $h .= '<button type="button" class="chip" data-show="'.e($g).'" aria-pressed="'.($g === 'formation' ? 'true' : 'false').'">'.e($label).'</button>';
    $h .= '</div><div class="compare-filter" role="group" aria-label="Show jurisdictions"><span class="compare-filter-label">Jurisdictions</span>';
    foreach ($rows as $k => $_) { $l = ($reg['sources'][$k] ?? $reg['pending'][$k])['label']; $h .= '<button type="button" class="chip" data-row="'.e($k).'" aria-pressed="true">'.e($l).'</button>'; }
    $h .= '</div><label class="compare-sort"><span>Sort</span><select class="select select-sm" data-sort><option value="default">Default order</option><option value="verified">Most verified values</option><option value="az">A–Z</option></select></label></div>';
  }
  $h .= '<div class="table-wrap table-stack'.($interactive ? ' compare' : '').'"'.($interactive ? ' data-compare data-show="formation"' : '').'><table class="table"><caption class="visually-hidden">'.e($t['caption']).'</caption><thead><tr><th scope="col">'.($id === 'jurisdictions' ? 'Jurisdiction' : 'Structure').'</th>';
  foreach ($cols as $ck => $label) $h .= '<th scope="col"'.(isset($groupOf[$ck]) ? ' data-group="'.$groupOf[$ck].'"' : '').'>'.e($label).'</th>';
  $h .= '</tr></thead><tbody>';
  $i = 0;
  foreach ($rows as $key => $row) {
    if ($only !== null && !in_array($key, $only, true)) continue;
    if ($id === 'jurisdictions') {
      $pend = !isset($reg['sources'][$key]); $src = $reg['sources'][$key] ?? $reg['pending'][$key];
      $srcUrl = $src['url'] ?? $src['links'][0]['url'];
      $known = count(array_filter($row, fn($c) => $c && isset($pages[$c['guide']])));
      $cells = '';
      foreach ($cols as $ck => $label) {
        $g = isset($groupOf[$ck]) ? ' data-group="'.$groupOf[$ck].'"' : '';
        if ($ck === 'authority') { $cells .= '<td data-label="'.e($label).'"><a href="'.e($srcUrl).'" target="_blank" rel="noopener noreferrer">'.e($src['authority']).'<span class="visually-hidden"> (opens official site)</span></a></td>'; continue; }
        $cell = $row[$ck] ?? null;
        if ($cell && isset($pages[$cell['guide']])) {
          $cells .= '<td data-label="'.e($label).'"'.$g.'>'.e($cell['value']).' <a class="cell-source" href="'.e(path_url($cell['guide'])).'">Source guide<span class="visually-hidden">: '.e($pages[$cell['guide']]['name']).'</span></a></td>';
        } else {
          $cells .= '<td data-label="'.e($label).'"'.$g.'>'.verify_value('Not yet verified from '.$src['authority'].' — check the official source').'</td>';
        }
      }
      $h .= '<tr data-row="'.e($key).'" data-verified="'.$known.'" data-order="'.($i++).'"><th scope="row"><a href="'.e(path_url($key)).'">'.e($src['label']).'</a>'.($pend ? ' <span class="badge badge-warning">In preparation</span>' : '').'</th>'.$cells;
    } else {
      $h .= '<tr><th scope="row">'.e($key).'</th>';
      foreach ($cols as $ck => $label) {
        $v = e($row[$ck]);
        if ($ck === 'check' && isset($row['guide'])) $v .= ' <a href="'.e(path_url($row['guide'])).'">Guide</a>';
        $h .= '<td data-label="'.e($label).'">'.$v.'</td>';
      }
    }
    $h .= '</tr>';
  }
  return $h.'</tbody></table></div>';
}

/** Pricing engine: verified lines only; otherwise the standard verification statement. */
function price_table(string $jurisdiction, string $authority): string {
  static $data = null; $data ??= require __DIR__.'/../content/pricing.php';
  $lines = array_filter($data[$jurisdiction] ?? [], fn($l) => isset($l['amount'], $l['currency'], $l['url'], $l['verified'])
    && (time() - strtotime($l['verified'])) <= PRICE_MAX_AGE_DAYS * 86400);
  if (!$lines) {
    return '<div class="alert alert-warning">'.icon('triangle-alert').'<div><strong>Fees vary — verify with the authority</strong>Fees vary by authority, activity, structure and selected services. Verify current charges with '.e($authority).' before payment. INCORPSYS shows the official source for every government fee. INCORPSYS service fee: <a href="/get-started/">contact for service fee</a>.</div></div>';
  }
  $h = '<div class="table-wrap"><table class="table"><thead><tr><th scope="col">Item</th><th scope="col">Amount</th><th scope="col">Source</th><th scope="col">Verified</th></tr></thead><tbody>';
  $currencies = array_unique(array_column($lines, 'currency')); $total = 0;
  foreach ($lines as $l) {
    $total += $l['amount'];
    $h .= '<tr><th scope="row">'.e($l['item']).'<br><small class="muted">'.e($l['validity'] ?? '').'</small></th><td>'.e($l['currency'].' '.number_format((float)$l['amount'], 2)).'</td><td><a href="'.e($l['url']).'" target="_blank" rel="noopener noreferrer">'.e($l['source']).'</a></td><td>'.e(fmt_date($l['verified'])).'</td></tr>';
  }
  if (count($currencies) === 1) $h .= '<tr><th scope="row">Total</th><td colspan="3"><strong>'.e($currencies[0].' '.number_format($total, 2)).'</strong></td></tr>';
  return $h.'</tbody></table></div>';
}

/** Leadership members from content/team.php, sorted by display order. */
function team_members(): array {
  $team = require __DIR__.'/../content/team.php';
  usort($team, fn($a, $b) => ($a['order'] ?? 99) <=> ($b['order'] ?? 99));
  return $team;
}
/** Leadership cards (About and Leadership pages). Optional fields (photo, bio, LinkedIn) render only when supplied. */
function team_grid(): string {
  $h = '<ul class="team-grid">';
  foreach (team_members() as $m) {
    $img = null;
    if (!empty($m['photo']) && is_file(__DIR__.'/../assets/img/'.$m['photo'])) $img = asset('img/'.$m['photo']);
    else foreach (['webp', 'jpg', 'png'] as $ext) { if (is_file(__DIR__."/../assets/img/team/{$m['slug']}.$ext")) { $img = asset("img/team/{$m['slug']}.$ext"); break; } }
    $initials = implode('', array_map(fn($w) => $w[0], array_slice(preg_split('/[\s.]+/', $m['name'], -1, PREG_SPLIT_NO_EMPTY), 0, 2)));
    $h .= '<li class="team-card">'.($img ? '<img src="'.e($img).'" alt="'.e($m['name']).'" width="320" height="320" loading="lazy">' : '<span class="team-initials" aria-hidden="true">'.e($initials).'</span>')
      .'<h3>'.e($m['name']).'</h3><p>'.e($m['designation']).'</p>'
      .(!empty($m['bio']) ? '<p class="team-bio">'.e($m['bio']).'</p>' : '')
      .(!empty($m['linkedin']) ? '<a class="team-link" href="'.e($m['linkedin']).'" target="_blank" rel="noopener">'.social_icon('LinkedIn').'<span class="visually-hidden">'.e($m['name']).' on LinkedIn (opens in a new tab)</span></a>' : '')
      .'</li>';
  }
  return $h.'</ul>';
}
function team_schema(): array {
  return array_map(fn($m) => ['@type' => 'Person', 'name' => $m['name'], 'jobTitle' => $m['designation'], 'worksFor' => ['@id' => SITE_URL.'/#organization']]
    + (!empty($m['linkedin']) ? ['sameAs' => [$m['linkedin']]] : []) + (!empty($m['bio']) ? ['description' => $m['bio']] : []), team_members());
}

/**
 * Company (legal) information, from includes/settings.php. Only supplied values are shown.
 * $variant: 'footer' (dark strip) or 'card' (light card, e.g. Legal & Support).
 */
function legal_details(string $variant = 'card'): string {
  $items = array_filter([
    ['building-2', 'Operated by', LEGAL_ENTITY_NAME],
    ['badge-check', 'CIN', REGISTRATION_NUMBER],
    ['file-text', 'GSTIN', TAX_ID],
    ['map-pin', 'Registered & head office', REGISTERED_ADDRESS],
  ], fn($i) => is_provided($i[2]));
  if (!$items) return '';
  $h = '<section class="legal-details legal-details-'.e($variant).'" aria-label="Company information">'
    .($variant === 'card' ? '<h2 class="h4">Company information</h2>' : '').'<dl>';
  foreach ($items as [$ic, $label, $value]) {
    $h .= '<div'.($label === 'Registered & head office' ? ' class="legal-wide"' : '').'><dt>'.icon($ic).e($label).'</dt><dd'.(in_array($label, ['CIN', 'GSTIN'], true) ? ' class="legal-id"' : '').'>'.e($value).'</dd></div>';
  }
  return $h.'</dl></section>';
}

/** Escape text and highlight "[To be confirmed: ...]" and "[TO BE PROVIDED]" placeholders in draft policies. */
function rich_text(string $text): string {
  return preg_replace('/\[To be confirmed:[^\]]*\]|\[TO BE PROVIDED\]/', '<mark class="tbc">$0</mark>', e($text));
}
/** Legal & Support navigation list. */
function legal_links(string $current = ''): array {
  $items = [];
  foreach (site_data() as $slug => $p) { if ($p['kind'] === 'legal') $items[$slug] = $p['name']; }
  $items['support'] = 'Support';
  unset($items[$current]);
  return $items;
}
