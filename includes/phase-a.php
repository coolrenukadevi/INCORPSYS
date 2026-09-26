<?php
declare(strict_types=1);
/*
 * Builds Phase A topic and service pages (/{jurisdiction}/{topic|service}/) from sourced material:
 * the jurisdiction's registered guide statements, the guides' own checklists, the jurisdiction profile
 * and the service definitions. Nothing new is stated here; unsourced topics show a pending-verification note.
 */

/** Guides (by slug) that cover each Phase A topic, per jurisdiction, derived from profiles and setup paths. */
function phase_a_topic_guides(string $jKey, string $topic): array {
  static $profiles = null, $journeys = null;
  $profiles ??= require __DIR__.'/../content/jurisdiction-profiles.php';
  $journeys ??= require __DIR__.'/../content/journeys.php';
  $sec = $profiles[$jKey]['sections'] ?? [];
  $path = $journeys['paths'][$jKey] ?? [];
  $map = [
    'company-incorporation-overview' => array_merge($sec['structures'] ?? [], $path['register'] ?? []),
    'company-registration' => array_merge($path['register'] ?? [], $sec['documents'] ?? []),
    'business-name-approval' => $path['name'] ?? [],
    'legal-structures' => $sec['structures'] ?? [],
    'licensing-permits' => array_merge($sec['licensing'] ?? [], $path['activity'] ?? []),
    'registered-office' => $path['address'] ?? [],
    'directors-governance' => array_merge($sec['who'] ?? [], $path['people'] ?? []),
    'documents-checklist' => $sec['documents'] ?? [],
    'post-incorporation' => array_merge($sec['compliance'] ?? [], $path['after'] ?? []),
    'official-sources' => [],
  ];
  $pages = site_data();
  // Keep only this jurisdiction's in-depth guides, de-duplicated, in order.
  return array_values(array_unique(array_filter($map[$topic] ?? [], fn($s) => isset($pages[$s]) && ($pages[$s]['jurisdiction'] ?? null) === $jKey)));
}

/** HTML list of sourced statements with links to the guide that cites each one. */
function phase_a_fact_list(array $slugs): string {
  $pages = site_data(); $h = '<ul class="fact-list">';
  foreach ($slugs as $s) { $h .= '<li><p>'.e($pages[$s]['answer']).'</p><a class="link-arrow small" href="'.e(path_url($s)).'">'.e($pages[$s]['name']).icon('arrow-right').'</a></li>'; }
  return $h.'</ul>';
}

/** Country-specific checklist collected from the guides' own "Practical checklist" sections. */
function phase_a_checklist(array $slugs): array {
  $pages = site_data(); $items = [];
  foreach ($slugs as $s) foreach ($pages[$s]['sections'] ?? [] as $sec) {
    if (($sec['title'] ?? '') === 'Practical checklist') foreach ($sec['bullets'] ?? [] as $b) $items[$b] = true;
  }
  return array_keys($items);
}

function phase_a_pending(string $topic, string $label, string $authority, ?array $link = null): string {
  return verification_status('We have not yet published verified guidance on '.e($topic).' for '.e($label).'. Check with '.e($authority).', or ask us to confirm it for your case.', $link);
}

/** Rewrites a Phase A page's answer, sections and FAQs from sourced material. */
function phase_a_enrich(array $page): array {
  $reg = site_registry(); $jKey = $page['jurisdiction']; $src = $reg['sources'][$jKey];
  $label = $src['label']; $auth = $src['authority'];
  $rest = substr($page['slug'], strlen($jKey) + 1);
  $pages = site_data();

  if ($page['kind'] === 'topic') {
    static $profiles = null; $profiles ??= require __DIR__.'/../content/jurisdiction-profiles.php';
    $topicName = $page['name']; $lens = $page['sections'][2]['body'] ?? '';
    $guides = phase_a_topic_guides($jKey, $rest);
    if ($rest === 'official-sources') {
      $links = $src['links'] ?? [['title' => $src['title'], 'url' => $src['url']]];
      $list = '<ul class="source-list">'.implode('', array_map(fn($l) => '<li><a href="'.e($l['url']).'" target="_blank" rel="noopener noreferrer">'.e($l['title']).icon('external-link').'</a></li>', $links)).'</ul>';
      $all = array_filter($pages, fn($p) => ($p['jurisdiction'] ?? null) === $jKey && $p['kind'] === 'guide');
      $page['answer'] = $auth.' is the primary authority for the company setup guidance INCORPSYS summarises for '.$label.'. Its official pages are listed below; every '.$label.' guide links back to them.';
      $page['sections'] = [
        ['title' => 'Official pages', 'html' => $list.'<p class="small muted">Sources last checked: '.e(fmt_date($src['verified'] ?? null)).'.</p>'],
        ['title' => 'Guides built on these sources', 'html' => '<ul class="link-list">'.implode('', array_map(fn($p) => '<li><a href="'.e(path_url($p['slug'])).'">'.icon('chevron-right').e($p['name']).'</a></li>', $all)).'</ul>'],
        ['title' => 'How to use official sources', 'body' => $lens],
      ];
    } else {
      $page['answer'] = $rest === 'company-incorporation-overview' ? ($profiles[$jKey]['answer'] ?? $page['answer']) : ($guides ? $pages[$guides[0]]['answer'] : 'We have not yet published verified guidance on this topic for '.$label.'. Check with '.$auth.' before acting.');
      $check = phase_a_checklist($guides);
      $page['sections'] = array_values(array_filter([
        // The first statement is the direct answer; list the rest here, then link every guide used.
        ['title' => 'What the official guidance says', 'html' => !$guides ? phase_a_pending(strtolower($topicName), $label, $auth, ['title' => $auth, 'url' => $src['url']])
          : (count($guides) > ($rest === 'company-incorporation-overview' ? 0 : 1) ? phase_a_fact_list($rest === 'company-incorporation-overview' ? $guides : array_slice($guides, 1)) : '')
            .'<p class="small muted">Source: '.e($auth).' guidance, via our in-depth guides:</p><ul class="link-list">'.implode('', array_map(fn($g) => '<li><a href="'.e(path_url($g)).'">'.icon('chevron-right').e($pages[$g]['name']).'</a></li>', $guides)).'</ul>'],
        $check ? ['title' => $topicName.' checklist for '.$label, 'bullets' => $check] : null,
        ['title' => 'Practical focus', 'body' => $lens],
      ]));
    }
    $page['faqs'] = [
      ['q' => 'Which authority controls '.strtolower($topicName).' in '.$label.'?', 'a' => $auth.' is the primary authority for the guidance on this page. Other authorities can be involved depending on your activity; re-check the official source before acting.'],
    ];
    if ($rest === 'company-incorporation-overview') $page['faqs'] = array_merge($page['faqs'], $profiles[$jKey]['faqs'] ?? []);
    $page['eyebrow'] = strtoupper($label).' · TOPIC OVERVIEW';
  } else { // service
    static $services = null; $services ??= require __DIR__.'/../content/services.php';
    $s = $services[$rest] ?? null;
    if ($s) {
      $guides = array_values(array_filter($s['guides'], fn($g) => isset($pages[$g]) && ($pages[$g]['jurisdiction'] ?? null) === $jKey));
      $resources = array_values(array_filter($s['guides'], fn($g) => isset($pages[$g]) && $pages[$g]['kind'] === 'resource'));
      $page['answer'] = $s['answer'].' In '.$label.', the primary authority for the guidance we rely on is '.$auth.'.';
      $page['sections'] = array_values(array_filter([
        ['title' => 'What INCORPSYS organizes in '.$label, 'html' => '<ul class="check-list">'.implode('', array_map(fn($b) => '<li>'.icon('check').'<span>'.e($b).'</span></li>', $s['scope'])).'</ul>'],
        ['title' => 'Official guidance for '.$label, 'html' => $guides ? phase_a_fact_list($guides) : '<p>'.e($src['note']).'</p><p>For this service we work from '.e($auth).' guidance and the specific authority involved in your case. <a href="'.e(path_url($jKey)).'">See the '.e($label).' guide</a>.</p>'],
        ['title' => 'What you provide', 'bullets' => $s['provide']],
        $resources ? ['title' => 'Useful guides', 'html' => '<ul class="link-list">'.implode('', array_map(fn($g) => '<li><a href="'.e(path_url($g)).'">'.icon('chevron-right').e($pages[$g]['name']).'</a></li>', $resources)).'</ul>'] : null,
        ['title' => 'Costs and timelines', 'html' => price_table($jKey, $auth)],
      ]));
      $page['faqs'] = $s['faqs'];
      $page['eyebrow'] = strtoupper($label).' · SERVICE';
    }
  }
  return $page;
}
