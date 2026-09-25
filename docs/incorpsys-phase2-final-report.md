# INCORPSYS — Phase 2 Final Report

**Date:** 25 September 2026
**Branch:** `claude/lucid-planck-30sxav` (not deployed, not merged)
**Baseline:** `main` at `491278b`; the audit is in `docs/incorpsys-phase2-audit.md`

## Executive summary

The site was rebuilt on its existing plain-PHP architecture. No framework, database or runtime dependency was added. It now has:
- a tokenised design system
- a redesigned header, mega menu and footer built around a properly prepared logo
- a guided setup finder and an 8-step qualified enquiry
- a progressive INCORPSYS Assist
- service, comparison, search and trust pages
- a reusable jurisdiction template fed by a source registry

Every new factual statement traces to an existing, source-dated registry entry. Nothing was invented: no fees, timelines, testimonials, awards or credentials. Where a fact is not verified, the page says so.

**The main limitation:** this environment's network policy blocked the live site and every official source. So:
- no new regulatory facts were added
- the UAE free-zone, visa and tax cluster was not created
- the 100 template-generated Phase A pages were set to noindex instead of being rewritten

Everything else in the brief was implemented and tested.

| Measure (Lighthouse mobile) | Before: home | After: home | After: guide | After: jurisdiction |
|---|---|---|---|---|
| Performance | 93 | **98** | 99 | 99 |
| Accessibility | 95 | **100** | 100 | 100 |
| Best practices | 100 | 100 | 100 | 100 |
| SEO | 100 | 100 | 100 | 100 |
| LCP | 3.2 s | **2.0 s** | 1.8 s | 1.8 s |
| CLS | 0 | 0 | 0.003 | 0.001 |

## Current vs improved

| Area | Before | After |
|---|---|---|
| Logo | 369 KB opaque PNG shown as a box; illegible country line | Transparent light and reversed lockups (9–27 KB WebP), responsive `srcset` |
| Header | Flat nav, anchor links | Utility bar, 5 mega menus, Login / Sign Up / Get Started, mobile drawer |
| Footer | 4 text columns | Reversed logo, contact, social profiles, 4 link columns, methodology notice |
| Enquiry | Single free-text form | 8-step qualified enquiry, allow-list validation, lead priority |
| Chat | Static link list | Guided flow that hands off pre-filled answers |
| Jurisdictions | Card list | Full template: 19 sections, sourced facts, "pending verification" where unsourced |
| Duplicate content | 100 indexable pages with ~1% unique text | Those 100 set to noindex; sitemap holds 121 pages that pass the content standard |
| Accessibility | 4 axe rule failures | 0 violations on 20 page types at 390px and 1280px |

## Design improvements
- **Tokens:** colour (navy, blue, silver, neutrals, semantic), type scale, spacing, radius, shadow and motion, all as CSS custom properties.
- **Font:** Inter, self-hosted (48 KB, OFL), with a metric-matched fallback so text doesn't shift when it loads.
- **Components:** buttons (primary, secondary, dark, ghost, on-dark; sm/lg/block), cards (link, subtle, compact), badges (verified / verify / info / soon), alerts, labelled inputs, choice cards, stacking tables, tabs, accordions, breadcrumbs, modal, tooltip, answer block, source card, steps, check lists.
- **Style:** restrained, with no glassmorphism, neon or heavy gradients. The only decoration is two thin rings behind the hero, hidden on phones.
- **Mobile:** designed rather than compressed:
  - drawer navigation with accordion menus
  - tables that become labelled cards
  - Assist as a bottom sheet with an icon-only toggle
  - wizard progress as a scrollable strip

## SEO improvements
- Unique titles (all ≤ 64 characters) and descriptions (all 70–160 characters) on all 121 indexable pages.
- Canonical URLs on every indexable page; no canonical on noindex pages.
- `sitemap.xml` generated from the content registry: 121 URLs, every one reachable by links and none noindex.
- JSON-LD:
  - `Organization` (with `sameAs` social profiles) and `WebSite` with a `SearchAction`
  - `Article` on guides, with `dateModified` and `citation`
  - `Service` on service pages
  - `FAQPage` only where FAQs are shown
  - `BreadcrumbList`, `AboutPage` (with leadership as `Person`), `ContactPage`, `CollectionPage`
- No review, rating or LocalBusiness schema.
- 1200×630 Open Graph image and `twitter:site`.
- `llms.txt` rewritten with Markdown links (passes Lighthouse's check).
- Internal linking: "More for {country}", "Compare with", "Popular services" and "Next steps" on every guide; "On this page" on jurisdiction guides.

## AEO improvements
- A direct-answer block leads every guide, service and jurisdiction page.
- Each jurisdiction guide has jurisdiction-specific FAQs whose answers restate registered official statements, e.g.:
  - "How long can a company name be reserved in Singapore?" → up to 120 days (ACRA)
  - "How many directors does a UK private company need?" → at least one (GOV.UK)
- Homepage FAQs answer the brief's high-intent questions (cost, timeline, foreign ownership, guarantees) honestly: fees and timelines are published only when verified.

## Content improvements
- **Jurisdiction template** (`pages/_hub_template.php`): overview, who can register, structures, mainland/free zone/offshore (UAE), requirements, documents, process, authorities, licensing, banking, tax, visa, compliance, costs, timeline, comparison, common mistakes, FAQs and official sources.
  - Facts come only from `content/source-registry.php`.
  - Unsourced sections show a "Pending verification" notice instead of filler.
- **Source registry:** 60 facts with statement, source, URL, date, jurisdiction, notes and status, exported to `docs/source-registry.csv`.
- **Phase 2 guides:** 3 boilerplate sections and 2 generic FAQs removed from all 95 guides.
- **New pages:** 10 service hubs with service-specific scope, inputs, guides and FAQs.
- **Trust pages:** Methodology, Source Policy and Editorial Policy, describing actual practice.
- **About:** leadership added (Anisha Bharti, Director; Renuka Devi, Director; V.K Anand, CEO).
- **Social profiles** (Facebook, X, Instagram, LinkedIn, YouTube) in the footer and the Organization schema.

## Conversion improvements
- **CTA hierarchy:** Get Started is the primary action in the header, hero, CTA bands and service rails; Compare Jurisdictions is secondary; WhatsApp, Call and Email are always one tap away.
- **Setup finder:** four questions (country, activity, ownership, visa) produce a personalised setup path (`/explore/`), then a pre-filled enquiry.
- **8-step enquiry:** need → country → activity → ownership → visa → timeline → contact → documents and consent. It shows "Your enquiry is being prepared" while sending, then a summary of the answers.
- **Lead qualification:** priority (High / Medium / Low) is set from the timeline and need, and appears in the email subject for triage.
- **Assist:** 7 flows with progressive questions; hands off to the pre-filled enquiry, WhatsApp or the country guide.
- **Login / Sign Up / portal preview:** honest "not yet available" UI with the planned dashboard modules (enquiries, quotes, applications, documents, payments, messages, progress, renewals, support). No fake data.

## Technical improvements
- **Components:** reusable PHP components (`partials/components.php`); a single navigation data file; the icon partial.
- **Build:** `tools/build.php` generates stubs (content, hubs, services), the sitemap and the source-registry CSV, and reports orphan stubs.
- **Bug fix:** a variable-scope leak from the navigation include, which produced broken links, was found by the crawl and fixed.
- **Engines:** comparison (`compare_table`) and pricing (`price_table`), with automatic expiry of fee lines older than 90 days.
- **Search:** `/search/` over names and descriptions, preferring in-depth pages.

## Security improvements
- **Content-Security-Policy:**
  - `default-src 'self'`
  - scripts from self plus one hash-allowed inline flag script
  - `style-src 'self'` (all inline styles removed)
  - `form-action 'self'`, `frame-ancestors 'self'`, `object-src 'none'`
- **Enquiry handler:**
  - Origin check (CSRF)
  - HMAC time token and honeypot
  - 5-per-hour rate limit per IP
  - allow-list validation of every choice field
  - phone format check and length limits
  - control-character stripping (no header injection)
  - consent required
  - no file uploads (no secure storage exists)
- **Links:** `rel="noopener"` on external links; `rel="noopener noreferrer"` on official-source links.
- **Not applicable:** SQL injection, sessions, password handling and upload validation (no database, authentication or uploads exist).

## Performance improvements
- LCP image 369 KB → 9–27 KB WebP with `srcset` and `fetchpriority="high"`.
- Font preloaded; the metric-matched fallback removes font-swap layout shift (homepage CLS 0.219 during development → 0).
- No third-party scripts. One deferred 12 KB script and one 47 KB stylesheet, both served gzip-compressed with 30-day cache-busted caching.

## Pages added
| Route | Indexed |
|---|---|
| `/jurisdictions/` | yes |
| `/get-started/` | yes |
| `/services/` + 10 service pages | yes |
| `/about/methodology/`, `/about/source-policy/`, `/about/editorial-policy/` | yes |
| `/explore/`, `/search/`, `/account/` | no (utility) |

## Pages and routes modified
- **Rebuilt:** homepage, 6 jurisdiction guides, resource hub, all guide/topic/service/contact/legal pages (shared template), About, Login, Sign Up, 404.
- **Noindex:** 100 Phase A pages. Same URLs, still linked, removed from the sitemap.
- **No URL was changed or removed**, so no redirects or migration were needed.

## Files changed (vs `main`)
71 files changed, including 11 new service stub files.

**Added:**
- Page files: `about/{methodology,source-policy,editorial-policy}/index.php`, `account/index.php`, `explore/index.php`, `get-started/index.php`, `search/index.php`, `pages/jurisdictions/index.php`, `pages/_service_template.php`
- Content: `content/{comparisons,journeys,jurisdiction-profiles,navigation,pricing,services,source-registry}.php`
- Code: `includes/search.php`, `partials/{components,icons,simple-page}.php`
- Assets: `assets/fonts/*`, `assets/img/*` (logo lockups, icon marks, OG image), `assets/icons-LICENSE.txt`
- Docs: `docs/incorpsys-phase2-audit.md`, `docs/source-registry.csv`, this report

**Modified:** `404.php`, `about/index.php`, `assets/css/site.css`, `assets/js/site.js`, `content/pages.php`, `content/phase2.php`, `enquiry/submit.php`, `includes/config.php`, `index.php`, `llms.txt`, `login/index.php`, `signup/index.php`, `pages/_hub_template.php`, `pages/_page_template.php`, `partials/{enquiry-form,footer,header}.php`, `sitemap.xml`, `tools/build.php`, `README.md`

**Removed:** none from `main`. The intermediate `logo-300/460` files created during this work were replaced by the final lockups.

## Database changes
None. There is no database, and no migrations exist.

## Dependencies added
None at runtime. Vendored static assets:
- Inter font (SIL OFL 1.1, licence in `assets/fonts/`)
- about 40 Lucide icon paths (ISC, licence in `assets/icons-LICENSE.txt`)

QA tools (axe-core, html-validate, Lighthouse, Playwright) were used outside the repository only.

## QA results
| Test | Result |
|---|---|
| Broken links | 248 pages crawled, 0 broken |
| Sitemap / robots | 121 URLs, all 200, all reachable by links, none noindex; `robots.txt` unchanged |
| HTML validation | 25 representative pages pass html-validate (recommended rules, 3 stylistic rules off) |
| Accessibility | axe-core WCAG 2 A/AA + best practice: 0 violations on 20 page types at 390px and 1280px; Lighthouse 100 |
| Keyboard | Skip link first; mega menus open with Enter, are reachable with Tab and close with Escape; 3px focus ring on all controls |
| Responsive | No horizontal overflow at 320, 375, 390, 430, 768, 1024, 1280, 1440 and 1920px on 20 page types |
| Forms | Wizard end to end: validation per step, consent required, submit via a test mail server, email checked; Assist hand-off and setup finder checked |
| Schema | All JSON-LD parses; types as listed above |
| Metadata | Titles and descriptions unique and within length on all indexable pages |
| Security | CSP present and enforced (it blocked an injected test script); blocked paths return 404; legacy URLs 301 |
| Server | No PHP warnings or notices in the Apache error log across the full crawl (PHP 8.3; lint also clean on 8.4) |
| Authentication | Not applicable: there is no authentication. Login and Sign Up are informational and their fields are disabled |

## Remaining issues
1. **Official-source access (blocking for content).** Allow the government and free-zone domains listed in the audit (§12), then:
   - re-verify the 60 registry facts, whose status is currently "supplied"
   - build the UAE cluster (mainland, free zones, offshore, visas, corporate tax, VAT)
   - rewrite the 100 noindex Phase A pages
   - fill the pricing engine with verified fees
2. **Live-site inspection:** `incorpsys.com` couldn't be reached. Confirm it runs this codebase before deployment planning.
3. **Leadership photos:** they arrived as chat images only. Add them as files to `assets/img/team/`.
4. **Business facts only you can supply:** legal entity name, registration number, registered address and office locations for the trust pages. None were invented.
5. **Legal text:** Privacy, Terms and Disclaimer need legal approval before they can be indexed.
6. **Email delivery:** `mail()` needs SMTP or a CRM webhook, plus SPF/DKIM.
7. **Minification (optional):** CSS and JS are gzip-served but not minified; the saving would be about 10 KB.

## Deployment readiness report
| Item | Status |
|---|---|
| Code | Complete for this scope; on `claude/lucid-planck-30sxav`; not merged or deployed |
| QA | All tests above pass |
| SEO | Ready. Sitemap, canonicals and schema consistent; 100 thin pages deliberately noindex |
| Security | Ready at application level. HSTS must be set at the HTTPS server or CDN; `INCORPSYS_FORM_SECRET` must be set |
| Performance | Lighthouse mobile 98–99; no third-party scripts |
| Migration | None needed. No URLs changed and no database |
| Content | Publishable, with the verification limits stated on the pages themselves |
| Blockers | Mail delivery (SMTP/SPF/DKIM), form secret, legal approval, and confirming the live site's current stack |

**Rollback plan:** the work is isolated on a branch.
- Before merge: rollback means not merging.
- After deployment: redeploy the previous release, i.e. the `main` commit `491278b` or the commit before the merge. There's no database or migration to reverse, and no URL changes to undo.

**Nothing has been deployed.** Merge and deployment are waiting for explicit approval.

## Recommended Phase 3
1. Grant source access, re-verify the registry, and set `status: verified` with fresh dates.
2. Build the UAE flagship cluster from verified sources: mainland, individual free-zone authorities, visas, corporate tax, VAT. One page per intent, no duplicates.
3. Rewrite the Phase A pages country by country and remove `noindex` as each passes the content standard.
4. Populate the pricing engine with official fee schedules, and add the INCORPSYS service fees once approved.
5. Connect enquiries to a CRM and build the client portal backend (accounts, documents, progress), then enable the Login and Sign Up forms.
6. Add Search Console monitoring and a quarterly source-freshness review.
