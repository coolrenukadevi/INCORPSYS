<?php
declare(strict_types=1);
// All content pages keyed by slug. Kinds: topic + service (Phase A), guide + resource (Phase 2), contact, legal.
$phase1 = require __DIR__.'/../content/pages.php';
$phase2 = require __DIR__.'/../content/phase2.php';
return $phase1 + $phase2;
