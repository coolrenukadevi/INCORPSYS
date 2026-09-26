<?php
declare(strict_types=1);
/*
 * Jurisdictions in preparation: listed across the site and open for enquiries, but with no published
 * regulatory guidance yet. Only the competent authority and its official home page are named here.
 * Every page for these countries is noindex and shows a verification-required status until verified
 * content is added (move the entry into content/sources.php with guides, profile and journey data).
 * 'links_checked' => false: INCORPSYS has not yet confirmed these pages from this environment.
 */
return [
  'saudi-arabia' => [
    'label' => 'Saudi Arabia', 'code' => 'SA', 'region' => 'Middle East',
    'authority' => 'Ministry of Investment (MISA) and Ministry of Commerce',
    'links' => [
      ['title' => 'Ministry of Investment (MISA)', 'url' => 'https://misa.gov.sa/'],
      ['title' => 'Ministry of Commerce', 'url' => 'https://mc.gov.sa/'],
    ],
    'links_checked' => false,
  ],
  'philippines' => [
    'label' => 'Philippines', 'code' => 'PH', 'region' => 'Asia',
    'authority' => 'Securities and Exchange Commission (SEC)',
    'links' => [
      ['title' => 'Securities and Exchange Commission (SEC)', 'url' => 'https://www.sec.gov.ph/'],
    ],
    'links_checked' => false,
  ],
  'thailand' => [
    'label' => 'Thailand', 'code' => 'TH', 'region' => 'Asia',
    'authority' => 'Department of Business Development (DBD), Ministry of Commerce',
    'links' => [
      ['title' => 'Department of Business Development (DBD)', 'url' => 'https://www.dbd.go.th/'],
    ],
    'links_checked' => false,
  ],
];
