# INCORPSYS Homepage Redesign — Audit, Gap Analysis & Plan

Date: 26 September 2026 · Branch: `claude/lucid-planck-30sxav` · Status: **plan only; no files changed. Waiting for approval.**

Scope: the homepage (`index.php`) and the shared components it uses. **The header and footer stay unchanged**, as instructed. The floating INCORPSYS Assist is part of the footer partial and is also left as it is.

## 1. Audit of the current homepage

| # | Current section | What it does | Keep / change |
|---|---|---|---|
| 1 | Hero: "Build your business beyond borders." + 4-step guided setup card (country, activity, ownership, visa → inline "Your setup path") | Works; estimator card is visually as heavy as the headline | Redesign (brief §Hero) |
| 2 | Trust bar: six authority cards, "Official source" | Correct and honest | Merge into the new "Built on Official Sources" section |
| 3 | Jurisdiction explorer: 9 cards (6 + 3 in preparation) | Code badge, authority, route, coverage, source status | Redesign as premium destination cards |
| 4 | Comparison: filterable table (13 columns, topic and jurisdiction filters, sort); phone view = stacked cards | Honest ("Not yet verified"); dense on desktop; not tabbed on phones | Redesign: visual matrix + mobile tabs with Previous/Next |
| 5 | Why INCORPSYS: four numbered pillars | Good | Restyle as the brief's four cards |
| 6 | Method (dark): 6-step flow + real ACRA source record | Good content | Becomes the "Source-first engine" |
| 7 | Services: lifecycle strip + 6 service cards | Generic card grid | Replace with the ecosystem diagram |
| 8 | Business structures table | Useful but table-heavy | Move below the scenarios, as a compact block |
| 9 | Compliance cards (3) | Thin | Fold into the ecosystem / process sections |
| 10 | Knowledge hub (6 guide cards) | Generic grid | Redesign as the "Global Business Intelligence" hub |
| 11 | FAQ (6 questions) | Good | Replace with the brief's search-intent questions, sourced answers |
| 12 | CTA band (mini-form) | Good | New closing section |

Measured now:
- **SEO / QA:** 140 indexable pages, `tools/qa.php` 0 failures; homepage JSON-LD has Organization, WebSite, WebPage, ItemList and FAQPage.
- **Lighthouse:** mobile 98 (LCP 2.0 s, CLS 0), desktop 100 (LCP 0.4 s).
- **Accessibility:** axe 0 violations.

## 2. Reference vs INCORPSYS rules — what cannot be reproduced literally

The reference is used for **design language only**: layout, rhythm, card treatment, dashboard feel. These elements in it conflict with the data-integrity rules, so the redesign handles them as follows:

| Reference element | Problem | Planned treatment |
|---|---|---|
| Tax rates (0%/9%, 17%, 16.5%, 24%) and processing times (1–5 days) in the comparison | Not in the INCORPSYS source registry; publishing them would be fabrication | Rows kept, values shown as **Not yet verified / Authority-dependent / State-dependent (USA) / Emirate / free-zone dependent (UAE)** |
| "200+ Regulatory Guidelines" stat | Not true: the registry holds 60 sourced statements | Stats bar uses real counts only: 6 jurisdictions with published guides, 60 source-backed guides, 12 service areas… (each count computed from the data, not typed) |
| Testimonial "Amit Sharma, Founder…" | Fabricated testimonial | Omitted. Replaced by a "Founder considerations" card (real guidance, no quotes) |
| Government logos (UAE emblem, ACRA, CR, Companies House, SBA, SSM) | Official marks imply endorsement and are usually restricted | Text "wordmark" tiles with the authority name, country and "Official source" label, linked to the authority |
| Donut "Total Setup Cost UAE (Example)" with proportions | Segment sizes imply amounts we do not have | Three-category cost architecture (Government / INCORPSYS / Third-party) as equal-weight segmented bars, each stating "Fee not yet verified" or "Contact for service fee", with a text table alternative |
| Stock skyline photos (hero, jurisdiction cards) | The brief itself says to avoid skyscraper stock photos; no licensed images exist; photos would cost LCP | Original lightweight SVG line-art per jurisdiction (abstract skyline silhouettes drawn for INCORPSYS), no photos (see decision D1) |
| Country flags on every row and card | The brief says to avoid excessive flags | Small country-code badges; optional tiny flag glyphs only in the matrix header (D1) |
| Dotted world map in the closing CTA | The brief says no literal map and no globe | Abstract node network linking the six jurisdiction nodes |
| "Calculate Fees & Timelines" CTA | No verified fee or timeline data to calculate | "Compare Jurisdictions" (the brief's own CTA) |
| "Compare 6 jurisdictions … fees, timelines, tax" copy | Implies data we do not have | "Compare authorities, routes and requirements" |

## 3. New homepage structure (maps to the brief's sections)

All text is crawlable HTML; diagrams are supplementary (inline SVG with `aria-hidden` plus an HTML text equivalent).

1. **Hero** (split):
   - **Left:** eyebrow "Global Company Incorporation"; H1 "Launch Your Global Business With Confidence."; supporting copy; **Launch Your Entity →** (primary) and **Compare Jurisdictions**; four trust points (Source-first · Transparent costs · Authority-linked information · Human support).
   - **Right:** a lighter "Find your ideal setup" configurator (Jurisdiction · Business structure · Founder residency → **Explore Setup →**), about 60% of the current card's visual weight. The inline result is kept (authority, route, requirements, services, what needs verification).
   - **Behind:** an abstract "Global Business Infrastructure" dashboard (six jurisdiction nodes → Incorporation → Licensing → Banking readiness → Compliance → Expansion).
2. **Stats bar:** counts computed from data (no invented numbers).
3. **One platform. Multiple global business destinations.** Six premium jurisdiction cards: authority, structures guide, filing route, source status, last-verified date, Explore →, with hover elevation. The three in-preparation jurisdictions sit in a slim row beneath (D3).
4. **Interactive comparison:**
   - **Desktop:** a compact visual matrix with ✓ / ● / "Not yet verified" indicators and a text legend; each cell links to its source guide.
   - **Filters:** only those supported by verified data (topic groups: Formation · Operating · Cost & time; plus jurisdiction toggles). The reference's "Lowest complexity / Technology / Trading / Holding" filters are **not** exposed because no verified data supports ranking.
   - **Phones:** jurisdiction tabs (WAI-ARIA tabs) with ← Previous / Next →, showing authority, structure, fees, requirements, processing, source and last verified.
5. **From Idea to Incorporated Business:** 6-stage process. Horizontal with drawn connecting lines on desktop, vertical on phones; stages reveal on scroll; reduced motion is respected.
6. **Know What You Are Paying For:**
   - Government / INCORPSYS / Third-party cost architecture (segmented bars and cards).
   - Every amount reads "Fee not yet verified", "Authority-dependent" or "Contact for service fee".
   - An accessible table alternative is included.
7. **Built on Official Sources:**
   - Engine diagram: Official authority → Verified requirement → INCORPSYS knowledge layer → Founder decision.
   - Six authority wordmark tiles with the real last-verified date (25 Sep 2026, from the registry) and "View official source →".
8. **Why INCORPSYS:** four cards. 01 Source-first · 02 Transparent · 03 Technology-driven · 04 Global.
9. **Global business ecosystem:**
   - **Desktop:** a radial diagram, with INCORPSYS at the centre and nodes linking only to existing service pages (Incorporation, Licensing, Banking readiness, Visa & residency, Compliance, Tax registration, Registered office / documents, International expansion).
   - **Phones:** stacked cards.
10. **Business scenarios:** Startup · Global expansion · Holding structure · Trading business · Regional office, each linking to existing verified guides and services.
11. **Which Jurisdiction Fits Your Business?**
    - Five questions (based where, activity, customers, local operations, residency).
    - Output: "Potentially relevant options" plus the matching guides, with an explicit note that professional, legal or tax advice may be required.
    - No jurisdiction is labelled "best".
12. **Global Business Intelligence** (Knowledge Hub):
    - Category rail (Company formation · Tax · Banking · Compliance · Visa · Global expansion).
    - Tiles: Featured guide · Jurisdiction comparison · Founder guide · Official source directory.
    - "Latest regulatory update" is **omitted**: no update feed exists, and inventing one would be fabrication.
13. **FAQ:** the brief's search-intent questions with answers drawn only from the registry, for example:
    - "Can a non-resident establish a company in Singapore?" is answered from the ACRA foreigners guide.
    - "How much does UK incorporation cost?" states that the fee is not yet verified and points to the GOV.UK source.
    - "UAE mainland vs free zone" states what the UAE Government mainland guidance covers and that free-zone rules are set by each free-zone authority (pending verification).
    - FAQPage schema is included.
14. **Closing CTA:** "Your Global Business Starts With the Right Structure." with Launch Your Entity → and Compare Jurisdictions, hello@incorpsys.com, +91 78448 19819, and an abstract node network (no map).

## 4. Files

| Action | File | Change |
|---|---|---|
| Rewrite | `index.php` | New section order and markup; keeps the title, description, canonical, one H1, and the Organization / WebSite / ItemList / FAQPage schema |
| Add | `partials/home/hero.php`, `jurisdiction-cards.php`, `comparison.php`, `process.php`, `costs.php`, `sources.php`, `ecosystem.php`, `scenarios.php`, `decision.php`, `knowledge.php` | Reusable homepage components (the brief's `/components/*`, following the repo's existing `partials/` convention) |
| Add | `content/home.php` | Homepage copy, scenarios, FAQ and ecosystem mapping (single data source) |
| Extend | `includes/setup-path.php` | Structure and residency answers for the new configurator; decision-module mapping to guides |
| Extend | `partials/components.php` | `compare_table()` gains matrix and tabbed-mobile output; existing callers (`/jurisdictions/`, country pages) keep their current output |
| Extend | `assets/css/site.css` | New homepage section styles (scoped under `.home-*`); header and footer rules untouched |
| Extend | `assets/js/site.js` | Configurator, comparison tabs (Previous/Next, arrow keys), scroll reveal (IntersectionObserver, reduced-motion aware), decision module |
| Add | `assets/img/home/*.svg` | Original line-art jurisdiction illustrations and diagrams (small, inline or cached) |
| Unchanged | `partials/header.php`, `partials/footer.php` (including Assist), all other routes, sitemap, robots | As instructed |

The brief's `/data/*.php` layout is **not** introduced: the repo already centralises this data in `content/sources.php`, `content/comparisons.php`, `content/services.php` and `content/journeys.php`. Moving it would touch every template without benefit (the brief says to keep the architecture unless the audit shows a need).

## 5. SEO / AEO safeguards
- No URL, title or canonical changes except the homepage H1 and title, which follow the brief. Proposed title: "Global Company Incorporation & Business Setup | INCORPSYS" (unchanged).
- All section content is in HTML headings, paragraphs, lists and tables; SVG diagrams are decorative with text equivalents.
- Internal links to the 6 country guides, the comparison page, 10 services, scenario guides and the Knowledge Hub are kept or increased.
- FAQ answers come only from the source registry.

## 6. Performance and accessibility plan
- **Assets:** no new fonts or libraries; SVG illustrations under about 6 KB each; no hero photo, so the LCP element is the H1 text.
- **Performance targets:** CLS 0; desktop LCP ≤ 1.2 s (0.4 s today). Mobile LCP under Lighthouse's throttled 4G is about 2.0 s today because of the font and CSS; target ≤ 1.8 s via critical CSS for the hero. 1.2 s on throttled mobile is not realistic without removing the web font; I will report the measured value.
- **Accessibility:** WAI-ARIA tabs for the mobile comparison; every chart has an HTML table or list alternative; `prefers-reduced-motion` disables reveal and line-draw; keyboard and focus styles on every control.
- **QA:** `tools/qa.php`, html-validate, axe, overflow at 7 widths (1440–375), Lighthouse, and the brief's final checklist.

## 7. Decisions needed before implementation
- **D1 Imagery:** original SVG line-art per jurisdiction (recommended), or licensed photography you supply.
- **D2 Headline:** switch the H1 to "Launch Your Global Business With Confidence." as in this brief (replacing "Build your business beyond borders.").
- **D3 In-preparation jurisdictions** (Saudi Arabia, Philippines, Thailand): a slim row under the six cards (recommended), or removed from the homepage (they stay in menus and on their own pages).
- **D4 Approval** to implement.
