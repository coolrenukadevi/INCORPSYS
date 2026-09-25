# INCORPSYS Phase 2 Audit — 2026-09-25

## Route counts (as integrated)
- Retained Phase A content routes: **100**
- Phase 2 routes supplied: **100** — integrated as 60 jurisdiction guides, 35 resource guides (`/resources/…`), Contact (`/contact/`) and 3 legal pages (`/legal/…`, noindex until approved). The supplied About page was merged into the existing `/about/` page.
- Hubs: 6 jurisdictions + `/resources/`.
- Sitemap URLs: **205** (all indexable pages, including home, About, hubs and Contact).

## Phase 2 route groups
- UAE: 10 new jurisdiction-topic routes
- Singapore: 10
- Hong Kong: 10
- UK: 10
- USA: 10
- Malaysia: 10
- Global resources, contact and legal content: 40

## UX / architecture
- Approved INCORPSYS navy + silver identity retained.
- Utility bar: Login + Sign Up on the left.
- Responsive navigation with a Jurisdictions dropdown and mobile menu.
- Floating INCORPSYS Assist: Enquiry Now / WhatsApp / Email / Call.
- Contact: hello@incorpsys.com / +91 78448 19819.
- Favicon + app icon + Web Manifest.
- No globe imagery in the brand system.

## SEO / AEO controls
- Canonicals on every indexable route.
- One primary H1 per page.
- Direct-answer block near top of page.
- FAQPage JSON-LD where FAQs exist.
- BreadcrumbList JSON-LD.
- WebPage JSON-LD and verification date.
- Open Graph + X/Twitter card metadata.
- robots.txt + sitemap.xml + llms.txt.
- Internal related-guide links.

## Source discipline
No page should state a government fee, processing guarantee, approval guarantee, tax outcome or immigration outcome unless the current authoritative source supports it. Government / registry pages remain the controlling authority.

## Production checks still required
- Replace `mail()` with authenticated email or CRM webhook.
- Final legal review of Privacy / Terms / Disclaimer.
- Live Lighthouse / PageSpeed / Core Web Vitals run after deployment.
- Live Search Console indexing inspection and sitemap submission.
- Fresh source review immediately before publishing any time-sensitive rate, fee or regulatory statement.
