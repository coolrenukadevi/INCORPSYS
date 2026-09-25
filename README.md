# INCORPSYS — Phase A 100 PHP Website

Premium, source-backed PHP website architecture.

### Included
- Approved INCORPSYS logo and matching favicon derived from the supplied logo.
- Navy / blue / silver premium design system; no globe imagery.
- Utility bar with Login + Sign Up on the left, email + phone on the right.
- Sticky navigation with Enquiry Now.
- Floating INCORPSYS Assist with Enquiry Now, WhatsApp, Email and Call.
- 100 clean indexable Phase A routes plus 6 jurisdiction hub pages (`/uae/`, `/singapore/` …), all cross-linked.
- 20 reserved Phase B route slots and one content registry for extension toward 200+ pages.
- SEO: canonical, unique title/description, Open Graph, Twitter card, robots.txt, XML sitemap, WebPage + BreadcrumbList + FAQPage JSON-LD.
- AEO: direct answer blocks and concise FAQs.
- Official source references for UAE, Singapore, Hong Kong, UK, USA and Malaysia.
- No fabricated fees, timelines, approval promises or legal claims.
- Enquiry form with honeypot, signed time-stamped token and per-IP rate limit; PHP mail() as a basic handler, production should use SMTP/SES/SendGrid/CRM.
- Mobile menu, custom 404 page, internal folders blocked from public access.

### Deployment
1. PHP 8.1+ on Apache/cPanel with mod_rewrite.
2. Point `www.incorpsys.com` to the web root.
3. Set the `INCORPSYS_FORM_SECRET` environment variable to a long random string (signs enquiry-form tokens).
4. Replace the legal policy placeholders with approved final text, then remove `$noindex=true` from the three `legal/*/index.php` files.
5. Replace PHP mail() with authenticated SMTP or CRM webhook.
6. Add SPF/DKIM for incorpsys.com so enquiry mail from `noreply@incorpsys.com` is delivered.
7. After adding or removing pages, run `php tools/build-sitemap.php`, then submit `/sitemap.xml` to Google Search Console and Bing Webmaster Tools.
8. Validate all current source pages before publishing time-sensitive regulatory information.

The 100 routes are intentionally template-driven but source-linked; Phase B can add deeper, source-specific content without changing the design architecture.
