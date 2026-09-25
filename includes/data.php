<?php
declare(strict_types=1);
// All content pages keyed by slug. Kinds: topic + service (Phase A), guide + resource (Phase 2), contact, legal.
// Order matters: content/legal.php overrides same-slug legal drafts in content/phase2.php.
$phase1 = require __DIR__.'/../content/pages.php';
$legal = require __DIR__.'/../content/legal.php';
$phase2 = require __DIR__.'/../content/phase2.php';
return $phase1 + $legal + $phase2;
