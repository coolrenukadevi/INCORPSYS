# INCORPSYS — Premium Polish Final Report

Date: 26 September 2026 · Branch: `claude/lucid-planck-30sxav` · Baseline: `70e5ae8` · Audit: `docs/incorpsys-premium-polish-audit.md`

Nothing has been deployed. The site is ready for review on the branch and as a cPanel upload zip; production release waits for your approval (brief §40).

## 1. Before / after

Scores are an internal assessment against the brief's acceptance test, not an external rating, and are not published on the site.

| Category | Before | After | What changed |
|---|---|---|---|
| Brand / visual | 8.0 | 9.0 | Editorial hero, official-source trust bar, explorer cards, numbered pillars, dark method section with a real source record, lifecycle strip |
| UX (10-second clarity) | 7.5 | 9.0 | One question at a time with progress; inline "Your setup path"; clear Get Started / Compare / Explore hierarchy |
| Conversion | 7.5 | 8.5 | Get My Setup Plan pre-fills the enquiry; "Need help with this setup?" mini-form on every major page; sticky phone bar; enquiries open for 3 new countries |
| Trust (official vs INCORPSYS) | 8.5 | 9.5 | Verification-status component; "Not yet verified" everywhere a value is unconfirmed; "Information pathway, not advice" on the setup path; "Who decides" and "What is not included" on services |
| SEO | 9.0 | 9.0 | Titles/descriptions refreshed; Quick facts on guides; new pages noindex until verified; sitemap unchanged at 128 URLs |
| AEO | 8.5 | 9.0 | Direct answers kept; Quick facts give extractable, cited values; ItemList schema |
| Mobile | 8.5 | 9.5 | Comparison cards, sticky action bar, 11 widths from 320 to 1920 with no overflow |
| Performance | 9.5 | 9.5 | Lighthouse mobile 98–99, desktop 100; CLS 0 on the homepage |
| Accessibility | 9.0 | 9.5 | axe 0 violations; all tap targets ≥ 24px (closes earlier M7); keyboard-safe guided setup; no-JS fallbacks |
| Security | 9.0 | 9.0 | Unchanged controls; new countries added to the server-side allow-list |

## 2. Changes

### Design system
- Verification status component (amber dot, title, "Verify with …" link) replaces the generic pending warnings on jurisdiction and topic pages.
- New components: chips, authority cards, explorer cards, editorial pillars, method flow, source record, lifecycle strip, facts grid, CTA mini-form, sticky phone bar.
- Motion is 150–250 ms and switched off under `prefers-reduced-motion`.

### Header, navigation, footer
- Company Setup mega menu regrouped: Middle East / Asia / Europe & Americas, with the new countries marked "Guide in preparation".
- Utility bar reads "Company setup across the Middle East, Asia, Europe and the Americas".
- Footer: new countries in the Jurisdictions column; social media icons; shorter justified intro.

### Homepage (brief §5–12)
- Hero: "Build your business beyond borders." with the supporting statement from the brief. Get Started (primary), Compare Jurisdictions (secondary), Explore Jurisdictions (text link).
- Guided setup, four steps: where, what, who, visa.
  - Result shows: official authority, possible structure, filing route, key requirements, relevant services and what needs verification.
  - Actions: Get My Setup Plan, See the full setup path, Start over.
  - Every item comes from registered sources (`includes/setup-path.php`).
- Trust bar "Built on official sources.": six authority cards labelled "Official source" and linked to the authority, with the line "not partners or endorsers".
- Jurisdiction explorer: nine cards with authority, incorporation route, coverage and source status.
- Why INCORPSYS: the brief's four pillars. Source-first method: the six steps plus a real ACRA source record with authority, source and last-verified date.

### Guided setup and quote UX (brief §6, §18)
- The result is an information pathway and says so. There is no automated pricing; a formal quote is requested through the enquiry.

### Jurisdiction pages (brief §13–14)
- New Quick facts grid near the top (13 fields from the comparison, each linked to its source guide or marked "Not yet verified").
- Pending sections use the verification-status component with a link to the authority.

### Comparison (brief §10)
- New rows: registered office, tax registration, visa and residency, corporate banking, ongoing compliance. Values come only from existing sourced guides.
- Controls: topic filter (Formation / Operating / Cost and time / All), jurisdiction toggles, and sort (Default / Most verified values / A–Z).
- Layout: pinned first column on desktop, cards on phones. Without JavaScript every column shows.
- "Verify" is renamed "Not yet verified"; the new countries appear as rows with no verified values.

### Services (brief §20)
- Added "Who decides", "How it works" and "What is not included" (advice, authority decisions, guarantees, government fees); new countries listed under "Where we provide it".

### Knowledge Hub and search (brief §21–22)
- `/resources/` is now the INCORPSYS Knowledge Hub:
  - search box and category filter using the brief's 11 categories (`content/knowledge-hub.php`)
  - jurisdiction cards with source status
- Search:
  - results show category, jurisdiction and verified date
  - filter chips by type (Jurisdiction, Service, Structure, Guide, FAQ, Checklist, Comparison, Glossary) work without JavaScript

### Commercial layer and Assist (brief §16, §19)
- Every major page ends with "Need help with this setup?" (country, activity, ownership, visa → Get a Setup Plan) and "Speak to an Expert" (WhatsApp, Contact us) with the no-guarantee line.
- Assist subheading "Guided setup assistance from the INCORPSYS team."; options in the brief's wording.

### New jurisdictions: Saudi Arabia, the Philippines, Thailand
- Pages `/saudi-arabia/`, `/philippines/` and `/thailand/` show:
  - direct answer, verification status and official starting points
  - how we work, cross-jurisdiction guides and a CTA
- They are noindex and not in the sitemap.
- Named authorities: MISA and Ministry of Commerce; SEC; DBD. Only their official home pages are linked, and they are labelled as not yet checked, because the official sites are blocked from this environment.
- Available in menus, footer, guided setup, `/explore/`, enquiry (server allow-list), search, service pages, comparison and the sitemap page.

## 3. Items from the briefs not built as written

See audit §3. Not built:
- government logos or "verified registry" badges
- security badges and client metrics
- sorting by tax rate, speed or fees
- a cost estimator
- the "2026 taxation matrix" lead magnet
- LegalService schema
- UAE free-zone pages

Each would require unverified or fabricated information.

## 4. SEO / AEO verification
- 281 pages crawled: all 200 except the intended 404; no truncated pages; all JSON-LD parses.
- Sitemap: 128 URLs, all 200, equal to the indexable set; new countries excluded.
- Parameterised `/get-started/?…` URLs canonicalise to `/get-started/`.
- Title changed: homepage "Global Company Incorporation & Business Setup | INCORPSYS". The resources page title is unchanged; its H1 and breadcrumb now read Knowledge Hub.
- Schema added: ItemList of jurisdiction guides (homepage graph, `/jurisdictions/` mainEntity).

## 5. QA results

| Check | Result |
|---|---|
| Crawl | 281 pages, 0 broken, 0 truncated |
| html-validate (recommended) | 0 errors on 281 pages |
| Overflow at 320, 360, 375, 390, 414, 430, 768, 1024, 1280, 1440, 1920 | None on 32 key pages |
| axe WCAG 2.0/2.1 A+AA + best practice (1280, 390) | 0 violations |
| Tap targets < 24px on phones | None |
| Console / JS errors | None |
| No-JS | Guided setup submits to `/explore/`; all comparison columns and hub categories visible; filters hidden |
| Enquiry POST (Thailand) | Accepted, summary shows the jurisdiction |
| Lighthouse `/` | Mobile 99/100/100/100, LCP 2.0 s, CLS 0 · Desktop 100/100/100/100, LCP 0.5 s |
| Lighthouse `/jurisdictions/`, `/uk/` | Mobile 99, desktop 100; CLS ≤ 0.007 |

Bugs found and fixed during QA:
- a lost helper function that cut pages off mid-render (caught by the new truncation check)
- hidden tooltips and screen-reader text widening scroll areas
- the comparison hiding columns without JavaScript
- a first-paint layout shift in the guided setup

## 6. Files
- **Added:**
  - `content/pending-jurisdictions.php`, `content/knowledge-hub.php`
  - `includes/setup-path.php`, `pages/_pending_hub.php`
  - `pages/{saudi-arabia,philippines,thailand}/index.php` (generated stubs)
  - `docs/incorpsys-premium-polish-audit.md`, this report
- **Changed:**
  - Shared partials and scripts: `index.php`, `partials/components.php`, `partials/header.php`, `partials/footer.php`, `assets/css/site.css`, `assets/js/site.js`
  - Content and includes: `content/comparisons.php`, `content/navigation.php`, `content/registry.php`, `includes/config.php`, `includes/phase-a.php`, `includes/search.php`
  - Templates: `pages/_hub_template.php`, `pages/_page_template.php`, `pages/_service_template.php`
  - Pages: `explore/index.php`, `search/index.php`, `get-started/index.php`, `enquiry/submit.php`, `sitemap/index.php`, `about/vision-mission/index.php`
  - Other: `tools/build.php`, `README.md`
- **Routes added:** `/saudi-arabia/`, `/philippines/`, `/thailand/` (noindex). No routes removed or renamed.
- **Database:** none (the site has no database).

## 7. Unresolved
1. **C1:** "Sources checked" dates reflect the supplied content (25 Sep 2026), not an independent check from this environment. Official sites remain blocked by the network policy.
2. The new countries need sourced content (guides, profile, journey, comparison values) before they can be indexed.
3. **Still needed from you:**
   - INCORPSYS service fees, legal-entity details, and the policy `[To be confirmed]` items
   - Filing Quality Commitment and Service Terms wording
   - GA4 ID, leadership photos, and a www or non-www decision
4. The article is omitted in generated phrases ("Company formation in Philippines", matching the existing "in UK"). A per-country display name would fix both.

## 8. Recommended next phase
1. Enable network access to official sources, re-verify the six jurisdictions (C1), then write verified guides for Saudi Arabia, the Philippines and Thailand.
2. UAE flagship: mainland / free zone / offshore architecture once individual free-zone authorities are verified.
3. Replace `mail()` with SMTP or a CRM webhook, then consider a quote backend.

## 9. Production readiness report

| Item | Status |
|---|---|
| Code on branch, validated | Ready |
| cPanel zip (with generated `includes/secrets.php`) | Ready for upload on your approval |
| PHP 8.1+, Apache `mod_rewrite` | Required (unchanged) |
| HTTPS + HSTS, SPF/DKIM, SMTP | Server-side items to confirm |
| Legal policies | Drafts, noindex, awaiting legal review |
| Rollback | Re-upload the previous zip (`incorpsys-cpanel-upload-v2.zip`) or redeploy commit `70e5ae8` |

**Waiting for your explicit approval before any production deployment.**
