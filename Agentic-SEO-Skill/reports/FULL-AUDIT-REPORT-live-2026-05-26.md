# Full Audit Report

- URL: `https://www.rubyshop.co.th`
- Generated: `2026-05-26T15:48:23.688211`
- Overall score: `82/100`
- Score confidence: `Medium`
- Scoring version: `1`

## Score Card

| Category | Weight | Score |
| --- | ---: | ---: |
| Security Headers | 10 | 100 |
| Social Meta | 3 | 85 |
| Robots and Crawlers | 12 | 100 |
| Broken Links | 10 | 96 |
| Internal Links | 10 | 40 |
| Redirects | 5 | 100 |
| AI Search | 5 | 100 |
| Performance and Core Web Vitals | 18 | 0 |
| On-Page SEO | 12 | 100 |
| Readability | 2 | 0 |
| Entity SEO | 3 | 50 |
| Link Profile | 7 | 35 |
| Hreflang | 3 | 100 |
| Content Uniqueness | 0 | 0 |

## Findings

| Severity | Area | Finding | Evidence | Fix |
| --- | --- | --- | --- | --- |
| Critical | broken_links | 🔴 1 broken link(s) found |  |  |
| Critical | link_profile | 16 orphan page(s) with zero inbound internal links. |  | Add internal links from relevant content pages to these orphan pages. |
| Warning | broken_links | ⚠️ 1 redirect chain(s) detected (>1 hop) |  |  |
| Warning | environment | Title tag needs optimization | Title length/content is likely suboptimal for rankings and click-through. | Update page templates to set complete title/meta/OG/Twitter tags. |
| Warning | environment | 1 broken links detected | Broken internal links hurt crawl flow and user trust. | Repair or remove broken internal links and refresh outdated navigation targets. |
| Warning | environment | Content readability is difficult | Long, complex text can reduce engagement and comprehension. | Rewrite key sections with shorter sentences (15-20 words), shorter paragraphs (2-4 sentences), and clearer subheadings. |
| Warning | internal_links | ⚠️ 30 potential orphan page(s) (≤1 internal link pointing to them) |  |  |
| Warning | internal_links | ⚠️ 16 internal link(s) have nofollow — this wastes link equity |  |  |
| Warning | internal_links | ⚠️ 56 link(s) have no anchor text |  |  |
| Warning | link_profile | 16 page(s) with no outbound internal links (dead ends). |  | Add contextual internal links to related content from these pages. |
| Warning | readability | ⚠️ Average sentence length (107.0 words) is too long — target 15-20 |  |  |
| Warning | readability | ⚠️ Content is difficult to read (Flesch: 0) — may reduce engagement |  |  |
| Warning | readability | ⚠️ Thin content (107 words) — may rank poorly |  |  |
| Warning | social | ⚠️ og:title is too long (73 chars, max 60) |  |  |
| Warning | social | ⚠️ twitter:title is too long (73 chars, max 70) |  |  |
| Info | Wikidata | No Wikidata entry found for 'RUBYSHOP'. |  | If the entity meets Wikidata notability guidelines, create or improve an item with accurate third-party references. Do not create one solely for SEO. |
| Info | Wikipedia | No Wikipedia article found for 'RUBYSHOP'. |  | Only pursue Wikipedia if the entity meets independent notability standards. Otherwise, strengthen official schema, sameAs profiles, citations, and About/Contact signals. |
| Info | environment | Performance measurement incomplete | PageSpeed API returned an error, so CWV recommendations are less reliable. | Set `PAGESPEED_API_KEY` in your environment or `.env` file (see `.env.example`), then rerun. The CLI also accepts `--api-key`. Prioritize LCP/INP/CLS fixes from that output. |
| info | pagespeed | pagespeed measurement incomplete | Script timed out after 120s | Rerun this check after resolving the environment/API/network limitation. |
| Info | sameAs | Missing sameAs link to Wikipedia (Primary KG signal). |  | Add the existing official 'wikipedia.org' URL to sameAs; do not create this profile solely for SEO. |
| Info | sameAs | Missing sameAs link to Wikidata (Primary KG signal). |  | Add the existing official 'wikidata.org' URL to sameAs; do not create this profile solely for SEO. |

## Measurement Notes

1 checks returned errors or incomplete measurements; treat affected scores as directional.
