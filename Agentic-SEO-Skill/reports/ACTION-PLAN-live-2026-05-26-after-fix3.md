# Action Plan

- URL: `https://www.rubyshop.co.th`
- Overall score: `76/100`

## Priority Fixes

1. **16 orphan page(s) with zero inbound internal links.**
   - Priority: `Critical`
   - Area: `link_profile`
   - Evidence: See audit output.
   - Fix: Add internal links from relevant content pages to these orphan pages.
2. **Title tag needs optimization**
   - Priority: `Warning`
   - Area: `environment`
   - Evidence: Title length/content is likely suboptimal for rankings and click-through.
   - Fix: Update page templates to set complete title/meta/OG/Twitter tags.
3. **Content readability is difficult**
   - Priority: `Warning`
   - Area: `environment`
   - Evidence: Long, complex text can reduce engagement and comprehension.
   - Fix: Rewrite key sections with shorter sentences (15-20 words), shorter paragraphs (2-4 sentences), and clearer subheadings.
4. **16 page(s) with no outbound internal links (dead ends).**
   - Priority: `Warning`
   - Area: `link_profile`
   - Evidence: See audit output.
   - Fix: Add contextual internal links to related content from these pages.
5. **Reduce unused CSS**
   - Priority: `Warning`
   - Area: `pagespeed`
   - Evidence: Estimated savings: 750ms
   - Fix: Reduce unused rules from stylesheets and defer CSS not used for above-the-fold content to decrease bytes consumed by network activity. [Learn how to reduce unused CSS](https://developer.chrome.com/doc
6. **No Wikidata entry found for 'RUBYSHOP'.**
   - Priority: `Info`
   - Area: `Wikidata`
   - Evidence: See audit output.
   - Fix: If the entity meets Wikidata notability guidelines, create or improve an item with accurate third-party references. Do not create one solely for SEO.
7. **No Wikipedia article found for 'RUBYSHOP'.**
   - Priority: `Info`
   - Area: `Wikipedia`
   - Evidence: See audit output.
   - Fix: Only pursue Wikipedia if the entity meets independent notability standards. Otherwise, strengthen official schema, sameAs profiles, citations, and About/Contact signals.
8. **Missing sameAs link to Wikipedia (Primary KG signal).**
   - Priority: `Info`
   - Area: `sameAs`
   - Evidence: See audit output.
   - Fix: Add the existing official 'wikipedia.org' URL to sameAs; do not create this profile solely for SEO.
9. **Missing sameAs link to Wikidata (Primary KG signal).**
   - Priority: `Info`
   - Area: `sameAs`
   - Evidence: See audit output.
   - Fix: Add the existing official 'wikidata.org' URL to sameAs; do not create this profile solely for SEO.
