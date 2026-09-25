<?xml version="1.0" encoding="UTF-8"?>
<!-- Presentation for sitemap.xml in browsers. Search engines read the XML and ignore this stylesheet. -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:s="http://www.sitemaps.org/schemas/sitemap/0.9">
<xsl:output method="html" encoding="UTF-8" indent="yes"/>
<xsl:template match="/">
<html lang="en"><head><meta charset="utf-8"/><meta name="viewport" content="width=device-width,initial-scale=1"/><meta name="robots" content="noindex,follow"/><title>XML Sitemap | INCORPSYS</title>
<style>
body{margin:0;font-family:"Inter",ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,sans-serif;color:#0b1830;background:#f6f8fb}
header{background:#0a2146;color:#fff;padding:32px 24px}header div,main{max-width:1100px;margin:0 auto}
h1{margin:0;font-size:28px;letter-spacing:-.02em}header p{margin:8px 0 0;color:#c5d3e6;font-size:15px}header a{color:#8fc1ff}
main{padding:24px}table{width:100%;border-collapse:collapse;background:#fff;border:1px solid #dfe5ed;border-radius:12px;overflow:hidden;font-size:14px}
th{background:#eef2f7;text-align:left;font-size:12px;text-transform:uppercase;letter-spacing:.06em;color:#44546c;padding:12px 16px}
td{padding:10px 16px;border-top:1px solid #eef2f7;vertical-align:top}td a{color:#1560d4;text-decoration:none;word-break:break-all}td a:hover{text-decoration:underline}
td.n{color:#5b6a82;white-space:nowrap}tr:hover td{background:#f3f8ff}
@media (max-width:640px){th:nth-child(n+3),td:nth-child(n+3){display:none}}
</style></head><body>
<header><div><h1>INCORPSYS XML Sitemap</h1><p>This file lists <xsl:value-of select="count(s:urlset/s:url)"/> pages for search engines. Visitors may prefer the <a href="/sitemap/">sitemap page</a> or the <a href="/">homepage</a>.</p></div></header>
<main><table><thead><tr><th>#</th><th>Page</th><th>Last checked</th><th>Priority</th></tr></thead><tbody>
<xsl:for-each select="s:urlset/s:url"><tr><td class="n"><xsl:value-of select="position()"/></td><td><a href="{s:loc}"><xsl:value-of select="s:loc"/></a></td><td class="n"><xsl:value-of select="s:lastmod"/></td><td class="n"><xsl:value-of select="s:priority"/></td></tr></xsl:for-each>
</tbody></table></main></body></html>
</xsl:template>
</xsl:stylesheet>
