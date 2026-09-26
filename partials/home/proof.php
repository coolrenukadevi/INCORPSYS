<?php // Testimonial + official sources (above the closing band). Expects $home, $reg.
// Authority names are text, not logos: these are sources INCORPSYS reads and links to, not partners or endorsers.
$srcName = ['uk' => 'Companies House'];
$t = $home['testimonials'];?>
<section class="section hs-proof" aria-label="Testimonial and official sources"><div class="container proof">
  <div class="proof-card">
    <h2>Trusted by Global Entrepreneurs</h2>
    <?php foreach($t as $q):?><figure class="tst">
      <img class="tst-photo" src="<?=e(asset($q['photo']))?>" alt="<?=e($q['name'])?>" width="240" height="240" loading="lazy" decoding="async">
      <blockquote><p>“<?=e($q['quote'])?>”</p></blockquote>
      <figcaption><strong><?=e($q['name'])?></strong><span><?=e($q['org'])?></span></figcaption>
    </figure><?php endforeach;?>
  </div>
  <div class="proof-card">
    <h2>Official Sources. Verified Information.</h2>
    <p class="proof-lead">Every guide is mapped to official government or regulatory sources, with the date each was last checked.</p>
    <ul class="auth-tiles">
      <?php foreach($reg['sources'] as $k=>$s):?><li><a href="<?=e($s['url'])?>" target="_blank" rel="noopener noreferrer"><span class="auth-ic"><?=icon('landmark')?></span><span class="auth-name"><?=e($srcName[$k] ?? authority_short($k))?></span><span class="auth-country"><?=e($s['label'])?></span><span class="visually-hidden"> (opens official site)</span></a></li><?php endforeach;?>
    </ul>
    <a class="link-arrow proof-more" href="/about/methodology/">View Our Source Methodology<?=icon('arrow-right')?></a>
  </div>
</div></section>
