<?php
// Interactive comparison: desktop matrix (features × jurisdictions); phones get jurisdiction tabs (built by site.js).
// Values only from content/comparisons.php (each linked to its source guide). Unverified = "Not yet verified".
// Expects $reg, $pages, $cmp.
$cols = $cmp['columns']; unset($cols['authority']);
$groupOf = []; foreach ($cmp['groups'] as $g => $def) foreach ($def['cols'] as $c) $groupOf[$c] = $g;
// Dependency labels for fees and processing time (not amounts): per the INCORPSYS data-integrity rules.
$dependent = ['usa' => 'State-dependent', 'uae' => 'Emirate / free-zone dependent'];
$cell = function (string $k, string $ck) use ($cmp, $pages, $dependent, $reg): string {
  $c = $cmp['rows'][$k][$ck] ?? null;
  if ($c && isset($pages[$c['guide']])) return '<span class="cm-st cm-ok" title="Verified from the official source">'.icon('check').'<span class="visually-hidden">Verified: </span></span><span class="cm-v">'.e($c['value']).'</span> <a class="cm-src" href="'.e(path_url($c['guide'])).'">Source<span class="visually-hidden"> guide: '.e($pages[$c['guide']]['name']).'</span></a>';
  if (in_array($ck, ['fees', 'timeline'], true) && isset($dependent[$k])) return '<span class="cm-st cm-dep" aria-hidden="true"></span><span class="cm-v cm-v-dep">'.e($dependent[$k]).'</span>';
  return '<span class="cm-st cm-nv" aria-hidden="true"></span><span class="cm-v cm-v-nv">Not yet verified</span>';
};
$short = fn($k) => ['uk' => 'United Kingdom', 'usa' => 'United States'][$k] ?? $reg['sources'][$k]['label'];
?>
<section class="section section-subtle hs-compare" id="compare" aria-labelledby="cmp-title"><div class="container">
  <div class="section-head"><div><p class="eyebrow">Compare jurisdictions</p><h2 id="cmp-title">What each authority publishes, side by side.</h2></div><p>Every value links to the guide that cites the official source. Where a value is not yet verified, we say so rather than estimate it.</p></div>
  <div class="cm-bar" data-cm-controls>
    <div class="cm-filters" role="group" aria-label="Show topics"><?php foreach($cmp['groups'] as $g=>$def):?><button class="chip" type="button" data-cm-show="<?=e($g)?>" aria-pressed="<?=$g==='formation'?'true':'false'?>"><?=e($def['label'])?></button><?php endforeach;?><button class="chip" type="button" data-cm-show="all" aria-pressed="false">All topics</button></div>
    <ul class="cm-legend" aria-label="Legend"><li><span class="cm-st cm-ok"><?=icon('check')?></span>Verified from the official source</li><li><span class="cm-st cm-dep"></span>Depends on state, emirate or free zone</li><li><span class="cm-st cm-nv"></span>Not yet verified</li></ul>
  </div>
  <div class="cm-wrap" data-cm data-show="formation">
    <table class="cm">
      <caption class="visually-hidden">Company setup requirements by jurisdiction, from each authority's published guidance</caption>
      <thead><tr><th scope="col" class="cm-corner">Requirement</th><?php foreach($reg['sources'] as $k=>$s):?><th scope="col" data-j="<?=e($k)?>"><span class="cm-j"><?=e($short($k))?></span><small><?=e(authority_short($k))?></small></th><?php endforeach;?></tr></thead>
      <tbody>
        <?php foreach($cols as $ck=>$label):?><tr data-group="<?=e($groupOf[$ck]??'')?>"><th scope="row"><?=e($label)?></th><?php foreach($reg['sources'] as $k=>$s):?><td data-j="<?=e($k)?>"><?=$cell($k,$ck)?></td><?php endforeach;?></tr><?php endforeach;?>
        <tr data-group="all"><th scope="row">Source checked</th><?php foreach($reg['sources'] as $k=>$s):?><td data-j="<?=e($k)?>"><span class="cm-st cm-ok"><?=icon('check')?></span><span class="cm-v"><?=e(fmt_date($s['verified']??null))?></span> <a class="cm-src" href="<?=e($s['url'])?>" target="_blank" rel="noopener noreferrer">Official<span class="visually-hidden"> source: <?=e($s['authority'])?> (opens official site)</span></a></td><?php endforeach;?></tr>
      </tbody>
    </table>
  </div>
  <div class="cluster mt-6"><a class="btn btn-primary" href="/jurisdictions/">Compare in detail<?=icon('arrow-right')?></a><a class="link-arrow" href="/resources/choose-jurisdiction-framework/">How to choose a jurisdiction<?=icon('arrow-right')?></a></div>
</div></section>
