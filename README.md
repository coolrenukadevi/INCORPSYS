# INCORPSYS — Global Company Incorporation Website

Premium, source-backed PHP website for **INCORPSYS — Global Company Incorporation**. Plain PHP 8.1+, no framework, no database, no runtime dependencies.

### Included
- Design system: CSS tokens and components (buttons, cards, forms, tables, tabs, accordions, alerts, badges, breadcrumbs, modal, tooltip); self-hosted Inter; Lucide icons as inline SVG.
- Header: utility bar, mega menu (Company Setup, Business Structures, Services, Resources, About), Login / Sign Up / Get Started, mobile drawer.
- Homepage: setup finder, jurisdiction comparison, services, process, structures, resources, FAQ.
- `/get-started/`: 8-step enquiry (works without JavaScript), with server-side validation, spam protection and lead priority.
- INCORPSYS Assist: guided chat flow that hands off to the enquiry or WhatsApp.
- Jurisdiction guides built from a source registry; comparison and pricing engines that show only verified values.
- SEO: canonical URLs, unique titles and descriptions, Open Graph with a 1200×630 image, XML sitemap, `robots.txt`, `llms.txt`, JSON-LD (Organization, WebSite, Article, Service, FAQPage, BreadcrumbList).
- Security: Content-Security-Policy, Origin check on form posts, internal folders blocked.

### Pages
| Group | URL pattern | Count | Indexed |
|---|---|---|---|
| Home, comparison, Get started | `/`, `/jurisdictions/`, `/get-started/` | 3 | yes |
| Jurisdiction guides | `/uae/` … | 6 | yes |
| In-depth jurisdiction guides | `/singapore/name-reservation-120-days/` | 60 | yes |
| Resource library and guides | `/resources/`, `/resources/fee-verification/` | 36 | yes |
| Services | `/services/`, `/services/company-incorporation/` | 11 | yes |
| About, trust pages, Contact | `/about/`, `/about/methodology/` … `/contact/` | 5 | yes |
| Phase A topic and service pages | `/uae/company-registration/` | 100 | **no** — template text, noindex until rewritten |
| Legal | `/legal/privacy/` | 3 | no — until final text is approved |
| Utility | `/explore/`, `/search/`, `/login/`, `/signup/`, `/account/` | 5 | no |

### Content files
| File | What it holds |
|---|---|
| `content/sources.php` | Official authority, source links and verification date per jurisdiction |
| `content/pages.php` | Phase A pages (set `'noindex'` per page; remove it once a page is rewritten with sourced content) |
| `content/phase2.php` | In-depth guides, resource guides, Contact and legal text |
| `content/jurisdiction-profiles.php` | Jurisdiction guide sections, FAQs and common mistakes |
| `content/services.php` | Service hub content |
| `content/comparisons.php` | Comparison tables (`null` cells render "Verify") |
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

**Team photos:** add square images to `assets/img/team/` named `anisha-bharti`, `renuka-devi` and `vk-anand` (`.webp`, `.jpg` or `.png`). The About page uses them automatically; initials show until then.

### Deployment
1. PHP 8.1+ on Apache/cPanel with `mod_rewrite` (and ideally `mod_headers`, `mod_deflate`).
2. Point `www.incorpsys.com` to the web root.
3. Set the `INCORPSYS_FORM_SECRET` environment variable to a long random string.
4. Replace `mail()` with authenticated SMTP or a CRM webhook, and add SPF/DKIM for incorpsys.com.
5. Review the legal text in `content/phase2.php`. Once approved, remove the legal `noindex` rule in `pages/_page_template.php` and the legal skip in `tools/build.php`.
6. Serve over HTTPS and add `Strict-Transport-Security` at the server or CDN.
7. Submit `/sitemap.xml` to Google Search Console and Bing Webmaster Tools.
8. Re-check official sources before relying on time-sensitive regulatory information.

See `docs/incorpsys-phase2-audit.md` and `docs/incorpsys-phase2-final-report.md` for the audit, the changes and the deployment readiness report.
