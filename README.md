# INCORPSYS — Global Company Incorporation Website

Premium, source-backed PHP website for **INCORPSYS — Global Company Incorporation**. Plain PHP 8.1+, no framework, no database, no runtime dependencies.

### Included
- Design system: CSS tokens and components (buttons, cards, forms, tables, tabs, accordions, alerts, badges, breadcrumbs, modal, tooltip); self-hosted Inter; Lucide icons as inline SVG.
- Header: utility bar (Login, Sign Up, positioning line, WhatsApp), menus Company / Services / Jurisdictions / Resources / About / Contact, Enquiry Now, mobile drawer.
- Cookie consent banner; Google Analytics loads only after the visitor accepts analytics cookies.
- Homepage: four-step guided setup with an inline setup path, official-source trust bar, jurisdiction explorer, filterable comparison, source-first method, services, structures, Knowledge Hub, FAQ.
- `/get-started/`: 8-step enquiry (works without JavaScript), with server-side validation, spam protection and lead priority.
- INCORPSYS Assist: guided flow plus Enquiry Now, WhatsApp, Call and Email.
- Jurisdiction guides built from a source registry; comparison and pricing engines that show only verified values.
- SEO: canonical URLs on https://incorpsys.com, unique titles and descriptions, Open Graph and X cards, XML sitemap, `robots.txt`, `llms.txt`, JSON-LD on every page (Organization, WebSite, WebPage, BreadcrumbList) plus Article, Service, FAQPage and ItemList where relevant. Favicon set in `assets/icons/` and `/favicon.ico`.
- Security: Content-Security-Policy, Origin check on form posts, internal folders blocked.

### Pages
| Group | URL pattern | Count | Indexed |
|---|---|---|---|
| Home, comparison, Get started | `/`, `/jurisdictions/`, `/get-started/` | 3 | yes |
| Jurisdiction guides | `/uae/` … | 6 | yes |
| Jurisdictions in preparation (Saudi Arabia, Philippines, Thailand) | `/saudi-arabia/` … | 3 | no — verification-required pages until sourced content is added |
| In-depth jurisdiction guides | `/singapore/name-reservation-120-days/` | 60 | yes |
| Knowledge Hub and resource guides | `/resources/`, `/resources/fee-verification/` | 36 | yes |
| Services | `/services/`, `/services/company-incorporation/` | 11 | yes |
| About, company and trust pages, Contact | `/about/`, `/about/why-choose-us/`, `/about/vision-mission/`, `/about/leadership/`, `/about/methodology/`, `/about/source-policy/`, `/about/editorial-policy/`, `/careers/`, `/support/`, `/contact/` | 10 | yes |
| Sitemap page (the XML sitemap is styled for browsers via `assets/sitemap.xsl`) | `/sitemap/` | 1 | yes |
| Phase A topic and service pages | `/uae/company-registration/` | 100 | **no** — template text, noindex until rewritten |
| Legal & Support hub | `/legal/` | 1 | yes |
| Policies: Privacy, Data, Payment, Refund, Cancellation, Hiring, Cookie, Terms of Use, Service Terms, Filing Quality Commitment, Disclaimer, Grievance Redressal | `/legal/privacy/` … | 12 | yes — approved, effective 26 September 2026 |
| Utility | `/explore/`, `/search/`, `/login/`, `/signup/`, `/account/` | 5 | no |

### Content files
| File | What it holds |
|---|---|
| `content/sources.php` | Official authority, source links and verification date per jurisdiction |
| `content/pending-jurisdictions.php` | Jurisdictions in preparation: authority and official home pages only. To publish one, move it into `sources.php` and add guides, a profile, a journey and comparison values |
| `content/knowledge-hub.php` | Knowledge Hub categories for the resource guides (also used for search result types) |
| `content/pages.php` | Phase A pages (built at render time by `includes/phase-a.php` from sourced guide statements; set `'noindex'` per page) |
| `content/legal.php` | Legal & Support policies (drafts; search for `[To be confirmed` to find open items) |
| `content/phase2.php` | In-depth guides, resource guides, Contact and legal text |
| `content/jurisdiction-profiles.php` | Jurisdiction guide sections, FAQs and common mistakes |
| `content/services.php` | Service hub content |
| `content/comparisons.php` | Comparison tables and filter groups (`null` cells render "Not yet verified") |
| `content/pricing.php` | Verified fees only: amount, currency, source, URL, date, validity |
| `content/journeys.php` | Setup-path steps used by `/explore/` and the jurisdiction guides |
| `content/navigation.php` | Mega menu links |
| `content/source-registry.php` | Source registry (exported to `docs/source-registry.csv`) |

After changing content, run:

```
php tools/build.php
```

It writes the page stub files, regenerates `sitemap.xml` and `docs/source-registry.csv`, and lists any stub folders that no longer have content.

**Adding a verified fee:** add a line to `content/pricing.php` with every field. Lines older than 90 days are hidden automatically until they are re-checked.

**Vision & Mission:** the text in `about/vision-mission/index.php` is drafted from the approved About text; confirm or replace it.

**Team photos:** square images in `assets/img/team/`, referenced from `content/team.php` (`photo`). Replace a file to update a photo.

### Settings (update in one place)
`includes/settings.php` holds the domain, contact details, legal entity fields, GA4 ID and brand lines.
- Legal entity: `LEGAL_ENTITY_NAME`, `REGISTRATION_NUMBER`, `REGISTERED_ADDRESS`, `TAX_ID`, `LEGAL_JURISDICTION` read `[TO BE PROVIDED]` until supplied. They appear in the draft policies and, once provided, in the Organization schema.
- Analytics: set `GA4_MEASUREMENT_ID` (for example `G-XXXXXXXXXX`). While it is empty, Google Analytics never loads; when set, it loads only after a visitor accepts analytics cookies.
- Leadership: `content/team.php` (name, designation, bio, photo, LinkedIn, display order). Empty fields are not shown.
- Policies: `content/legal.php`. `POLICIES_EFFECTIVE_DATE` in settings publishes them (approved 26 September 2026); clear it to return them to draft (noindex + notice). `[To be confirmed]` items stay highlighted until supplied.

### Deployment
1. PHP 8.1+ on Apache/cPanel with `mod_rewrite` (and ideally `mod_headers`, `mod_deflate`).
2. Point `incorpsys.com` and `www.incorpsys.com` to the web root. `.htaccess` redirects www → `https://incorpsys.com` and HTTP → HTTPS on the live domain; canonicals, sitemap and schema use `https://incorpsys.com`.
3. Copy `includes/secrets.example.php` to `includes/secrets.php` and set `FORM_SECRET` (a long random string), or set the `INCORPSYS_FORM_SECRET` environment variable. The cPanel zip already contains a generated one.
4. Replace `mail()` with authenticated SMTP or a CRM webhook, and add SPF/DKIM for incorpsys.com.
5. Serve over HTTPS and add `Strict-Transport-Security` at the server or CDN.
6. Submit `https://incorpsys.com/sitemap.xml` to Google Search Console and Bing Webmaster Tools.
7. Re-check official sources before relying on time-sensitive regulatory information.

### QA commands
```
php tools/build.php                     # regenerate stubs, sitemap.xml and docs/source-registry.csv
php -l includes/settings.php            # syntax check after editing settings
php tools/qa.php                        # quality gate against a local copy (http://127.0.0.1:8080)
php tools/qa.php https://incorpsys.com  # quality gate against the live site
curl -sI https://www.incorpsys.com/     # expect 301 → https://incorpsys.com/
curl -sI http://incorpsys.com/          # expect 301 → https://incorpsys.com/
```
`tools/qa.php` checks broken links, truncated pages, canonicals, unique titles and descriptions, one H1, breadcrumbs, Open Graph/X tags, Organization/WebSite/WebPage/BreadcrumbList schema, FAQ coverage, thin content, orphans, sitemap ↔ indexable pages, robots.txt, and the Enquiry/Email/WhatsApp/Call/Login/Sign Up/favicon links.

See `docs/incorpsys-premium-polish-audit.md` and `docs/incorpsys-premium-polish-final-report.md` for the latest audit, changes and production readiness report (earlier: `docs/incorpsys-phase2-*.md`).
