<?php
declare(strict_types=1);
// Reusable UI components. Each returns an HTML string; all dynamic text is escaped here.

function fmt_date(?string $ymd): string { return $ymd ? date('j F Y', strtotime($ymd)) : ''; }

function json_ld(array $data): string {
  return '<script type="application/ld+json">'.json_encode($data, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG).'</script>';
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
  return '<span class="verify" data-tip="'.e($hint).'" tabindex="0">'.icon('triangle-alert').'Verify<span class="visually-hidden">: '.e($hint).'</span></span>';
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

/** Final call-to-action band. Optional jurisdiction pre-fills the enquiry. */
function cta_band(string $countryKey = '', string $countryLabel = '', string $heading = ''): string {
  $url = '/get-started/'.($countryKey !== '' ? '?country='.rawurlencode($countryKey) : '');
  $heading = $heading !== '' ? $heading : ($countryLabel !== '' ? 'Planning a company in '.$countryLabel.'?' : 'Ready to plan your company setup?');
  return '<section class="section-tight"><div class="container"><div class="cta-band on-dark"><div><p class="eyebrow">Next step</p><h2>'.e($heading).'</h2>'
    .'<p>Answer a few questions about your activity, ownership and timeline. We map each step to the authority that controls it and reply with a structured plan.</p>'
    .'<div class="cluster mt-6"><a class="btn btn-cta btn-lg" href="'.e($url).'">Launch your entity'.icon('arrow-right').'</a><a class="btn btn-on-dark btn-lg" href="/jurisdictions/">Compare jurisdictions</a></div></div>'
    .'<ul class="cta-contact">'
    .'<li><a href="'.e(wa_url()).'" target="_blank" rel="noopener">'.icon('message-circle').'<span>WhatsApp<small>Chat with the team</small></span></a></li>'
    .'<li><a href="/contact/">'.icon('send').'<span>Contact us<small>Send a message</small></span></a></li>'
    .'</ul></div></div></section>';
}

/** Standard page shell pieces for simple pages. */
function publisher(): array { return ['@type' => 'Organization', '@id' => SITE_URL.'/#organization', 'name' => 'INCORPSYS', 'url' => SITE_URL]; }
function organization_schema(): array {
  return ['@type' => 'Organization', '@id' => SITE_URL.'/#organization', 'name' => 'INCORPSYS', 'alternateName' => 'Incorporation System', 'url' => SITE_URL,
    'logo' => url('assets/img/logo-144.png'), 'email' => SITE_EMAIL, 'telephone' => SITE_PHONE, 'sameAs' => array_values(SOCIAL_LINKS)];
}

/** Comparison engine: renders a table from content/comparisons.php; null cells show "Verify". */
function compare_table(string $id, ?array $only = null): string {
  static $data = null; $data ??= require __DIR__.'/../content/comparisons.php';
  $t = $data[$id]; $reg = site_registry(); $pages = site_data();
  $cols = $t['columns'];
  $h = '<div class="table-wrap table-stack"><table class="table"><caption class="visually-hidden">'.e($t['caption']).'</caption><thead><tr><th scope="col">'.($id === 'jurisdictions' ? 'Jurisdiction' : 'Structure').'</th>';
  foreach ($cols as $label) $h .= '<th scope="col">'.e($label).'</th>';
  $h .= '</tr></thead><tbody>';
  foreach ($t['rows'] as $key => $row) {
    if ($only !== null && !in_array($key, $only, true)) continue;
    if ($id === 'jurisdictions') {
      $src = $reg['sources'][$key];
      $h .= '<tr><th scope="row"><a href="'.e(path_url($key)).'">'.e($src['label']).'</a></th>';
      foreach ($cols as $ck => $label) {
        if ($ck === 'authority') { $h .= '<td data-label="'.e($label).'"><a href="'.e($src['url']).'" target="_blank" rel="noopener noreferrer">'.e($src['authority']).'</a></td>'; continue; }
        $cell = $row[$ck] ?? null;
        if ($cell && isset($pages[$cell['guide']])) {
          $h .= '<td data-label="'.e($label).'">'.e($cell['value']).' <a href="'.e(path_url($cell['guide'])).'" aria-label="Source guide: '.e($pages[$cell['guide']]['name']).'">Guide</a></td>';
        } else {
          $h .= '<td data-label="'.e($label).'">'.verify_value('Not yet verified from the '.$src['authority'].' — check the official source').'</td>';
        }
      }
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
    return '<div class="alert alert-warning">'.icon('triangle-alert').'<div><strong>Fees vary — verify with the authority</strong>Fees vary by authority, activity, structure and selected services. Verify current charges with '.e($authority).' before payment. INCORPSYS quotes only after confirming your requirements, and shows the official source for every government fee.</div></div>';
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

/** Leadership cards (About and Leadership pages). */
function team_grid(): string {
  $h = '<ul class="team-grid">';
  foreach (require __DIR__.'/../content/team.php' as $m) {
    $img = null;
    foreach (['webp', 'jpg', 'png'] as $ext) { if (is_file(__DIR__."/../assets/img/team/{$m['slug']}.$ext")) { $img = asset("img/team/{$m['slug']}.$ext"); break; } }
    $initials = implode('', array_map(fn($w) => $w[0], array_slice(preg_split('/[\s.]+/', $m['name'], -1, PREG_SPLIT_NO_EMPTY), 0, 2)));
    $h .= '<li class="team-card">'.($img ? '<img src="'.e($img).'" alt="'.e($m['name']).'" width="320" height="320" loading="lazy">' : '<span class="team-initials" aria-hidden="true">'.e($initials).'</span>')
      .'<h3>'.e($m['name']).'</h3><p>'.e($m['role']).'</p></li>';
  }
  return $h.'</ul>';
}
function team_schema(): array {
  return array_map(fn($m) => ['@type' => 'Person', 'name' => $m['name'], 'jobTitle' => $m['role'], 'worksFor' => ['@id' => SITE_URL.'/#organization']], require __DIR__.'/../content/team.php');
}

/** Escape text and highlight "[To be confirmed: ...]" placeholders in draft policies. */
function rich_text(string $text): string {
  return preg_replace('/\[To be confirmed:[^\]]*\]/', '<mark class="tbc">$0</mark>', e($text));
}
/** Legal & Support navigation list. */
function legal_links(string $current = ''): array {
  $items = [];
  foreach (site_data() as $slug => $p) { if ($p['kind'] === 'legal') $items[$slug] = $p['name']; }
  $items['support'] = 'Support';
  unset($items[$current]);
  return $items;
}
