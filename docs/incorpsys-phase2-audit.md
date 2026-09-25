# INCORPSYS — Phase 2 Production Audit

**Date:** 25 September 2026
**Codebase audited:** `main` at `491278b` (after PR #1: audit fixes, About Us, Phase 2 content)
**Method:** full source review; site served on Apache 2.4 + mod_php 8.3 with the real `.htaccess`; link crawl of every sitemap URL; content-duplication analysis (5-word shingles); axe-core (WCAG 2 A/AA + best practice) on 10 representative pages; html-validate; Lighthouse (mobile) on two pages; Playwright at 390–1440px.

## 0. Limits of this audit

| Limit | Effect |
|---|---|
| The live site `incorpsys.com` is blocked by this environment's network policy | The audit covers this repository only. If the live site runs different code, it has not been inspected. |
| Government and free-zone sources (`u.ae`, `tax.gov.ae`, `acra.gov.sg`, `gov.uk`, `irs.gov`, `ssm.com.my`, `cr.gov.hk`, `dmcc.ae`, `ifza.com` …) are blocked | No new regulatory fact can be verified. Under the no-fabrication rule, no new fees, timelines, visa rules, tax rates or free-zone details are added until access is granted. |
| No database, authentication, sessions or file uploads exist | Nothing to audit for SQL injection, password handling or upload validation. Login and Sign Up are placeholder pages. |

## 1. Current architecture

- **Stack:** plain PHP 8.1+, no framework, no database, no Composer/npm dependencies. Apache `mod_rewrite` routes clean URLs to one-line stub files.
- **Request flow:** `/uae/company-registration/` → `.htaccess` → `pages/uae/company-registration/index.php` (stub sets `PAGE_SLUG`) → `pages/_page_template.php` → content from `includes/data.php`.
- **Content registry** (PHP arrays):
  - `content/sources.php`: one primary authority, a source library and a verification date per jurisdiction
  - `content/registry.php`: topic and service names
  - `content/pages.php`: Phase A pages, generated from templates
  - `content/phase2.php`: Phase 2 pages
- **Templates:** `_page_template.php` (content pages), `_hub_template.php` (jurisdiction and resource hubs), `404.php`, `about/`, `login/`, `signup/`, `legal/*` (rendered by the page template, noindex).
- **Partials:** `header.php`, `footer.php` (includes the chat widget), `enquiry-form.php`.
- **Assets:** one CSS file (13 KB, flat and largely one-off rules), one JS file (1.6 KB), PNG logo (369 KB) and icons. System font stack; "Inter" is declared but never loaded.
- **Forms:** one enquiry form posts to `enquiry/submit.php`, protected by a honeypot, an HMAC time token and a per-IP rate limit. Delivery uses `mail()`.
- **Tooling:** `tools/build.php` generates stubs and `sitemap.xml`.

## 2. Routes (208 HTML routes + utility)

| Group | Pattern | Count | Indexable |
|---|---|---|---|
| Home | `/` | 1 | yes |
| About | `/about/` | 1 | yes |
| Contact | `/contact/` | 1 | yes |
| Jurisdiction hubs | `/{uae,singapore,hong-kong,uk,usa,malaysia}/` | 6 | yes |
| Resource hub | `/resources/` | 1 | yes |
| Phase A topic pages | `/{jurisdiction}/{topic}/` | 60 | yes |
| Phase A service pages | `/{jurisdiction}/{service}/` (4 jurisdictions) | 40 | yes |
| Phase 2 jurisdiction guides | `/{jurisdiction}/{guide}/` | 60 | yes |
| Phase 2 resource guides | `/resources/{guide}/` | 35 | yes |
| Legal | `/legal/{privacy,terms,disclaimer}/` | 3 | noindex |
| Login / Sign Up | `/login/`, `/signup/` | 2 | noindex |
| Enquiry handler | `POST /enquiry/submit.php` | 1 | n/a |
| Utility | `robots.txt`, `sitemap.xml` (205 URLs), `llms.txt`, `manifest.webmanifest` | | |

**Broken internal links:** none. All 210 crawled pages return 200, and every sitemap URL is reachable by links.
**External links:** not checked (network blocked).

## 3. Components inventory

| Component | Where | State |
|---|---|---|
| Utility bar | header | Login/Sign Up left, tagline centre, email/phone right; collapses on mobile |
| Header + nav | header | Home, About, Services (anchor), Jurisdictions dropdown, Resources, Contact, Enquiry Now; mobile menu |
| Hero + metrics panel | home | Present; no guided setup selector |
| Cards / grid | everywhere | One card style; no variants |
| Direct-answer block | content pages | Present |
| Source rail | content pages | Authority, note, source library, verification date (Phase 2 only) |
| Related links | content pages | Present |
| Enquiry form | every page | Single step; placeholder-only inputs (no visible labels) |
| Chat widget | footer | Static list of 4 links; not a guided flow |
| Footer | all | 4 columns |
| Breadcrumbs, 404 | | Present; 404 has no search |
| Tables, tabs, accordions, alerts, badges, modal, tooltip | | **Missing** |
| Comparison / pricing components | | **Missing** |

## 4. SEO findings

| Check | Result |
|---|---|
| Unique titles | ✅ all unique |
| Title length > 60 chars | ⚠️ 7 pages (e.g. `hong-kong/certificates` at 79) |
| Meta description outside 70–160 chars | ⚠️ 4 (1 indexable: `hong-kong/certificates` at 172; 3 legal pages under 60) |
| Canonical | ✅ on all indexable pages; omitted on noindex pages |
| One H1 per page | ✅ |
| Heading order | ⚠️ skips H2 → H3 in 3 sampled templates (hub cards, footer) |
| Breadcrumbs + BreadcrumbList | ✅ |
| Schema | ✅ Organization (home), WebPage, BreadcrumbList, FAQPage, CollectionPage, ContactPage. ❌ No `WebSite`, `Article` or `Service`; `Organization` is on the homepage only |
| Open Graph / Twitter | ✅ present. ⚠️ The OG image is the logo (1400×425), not a 1200×630 social image |
| robots.txt / sitemap | ✅ consistent; sitemap excludes noindex pages |
| Image alt text | ✅ |
| Orphan pages | ✅ none |
| **Duplicate / thin content** | ❌ **Critical** — see §6 |
| URL structure | ✅ short, lowercase, hyphenated, stable, with 301s for legacy/missing-slash forms |

## 5. AEO findings

- ✅ Every content page opens with a Direct Answer block and ends with FAQs.
- ❌ In the 100 Phase A pages, the direct answer and all 3 FAQs are **identical across every country and topic**, so they answer nothing specific.
- ⚠️ The Phase 2 guides have country-specific answers and checklists, but 5 boilerplate sections and 3 generic FAQs repeat on all 95 Phase 2 pages.
- ❌ No page directly answers the high-intent questions in the brief ("Can foreigners establish a company?", "Do I need a local director?", "How much does it cost?") with sourced, jurisdiction-specific facts.
- ❌ No comparison content (e.g. UAE vs Singapore) and no definitions/glossary blocks, although glossary pages exist as resources.

## 6. Content findings (duplicate and thin pages)

Measured as the share of each page's 5-word phrases that appear on no other page:

| Page type | Pages | Median unique text | Pages under 10% unique |
|---|---|---|---|
| Phase A topic pages | 60 | **1%** | 60 |
| Phase A service pages | 40 | **1%** | 40 |
| Phase 2 jurisdiction guides | 60 | 13% | 0 |
| Phase 2 resource guides | 35 | 12% | 2 |
| Contact | 1 | 81% | 0 |

Examples of pairwise overlap:
- `/uae/company-registration/` vs `/uae/legal-structures/`: **82%** identical
- `/uae/company-registration/` vs `/singapore/company-registration/`: **60%**
- `/resources/fee-verification/` vs `/resources/timeline-verification/`: **71%**

**Conclusion:** the 100 Phase A pages are country-name-replacement pages. They fail the brief's content test (§28) and minimum page standard (§32). The Phase 2 guides pass narrowly: their unique part is useful, but it is buried under shared boilerplate.

Other content issues:
- Every Phase A page for one country cites the same single source, so the UAE visa, tax and banking pages all cite the mainland business-setup page.
- No jurisdiction page covers the brief's sections (who can register, structures, documents, process, tax, visa, banking, costs, timeline, comparison, common mistakes) with sourced facts.
- No UAE free-zone, mainland/offshore, visa or tax content exists. Adding it needs source access (see §0).
- Legal pages are baseline drafts flagged "final legal text should be reviewed". They are correctly noindex.
- No methodology, source policy or editorial policy pages, although the site's positioning depends on them.

## 7. UX and conversion findings

- **CTA hierarchy:** "Enquiry Now" appears in the header, hero, every page, the chat widget and the footer. There's no "Get Started" path and no lead qualification before the form.
- **Enquiry form:** a single step with free-text "jurisdiction" and "message". It doesn't ask what the visitor needs, their activity, ownership, visa needs or timeline, so replies can't be prepared properly.
- **Discovery:** no guided "find the right setup" selector and no jurisdiction comparison. Services have no landing pages of their own; they exist only per country.
- **Navigation:** no Business Structures or Services menus, and no methodology, source policy or search.
- **Chat widget:** a static link list. It covers the "Enquiry Now" button on small screens (partly fixed: hidden while the mobile menu is open).
- **Trust signals:** source links and verification dates are good. There's no methodology or editorial transparency, and no company or legal-entity information. That information must come from the business, not be invented.
- **Login / Sign Up:** placeholder text only. There's no portal architecture that sets expectations.

## 8. Technical findings

- ✅ PHP lint clean on 8.3 and 8.4; no warnings in the Apache error log across the full crawl.
- ✅ Output escaping via `e()` throughout templates.
- ❌ Unescaped `&` in header/footer HTML (html-validate `no-raw-characters`).
- ⚠️ CSS: flat rules with repeated colours and sizes, many inline `style=""` attributes in templates, and no design tokens beyond 9 colour variables.
- ⚠️ Stub-file routing needs `tools/build.php` after every content change (documented).
- ✅ Legacy phase-B placeholders are blocked from the web.

## 9. Accessibility findings (axe-core, 10 pages)

| Impact | Rule | Pages | Detail |
|---|---|---|---|
| serious | `aria-hidden-focus` | 10/10 | Links inside the closed chat panel are focusable while `aria-hidden="true"` |
| serious | `color-contrast` | 4/10 | Small grey text in the source rail (`#7a8797` on `#f4f8fd`) |
| moderate | `region` | 10/10 | Utility bar outside any landmark |
| moderate | `heading-order` | 3/10 | H3 without a preceding H2 (hub cards, footer) |

Also missing:
- Visible form labels (placeholder-only fields)
- A `:focus-visible` style on buttons and links (browser default only)
- An accessible name on the chat toggle (it is an emoji)

Lighthouse accessibility scores: 92–95.

## 10. Performance findings (Lighthouse mobile, simulated throttling)

| Page | Perf | A11y | Best practices | SEO | LCP | CLS | TBT |
|---|---|---|---|---|---|---|---|
| `/` | 93 | 95 | 100 | 100 | 3.2 s | 0 | 0 ms |
| `/uae/company-registration/` | 95 | 92 | 100 | 100 | 3.0 s | 0 | 20 ms |

- LCP is dominated by the **369 KB logo PNG**, which is displayed at 220×67. A 440px WebP would be about 10 KB.
- There's no web font, so there's no font cost, but typography falls back to each device's system font.
- CSS and JS are tiny, cache-busted and cached for 30 days. There are no third-party scripts.

## 11. Security findings

| Area | Status |
|---|---|
| SQL injection | n/a (no database) |
| XSS | ✅ all dynamic output escaped |
| CSRF | ⚠️ HMAC time token, but no Origin check; the token isn't bound to the requesting site |
| Form abuse | ✅ honeypot, minimum fill time, 5/hour/IP rate limit, length limits, header-injection stripping |
| Server-side validation | ⚠️ free-text only; no allow-lists because there are no structured fields yet |
| Sessions / auth / passwords | n/a (none exist) |
| File uploads | n/a (none exist) |
| Secrets | ✅ none in the repo; the form secret comes from the environment (a fallback is derived from host details and should be overridden in production) |
| Security headers | ✅ nosniff, Referrer-Policy, Permissions-Policy, X-Frame-Options. ❌ no Content-Security-Policy; ❌ no HSTS (set at the HTTPS vhost/CDN) |
| Error leakage | ✅ custom 404; PHP errors not displayed (depends on production `display_errors=Off`) |
| Internal files | ✅ `includes/`, `content/`, `docs/`, `tools/`, dotfiles and README/CSV files return 404 |

## 12. Recommended changes and plan

Changes are split into what can be done **now** (no new regulatory facts needed) and what is **blocked on source access**.

### Now
1. **Design system:**
   - tokens for colour, type scale, spacing, radius, shadow and motion
   - self-hosted Inter
   - components: buttons, cards, labelled inputs, alerts, badges, tables, tabs, accordions, breadcrumbs, modal, tooltip, `:focus-visible`
   - remove inline styles
2. **Assets:** a resized WebP/PNG logo (the LCP fix) and a 1200×630 OG image.
3. **Header:**
   - utility bar with region context, phone, WhatsApp and email
   - mega menu: Company Setup, Business Structures (only structures that have pages), Services, Resources, About
   - Login, Sign Up and Get Started on the right
4. **Homepage IA** per the brief, including a guided setup selector that leads to a personalised "setup path" page built from existing guides. It contains no invented facts.
5. **Service hubs** (`/services/{service}/`): one page per service, listing the countries where it's offered.
6. **Comparison hub** (`/jurisdictions/`): only fields already sourced (authority, official starting point, registry channel, guides available). Unknown fields say "Verify".
7. **Multi-step enquiry** (`/get-started/`):
   - allow-listed fields, validated server-side, plus an Origin check
   - lead-priority tag in the email subject
   - no document upload, because there's no secure storage
8. **INCORPSYS Assist:** a progressive guided flow that hands off to the multi-step enquiry or WhatsApp with the answers pre-filled. It will not obstruct CTAs on mobile.
9. **Trust pages:**
   - Methodology, Source Policy and Editorial Policy, describing what the site actually does
   - no invented team, entity, awards or clients
10. **Login / Sign Up / Dashboard preview:**
    - honest "client portal not yet available" UI
    - the planned dashboard modules marked as not yet available
    - noindex
11. **Site search** (`/search/`, noindex) and a 404 page with search, popular jurisdictions and services.
12. **Jurisdiction template and source registry:**
    - a fact-level registry: fact, source, URL, verified date, jurisdiction, status
    - a jurisdiction template covering every section in the brief; sections without a verified fact show "Verify with the authority" and link to the relevant guides
    - UAE first
13. **Thin pages:**
    - set the 100 Phase A country-replacement pages to `noindex,follow` and remove them from the sitemap
    - keep their URLs working and move them out of primary navigation
    - one flag in `content/pages.php` reverses this per page once rewritten with sourced content
    - no redirects, so no URL migration is needed
14. **Phase 2 boilerplate:** replace the 2 repeated generic sections with a short shared source-policy note to raise the unique-content share.
15. **Schema:** add `WebSite` (with site search), `Organization` site-wide, `Article` on guides, `Service` on service hubs. No review, rating or LocalBusiness schema.
16. **Pricing and comparison engines:**
    - data structures that carry amount, currency, source, URL, verified date and validity
    - components that render "Verify" when there's no verified value
    - no prices are entered, because none are verified
17. **Security:** Origin check on POST, a CSP header, and allow-list validation.
18. **Accessibility:** fix every axe finding, add visible labels and fix contrast.

### Blocked until official sources are reachable
- The UAE flagship cluster: `/uae/mainland/`, `/uae/free-zone/`, `/uae/offshore/`, emirate and free-zone pages (DMCC, IFZA, RAKEZ, JAFZA, DAFZA, SHAMS), visa, corporate tax and VAT pages.
- Filling the jurisdiction template's factual sections for all six countries.
- Rewriting the 100 Phase A pages with jurisdiction-specific content.
- Any fee, timeline, tax rate or visa rule; populating the pricing and free-zone comparison engines.
- Checking external links.

Hosts to allow include:
- UAE: `u.ae`, `tax.gov.ae`, `dubaidet.gov.ae`, `adbc.gov.ae` and the official free-zone domains
- Singapore: `acra.gov.sg`, `iras.gov.sg`, `mom.gov.sg`
- Hong Kong: `cr.gov.hk`, `ird.gov.hk`
- UK: `gov.uk`
- USA: `sba.gov`, `irs.gov`
- Malaysia: `ssm.com.my`, `hasil.gov.my`
