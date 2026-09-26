<?php
declare(strict_types=1);
/*
 * INCORPSYS original SVG illustration system (homepage).
 * Abstract architecture, data nodes and connection lines — no photographs, landmarks, flags or globe.
 * All artwork is decorative (aria-hidden); the information it depicts is always present as HTML text.
 * Colours come from CSS (currentColor + classes), so the same art works on dark and light sections.
 */

/** Hero: "Global Business Infrastructure" — platform → incorporation → licensing / banking / compliance → expansion → jurisdictions. */
function art_hero(): string {
  $chips = ['AE', 'SG', 'HK', 'UK', 'US', 'MY'];
  $c = '';
  foreach ($chips as $i => $code) {
    $x = 70 + $i * 76;
    $c .= '<path class="ai-dash" d="M280 386 C280 404 '.($x + 28).' 400 '.($x + 28).' 424"/>'
      .'<rect class="ai-chip" x="'.$x.'" y="424" width="56" height="26" rx="13"/><text class="ai-chip-t" x="'.($x + 28).'" y="441.5">'.$code.'</text>';
  }
  return '<svg class="art-hero" viewBox="0 0 560 500" aria-hidden="true" focusable="false">'
    .'<defs><linearGradient id="ai-g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#2563EB"/><stop offset="1" stop-color="#4F46E5"/></linearGradient>'
    .'<linearGradient id="ai-fade" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#CBD5E1" stop-opacity=".0"/><stop offset="1" stop-color="#CBD5E1" stop-opacity=".22"/></linearGradient></defs>'
    // architectural line-art horizon
    .'<g class="ai-arch"><path d="M0 500V438h26v-30h18v30h14v-58h22v58h12v-22h20v22h16v-74l10-10 10 10v74h14v-40h24v40h10v-18h18v18"/>'
    .'<path d="M380 500v-40h18v-26h16v26h12v-66h8l6-12 6 12h8v66h14v-34h22v34h10v-50h18v50h16v-24h16v64"/></g>'
    // platform
    .'<rect class="ai-plat" x="150" y="18" width="260" height="58" rx="14"/>'
    .'<text class="ai-plat-t" x="280" y="44">INCORPSYS</text><text class="ai-plat-s" x="280" y="62">GLOBAL BUSINESS PLATFORM</text>'
    .'<path class="ai-line" d="M280 76V118"/>'
    // incorporation
    .'<rect class="ai-node ai-key" x="186" y="118" width="188" height="50" rx="12"/><text class="ai-node-t" x="280" y="148">Incorporation</text>'
    .'<path class="ai-line" d="M280 168C280 200 130 196 130 230"/><path class="ai-line" d="M280 168V230"/><path class="ai-line" d="M280 168C280 200 430 196 430 230"/>'
    // three capabilities
    .'<rect class="ai-node" x="55" y="230" width="150" height="46" rx="12"/><text class="ai-node-t" x="130" y="258">Licensing</text>'
    .'<rect class="ai-node" x="205" y="230" width="150" height="46" rx="12"/><text class="ai-node-t" x="280" y="258">Banking</text>'
    .'<rect class="ai-node" x="355" y="230" width="150" height="46" rx="12"/><text class="ai-node-t" x="430" y="258">Compliance</text>'
    .'<path class="ai-line" d="M130 276C130 312 280 300 280 334"/><path class="ai-line" d="M280 276V334"/><path class="ai-line" d="M430 276C430 312 280 300 280 334"/>'
    // expansion
    .'<rect x="176" y="334" width="208" height="52" rx="14" fill="url(#ai-g)"/><text class="ai-exp-t" x="280" y="365">Global Expansion</text>'
    .$c
    // growth indicator
    .'<g class="ai-growth"><rect x="452" y="118" width="84" height="74" rx="10"/><path class="ai-bars" d="M466 176v-10M480 176v-18M494 176v-14M508 176v-26M522 176v-34"/><path class="ai-trend" d="M464 158l16-10 14 4 14-14 14-8"/></g>'
    .'<g class="ai-doc"><rect x="24" y="112" width="70" height="84" rx="10"/><path d="M38 134h42M38 146h42M38 158h30M38 170h36"/><circle cx="76" cy="180" r="7"/><path d="M73 180l2 2 4-4"/></g>'
    .'</svg>';
}

/** Miniature jurisdiction illustrations: original abstract architecture, one motif per jurisdiction. */
function art_jurisdiction(string $key): string {
  $base = '<path class="aj-ground" d="M8 108H232"/>';
  $grid = '<g class="aj-grid"><path d="M20 20H220M20 44H220M20 68H220"/></g>';
  $art = match ($key) {
    // UAE: tapered spire with staggered towers — modern architectural geometry
    'uae' => '<circle class="aj-sun" cx="62" cy="42" r="12"/>'
      .'<path class="aj-b aj-hi" d="M120 12l4 22h4l3 26h4l3 48h-36l3-48h4l3-26h4z"/>'
      .'<path class="aj-b" d="M80 108V70h14v38M150 108V58h16v50M172 108V80h14v28M58 108V84h14v24M196 108V92h16v16"/>'
      .'<path class="aj-d" d="M126 52v48M150 70h16M150 82h16M150 94h16"/>',
    // Singapore: clean vertical towers crossed by data lines
    'singapore' => '<path class="aj-b" d="M74 108V40h18v68M108 108V28h18v80M142 108V46h18v62M176 108V64h16v44M50 108V76h14v32"/>'
      .'<path class="aj-data" d="M40 58C80 50 160 66 206 52M40 78C84 72 150 86 206 74"/>'
      .'<circle class="aj-node" cx="83" cy="55" r="3"/><circle class="aj-node" cx="117" cy="61" r="3"/><circle class="aj-node" cx="151" cy="60" r="3"/><circle class="aj-node" cx="184" cy="56" r="3"/>',
    // Hong Kong: dense vertical cluster
    'hong-kong' => '<path class="aj-hill" d="M8 92C60 64 110 70 150 84S214 74 232 82"/>'
      .'<path class="aj-b" d="M40 108V70h12v38M56 108V52h12v56M72 108V38h14v70M90 108V58h12v50M106 108V24h16v84M126 108V46h12v62M142 108V34h14v74M160 108V62h12v46M176 108V48h14v60M194 108V72h12v36"/>'
      .'<path class="aj-d" d="M114 32v70M149 42v60"/>',
    // UK: institutional building with pediment and columns, modern towers behind
    'uk' => '<path class="aj-b aj-soft" d="M168 108V44h18v64M190 108V60h16v48M40 108V62h16v46"/>'
      .'<path class="aj-b aj-hi" d="M66 58L120 34 174 58z"/><path class="aj-b" d="M70 58h100v6H70zM76 64v34M94 64v34M112 64v34M130 64v34M148 64v34M166 64v34M64 98h112v5H64zM58 103h124v5H58z"/>',
    // USA: stepped financial tower with ascending chart
    'usa' => '<path class="aj-b aj-hi" d="M98 108V50h8V38h6V20h8v18h6v12h8v58z"/>'
      .'<path class="aj-b" d="M60 108V66h24v42M148 108V58h22v50M176 108V78h18v30"/>'
      .'<path class="aj-bars" d="M200 104v-8M208 104v-14M216 104v-22M224 104v-32"/><path class="aj-trend" d="M196 90l10-8 8 2 12-16"/>',
    // Malaysia: faceted towers with geometric lattice band
    'malaysia' => '<path class="aj-lattice" d="M20 96l12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12 12-12 12 12"/>'
      .'<path class="aj-b aj-hi" d="M96 108V40l8-12 8 12v68M126 108V48l7-10 7 10v60"/><path class="aj-b" d="M66 108V70h16v38M154 108V62h16v46M176 108V80h14v28"/>'
      .'<path class="aj-d" d="M104 44v56M133 52v48"/>',
    default => '',
  };
  return '<svg class="art-j" viewBox="0 0 240 120" aria-hidden="true" focusable="false" preserveAspectRatio="xMidYMax meet">'.$grid.$art.$base.'</svg>';
}

/** Ecosystem connector lines (INCORPSYS at the centre of a 3×3 grid). */
function art_ecosystem_lines(): string {
  $pts = [[50, 50], [150, 50], [250, 50], [50, 150], [250, 150], [50, 250], [150, 250], [250, 250]];
  $l = '';
  foreach ($pts as [$x, $y]) $l .= '<path d="M150 150L'.$x.' '.$y.'"/>';
  return '<svg class="art-eco" viewBox="0 0 300 300" preserveAspectRatio="none" aria-hidden="true" focusable="false">'.$l.'</svg>';
}

/** Closing CTA: abstract node network (no map). */
function art_network(): string {
  $n = [[60, 70, 'UK'], [150, 40, 'HK'], [250, 90, 'SG'], [330, 50, 'MY'], [110, 160, 'US'], [280, 170, 'AE']];
  $lines = '<path d="M60 70L150 40L250 90L330 50M150 40L110 160L280 170L250 90M60 70L110 160M330 50L280 170"/>';
  $dots = '';
  foreach ($n as [$x, $y, $t]) $dots .= '<circle cx="'.$x.'" cy="'.$y.'" r="16"/><text x="'.$x.'" y="'.($y + 4).'">'.$t.'</text>';
  return '<svg class="art-net" viewBox="0 0 390 210" aria-hidden="true" focusable="false"><g class="an-l">'.$lines.'</g><g class="an-n">'.$dots.'</g></svg>';
}
