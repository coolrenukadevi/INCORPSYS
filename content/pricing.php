<?php
declare(strict_types=1);
/*
 * Pricing engine data. Add a line ONLY when the amount is published by the competent authority
 * (or is an INCORPSYS service fee approved by the business). Every line needs all fields:
 *   ['item' => 'Trade name registration', 'type' => 'authority'|'licence'|'registration'|'establishment-card'|'visa'|'renewal'|'government'|'service',
 *    'amount' => 0.00, 'currency' => 'AED', 'source' => 'Authority name', 'url' => 'https://…',
 *    'verified' => 'YYYY-MM-DD', 'validity' => 'Applies to … ; check before payment']
 * Lines older than PRICE_MAX_AGE_DAYS are hidden automatically and the page falls back to "Verify".
 * Totals are only shown when every line in a jurisdiction shares one currency.
 */
const PRICE_MAX_AGE_DAYS = 90;
return [
  'uae' => [],
  'singapore' => [],
  'hong-kong' => [],
  'uk' => [],
  'usa' => [],
  'malaysia' => [],
];
