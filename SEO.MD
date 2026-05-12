# SEO Status - rubyshop-main-ecom-2026

วันที่อัปเดต: 2026-04-20

## สถานะปัจจุบัน
โปรเจกต์นี้แก้ technical SEO หลักไปแล้วระดับหนึ่ง และถือว่า “พร้อมใช้งานจริง” มากขึ้น แต่ยังไม่ถึงจุด optimal สำหรับปี 2026

## ทำแล้ว
- canonical ถูกทำให้ dynamic ตาม URL จริงในเทมเพลตหลัก
- เพิ่ม `hreflang` ครบชุดสำหรับ `th`, `en`, และ `x-default`
- `robots.txt` ใส่ `Sitemap:` แล้ว
- structured data ถูกเพิ่ม/ปรับให้ครบขึ้นในหน้าหลัก, บทความ, สินค้า, และหมวดสินค้า
- redirect/trailing-slash behavior ถูกจัดให้ไม่ชนกันและลด redirect chain
- เพิ่ม security headers ฝั่งแอปแล้ว
  - `X-Content-Type-Options`
  - `X-Frame-Options`
  - `Referrer-Policy`
  - `Permissions-Policy`
  - `Strict-Transport-Security`
  - `Cross-Origin-Opener-Policy`
- ลบ third-party tracker ที่ไม่จำเป็นในหน้า landing/blog บางหน้า (เช่น Ahrefs/Tawk ในหน้าที่ไม่จำเป็น)
- เพิ่ม metadata ให้หน้า legal (`canonical`, `hreflang`, `og`, `twitter`) เพื่อลด orphan metadata
- เพิ่ม SEO sections (`seo_title`, `seo_description`, `seo_image`) และ Product JSON-LD ในหน้า `products/show`
- เอา Tailwind CDN ออกจากหน้า legal ทั้ง 3 หน้าและย้ายเป็น CSS ในไฟล์ ลด render-blocking request
- ปรับหน้า promotion ให้โหลด GA/GTM เมื่อยินยอม cookie เท่านั้น (consent-driven loading)
- เปลี่ยนหน้า `layouts/app`, `aboutcompany`, `blogs` จาก Tailwind CDN ไปใช้ local stylesheet (`public/css/tailwind.css`) เพื่อลด third-party dependency เพิ่มเติม

## ยังเหลือ
- ยังต้องเก็บ CWV field data จริงเพื่อดู LCP / INP / CLS ว่าหน้าไหนเป็นตัว拖
- หน้า legacy / static template บางส่วนยังใช้ metadata แบบ hardcode อยู่บ้าง ต้องทยอย normalize ให้เป็นระบบเดียว
- ตอนนี้ Tailwind CDN เหลือหลัก ๆ ที่หน้า promotion (ต้องคงไว้ชั่วคราวเพราะใช้ custom `brand-*` classes จาก runtime config)
- ยังมี inline script ปริมาณมากในหน้า static ใหญ่บางหน้า ซึ่งยังมีผลต่อ INP/LCP บางช่วง
- ต้องตรวจใน Google Search Console ว่าไม่มีปัญหา canonical, duplicate, หรือ rich result error ค้าง
- ยังควรไล่ legacy URL และทำ 301 map ให้ครบทุกเส้นทางเก่า

## ลำดับต่อไป
1. เก็บ CWV จริงจาก production และแก้ตามหน้า
2. ตรวจ GSC Coverage / Enhancements / Crawl stats
3. ไล่ normalize metadata ทุกหน้าให้ใช้ pattern เดียว
4. ลด third-party scripts ที่ไม่จำเป็นหรือ defer ให้มากขึ้น
5. ปิด legacy redirects และ duplicate routes ให้หมด

## หมายเหตุ
- โฟกัสรอบนี้คือ technical SEO baseline ก่อน แล้วค่อยไล่ content cluster และ internal linking ต่อ
- ถ้าจะดันต่อให้สุด ต้องใช้ข้อมูล GSC + field CWV เป็นตัวตัดสิน ไม่ใช่แค่ lab test
