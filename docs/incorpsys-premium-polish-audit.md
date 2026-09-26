# INCORPSYS — Premium Polish Audit

Date: 26 September 2026 · Branch: `claude/lucid-planck-30sxav` · Baseline commit: `70e5ae8`

Scope: the "Final Premium Polish & Conversion" brief (and the CRO brief sent with it), checked against the codebase as it stands. Nothing here is deployed; the brief's production gate applies.

## 1. What exists today (scanned)

| Area | Current implementation | Files |
|---|---|---|
| Stack | Plain PHP 8.1+, no DB, Apache rewrite, stub routing, tokenised CSS, one JS file | `includes/`, `pages/`, `assets/` |
| Homepage | Hero ("Launch Your Global Business With Confidence."), 4-field setup finder, source band, comparison table, services, process, why pillars, destinations, structures, compliance, resources, FAQ, CTA | `index.php` |
| Header / nav | Utility bar (WhatsApp, Login, Sign Up), 5 mega menus with intros, Get Started, mobile drawer | `partials/header.php`, `content/navigation.php` |
| Footer | Logo, justified intro, WhatsApp/Contact, social icons, 5 columns, methodology notice, cookie banner, Assist | `partials/footer.php` |
| Jurisdictions | 6 hubs × 19 sections, 60 in-depth guides, 100 noindex topic/service pages | `pages/_hub_template.php`, `content/*` |
| Comparison | Server-rendered table; `null` → "Verify"; stacked on mobile via `data-label` | `compare_table()`, `content/comparisons.php` |
| Guided setup | Homepage finder → `/explore/` step path from `content/journeys.php` → pre-filled `/get-started/` | `explore/index.php` |
| Enquiry | 8-step wizard, no-JS fallback, Origin check, HMAC token, honeypot, rate limit | `get-started/`, `enquiry/submit.php` |
| Assist | Static options + progressive flow to enquiry/WhatsApp; says answers go to the team | `partials/footer.php`, `assets/js/site.js` |
| Search | Linear scan over names/descriptions; type badge | `includes/search.php`, `search/` |
| SEO | Canonicals, unique titles, OG, XML + HTML sitemap, robots, llms.txt, JSON-LD (Organization, WebSite, Article, Service, FAQPage, BreadcrumbList, CollectionPage) | `partials/header.php`, templates |
| Trust | Methodology, source policy, editorial policy, leadership, legal hub (draft policies, noindex) | `about/`, `legal/` |
| Quality (last run) | 263 pages 0 broken; html-validate 0; axe 0; no overflow 375–1440; Lighthouse home 98 mobile / 100 desktop | — |

## 2. Gaps against the brief

| # | Brief item | Gap | Priority |
|---|---|---|---|
| G1 | §5 hero message | Headline/CTAs differ from the brief ("Build your business beyond borders.", Get Started / Compare / Explore) | High |
| G2 | §6 guided setup | Finder is a 4-select form; no step framing, no inline "Your setup path" (authority, structure, requirements, services, what needs verification, next action); result lives only on `/explore/` | High |
| G3 | §8 trust bar | Authorities shown as plain badges inside a card, not a dedicated "Built on official sources" bar with official-source labelling | High |
| G4 | §9 explorer | Destination cards show code, guide count, note; missing structures, route, services, source status | Medium |
| G5 | §10 comparison | No filter/sort; fewer rows than the brief (tax, visa, banking, compliance, registered office); "Verify" wording instead of "Not yet verified"; mobile is stacked table, not cards | High |
| G6 | §12 source-first | No visual methodology flow (Authority requirement → … → Ongoing compliance) | High |
| G7 | §14 verification UX | Pending notices are generic warning alerts; no "Verify with authority" action | Medium |
| G8 | §16 commercial layer | CTA band is link-only; no inline "Need help with this setup?" mini-form | Medium |
| G9 | §19 Assist | Subheading differs from the brief | Low |
| G10 | §21–22 hub/search | Resource hub has no category filter; search results lack category/jurisdiction/date | Medium |
| G11 | §24 mobile | No sticky bottom action bar on phones | Medium |
| G12 | §30 schema | No ItemList for jurisdictions; no ProfessionalService entity | Low |
| G13 | New request | Philippines, Thailand, Saudi Arabia not present | High (user request) |

## 3. Items not implemented as written, and why

| Brief request | Issue | What we do instead |
|---|---|---|
| "Verified registry icons (ACRA, Companies House, SSM, SBA, UAE Govt)" | Government logos/crests imply endorsement or partnership and are usually restricted marks | Text authority cards labelled **Official source**, linking to the authority |
| "Security badges", "active client metrics" | No certification or verified client numbers exist; publishing them would be fabricated | Omitted; process and source facts only |
| Matrix sort "by tax rate, setup speed, total estimated fees" | No verified tax rates, timelines or fees in the registry | Filters by jurisdiction and topic; unverified cells read **Not yet verified** |
| "Incorporation Readiness & Cost Estimator" | No verified fee data and no quote backend | Guided setup path + "Request a formal quote" through the enquiry; no computed prices (brief §18 permits UX-only) |
| Lead magnets ("2026 Cross-Border Taxation Master Matrix", "Checklist Generator") | No verified tax matrix exists; exit-intent popups conflict with the calm/consultative brief | Deferred; existing checklists linked from the commercial layer |
| "LegalService" schema | INCORPSYS is not a law firm; LegalService implies legal representation | `ProfessionalService` |
| "Launch 60-Sec Jurisdiction Matcher", "Start Corporate Setup" (CRO brief) | Conflicts with the Final brief's CTA set | Final brief wins: Get Started / Compare Jurisdictions / Explore Jurisdictions |
| UAE free-zone pages (DMCC, IFZA, RAKEZ …) | Brief §15 requires official verification first; official sites are not reachable from this environment | Architecture note only; no pages created |
| Philippines / Thailand / Saudi Arabia facts | No supplied content; official sites unreachable here | Jurisdictions added as **in preparation**: authority links, verification-required status, enquiry and setup routing; pages `noindex` until verified content exists |

## 4. Risks carried forward

- **C1 (from the earlier audit):** "Sources checked" badges reflect the supplied content date, not an independent check from this environment.
- Official sources remain blocked by the network policy, so no new fact can be verified here.
- Legal policies remain drafts with `[To be confirmed]` items (noindex).

## 5. Plan (brief §37 order)

1. Design tokens: verification component, authority cards, methodology flow, sticky bar.
2. Header/nav: new jurisdictions in the Company Setup menu and footer.
3. Homepage: brief hero copy and CTAs, guided 4-step setup with inline setup path, trust bar, explorer, pillars, methodology.
4. Jurisdiction template: premium verification status; pending template for in-preparation countries.
5. Comparison: extra rows, filter chips, mobile cards, "Not yet verified".
6. Commercial layer: "Need help with this setup?" mini-form on major pages.
7. Assist copy; search result metadata; knowledge-hub category filter.
8. Schema: ItemList, ProfessionalService.
9. QA at 11 widths, html-validate, axe, Lighthouse; final report and production-readiness report. No deployment.
