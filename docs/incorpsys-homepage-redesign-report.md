# INCORPSYS Premium Homepage Redesign — Final Report

Date: 26 September 2026 · Branch: `claude/lucid-planck-30sxav` · Plan: `docs/incorpsys-homepage-redesign-plan.md` (approved)

Package: `INCORPSYS_Premium_Homepage_Redesign_Phase2_FINAL.zip` (new file; earlier zips untouched). **Not deployed.**

## 1. Before vs after

| | Before | After |
|---|---|---|
| Hero | Light hero; "Build your business beyond borders."; heavy 4-step card as tall as the headline | Dark navy hero; single H1 "Launch Your Global Business With Confidence."; Launch Your Entity (emerald, primary); original SVG "Global Business Infrastructure" diagram; lighter 3-field configurator bar under the hero |
| Proof | Authority badges | Stats computed from data (6 · 60 · 17 · 10) plus a source-first engine with authority tiles and real verification dates |
| Jurisdictions | 9 equal cards | 6 premium cards with original line-art; slim "More jurisdictions — guides in preparation" row for Saudi Arabia, the Philippines and Thailand |
| Comparison | 13-column table; stacked cards on phones | Features × jurisdictions matrix with visual status indicators and a topic filter (Formation by default); phone tabs with Previous / Next |
| New sections | — | Process flow (animated), cost architecture, ecosystem diagram, business scenarios, founder decision module, Global Business Intelligence hub, closing CTA with contact links |
| FAQ | 6 general questions | 8 search-intent questions; each answer restates a registry statement and links its source guide |

## 2. Files
- **Modified:** `index.php`, `assets/css/site.css`, `assets/js/site.js`, `includes/setup-path.php`
- **Added:**
  - `content/home.php`: homepage copy and data (single source).
  - `partials/home/art.php`: SVG illustration system.
  - `partials/home/`: section components `hero.php`, `jurisdiction-cards.php`, `comparison.php`, `process.php`, `costs.php`, `sources.php`, `why.php`, `ecosystem.php`, `scenarios.php`, `decision.php`, `knowledge.php`, `cta.php`.
  - Docs: the plan and this report.
- **Removed:** no files. About 180 lines of CSS that only the old homepage used, plus the old guided-setup script.
- **Not changed:** header, footer, INCORPSYS Assist, every other page and route, sitemap, robots, canonical structure.

## 3. Components and visual system
- `art_hero()`: platform → Incorporation → Licensing / Banking / Compliance → Global Expansion → six jurisdiction chips, plus a document check, a growth chart and an architectural horizon.
- `art_jurisdiction($key)`: six original abstract motifs:
  - UAE: tapered spire geometry
  - Singapore: vertical towers crossed by data lines
  - Hong Kong: dense vertical cluster
  - UK: institutional pediment and columns
  - USA: stepped tower with ascending chart
  - Malaysia: faceted towers with a lattice band
- No photographs, landmarks, flags or globe.
- `art_ecosystem_lines()` and `art_network()`: connector diagrams (the closing CTA uses an abstract node network, not a map).
- All SVG is inline, decorative (`aria-hidden`), coloured via CSS and under a few KB. Every piece of information shown in a diagram also exists as HTML text (captions, lists, tables).

## 4. UX and CRO
- **One clear primary action:** Launch Your Entity (hero, setup result, decision module and closing CTA). Compare Jurisdictions is the secondary action.
- **Configurator:** Jurisdiction · Business structure · Founder → an inline setup path showing:
  - authority, structure guide, filing route and key requirements
  - "Also read" guides and what still needs verification
  - Launch Your Entity, pre-filled with the three answers
  - without JavaScript it submits to `/explore/`
- **Decision module:** five questions → "Potentially relevant options" (by market region only), the guides for your answers, a "not a recommendation" note, and a pre-filled CTA.
- **In-preparation jurisdictions:** "Enquire" pre-fills the enquiry with the country.
- **Cost architecture:** keeps Government / INCORPSYS / Third-party costs separate, with "Contact for Service Fee".

## 5. Data integrity
- **No values invented:** no tax rates, fees, processing times, testimonials, ratings, client numbers, government logos, partnerships or guarantees.
- **Comparison cells:** each is either a registry value linked to its source guide or "Not yet verified". Fees and processing time read "State-dependent" (USA) or "Emirate / free-zone dependent" (UAE).
- **Stats:** computed at runtime from the registry (jurisdictions, guides, official links, services).
- **Scan:** the rendered homepage text contains no currency amounts or percentages. The only durations are the sourced ACRA 120-day and SSM 30-day rules; "guarantee" appears only in denials.

## 6. SEO / AEO
- **Page structure:** one H1; each of the 13 sections has an H2 and crawlable text; title, description and canonical (`https://incorpsys.com/`) intact.
- **Structured data:** Organization, WebSite (+SearchAction), ItemList (jurisdiction guides), FAQPage (8 Q&A), WebPage via the site graph; all JSON-LD valid.
- **Internal links added:** country guides, structure guides, comparison, services (ecosystem), scenario guides, Knowledge Hub categories, FAQ source guides.
- **Site-wide:** `tools/qa.php`: 275 URLs crawled, 140 indexable, 140 in the sitemap, 0 failures, 0 warnings.
- **In-preparation pages** (`/saudi-arabia/`, `/philippines/`, `/thailand/`): evaluated. They hold no jurisdiction-specific verified facts (authority links and process only), so they **stay noindex** to avoid thin pages. Make them indexable once sourced guides exist.

## 7. Accessibility
- **Screen readers:** decorative SVG hidden; charts have text equivalents (legend, table, lists).
- **Keyboard:** WAI-ARIA tabs with arrow keys on phones; a Close button on the setup result; the FAQ uses native `<details>`; visible focus throughout.
- **Motion:** `prefers-reduced-motion` disables the reveal and line-drawing.
- **axe (WCAG 2.0/2.1 A+AA + best practice):** 0 violations on the homepage at 1280 and 390, including with the setup result and decision output open. The site sweep (34 pages) is also 0.

## 8. Responsive
- **Tested:** 320, 360, 375, 390, 414, 430, 768, 1024, 1280, 1440 and 1920. No horizontal overflow at any width (34-page sweep).
- **Desktop:** split hero; 3-column jurisdiction cards; matrix; horizontal process; radial ecosystem.
- **Tablet:** stacked hero; 2-column cards and configurator.
- **Phones:** single column; comparison tabs with Previous / Next; vertical process; stacked ecosystem.

## 9. Performance (Lighthouse, lab, local server)

| | Performance | LCP | FCP | TBT | CLS | Weight |
|---|---|---|---|---|---|---|
| Desktop | 100 | 0.4 s | 0.3 s | 0 ms | 0 | 178 KB |
| Mobile (throttled slow 4G, 4× CPU) | 99 | 2.0 s | 1.2 s | 0 ms | 0 | 195 KB |

Accessibility, Best Practices and SEO score 100 on both.

**What changed for performance:**
- No images at all in the hero (the H1 and lead paragraph are the LCP candidates).
- `content-visibility: auto` on sections below the fold (mobile TBT 170–210 ms → 0 ms).
- Old CSS removed; one deferred script.

**Target status:** desktop LCP ≤ 1.2 s is met (0.4 s). Mobile lab LCP is 2.0 s: FCP alone is 1.2 s under Lighthouse's slow-4G throttling, and the rest is the brand web font. Reaching 1.2 s there would mean dropping the web font or inlining critical CSS (see §11). CLS ≤ 0.05 is met (0). INP ≤ 100 ms: TBT is 0 ms; real INP comes from field data after launch.

## 10. QA checklist

| Check | Result |
|---|---|
| Homepage loads, logo and favicon | Pass |
| Header, sticky navigation, mobile navigation (unchanged) | Pass |
| Hero hierarchy (H1 dominant, configurator secondary) | Pass |
| CTAs: Launch Your Entity, Compare, Enquire (pre-filled) | Pass |
| Configurator result (JS) and `/explore/` fallback (no JS) | Pass |
| Comparison: desktop filter; phone tabs with Previous / Next and arrow keys | Pass |
| Process animation (and reduced motion) | Pass |
| Cost visualisation, ecosystem, decision module, FAQ | Pass |
| Floating Assist, WhatsApp, email and phone links | Pass (unchanged Assist; hero CTA contact links) |
| Horizontal overflow, layout shift, console errors | None |
| Broken links or images | None (275 URLs) |
| Fabricated data | None found |
| SEO metadata, canonical, sitemap (140), robots, JSON-LD, no accidental noindex, single H1 | Pass |
| html-validate | 0 errors |

## 11. Known limitations and next steps
1. **Mobile LCP:** 2.0 s under throttled lab conditions. Options: inline critical hero CSS, or use `font-display: optional`. The latter was tested: no measurable gain, so `swap` is kept for brand typography.
2. **Comparison coverage:** tax, visa, banking and fee cells stay "Not yet verified" until the official sources are re-checked. That needs network access to the government sites.
3. **In-preparation jurisdictions:** remain noindex until verified guides exist.
4. **Assist label:** the floating Assist and footer are unchanged as instructed, so Assist still says "Enquiry Now" (the page CTAs say "Launch Your Entity").

## 12. Deployment and rollback
- **Deploy (after your review):** in cPanel File Manager, upload `INCORPSYS_Premium_Homepage_Redesign_Phase2_FINAL.zip` to `public_html`, extract it and overwrite. `includes/secrets.php` is included (freshly generated). Then run `php tools/qa.php https://incorpsys.com`.
- **Rollback:** re-upload the previous package (`incorpsys-cpanel-upload-v11.zip`) and extract it over the site, or redeploy commit `59933c2` (the last commit before the redesign).
