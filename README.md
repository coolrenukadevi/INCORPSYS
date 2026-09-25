# INCORPSYS — Global Company Incorporation Website

Premium, source-backed PHP website for **INCORPSYS — Global Company Incorporation**.

### Included
- Approved INCORPSYS logo, matching favicon, app icon and web manifest.
- Navy / blue / silver premium design system; no globe imagery.
- Utility bar with Login + Sign Up on the left, email + phone on the right.
- Sticky navigation with a Jurisdictions dropdown, mobile menu and Enquiry Now.
- Floating INCORPSYS Assist with Enquiry Now, WhatsApp, Email and Call.
- Official source references for UAE, Singapore, Hong Kong, UK, USA and Malaysia, with a source library and "sources checked" date.
- No fabricated fees, timelines, approval promises or legal claims.
- SEO: canonical, unique title/description, Open Graph, Twitter card, robots.txt, XML sitemap, `llms.txt`, WebPage + BreadcrumbList + FAQPage JSON-LD.
- AEO: direct answer blocks and concise FAQs.
- Enquiry form with honeypot, signed time-stamped token and per-IP rate limit; PHP mail() as a basic handler, production should use SMTP/SES/SendGrid/CRM.
- Custom 404 page; internal folders (`includes/`, `content/`, `docs/`, `tools/` …) blocked from public access.

### Pages
| Group | URL pattern | Count |
|---|---|---|
| Jurisdiction topic guides (Phase A) | `/uae/company-registration/` | 60 |
| Jurisdiction service pages (Phase A; USA and Malaysia reserved for later) | `/uae/corporate-banking/` | 40 |
| In-depth jurisdiction guides (Phase 2) | `/singapore/name-reservation-120-days/` | 60 |
| Cross-jurisdiction resource guides (Phase 2) | `/resources/fee-verification/` | 35 |
| Hubs: 6 jurisdictions + resource library | `/uae/`, `/resources/` | 7 |
| Home, About, Contact | `/`, `/about/`, `/contact/` | 3 |
| Legal (noindex until final text is approved) | `/legal/privacy/` | 3 |

The sitemap lists the 205 indexable URLs. Every one is reachable through internal links.

### Content
- `content/sources.php` — official authority, source library links and verification date per jurisdiction.
- `content/pages.php` — Phase A topic and service pages.
- `content/phase2.php` — Phase 2 in-depth guides, resource guides, Contact and legal pages.
- `/about/index.php` — About Us text.

After adding, removing or renaming a page in the content files, run:

```
php tools/build.php
```

It writes each page's stub file under `pages/` (or `legal/`), regenerates `sitemap.xml`, and lists any stub folders that no longer have content.

### Deployment
1. PHP 8.1+ on Apache/cPanel with mod_rewrite.
2. Point `www.incorpsys.com` to the web root.
3. Set the `INCORPSYS_FORM_SECRET` environment variable to a long random string (signs enquiry-form tokens).
4. Review the Privacy, Terms and Disclaimer text in `content/phase2.php`; once approved, remove the legal `noindex` rule in `pages/_page_template.php` and the legal skip in `tools/build.php`.
5. Replace PHP mail() with authenticated SMTP or CRM webhook.
6. Add SPF/DKIM for incorpsys.com so enquiry mail from `noreply@incorpsys.com` is delivered.
7. Submit `/sitemap.xml` to Google Search Console and Bing Webmaster Tools.
8. Validate all current source pages before publishing time-sensitive regulatory information.

### Quality note
Lighthouse / Core Web Vitals scores are targets, not guarantees: they depend on the live hosting stack, caching, image delivery, CDN and server response.
