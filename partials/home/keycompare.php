<?php
// "Compare Jurisdictions" key-comparison panel + setup-cost categories. Expects $home, $reg, $pages, $cmp.
// Data integrity: every "verified" cell comes from content/comparisons.php and links to its source guide;
// no tax rates, fees or processing times are shown unless sourced. The cost ring shows categories, not amounts.
$kc = $home['keycompare'];
$dependent = ['usa' => 'State-dependent', 'uae' => 'Emirate-dependent'];
$kcCell = function (string $k, string $ck) use ($cmp, $pages, $kc, $dependent): string {
  // Compact view: status icon only; the sourced statement is in the tooltip and in screen-reader text.
  $c = $cmp['rows'][$k][$ck] ?? null;
  if ($c && isset($pages[$c['guide']])) {
    $label = $kc['short'][$k][$ck] ?? $c['value'];
    return '<a class="kc-cell" href="'.e(path_url($c['guide'])).'" data-tip="'.e($label.': '.$c['value']).'"><span class="kc-st kc-ok">'.icon('check').'</span><span class="visually-hidden">'.e($label).': '.e($c['value']).' (source guide)</span></a>';
  }
  if (in_array($ck, ['fees', 'timeline'], true) && isset($dependent[$k])) return '<span class="kc-cell kc-txt">Varies<span class="visually-hidden"> ('.e($dependent[$k]).')</span></span>';
  return '<span class="kc-cell"><span class="kc-st kc-nv" aria-hidden="true"></span><span class="visually-hidden">Not yet verified</span></span>';
};
$kcName = fn($k) => $reg['sources'][$k]['label'];
?>
<section class="section hs-keycmp" aria-labelledby="kc-title"><div class="container">
  <div class="kc-head">
    <div><h2 id="kc-title">Compare Jurisdictions</h2><p>Understand key differences across the most popular business destinations.</p></div>
    <div class="kc-tabs" role="tablist" aria-label="Comparison topic"><?php $i=0; foreach($kc['tabs'] as $t=>[$label]):?><button class="kc-tab" type="button" role="tab" id="kc-tab-<?=e($t)?>" aria-controls="kc-panel" aria-selected="<?=$i++===0?'true':'false'?>" data-kc-tab="<?=e($t)?>"><?=e($label)?></button><?php endforeach;?></div>
  </div>
  <div class="kc-grid">
    <div class="kc-main">
      <div class="kc-wrap" id="kc-panel" role="tabpanel" aria-labelledby="kc-tab-key" tabindex="0" data-kc>
        <table class="kc-table">
          <caption class="visually-hidden">Key requirements by jurisdiction, from each authority's published guidance</caption>
          <thead><tr><th scope="col" class="kc-corner">Feature</th><?php foreach($reg['sources'] as $k=>$s):?><th scope="col"><?php if(is_file(__DIR__.'/../../assets/img/jurisdictions/'.$k.'.webp')):?><img class="kc-av" src="<?=e(asset('img/jurisdictions/'.$k.'.webp'))?>" alt="" width="26" height="26" loading="lazy" decoding="async"><?php endif;?><span><?=e($kcName($k))?></span></th><?php endforeach;?></tr></thead>
          <tbody>
            <?php foreach($kc['tabs'] as $t=>[$tl,$rows]): foreach($rows as $ck=>[$rl,$ic]):?><tr data-kc-row="<?=e($t)?>"<?=$t==='key'?'':' class="kc-off"'?>><th scope="row"><span class="kc-ric"><?=icon($ic)?></span><?=e($rl)?></th><?php foreach($reg['sources'] as $k=>$s):?><td><?=$kcCell($k,$ck)?></td><?php endforeach;?></tr><?php endforeach; endforeach;?>
          </tbody>
        </table>
      </div>
      <ul class="kc-legend" aria-label="Legend"><li><span class="kc-st kc-ok"><?=icon('check')?></span>From the official source (hover or select for details)</li><li><span class="kc-txt">Varies</span>Depends on state or emirate</li><li><span class="kc-st kc-nv"></span>Not yet verified</li></ul>
      <div class="kc-actions"><a class="btn btn-primary btn-lg" href="/jurisdictions/">Compare in Detail<?=icon('arrow-right')?></a><a class="link-arrow" href="/resources/choose-jurisdiction-framework/">View Full Comparison Guide<?=icon('arrow-right')?></a></div>
    </div>
    <aside class="kc-cost" aria-labelledby="kc-cost-title">
      <h3 id="kc-cost-title">Setup Cost Breakdown <span>(categories, not to scale)</span></h3>
      <div class="kc-cost-body">
        <div class="kc-ring" aria-hidden="true">
          <svg viewBox="0 0 120 120"><g fill="none" stroke-width="16" transform="rotate(-90 60 60)"><circle cx="60" cy="60" r="46" stroke="#F5B82E" stroke-dasharray="94.3 194.7"/><circle cx="60" cy="60" r="46" stroke="#6D5AE6" stroke-dasharray="94.3 194.7" stroke-dashoffset="-96.3"/><circle cx="60" cy="60" r="46" stroke="#14B8A6" stroke-dasharray="94.3 194.7" stroke-dashoffset="-192.6"/></g></svg>
          <span class="kc-ring-c"><b>Your Setup Cost</b><small>3 cost categories</small></span>
        </div>
        <ul class="kc-cost-list">
          <?php foreach($home['costs'] as [$key,$who,$t,,$status]):?><li class="kc-c-<?=e($key)?>"><b><?=e($key==='government'?'Government / Registry Fees':($key==='incorpsys'?'INCORPSYS Service Fees':'Third-Party Costs'))?></b><span><?=e($t)?></span><em><?=e($status)?></em></li><?php endforeach;?>
        </ul>
      </div>
      <p class="kc-note">Note: Fees vary by jurisdiction and business structure. Please check the official source for the latest information.</p>
    </aside>
  </div>
</div></section>
